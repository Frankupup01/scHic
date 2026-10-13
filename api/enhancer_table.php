<?php
header('Content-Type: application/json');
session_start();

$DS = DIRECTORY_SEPARATOR;
require dirname(__DIR__) . "{$DS}app{$DS}Db.class.php";
require dirname(__DIR__) . "{$DS}app{$DS}Func.php";

// DataTables serverSide 参数
$draw   = intval($_POST['draw'] ?? 1);
$start  = intval($_POST['start'] ?? 0);   // 本页起始行
$length = intval($_POST['length'] ?? 10); // 每页行数

// 从父表传来的 gene 范围
$gene_site = $_POST['gene_site'] ?? '';

if (empty($gene_site)) {
    echo json_encode(['data' => []]);
    exit;
}

// 解析 gene_site (格式: chr:start-end)
if (!preg_match('/^([^:]+):(\d+)-(\d+)$/', $gene_site, $m)) {
    echo json_encode(['data' => []]);
    exit;
}

$chr   = $m[1];
$gstart = intval($m[2]);
$gend   = intval($m[3]);

try {
    // 先查总数（不分页）
    $totalRows = Db::table('enhancer_browse')
        ->where([['Chr', '=', $chr]])
        ->where([['End', '>=', $gstart]])
        ->where([['Start', '<=', $gend]])
        ->count();

    // 再查分页数据（limit 支持 limit(start, length)）
    $enhancerRows = Db::table('enhancer_browse')
        ->where([['Chr', '=', $chr]])
        ->where([['End', '>=', $gstart]])
        ->where([['Start', '<=', $gend]])
        ->limit($start, $length)  //  用 limit(start, length)
        ->select();

    $recordsTotal    = $totalRows;
    $recordsFiltered = $totalRows;

    $data = [];
    $debugRow = null;

    foreach ($enhancerRows as $e) {
        if ($debugRow === null) {
            $debugRow = $e;
        }
        $row = array_change_key_case((array)$e, CASE_LOWER);

        $enhancerid = $row['enhancerid'] ?? '';
        $Chr        = $row['chr'] ?? '';
        $StartPos   = $row['start'] ?? '';
        $EndPos     = $row['end'] ?? '';
        $tf         = $row['unknown'] ?? '';

        $data[] = [
            'enhancerid' => $enhancerid,
            'region'     => $Chr && $StartPos && $EndPos ? "$Chr:$StartPos-$EndPos" : ':-',
            'tf'         => $tf
        ];
    }

    echo json_encode([
        "draw"            => $draw,
        "recordsTotal"    => $recordsTotal,
        "recordsFiltered" => $recordsFiltered,
        "data"            => $data
    ]);

} catch (Exception $e) {
    echo json_encode([
        "data"  => [],
        "error" => $e->getMessage()
    ]);
}