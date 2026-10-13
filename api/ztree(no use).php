<?php
header('Content-Type: application/json');
require_once("../app/Db.class.php"); // 你自己的数据库连接类

$organism = $_POST['organism'] ?? '';
$tissue   = $_POST['tissue'] ?? '';
$cellline = $_POST['cellline'] ?? '';

$db = new Db();

// 拼接查询
$sql = "SELECT * FROM database_modified WHERE 1=1 ";
$params = [];

if (!empty($organism)) {
    $sql .= " AND Organism = :organism";
    $params[':organism'] = $organism;
}
if (!empty($tissue)) {
    $sql .= " AND TissueCellLine = :tissue";
    $params[':tissue'] = $tissue;
}
if (!empty($cellline)) {
    $sql .= " AND TissueCellLine = :cellline";  // 如果 cellline 和 tissue 是分开的表字段就改成对应的
    $params[':cellline'] = $cellline;
}

$result = $db->query($sql, $params);

echo json_encode([
    "status" => "success",
    "count"  => count($result),
    "data"   => $result
]);;