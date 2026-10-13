<?php
header('Content-Type: application/json');
session_start();

$DS = DIRECTORY_SEPARATOR;
require dirname(__DIR__) . "{$DS}app{$DS}Db.class.php";
require dirname(__DIR__) . "{$DS}app{$DS}Func.php";

// 接收前端参数（前端仍用 SampleName 传入 tissue1/tissue2）
$sampleParam = trim($_GET['SampleName'] ?? '');
if ($sampleParam === '') {
    echo json_encode(['error' => '缺少 SampleName 参数']);
    exit;
}

// 先按 SampleName 查 database_modified（多数情况传入的是 SampleName）
// 若没命中，再尝试按 TissueCellLine 查（提高容错）
$rows = Db::table('database_modified')
    ->where([['SampleName', '=', $sampleParam]])
    ->select();

if (!$rows || count($rows) === 0) {
    // fallback: try matching TissueCellLine
    $rows = Db::table('database_modified')
        ->where([['TissueCellLine', '=', $sampleParam]])
        ->select();
}

$cellType = $diseaseType = $condition = '';

if ($rows && count($rows) > 0) {
    // 取第一条匹配记录
    $row = $rows[0];

    // 统一键为小写，避免列名大小写不一致导致 undefined index
    $rowLower = array_change_key_case($row, CASE_LOWER);

    $cellType    = $rowLower['celltype']    ?? '';
    $diseaseType = $rowLower['diseasetype'] ?? '';
    $condition   = $rowLower['condition']   ?? '';
}

// 返回给前端（第一步只返回这些字段）
echo json_encode([
    'SampleName'   => $sampleParam,
    'CellType'     => $cellType,
    'DiseaseType'  => $diseaseType,
    'Condition'    => $condition
], JSON_UNESCAPED_UNICODE);
exit;