<?php
header('Content-Type: application/json');
require dirname(__DIR__) . '/app/Db.class.php';

$sid = $_POST['sid'] ?? '';
$chr = $_POST['chr'] ?? '';
$side = $_POST['side'] ?? '';
$relativeChr = $_POST['relativeChr'] ?? '';
$start = (int)($_POST['start'] ?? 0);
$end = (int)($_POST['end'] ?? PHP_INT_MAX);

if (!$sid || !$chr || !$side || !$relativeChr)
    exit(json_encode(['status' => 'error', 'message' => '参数不全']));

try {
    $sample = Db::table('database_modified')->where([['Source', '=', $sid]])->field('SampleName')->select()[0]['SampleName'];

    if ($side === 'left') {
        $rows = Db::table('chr_browse')->where([
            ['Sampleid', '=', $sample],
            ['Chr1', '=', $chr],
            ['Chr2', '=', $relativeChr],
            ['Start1', '>=', $start],
            ['End1', '<=', $end]
        ])->field('Start2, End2')->select();
    } else {
        $rows = Db::table('chr_browse')->where([
            ['Sampleid', '=', $sample],
            ['Chr2', '=', $chr],
            ['Chr1', '=', $relativeChr],
            ['Start2', '>=', $start],
            ['End2', '<=', $end]
        ])->field('Start1, End1')->select();
    }

    $min = min(array_column($rows, $side === 'left' ? 'Start2' : 'Start1'));
    $max = max(array_column($rows, $side === 'left' ? 'End2' : 'End1'));

    echo json_encode(['status' => 'success', 'data' => ['min' => (int)$min, 'max' => (int)$max]]);
} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}