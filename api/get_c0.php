<?php
header('Content-Type: application/json');
$DS = DIRECTORY_SEPARATOR;
require dirname(__DIR__) . "{$DS}app{$DS}Db.class.php";

$sampleName = $_POST['SampleName'] ?? '';

if (!$sampleName) {
    echo json_encode(['status' => 'error', 'message' => 'Missing SampleName']);
    exit;
}

try {
    // 根据 SampleName 去 SQLite 找同行的 C0
    $res = Db::table('database_modified')
        ->where([['SampleName', '=', $sampleName]])
        ->field('C0')
        ->select();

    if (!empty($res) && !empty($res[0]['C0'])) {
        echo json_encode(['status' => 'success', 'data' => ['C0' => $res[0]['C0']]]);
    } else {
        echo json_encode(['status' => 'success', 'data' => ['C0' => null]]);
    }
} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
?>