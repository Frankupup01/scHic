<?php
set_time_limit(120);
header('Content-Type: application/json');
session_start();

$DS = DIRECTORY_SEPARATOR;
require dirname(__DIR__) . "{$DS}app{$DS}Db.class.php";
require dirname(__DIR__) . "{$DS}app{$DS}Func.php";

$chr2 = $_POST['chr2'] ?? '';
$range2Min = intval($_POST['range2Min'] ?? 0);
$range2Max = intval($_POST['range2Max'] ?? 0);
$draw   = intval($_POST['draw'] ?? 1);
$start  = intval($_POST['start'] ?? 0);
$length = intval($_POST['length'] ?? 10);

try {
    $totalCount = 0;
    $chr2Rows = [];

    if (!empty($chr2) && $range2Min > 0 && $range2Max > 0) {
        $totalCount = Db::table('gene_browse')
            ->where([['chr1', '=', $chr2]])
            ->where([['start1', '>=', $range2Min]])
            ->where([['end1', '<=', $range2Max]])
            ->count();

        $chr2Rows = Db::table('gene_browse')
            ->where([['chr1', '=', $chr2]])
            ->where([['start1', '>=', $range2Min]])
            ->where([['end1', '<=', $range2Max]])
            ->limit($start, $length)
            ->select();
    }

    $data = [];
    foreach ($chr2Rows as $g2) {
        $data[] = [
            'chr2_gene_sites'      => "{$g2['chr1']}:{$g2['start1']}-{$g2['end1']}",
            'chr2_strand'          => $g2['strand'] ?? '',
            'chr2_gene_name'       => $g2['geneid'] ?? '',
            'chr2_promoter_region' => "{$g2['chr2']}:{$g2['Promoter1']}-{$g2['Promoter2']}",
            'chr2_enhancer_count'  => Db::table('enhancer_browse')
                ->where([['chr', '=', $g2['chr1']]])
                ->where([['end', '>=', $g2['start1']]])
                ->where([['start', '<=', $g2['end1']]])
                ->count()
        ];
    }

    echo json_encode([
        'draw' => $draw,
        'recordsTotal' => $totalCount,
        'recordsFiltered' => $totalCount,
        'data' => $data
    ]);
} catch (Exception $e) {
    echo json_encode([
        'draw' => $draw,
        'recordsTotal' => 0,
        'recordsFiltered' => 0,
        'data' => [],
        'error' => $e->getMessage()
    ]);
}