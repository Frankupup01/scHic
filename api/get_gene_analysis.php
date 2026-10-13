<?php
header('Content-Type: application/json');
session_start();

$DS = DIRECTORY_SEPARATOR;
require dirname(__DIR__) . "{$DS}app{$DS}Db.class.php";
require dirname(__DIR__) . "{$DS}app{$DS}Func.php";

$draw   = intval($_POST['draw'] ?? 0);
$start  = intval($_POST['start'] ?? 0);
$length = intval($_POST['length'] ?? 10);
$geneInput   = trim($_POST['gene'] ?? '');
$searchValue = trim($_POST['search']['value'] ?? '');

// ===== 构建精准匹配条件 =====
$where = [];
$geneList = [];

if ($geneInput !== '') {
    $geneList = preg_split('/[\s,]+/', $geneInput, -1, PREG_SPLIT_NO_EMPTY);
    if (count($geneList) === 1) {
        $where[] = ['geneid', '=', $geneList[0]];
    } else {
        $where[] = ['geneid', 'in', $geneList];
    }
}

if ($searchValue !== '') {
    $where[] = ['species', 'like', "%{$searchValue}%"];
}

// ===== 构建排序 SQL =====
$orderSql = 'start1 ASC';
if (count($geneList) > 1) {
    $cases = [];
    $i = 1;
    foreach ($geneList as $g) {
        $cases[] = "WHEN '" . addslashes($g) . "' THEN $i";
        $i++;
    }
    $caseExpr = "CASE geneid " . implode(' ', $cases) . " END";
    $orderSql = "$caseExpr ASC, start1 ASC";
}

// ===== 统计总数 =====
$totalResult = Db::table('gene_browse')
    ->where($where)
    ->select();
$recordsTotal = count($totalResult);

// ===== 分页数据 =====
$dataQuery = Db::table('gene_browse')
    ->where($where)
    ->order($orderSql)  // 用 CASE WHEN 排序
    ->limit($start, $length)
    ->select();

// ===== 计算 Size =====
foreach ($dataQuery as &$row) {
    $row['Size'] = intval($row['end1']) - intval($row['start1']);
}

echo json_encode([
    "draw" => $draw,
    "recordsTotal" => $recordsTotal,
    "recordsFiltered" => $recordsTotal,
    "data" => $dataQuery
], JSON_UNESCAPED_UNICODE);
exit;