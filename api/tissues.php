<?php
header('Content-Type: application/json');
require dirname(__DIR__).'/app/Db.class.php';

$species = $_GET['species'] ?? '';
if(!$species){
    echo json_encode([]);
    exit;
}

$tissues = Db::table('database_modified')
    ->field('DISTINCT TissueCellLine')
    ->where([['Organism','=',$species]])
    ->order('TissueCellLine ASC')
    ->select();

$result = [];
foreach($tissues as $row){
    $result[] = [$row['TissueCellLine']]; // 返回二维数组，兼容前端
}

echo json_encode($result, JSON_UNESCAPED_UNICODE);
exit;