<?php
header('Content-Type: application/json');

// 1. 接收唯一标识 SampleName
$sampleName = isset($_POST['SampleName']) ? $_POST['SampleName'] : '';

if (empty($sampleName)) {
    echo json_encode(['error' => 'Missing SampleName parameter']);
    exit;
}

try {
    $dbPath = __DIR__ . '/../db/scHic.db';
    $db = new SQLite3($dbPath);

    // 2. 关键修改：用 SampleName 精准定位唯一的一行
    $stmt = $db->prepare("SELECT * FROM database_modified WHERE SampleName = :sampleName LIMIT 1");
    $stmt->bindValue(':sampleName', $sampleName, SQLITE3_TEXT);

    $result = $stmt->execute();
    $data = $result->fetchArray(SQLITE3_ASSOC);

    if ($data) {
        echo json_encode($data);
    } else {
        echo json_encode(['error' => 'Sample not found']);
    }

} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>