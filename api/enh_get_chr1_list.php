<?php
header('Content-Type: application/json');
session_start();

$DS = DIRECTORY_SEPARATOR;
require dirname(__DIR__) . "{$DS}app{$DS}Db.class.php";
require dirname(__DIR__) . "{$DS}app{$DS}Func.php";

$sid = $_POST['sid'] ?? '';

if (empty($sid)) {
    echo json_encode(['status' => 'error', 'message' => 'Missing source ID']);
    exit;
}

try {
    // 1. 先从 database_modified 表中根据 Source 找 SampleName
    $sample_rows = Db::table('database_modified')
        ->where([['Source', '=', $sid]])
        ->field('SampleName')
        ->select();

    if (!$sample_rows || count($sample_rows) === 0) {
        echo json_encode(['status' => 'error', 'message' => 'No sample found for given source']);
        exit;
    }

    $sample_name = $sample_rows[0]['SampleName'];

    // 2. 再用 SampleName 去 chr_browse 表中找对应 Sampleid 的 Chr2 列（去重）
    $chr_rows = Db::table('chr_browse')
        ->where([['Sampleid', '=', $sample_name]])
        ->field('DISTINCT Chr2')
        ->select();

    $chr_list = array_column($chr_rows, 'Chr2');

    // 自定义排序函数
    usort($chr_list, function($a, $b) {
        // 提取数字部分，支持前缀任意字符串，如 chr1, chr10, chrX
        $numA = null;
        $numB = null;

        if (preg_match('/(\d+)/', $a, $matchA)) {
            $numA = (int)$matchA[1];
        }
        if (preg_match('/(\d+)/', $b, $matchB)) {
            $numB = (int)$matchB[1];
        }

        // 都有数字时按数字排序
        if ($numA !== null && $numB !== null) {
            if ($numA == $numB) {
                // 数字相等，按字母排序
                return strcmp($a, $b);
            }
            return $numA <=> $numB;
        }

        // 只有a有数字，a排前
        if ($numA !== null) {
            return -1;
        }

        // 只有b有数字，b排前
        if ($numB !== null) {
            return 1;
        }

        // 都没有数字，按字母排序
        return strcmp($a, $b);
    });

    echo json_encode([
        'status' => 'success',
        'data' => $chr_list
    ]);

} catch (Exception $e) {
    echo json_encode([
        'status' => 'error',
        'message' => '查询异常：' . $e->getMessage()
    ]);
}