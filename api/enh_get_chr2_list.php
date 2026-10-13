<?php
header('Content-Type: application/json');
session_start();

$DS = DIRECTORY_SEPARATOR;
require dirname(__DIR__) . "{$DS}app{$DS}Db.class.php";
require dirname(__DIR__) . "{$DS}app{$DS}Func.php";

$sid = $_POST['sid'] ?? '';
$chr1 = $_POST['chr1'] ?? '';
$range_start = $_POST['range_start'] ?? '';
$range_end = $_POST['range_end'] ?? '';

if (empty($sid) || empty($chr1)) {
    echo json_encode(['status' => 'error', 'message' => '缺少参数']);
    exit;
}

try {
    $sample_rows = Db::table('database_modified')
        ->where([['Source', '=', $sid]])
        ->field('SampleName')
        ->select();

    if (!$sample_rows) {
        echo json_encode(['status' => 'error', 'message' => '无对应 SampleName']);
        exit;
    }

    $sample_name = $sample_rows[0]['SampleName'];

    // ✅ 根据范围过滤
    $where = [
        ['Sampleid', '=', $sample_name],
        ['Chr1', '=', $chr1],
    ];

    if ($range_start !== '' && $range_end !== '') {
        $where[] = ['Pos1', '>=', $range_start];
        $where[] = ['Pos1', '<=', $range_end];
    }

    $chr2_rows = Db::table('chr_browse')
        ->where($where)
        ->field('Chr2')
        ->select();

    if (!$chr2_rows) {
        echo json_encode(['status' => 'error', 'message' => '未找到对应 Chr2']);
        exit;
    }

    $chr2_list = array_values(array_unique(array_column($chr2_rows, 'Chr2')));

    usort($chr2_list, function($a, $b) {
        $a_upper = strtoupper($a);
        $b_upper = strtoupper($b);
        if ($a_upper === 'CHRX') return 1;
        if ($b_upper === 'CHRX') return -1;
        if ($a_upper === 'CHRY') return 1;
        if ($b_upper === 'CHRY') return -1;
        preg_match('/(\d+)/', $a, $a_match);
        preg_match('/(\d+)/', $b, $b_match);
        return ($a_match[1] ?? 999) - ($b_match[1] ?? 999);
    });

    echo json_encode(['status' => 'success', 'data' => $chr2_list]);
} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => '查询异常：' . $e->getMessage()]);
}
?>