<?php
header('Content-Type: application/json');

try {
    $dbPath = __DIR__ . '/../db/scHic.db';
    if (!file_exists($dbPath)) {
        echo json_encode(['error' => "数据库文件不存在：$dbPath"]);
        exit;
    }

    $db = new SQLite3($dbPath);

    // DataTables 参数
    $draw = isset($_POST['draw']) ? intval($_POST['draw']) : 1;
    $start = isset($_POST['start']) ? intval($_POST['start']) : 0;
    $length = isset($_POST['length']) ? intval($_POST['length']) : 10;
    $searchValue = isset($_POST['search']['value']) ? $_POST['search']['value'] : '';

    // 前端传来的 zTree 过滤值
    $treeFilter = isset($_POST['treeFilter']) ? trim($_POST['treeFilter']) : '';
    $organismFilter = isset($_POST['organismFilter']) ? trim($_POST['organismFilter']) : '';

    // 排序参数
    $orderColumnIndex = isset($_POST['order'][0]['column']) ? intval($_POST['order'][0]['column']) : 10; // 🌟 默认可以改为 10
    $orderDir = isset($_POST['order'][0]['dir']) && in_array(strtolower($_POST['order'][0]['dir']), ['asc', 'desc'])
        ? $_POST['order'][0]['dir']
        : 'asc';

    // 🌟 修改点 1：映射 DataTables 列索引到数据库列名，加入第 10 列
    $columns = [
        0 => null,          // 复选框列，无排序
        1 => 'Source',      // 隐藏列
        2 => 'Source',      // Sample ID 用 Source 字段
        3 => 'GEOStudy',
        4 => 'Organism',
        5 => 'TissueCellLine',
        6 => 'DiseaseType',
        7 => 'CellType',
        8 => 'Condition',
        9 => 'PMID',
        10 => 'sort_order'  // 🌟 新增的排序列
    ];

    $orderColumnName = isset($columns[$orderColumnIndex]) ? $columns[$orderColumnIndex] : 'sort_order';

    // 🌟 修改点 2：构造 ORDER BY 子句，增加 sort_order 的处理
    switch ($orderColumnName) {
        case 'sort_order':
            $orderBy = "ORDER BY sort_order $orderDir";
            break;
        case 'Source':
            $orderBy = "ORDER BY LENGTH(Source) $orderDir, CAST(Source AS INTEGER) $orderDir, Source $orderDir";
            break;
        case 'GEOStudy':
            $orderBy = "ORDER BY LENGTH(GEOStudy) $orderDir, CAST(GEOStudy AS INTEGER) $orderDir, GEOStudy $orderDir";
            break;
        case 'PMID':
            $orderBy = "ORDER BY PMID $orderDir";
            break;
        default:
            $orderBy = "ORDER BY sort_order $orderDir";
            break;
    }

    // 获取总记录数
    $totalResult = $db->query('SELECT COUNT(*) as count FROM database_modified');
    $totalRow = $totalResult->fetchArray(SQLITE3_ASSOC);
    $recordsTotal = $totalRow['count'];

    // -------------------------
    // 构造 WHERE 条件
    // -------------------------
    $whereParts = [];
    $params = [];

    // 全局搜索 (DataTables 默认搜索框)
    if (!empty($searchValue)) {
        $searchableColumns = [
            'Source',
            'SampleName',
            'SRAStudy',
            'GEOStudy',
            'Organism',
            'TissueCellLine',
            'DiseaseType',
            'CellType',
            'Condition',
            'PMID'
        ];
        $likeClauses = array_map(function ($col) {
            return "$col LIKE :search";
        }, $searchableColumns);
        $whereParts[] = '(' . implode(' OR ', $likeClauses) . ')';
        $params[':search'] = '%' . $searchValue . '%';
    }

    // 树节点过滤
    if (!empty($treeFilter)) {
        if (!empty($organismFilter)) {
            // 精确匹配 Organism + 节点
            $whereParts[] = '(Organism = :organismFilter AND (TissueCellLine = :treeFilter OR DiseaseType = :treeFilter))';
            $params[':organismFilter'] = $organismFilter;
            $params[':treeFilter'] = $treeFilter;
        } else {
            // 没传 organismFilter 时，退回模糊匹配
            $whereParts[] = '(Organism LIKE :treeFilter OR TissueCellLine LIKE :treeFilter OR DiseaseType LIKE :treeFilter)';
            $params[':treeFilter'] = '%' . $treeFilter . '%';
        }
    }

    $whereClause = '';
    if (!empty($whereParts)) {
        $whereClause = ' WHERE ' . implode(' AND ', $whereParts);
    }

    // -------------------------
    // 过滤后的记录数
    // -------------------------
    $countSql = "SELECT COUNT(DISTINCT SampleName) as count FROM database_modified $whereClause";
    $countStmt = $db->prepare($countSql);
    foreach ($params as $key => $val) {
        $countStmt->bindValue($key, $val, SQLITE3_TEXT);
    }
    $filteredCountResult = $countStmt->execute();
    if (!$filteredCountResult) {
        throw new Exception('SQL 查询失败 (count)');
    }
    $filteredRow = $filteredCountResult->fetchArray(SQLITE3_ASSOC);
    $recordsFiltered = $filteredRow['count'];

    // -------------------------
    // 查询数据
    // -------------------------
    // 🌟 修改点 3：必须把 sort_order 查出来
    $sql = "SELECT 
            MIN(Source) AS Source,
            SampleName,
            MIN(SRAStudy) AS SRAStudy,
            MIN(GEOStudy) AS GEOStudy,
            MIN(Organism) AS Organism,
            MIN(TissueCellLine) AS TissueCellLine,
            MIN(DiseaseType) AS DiseaseType,
            MIN(CellType) AS CellType,
            MIN(Condition) AS Condition,
            MIN(PMID) AS PMID,
            MIN(sort_order) AS sort_order 
        FROM database_modified
        $whereClause
        GROUP BY SampleName
        $orderBy
        LIMIT :limit OFFSET :offset";

    $stmt = $db->prepare($sql);
    foreach ($params as $key => $val) {
        $stmt->bindValue($key, $val, SQLITE3_TEXT);
    }
    $stmt->bindValue(':limit', $length, SQLITE3_INTEGER);
    $stmt->bindValue(':offset', $start, SQLITE3_INTEGER);

    $result = $stmt->execute();
    if (!$result) {
        throw new Exception('SQL 查询失败 (data)');
    }

    $data = [];
    while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
        unset($row['C0']); // 如果 SQLite 自动生成了 C0
        $data[] = $row;
    }

    echo json_encode([
        'draw' => $draw,
        'recordsTotal' => $recordsTotal,
        'recordsFiltered' => $recordsFiltered,
        'data' => $data,
    ]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => '数据库错误: ' . $e->getMessage()]);
}