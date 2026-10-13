<?php
session_start();
$DS = DIRECTORY_SEPARATOR;
require dirname(__DIR__) . "{$DS}app{$DS}Db.class.php";
require dirname(__DIR__) . "{$DS}app{$DS}Func.php";

$select_specie = $_POST['select_specie'];
$select_experimenttype = $_POST['select_experimenttype'];

// 映射组合物种
$specie_map = [
    'Homo sapiens' => ['Homo sapiens', 'Mus musculus/Homo sapiens'],
    'Mus musculus' => ['Mus musculus', 'Mus musculus/Homo sapiens'],
    'Drosophila melanogaster' => ['Drosophila melanogaster'],
    'Oryza sativa Japonica Group' => ['Oryza sativa Japonica Group']
];
$species_to_query = $specie_map[$select_specie] ?? [$select_specie];

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
$map[] = ['Organism', 'IN', $species_to_query];
$map[] = ['ExperimentType', 'LIKE', "%{$select_experimenttype}%"];

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
            ['TissueCellLine', 'like', $searchQuery],
            ['DiseaseType', 'like', $searchQuery],
            ['ExperimentType', 'like', $searchQuery],
            ['PMID', 'like', $searchQuery],
            ['CellType', 'like', $searchQuery],
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
            ['DiseaseType', 'like', $searchQuery],
            ['ExperimentType', 'like', $searchQuery],
            ['TissueCellLine', 'like', $searchQuery],
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
