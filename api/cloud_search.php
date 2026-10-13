<?php
session_start();
$DS = DIRECTORY_SEPARATOR;
require dirname(__DIR__) . "{$DS}app{$DS}Db.class.php";
require dirname(__DIR__) . "{$DS}app{$DS}Func.php";

// 接收参数
$keyword = $_POST['keyword'] ?? '';
$draw = $_POST['draw'] ?? 1;
$row = $_POST['start'] ?? 0;
$rowperpage = $_POST['length'] ?? 10;
$columnIndex = $_POST['order'][0]['column'] ?? 0;
$columnName = $_POST['columns'][$columnIndex]['data'] ?? 'SampleName';
$columnSortOrder = $_POST['order'][0]['dir'] ?? 'asc';
$searchValue = $_POST['search']['value'] ?? '';

$keywordQuery = "%$keyword%";
$searchQuery = "%$searchValue%";

// ---------- 总记录数 ----------
$totalRecords = Db::table('database_modified')->count();

// ---------- 过滤条件 ----------
$whereKeyword = function ($query) use ($keywordQuery, $keyword) {
    if ($keyword !== '') {
        // 🌟 核心修复：彻底删除了 Datasetid
        $query->whereOr([
            ['SampleName', 'like', $keywordQuery],
            ['Organism', 'like', $keywordQuery],
            ['DiseaseType', 'like', $keywordQuery],
            ['TissueCellLine', 'like', $keywordQuery],
            ['CellType', 'like', $keywordQuery],
            ['Condition', 'like', $keywordQuery],
            ['PMID', 'like', $keywordQuery],
            ['GEOStudy', 'like', $keywordQuery],
            ['Source', 'like', $keywordQuery],
            ['ExperimentType', 'like', $keywordQuery],
        ]);
    }
};

$whereSearch = function ($query) use ($searchQuery) {
    if (trim($searchQuery) !== '%%') {
        // 🌟 核心修复：彻底删除了 Datasetid
        $query->whereOr([
            ['SampleName', 'like', $searchQuery],
            ['Organism', 'like', $searchQuery],
            ['DiseaseType', 'like', $searchQuery],
            ['TissueCellLine', 'like', $searchQuery],
            ['CellType', 'like', $searchQuery],
            ['Condition', 'like', $searchQuery],
            ['PMID', 'like', $searchQuery],
            ['GEOStudy', 'like', $searchQuery],
            ['Source', 'like', $searchQuery],
            ['ExperimentType', 'like', $searchQuery],
        ]);
    }
};

// ---------- 符合条件记录数 ----------
$totalRecordwithFilter = Db::table('database_modified')
    ->where($whereKeyword)
    ->where($whereSearch)
    ->count();

// ---------- 查询结果 ----------
// 🌟 核心修复：在 field 里面去掉了 Datasetid
$result = Db::table('database_modified')
    ->where($whereKeyword)
    ->where($whereSearch)
    ->field('SampleName, Organism, DiseaseType, TissueCellLine, CellType, Condition, PMID, GEOStudy, Source, ExperimentType')
    ->order($columnName . ' ' . $columnSortOrder)
    ->limit($row, $rowperpage)
    ->select();

// ---------- 返回 JSON ----------
// 🌟 升级：使用现代 DataTables 标准参数名
$response = [
    "draw" => intval($draw),
    "recordsTotal" => $totalRecords,
    "recordsFiltered" => $totalRecordwithFilter,
    "data" => $result ? $result : []
];

echo json_encode($response, JSON_UNESCAPED_UNICODE);