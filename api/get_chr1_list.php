<?php
header('Content-Type: application/json');
require dirname(__DIR__) . '/app/Db.class.php';
require dirname(__DIR__) . '/app/Func.php';

$sid = $_POST['sid'] ?? '';
if (!$sid) exit(json_encode(['status' => 'error', 'message' => 'Missing sid']));

try {
    $sample = Db::table('database_modified')->where([['Source', '=', $sid]])->field('SampleName')->select()[0]['SampleName'];

    $rows = Db::table('chr_browse')->where([['Sampleid', '=', $sample]])->field('DISTINCT Chr1, Chr2')->select();
    $chr1 = array_unique(array_column($rows, 'Chr1'));
    $chr2 = array_unique(array_column($rows, 'Chr2'));

    natsort($chr1);
    natsort($chr2);

    $combined = [];
    foreach ($chr1 as $c) $combined[] = ['value' => "$c|left", 'label' => "$c (left)"];
    foreach ($chr2 as $c) $combined[] = ['value' => "$c|right", 'label' => "$c (right)"];

    echo json_encode(['status' => 'success', 'data' => $combined]);
} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}