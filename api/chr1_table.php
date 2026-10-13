<?php
set_time_limit(120);
header('Content-Type: application/json');
session_start();

$DS = DIRECTORY_SEPARATOR;
require dirname(__DIR__) . "{$DS}app{$DS}Db.class.php";
require dirname(__DIR__) . "{$DS}app{$DS}Func.php";

// 只接收 Chr1 需要的参数
$chr1 = $_POST['chr1'] ?? '';
$range1Min = intval($_POST['range1Min'] ?? 0);
$range1Max = intval($_POST['range1Max'] ?? 0);

$draw   = intval($_POST['draw'] ?? 1);
$start  = intval($_POST['start'] ?? 0);
$length = intval($_POST['length'] ?? 10);

try {
    $totalCount = 0;
    $chr1Rows = [];

    // ----------- 仅查询 Chr1 的数据 -----------
    if (!empty($chr1) && $range1Min > 0 && $range1Max > 0) {
        $totalCount = Db::table('gene_browse')
            ->where([['chr1', '=', $chr1]])
            ->where([['start1', '>=', $range1Min]])
            ->where([['end1', '<=', $range1Max]])
            ->count();

        $chr1Rows = Db::table('gene_browse')
            ->where([['chr1', '=', $chr1]])
            ->where([['start1', '>=', $range1Min]])
            ->where([['end1', '<=', $range1Max]])
            ->limit($start, $length)
            ->select();
    }

    // ----------- 组装前端需要的数据 -----------
    $data = [];
    foreach ($chr1Rows as $g1) {
        $data[] = [
            'chr1_gene_sites'      => "{$g1['chr1']}:{$g1['start1']}-{$g1['end1']}",
            'chr1_strand'          => $g1['strand'] ?? '',
            'chr1_gene_name'       => $g1['geneid'] ?? '',
            'chr1_promoter_region' => "{$g1['chr2']}:{$g1['Promoter1']}-{$g1['Promoter2']}",
            'chr1_enhancer_count'  => Db::table('enhancer_browse')
                ->where([['chr', '=', $g1['chr1']]])
                ->where([['end', '>=', $g1['start1']]])
                ->where([['start', '<=', $g1['end1']]])
                ->count()
        ];
    }

    // 返回纯净的 Chr1 结果
    echo json_encode([
        'draw'            => $draw,
        'recordsTotal'    => $totalCount,
        'recordsFiltered' => $totalCount,
        'data'            => $data
    ]);

} catch (Exception $e) {
    echo json_encode([
        'draw'            => $draw,
        'recordsTotal'    => 0,
        'recordsFiltered' => 0,
        'data'            => [],
        'error'           => $e->getMessage()
    ]);
}