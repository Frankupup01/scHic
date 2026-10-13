<?php
session_start();
ini_set('memory_limit', '8192M');  // 临时提高内存，后续可根据需要调整
header('Content-Type: application/json');

$DS = DIRECTORY_SEPARATOR;
require dirname(__DIR__) . "{$DS}app{$DS}Db.class.php";
require dirname(__DIR__) . "{$DS}app{$DS}Func.php";

$geoStudy = $_POST['GEOStudy'] ?? null;

if (!$geoStudy) {
    file_put_contents("debug.log", "未接收到 GEOStudy\n", FILE_APPEND);
    echo json_encode([]);
    exit;
}

try {
    // 通过 GEOStudy 获取 SampleName
    $map1[] = ['GEOStudy', '=', $geoStudy];
    $sampleRows = Db::table('database_modified')->where($map1)->field('SampleName')->select();
    $sampleNames = array_column($sampleRows, 'SampleName');

    if (empty($sampleNames)) {
        file_put_contents("debug.log", "找不到对应 SampleName\n", FILE_APPEND);
        echo json_encode([]);
        exit;
    }

    $batchSize = 100;  // 降低批次大小，减小内存占用
    $chunks = array_chunk($sampleNames, $batchSize);

    $chrsMap = [];
    foreach ($chunks as $i => $batch) {
        file_put_contents("debug.log", "处理第 " . ($i+1) . " 批，共 " . count($batch) . " 条 Sampleid\n", FILE_APPEND);

        // 这里确认字段名是 Sampleid（和 SampleName 对应）
        $map2 = [['Sampleid', 'IN', $batch]];
        $rows = Db::table('chr_browse')->where($map2)->field('Chr1, Chr2')->select();

        foreach ($rows as $row) {
            if (!empty($row['Chr1'])) $chrsMap[$row['Chr1']] = true;
            if (!empty($row['Chr2'])) $chrsMap[$row['Chr2']] = true;
        }
    }

    $response = array_keys($chrsMap);
    file_put_contents("debug.log", "返回 CHR：" . json_encode($response) . "\n", FILE_APPEND);
    echo json_encode($response);

} catch (Exception $e) {
    file_put_contents("debug.log", "查询异常：" . $e->getMessage() . "\n" . $e->getTraceAsString() . "\n", FILE_APPEND);
    echo json_encode([]);
    exit;
}