<?php
header('Content-Type: application/json');
session_start();

$DS = DIRECTORY_SEPARATOR;
require dirname(__DIR__) . "{$DS}app{$DS}Db.class.php";
require dirname(__DIR__) . "{$DS}app{$DS}Func.php";

$sid = $_POST['sid'] ?? '';
$chr1 = $_POST['chr1'] ?? '';
$chr2 = $_POST['chr2'] ?? '';

if (empty($sid) || empty($chr1) || empty($chr2)) {
    echo json_encode(['status' => 'error', 'message' => '缺少参数']);
    exit;
}

try {
    // 获取 SampleName
    $sample_rows = Db::table('database_modified')
        ->where([['Source', '=', $sid]])
        ->field('SampleName')
        ->select();

    if (!$sample_rows || count($sample_rows) === 0) {
        echo json_encode(['status' => 'error', 'message' => '无对应 SampleName']);
        exit;
    }

    $sample_name = $sample_rows[0]['SampleName'];

    // 查询 Start1, End1
    $rows = Db::table('chr_browse')
        ->where([
            ['Sampleid', '=', $sample_name],
            ['Chr1', '=', $chr1],
            ['Chr2', '=', $chr2]
        ])
        ->field('Start1, End1')
        ->select();

    if (!$rows || count($rows) === 0) {
        echo json_encode(['status' => 'error', 'message' => '未找到范围']);
        exit;
    }

    // 取 Start1 > 0 的最小值
    $startVals = array_column($rows, 'Start1');
    $startValsPositive = array_filter($startVals, function($v) {
        return $v > 0;
    });
    $minVal = $startValsPositive ? min($startValsPositive) : min($startVals);

    // 取 End1 最大值
    $maxVal = max(array_column($rows, 'End1'));

    // 兜底：保证 maxVal > minVal
    if ($maxVal <= $minVal) {
        $maxVal = $minVal + 1;
    }

    echo json_encode([
        'status' => 'success',
        'data' => [
            'min' => $minVal,
            'max' => $maxVal
        ]
    ]);
} catch (Exception $e) {
    echo json_encode([
        'status' => 'error',
        'message' => '查询异常：' . $e->getMessage()
    ]);
}