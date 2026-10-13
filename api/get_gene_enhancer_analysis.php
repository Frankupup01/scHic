<?php
header('Content-Type: application/json');
session_start();

$DS = DIRECTORY_SEPARATOR;
require dirname(__DIR__) . "{$DS}app{$DS}Db.class.php";
require dirname(__DIR__) . "{$DS}app{$DS}Func.php";

$draw   = intval($_POST['draw'] ?? 0);
$start  = intval($_POST['start'] ?? 0);
$length = intval($_POST['length'] ?? 10);
$geneRaw = trim($_POST['gene'] ?? '');

// ====== 1. 处理多个基因输入 ======
if ($geneRaw === '') {
    echo json_encode([
        "draw" => $draw,
        "recordsTotal" => 0,
        "recordsFiltered" => 0,
        "data" => []
    ]);
    exit;
}

$geneList = preg_split('/[\s,]+/', $geneRaw, -1, PREG_SPLIT_NO_EMPTY);
$geneList = array_values(array_unique($geneList)); // 去重 & 重建索引

if (empty($geneList)) {
    echo json_encode([
        "draw" => $draw,
        "recordsTotal" => 0,
        "recordsFiltered" => 0,
        "data" => []
    ]);
    exit;
}

// ====== 2. 先查 gene_browse ======
$where = [['geneid', 'in', $geneList]];

$cases = [];
$idx = 1;
foreach ($geneList as $g) {
    $cases[] = "WHEN '" . addslashes($g) . "' THEN $idx";
    $idx++;
}
$caseExpr = "CASE geneid " . implode(' ', $cases) . " END";

$geneRows = Db::table('gene_browse')
    ->where($where)
    ->order("$caseExpr ASC, start1 ASC")
    ->select();

// 统一字段名大小写
$geneRows = array_map(fn($row) => array_change_key_case($row, CASE_LOWER), $geneRows);

if (empty($geneRows)) {
    echo json_encode([
        "draw" => $draw,
        "recordsTotal" => 0,
        "recordsFiltered" => 0,
        "data" => []
    ]);
    exit;
}

// ====== 3. enhancer 查询 ======
$results = [];
foreach ($geneRows as $geneRow) {
    $species = $geneRow['species'] ?? '';
    $chr1    = $geneRow['chr1'] ?? '';
    $gStart  = intval($geneRow['start1'] ?? 0);
    $gEnd    = intval($geneRow['end1'] ?? 0);
    $geneid  = $geneRow['geneid'] ?? '';

    $enhancers = Db::table('enhancer_browse')
        ->where([
            ['species', '=', $species],
            ['chr', '=', $chr1],
            ['start', '>=', $gStart],
            ['end', '<=', $gEnd]
        ])
        ->order('start ASC')
        ->select();

    // 同样统一字段名大小写
    $enhancers = array_map(fn($row) => array_change_key_case($row, CASE_LOWER), $enhancers);

    foreach ($enhancers as $e) {
        $results[] = [
            "gene_order" => array_search($geneid, $geneList),
            "species"   => $species,
            "geneid"    => $geneid,
            "Enhancerid"=> $e['enhancerid'] ?? '',
            "Chr"       => $e['chr'] ?? '',
            "Start"     => intval($e['start'] ?? 0),
            "End"       => intval($e['end'] ?? 0),
            "Size"      => intval(($e['end'] ?? 0) - ($e['start'] ?? 0)),
            "Unknown"   => $e['unknown'] ?? ''
        ];
    }
}

// ====== 4. 排序 ======
usort($results, function ($a, $b) {
    if ($a['gene_order'] === $b['gene_order']) {
        return $a['Start'] <=> $b['Start'];
    }
    return $a['gene_order'] <=> $b['gene_order'];
});

// ====== 5. 分页 & 返回 ======
$total = count($results);
$pagedResults = array_slice($results, $start, $length);

foreach ($pagedResults as &$row) {
    unset($row['gene_order']);
}

echo json_encode([
    "draw" => $draw,
    "recordsTotal" => $total,
    "recordsFiltered" => $total,
    "data" => $pagedResults
], JSON_UNESCAPED_UNICODE);
exit;