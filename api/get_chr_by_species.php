<?php
session_start();

$DS = DIRECTORY_SEPARATOR;
require dirname(__DIR__) . "{$DS}app{$DS}Db.class.php";
require dirname(__DIR__) . "{$DS}app{$DS}Func.php";

$species = $_POST['Species'] ?? '';

if ($species) {
    // 获取匹配 Organism 的 SampleName 列表
    $sampleNames = Db::table('database_modified')
        ->where([['Organism', '=', $species]])
        ->select();

    $sampleNameArray = array_column($sampleNames, 'SampleName');

    if (empty($sampleNameArray)) {
        echo json_encode([]);
        exit;
    }

    // 查询 chr_browse 表中所有 Chr1 和 Chr2
    $chr_rows = Db::table('chr_browse')
        ->where([['Sampleid', 'in', $sampleNameArray]])
        ->select();

    $chr_list = [];

    foreach ($chr_rows as $row) {
        if (!empty($row['Chr1'])) {
            $chr_list[] = $row['Chr1'];
        }
        if (!empty($row['Chr2'])) {
            $chr_list[] = $row['Chr2'];
        }
    }

    // 去重并排序
    $chr_list = array_unique($chr_list);
    sort($chr_list, SORT_NATURAL);

    echo json_encode(array_values($chr_list));
    exit;
} else {
    echo json_encode([]);
    exit;
}