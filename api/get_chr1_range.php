<?php
header('Content-Type: application/json');
require dirname(__DIR__) . '/app/Db.class.php';
require dirname(__DIR__) . '/app/Func.php';

$sid = $_POST['sid'] ?? '';
$chrFull = $_POST['chr'] ?? '';

if (!$sid || !$chrFull) {
    exit(json_encode(['status' => 'error', 'message' => '缺少参数']));
}

try {
    // 找 SampleName
    $sampleRow = Db::table('database_modified')
        ->where([['Source', '=', $sid]])
        ->field('SampleName')
        ->select();

    if (empty($sampleRow)) {
        exit(json_encode(['status' => 'error', 'message' => '找不到对应 SampleName']));
    }
    $sample = $sampleRow[0]['SampleName'];

    // 解析 chrFull:
    // 支持 "chr1|left"、"chr1 (left)"、"chr1"
    $chrFull = trim($chrFull);
    $side = 'left';
    if (strpos($chrFull, '|') !== false) {
        $parts = explode('|', $chrFull);
        $chr = trim($parts[0]);
        $side = strtolower(trim($parts[1]));
    } elseif (preg_match('/^(.+?)\s*\((left|right)\)\s*$/i', $chrFull, $m)) {
        $chr = trim($m[1]);
        $side = strtolower($m[2]);
    } else {
        $chr = $chrFull;
    }

    // 规范化 chr（去掉多余空白）
    $chr = trim($chr);

    // 写日志便于排查（查看 php error log）
    error_log("get_chr1_range | sid=$sid | sample=$sample | chrFull={$chrFull} | chr={$chr} | side={$side}");

    // 查询 left side stats (Chr1 -> Start1/End1)
    $leftStats = Db::table('chr_browse')
        ->where([['Sampleid', '=', $sample], ['Chr1', '=', $chr]])
        ->field('COUNT(*) as cnt, MIN(Start1) as min, MAX(End1) as max')
        ->select()[0];

    // 查询 right side stats (Chr2 -> Start2/End2)
    $rightStats = Db::table('chr_browse')
        ->where([['Sampleid', '=', $sample], ['Chr2', '=', $chr]])
        ->field('COUNT(*) as cnt, MIN(Start2) as min, MAX(End2) as max')
        ->select()[0];

    // 如果选中的侧没有数据，尝试 LIKE 模糊匹配一次（宽松匹配）
    if (($side === 'left' && intval($leftStats['cnt'] ?? 0) === 0) ||
        ($side === 'right' && intval($rightStats['cnt'] ?? 0) === 0)) {
        // 尝试模糊匹配（例如数据库里是 "chr1_extra"）
        $like = $chr . '%';
        if ($side === 'left') {
            $leftLike = Db::table('chr_browse')
                ->where([['Sampleid', '=', $sample], ['Chr1', 'LIKE', $like]])
                ->field('COUNT(*) as cnt, MIN(Start1) as min, MAX(End1) as max')
                ->select()[0];
            if (intval($leftLike['cnt'] ?? 0) > 0) {
                $leftStats = $leftLike;
                error_log("get_chr1_range | left LIKE matched for {$chr}");
            }
        } else {
            $rightLike = Db::table('chr_browse')
                ->where([['Sampleid', '=', $sample], ['Chr2', 'LIKE', $like]])
                ->field('COUNT(*) as cnt, MIN(Start2) as min, MAX(End2) as max')
                ->select()[0];
            if (intval($rightLike['cnt'] ?? 0) > 0) {
                $rightStats = $rightLike;
                error_log("get_chr1_range | right LIKE matched for {$chr}");
            }
        }
    }

    // 保护 null
    $left = [
        'count' => intval($leftStats['cnt'] ?? 0),
        'min' => isset($leftStats['min']) ? (int)$leftStats['min'] : null,
        'max' => isset($leftStats['max']) ? (int)$leftStats['max'] : null
    ];
    $right = [
        'count' => intval($rightStats['cnt'] ?? 0),
        'min' => isset($rightStats['min']) ? (int)$rightStats['min'] : null,
        'max' => isset($rightStats['max']) ? (int)$rightStats['max'] : null
    ];

    // 选择返回哪一侧
    $use = ($side === 'right') ? $right : $left;

    // 当选中侧没有数据但另一侧有数据时，提供 note 提示，但仍返回选中侧（可能为 null）
    $note = null;
    if ($use['count'] === 0 && ($left['count'] > 0 || $right['count'] > 0)) {
        $note = 'Selected side has no rows; other side has data.';
    }

    // 返回 selected min/max（如果为 null, 前端会处理成默认值）
    $min = $use['min'] ?? 0;
    $max = $use['max'] ?? 0;

    echo json_encode([
        'status' => 'success',
        'data' => [
            'min' => (int)$min,
            'max' => (int)$max
        ],
        'debug' => [
            'requested' => ['chrFull' => $chrFull, 'chr' => $chr, 'side' => $side],
            'left' => $left,
            'right' => $right,
            'note' => $note
        ]
    ]);
} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}