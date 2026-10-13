<?php
header('Content-Type: application/json');
session_start();

$DS = DIRECTORY_SEPARATOR;
require dirname(__DIR__) . "{$DS}app{$DS}Db.class.php";
require dirname(__DIR__) . "{$DS}app{$DS}Func.php";

// 前端传来的基因名数组
$geneNames = $_POST['name'] ?? [];
if (empty($geneNames) || !is_array($geneNames)) {
    echo json_encode([]);
    exit;
}

// 去掉空白、统一大写
$geneNames = array_filter(array_map('trim', $geneNames));
$geneNamesUpper = array_map('strtoupper', $geneNames);

// ----------------------------
// 1. 查 Gene 表拿 gene_id
// ----------------------------
$geneRes = Db::table('Gene')
    ->field('id, gene_name')
    ->select();

$geneIdMap = [];
foreach ($geneRes as $g) {
    if (in_array(strtoupper($g['gene_name']), $geneNamesUpper)) {
        $geneIdMap[$g['id']] = $g['gene_name'];
    }
}

if (empty($geneIdMap)) {
    echo json_encode([]);
    exit;
}

$geneIds = array_keys($geneIdMap);

// ----------------------------
// 2. 查 Expression 表
// ----------------------------
$rows = Db::table('Expression')
    ->field('gene_id, tissue, Encode, GTEx, HPA')
    ->where([['gene_id', 'in', $geneIds]])
    ->select();

// ----------------------------
// 3. 整理数据
// ----------------------------
$rowGenes = [];
$tissueOrder = [];
$dataEncode = $dataGTEx = $dataHPA = [];
$rawEncode = $rawGTEx = $rawHPA = []; // 保存原始值

foreach ($rows as $r) {
    $geneName = $geneIdMap[$r['gene_id']];
    $rowGenes[$r['gene_id']] = $geneName;
    $tissueOrder[] = $r['tissue'];

    $y = array_search($geneName, array_values(array_unique($rowGenes)));
    $x = array_search($r['tissue'], array_values(array_unique($tissueOrder)));

    $encodeVal = floatval($r['Encode']);
    $gtexVal   = floatval($r['GTEx']);
    $hpaVal    = floatval($r['HPA']);

    $rawEncode[] = $encodeVal;
    $rawGTEx[]   = $gtexVal;
    $rawHPA[]    = $hpaVal;

    // 原始
    $dataEncode[] = [$x, $y, $encodeVal];
    $dataGTEx[]   = [$x, $y, $gtexVal];
    $dataHPA[]    = [$x, $y, $hpaVal];
}

// 去重排序
$rowGenes = array_values(array_unique($rowGenes));
$tissueOrder = array_values(array_unique($tissueOrder));

// 计算最大值（log1p）
$max = [
    !empty($dataEncode) ? max(array_column($dataEncode, 2)) : 0,
    !empty($dataGTEx)   ? max(array_column($dataGTEx, 2))   : 0,
    !empty($dataHPA)    ? max(array_column($dataHPA, 2))    : 0,
];

// ----------------------------
// 4. 输出 JSON
// ----------------------------
echo json_encode([
    'col'        => $tissueOrder,
    'row'        => $rowGenes,
    'data'       => [$dataEncode, $dataGTEx, $dataHPA],
    'max'        => $max,
    'raw'        => [$rawEncode, $rawGTEx, $rawHPA] // 原始值 tooltip 使用
], JSON_UNESCAPED_UNICODE);