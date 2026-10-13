<?php
session_start();
$DS = DIRECTORY_SEPARATOR;
require dirname(__DIR__) . "{$DS}app{$DS}Db.class.php";
require dirname(__DIR__) . "{$DS}app{$DS}Func.php";

$select_specie = $_POST['select_specie'];
$select_disease = $_POST['select_disease'];
$select_celltype = $_POST['select_celltype'];

// 映射物种名
$specie_map = [
    'Homo Sapiens' => 'Homo sapiens',
    'Mus Musculus' => 'Mus musculus',
    'HUMAN' => 'Homo sapiens',
    'MOUSE' => 'Mus musculus'
];
if (array_key_exists($select_specie, $specie_map)) {
    $select_specie = $specie_map[$select_specie];
}

// DataTables 请求参数
$draw = $_POST['draw'];
$row = $_POST['start'];
$rowperpage = $_POST['length'];
$columnIndex = $_POST['order'][0]['column'];
$columnName = $_POST['columns'][$columnIndex]['data'];
$columnSortOrder = $_POST['order'][0]['dir'];
$searchValue = $_POST['search']['value'];
$searchQuery = '%' . $searchValue . '%';

// 查询条件
$map = [];
$map[] = ['Organism', '=', $select_specie];
$map[] = ['DiseaseType', '=', $select_disease];
$map[] = ['CellType', '=', $select_celltype];

// 表名
$table = 'database_modified';

// 总记录数
$totalRecords = Db::table($table)->where($map)->count();

// 搜索后记录数
$totalRecordwithFilter = Db::table($table)
    ->where($map)
    ->where(function ($query) use ($searchQuery) {
        $query->whereOr([
            ['SampleName', 'like', $searchQuery],
            ['GEOStudy', 'like', $searchQuery],
            ['Organism', 'like', $searchQuery],
            ['ExperimentType', 'like', $searchQuery],
            ['PMID', 'like', $searchQuery],
        ]);
    })
    ->count();

// 获取分页数据
$result = Db::table($table)
    ->where($map)
    ->where(function ($query) use ($searchQuery) {
        $query->whereOr([
            ['SampleName', 'like', $searchQuery],
            ['GEOStudy', 'like', $searchQuery],
            ['Organism', 'like', $searchQuery],
            ['ExperimentType', 'like', $searchQuery],
            ['PMID', 'like', $searchQuery],
            ['CellType', 'like', $searchQuery],
        ]);
    })
    ->field('SampleName, GEOStudy, Organism, ExperimentType, PMID, TissueCellLine, DiseaseType, CellType, Source')
    ->order($columnName . ' ' . $columnSortOrder)
    ->limit($row, $rowperpage)
    ->select();

// 返回 JSON
$response = array(
    "draw" => intval($draw),
    "iTotalRecords" => $totalRecords,
    "iTotalDisplayRecords" => $totalRecordwithFilter,
    "aaData" => $result
);

echo json_encode($response, JSON_UNESCAPED_UNICODE); 