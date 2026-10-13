<?php
session_start();
$DS = DIRECTORY_SEPARATOR;
require dirname(__DIR__) . "{$DS}app{$DS}Db.class.php";
require dirname(__DIR__) . "{$DS}app{$DS}Func.php";

$groupBy = $_POST['groupBy'] ?? 'ExperimentType';

// 校验合法字段
$validCols = ['ExperimentType', 'TissueCellLine', 'DiseaseType', 'Condition', 'Enzyme', 'LibraryStrategy'];
if (!in_array($groupBy, $validCols)) {
    echo json_encode([]);
    exit;
}

// 拼接 SQL 字段，兼容你的 Db::table()->select() 结构
$field = "`$groupBy` AS label, COUNT(*) AS count";

// 手动拼接 GROUP BY 和 ORDER BY，写在 table() 之后
$tableWithGroup = "database_modified GROUP BY `$groupBy` ORDER BY count DESC LIMIT 30";

$data = Db::table($tableWithGroup)
    ->field($field)
    ->select();

echo json_encode($data, JSON_UNESCAPED_UNICODE);