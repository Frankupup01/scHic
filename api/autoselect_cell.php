<?php

session_start();
$DS = DIRECTORY_SEPARATOR;
require dirname(__DIR__)."{$DS}app{$DS}Db.class.php";
require dirname(__DIR__)."{$DS}app{$DS}Func.php";



$select_specie = $_POST['select_specie'];
$select_disease = $_POST['select_disease'];

//$select_specie = 'Gallus gallus';
//$select_experiment = 'SMARTer';

//$select_specie = 'Homo Sapiens';
//$select_specie = 'Mus musculus';
//$select_experiment = 'Smart-seq2';


$specie_map = [
    'Homo sapiens' => 'Homo sapiens',
    'Mus musculus' => 'Mus musculus',
    'HUMAN' => 'Homo sapiens',
    'MOUSE' => 'Mus musculus'
];

// 如果前端传入的物种在映射中有对应关系，则使用映射后的值
if (array_key_exists($select_specie, $specie_map)) {
    $select_specie = $specie_map[$select_specie];
}




// 根据物种映射，构造查询条件
//$species_to_query = $specie_map[$select_specie];
$map[] = ['Species', '=', $select_specie];
$map[] = ['DiseaseType', '=', $select_disease];

$result = Db::table('database_modified')->where($map)
    ->field('TissueCellLine')->select();


// 从查询结果中提取 project_id 值

$tissue_ids = [];
foreach ($result as $row) {
    $tissue_ids[] = $row['TissueCellLine'];  // 假设您的字段名是 project_id
}

// 去重处理
$unique_tissue_ids = array_unique($tissue_ids);

// 格式化为数组形式
$response = array_values($unique_tissue_ids);  // 保证返回的数组索引从 0 开始

// 返回 JSON 格式
echo json_encode($response);
