<?php
header('Content-Type: application/json');
session_start();

$DS = DIRECTORY_SEPARATOR;

// --- ClickHouse 配置 ---
$CH_URL = "http://127.0.0.1:8123/";

function queryClickHouse($sql) {
    global $CH_URL;
    $ch = curl_init($CH_URL);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $sql . " FORMAT JSON");
    $response = curl_exec($ch);
    if (curl_errno($ch)) {
        throw new Exception('ClickHouse Error: ' . curl_error($ch));
    }
    curl_close($ch);
    return json_decode($response, true);
}

try {
    // 1. 接收前端传来的 SampleName
    if (!isset($_POST['SampleName']) || empty(trim($_POST['SampleName']))) {
        throw new Exception('Missing SampleName parameter from frontend');
    }
    $sampleName = trim($_POST['SampleName']);

    // 默认给 ClickHouse 查询用的 ID 就是传进来的 SampleName
    $clickhouseSampleId = $sampleName;

    // =================================================================
    // 🌟 核心拦截逻辑：如果是 SAMN 开头，去 SQLite 查 C0 替换
    // =================================================================
    if (strpos($sampleName, 'SAMN') === 0) {
        $db_file = dirname(__DIR__) . "{$DS}db{$DS}scHic.db";
        if (file_exists($db_file)) {
            $db = new SQLite3($db_file);
            $stmt = $db->prepare("SELECT C0 FROM database_modified WHERE SampleName = :sn LIMIT 1");
            $stmt->bindValue(':sn', $sampleName, SQLITE3_TEXT);
            $res = $stmt->execute()->fetchArray(SQLITE3_ASSOC);

            // 如果查到了 C0 且不为空，就把去 ClickHouse 查的 ID 偷换成 C0
            if ($res && !empty($res['C0'])) {
                // 强制去掉可能存在的后缀，只保留纯 ID 去 ClickHouse 里查
                $clean_C0 = str_replace('.csv', '', $res['C0']);
                $clean_C0 = str_replace('.gz', '', $clean_C0);
                $clean_C0 = str_replace('.txt', '', $clean_C0);

                $clickhouseSampleId = $clean_C0;
            }
            $db->close();
        }
    }
    // =================================================================

    $draw = intval($_POST['draw'] ?? 1);
    $start = intval($_POST['start'] ?? 0);
    $length = intval($_POST['length'] ?? 10);

    // 2. 构造 ClickHouse 查询条件 (使用翻译后的 $clickhouseSampleId)
    $where = "WHERE Sampleid = '" . addslashes($clickhouseSampleId) . "'";

    // 3. 处理搜索逻辑
    $searchValue = trim($_POST['search']['value'] ?? '');
    $searchCondition = "";
    if ($searchValue !== '') {
        $s = addslashes($searchValue);
        $searchCondition = " AND (
            concat('chr', toString(Chr1)) LIKE '%$s%' OR 
            concat('chr', toString(Chr1), ':', toString(Start1), '-', toString(End1)) LIKE '%$s%' OR 
            concat('chr', toString(Chr2)) LIKE '%$s%' OR 
            concat('chr', toString(Chr2), ':', toString(Start2), '-', toString(End2)) LIKE '%$s%' OR 
            toString(Frequency) LIKE '%$s%'
        )";
    }

    // 4. 执行主查询
    $sql = "SELECT 
                concat('chr', toString(Chr1)) AS c1_out, 
                concat('chr', toString(Chr1), ':', toString(Start1), '-', toString(End1)) AS r1_out, 
                concat('chr', toString(Chr2)) AS c2_out, 
                concat('chr', toString(Chr2), ':', toString(Start2), '-', toString(End2)) AS r2_out, 
                Frequency
            FROM scHic.chr_browse 
            $where 
            $searchCondition
            ORDER BY Chr1 ASC, Start1 ASC 
            LIMIT $start, $length";

    $mainRes = queryClickHouse($sql);

    // 5. 获取统计总数
    $countRes = queryClickHouse("SELECT count() as cnt FROM scHic.chr_browse $where $searchCondition");
    $recordsFiltered = $countRes['data'][0]['cnt'] ?? 0;

    $totalRes = queryClickHouse("SELECT count() as cnt FROM scHic.chr_browse WHERE Sampleid = '" . addslashes($clickhouseSampleId) . "'");
    $recordsTotal = $totalRes['data'][0]['cnt'] ?? 0;

    // 6. 整理返回给前端的数据
    $data = [];
    if (isset($mainRes['data'])) {
        foreach ($mainRes['data'] as $row) {
            $data[] = [
                "Chr1" => $row['c1_out'],
                "Chr1Region" => $row['r1_out'],
                "Chr2" => $row['c2_out'],
                "Chr2Region" => $row['r2_out'],
                "Frequency" => $row['Frequency']
            ];
        }
    }

    echo json_encode([
        "draw" => $draw,
        "recordsTotal" => intval($recordsTotal),
        "recordsFiltered" => intval($recordsFiltered),
        "data" => $data
    ]);

} catch (Exception $e) {
    echo json_encode([
        "draw" => intval($_POST['draw'] ?? 1),
        "recordsTotal" => 0,
        "recordsFiltered" => 0,
        "data" => [],
        "error" => $e->getMessage()
    ]);
}
?>