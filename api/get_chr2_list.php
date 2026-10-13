<?php
header('Content-Type: application/json');
require dirname(__DIR__) . '/app/Db.class.php';

$sid     = $_POST['sid']   ?? '';
$chrFull = $_POST['chr']   ?? '';
$start   = (int)($_POST['start'] ?? 0);
$end     = (int)($_POST['end']   ?? 0);

if (!$sid || !$chrFull || !$start || !$end) {
    exit(json_encode(['status' => 'error', 'message' => '缺少参数']));
}

try {
    // 取样本名
    $sampleRow = Db::table('database_modified')
        ->where([['Source', '=', $sid]])
        ->field('SampleName')
        ->select();

    if (empty($sampleRow)) {
        exit(json_encode(['status' => 'error', 'message' => '找不到对应 SampleName']));
    }

    $sample = $sampleRow[0]['SampleName'];

    // --- 解析 chrFull，例如 "chr17|left" 或 "chr17|right" ---
    $chr = $chrFull;
    $side = 'left';
    if (strpos($chrFull, '|') !== false) {
        [$chr, $side] = explode('|', $chrFull);
        $chr = trim($chr);
        $side = strtolower(trim($side));
    } elseif (preg_match('/^(.+?)\s*\((left|right)\)\s*$/i', $chrFull, $m)) {
        $chr = trim($m[1]);
        $side = strtolower($m[2]);
    }

    // --- 根据 side 查询不同字段 ---
    if ($side === 'left') {
        // 当前 chr 是 Chr1，用 Start1-End1 限制范围，查对应的 Chr2
        $rows = Db::table('chr_browse')
            ->where([
                ['Sampleid', '=', $sample],
                ['Chr1', '=', $chr],
                ['Start1', '>=', $start],
                ['End1', '<=', $end]
            ])
            ->field('DISTINCT Chr2')
            ->select();

        $list = array_unique(array_column($rows, 'Chr2'));
    } else {
        // 当前 chr 是 Chr2，用 Start2-End2 限制范围，查对应的 Chr1
        $rows = Db::table('chr_browse')
            ->where([
                ['Sampleid', '=', $sample],
                ['Chr2', '=', $chr],
                ['Start2', '>=', $start],
                ['End2', '<=', $end]
            ])
            ->field('DISTINCT Chr1')
            ->select();

        $list = array_unique(array_column($rows, 'Chr1'));
    }

    //  排序
    sort($list, SORT_NATURAL | SORT_FLAG_CASE);

    echo json_encode(['status' => 'success', 'data' => array_values($list)]);

} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}