<?php
session_start();
$DS = DIRECTORY_SEPARATOR;
require dirname(__DIR__) . "{$DS}app{$DS}Db.class.php";
require dirname(__DIR__) . "{$DS}app{$DS}Func.php";

// ---------- 1. 接收参数 ----------
$keyword = $_POST['keyword'] ?? '';
$groupBy = $_POST['groupBy'] ?? ''; // 接收柱状图传来的分类名

$draw = $_POST['draw'] ?? 1;
$row = $_POST['start'] ?? 0;
$rowperpage = $_POST['length'] ?? 10;
$columnIndex = $_POST['order'][0]['column'] ?? 0;
$columnName = $_POST['columns'][$columnIndex]['data'] ?? 'SampleName';
$columnSortOrder = $_POST['order'][0]['dir'] ?? 'asc';
$searchValue = $_POST['search']['value'] ?? '';

$keywordQuery = "%$keyword%";
$searchQuery = "%$searchValue%";

// 校验 groupBy 的合法性（防止 SQL 注入）
$validCols = ['ExperimentType', 'TissueCellLine', 'DiseaseType', 'Condition', 'Enzyme', 'LibraryStrategy', 'Organism', 'CellType'];
if (!empty($groupBy) && !in_array($groupBy, $validCols)) {
    $groupBy = '';
}

// ---------- 2. 总记录数 ----------
$totalRecords = Db::table('database_modified')->count();

// ---------- 3. 过滤条件逻辑 ----------
// 处理外部传来的 Keyword 和 groupBy
$whereKeyword = function ($query) use ($keyword, $keywordQuery, $groupBy) {
    if (!empty($groupBy) && $keyword !== '') {
        // 如果是从柱状图点过来的，精确匹配对应的分类列
        $query->where([[$groupBy, '=', $keyword]]);
    } else if ($keyword !== '') {
        // 如果是从词云点过来的 (没有 groupBy)，全局模糊搜索 (移除了 Datasetid)
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
            ['Enzyme', 'like', $keywordQuery],
            ['LibraryStrategy', 'like', $keywordQuery],
            ['ExperimentType', 'like', $keywordQuery],
        ]);
    }
};

// 处理 DataTables 右上角的内置搜索框
$whereSearch = function ($query) use ($searchQuery) {
    if (trim($searchQuery) !== '%%') {
        // 同样移除 Datasetid
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
            ['Enzyme', 'like', $searchQuery],
            ['LibraryStrategy', 'like', $searchQuery],
            ['ExperimentType', 'like', $searchQuery],
        ]);
    }
};

// ---------- 4. 符合条件记录数 ----------
$totalRecordwithFilter = Db::table('database_modified')
    ->where($whereKeyword)
    ->where($whereSearch)
    ->count();

// ---------- 5. 查询结果 ----------
// 移除了 Datasetid，确保数据库能正常查出数据
$result = Db::table('database_modified')
    ->where($whereKeyword)
    ->where($whereSearch)
    ->field('SampleName, Organism, DiseaseType, TissueCellLine, CellType, Condition, PMID, GEOStudy, Source, ExperimentType, Enzyme, LibraryStrategy')
    ->order($columnName . ' ' . $columnSortOrder)
    ->limit($row, $rowperpage)
    ->select();

// ---------- 6. 返回 JSON ----------
// 使用 DataTables 新版标准参数名称，同时保留旧版以防兼容性问题
$response = [
    "draw" => intval($draw),
    "recordsTotal" => $totalRecords,
    "recordsFiltered" => $totalRecordwithFilter,
    "data" => $result ? $result : []
];

echo json_encode($response, JSON_UNESCAPED_UNICODE);