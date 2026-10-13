<?php
session_start();
$DS = DIRECTORY_SEPARATOR;
require dirname(__DIR__) . "{$DS}app{$DS}Db.class.php";
require dirname(__DIR__) . "{$DS}app{$DS}Func.php";

// 获取 DataTables 参数
$keyword = $_POST['keyword'] ?? '';
$draw = $_POST['draw'] ?? 1;
$row = $_POST['start'] ?? 0;
$rowperpage = $_POST['length'] ?? 10;
$columnIndex = $_POST['order'][0]['column'] ?? 0;
$columnName = $_POST['columns'][$columnIndex]['data'] ?? 'Organism';
$columnSortOrder = $_POST['order'][0]['dir'] ?? 'asc';

// 模糊匹配关键字
$keywordQuery = "%$keyword%";

// 查询字段
$fields = 'Organism, SampleName, TissueCellLine, ExperimentType, DiseaseType, Datasetid, Condition, PMID, GEOStudy, Source';

// 构建查询
$query = Db::table('database_modified')
    ->whereOr([
        ["Organism", "like", $keywordQuery],
        ["SampleName", "like", $keywordQuery],
        ["TissueCellLine", "like", $keywordQuery],
        ["ExperimentType", "like", $keywordQuery],
        ["DiseaseType", "like", $keywordQuery],
        ["Datasetid", "like", $keywordQuery],
        ["Condition", "like", $keywordQuery],
        ["PMID", "like", $keywordQuery],
    ]);

// 计算总数
$totalRecords = $query->count();

// 获取分页数据
$result = $query->field($fields)
    ->order($columnName . ' ' . $columnSortOrder)
    ->limit($row, $rowperpage)
    ->select();

// 构造返回 JSON
$response = array(
    "draw" => intval($draw),
    "iTotalRecords" => $totalRecords,
    "iTotalDisplayRecords" => $totalRecords,
    "aaData" => $result
);

header('Content-Type: application/json; charset=utf-8');
echo json_encode($response, JSON_UNESCAPED_UNICODE);