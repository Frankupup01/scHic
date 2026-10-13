<!--include base-->
<?php
include "./Template/base.php";
?>
<!--include header-->
<?php
include "./Template/header.php";
?>
<body background="" class="float">
<br>
<div id="header_map"></div>
<div class="container" id="body">
    <div class="card-header">
        <h4 style="font-size: 24px; color: rgb(41,101,124)" id="yhead">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-graph-up-arrow" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M0 0h1v15h15v1H0zm10 3.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 .5.5v4a.5.5 0 0 1-1 0V4.9l-3.613 4.417a.5.5 0 0 1-.74.037L7.06 6.767l-3.656 5.027a.5.5 0 0 1-.808-.588l4-5.5a.5.5 0 0 1 .758-.06l2.609 2.61L13.445 4H10.5a.5.5 0 0 1-.5-.5"/>
            </svg>
             Statistic of scHI-Cdb
        </h4>
    </div>

    <div class="row">
        <hr>
        <div class="col-lg-6"><center><span style="font-size: 18px; font-weight: bold;">Human</span></center><div id="view_human" style="height: 370px;"></div></div>
        <div class="col-lg-6"><center><span style="font-size: 18px; font-weight: bold;padding-left: 130px">Mouse</span></center><div id="view_mouse" style="height: 370px;padding-left: 80px"></div></div>
    </div>
</div>
<div class="row">
    <hr>
    <div class="col-lg-6" style="position: relative; padding-left: 100px;">
        <div style="font-size: 18px; font-weight: bold; text-align: center; margin-bottom: 10px;">Human</div>

        <!-- 切换按钮 -->
        <div style="text-align: center; margin-bottom: 10px;">
            <button class="btn btn-primary btn-sm" onclick="switchChartHuman('tissue_human')">Tissue/Cell Line</button>
            <button class="btn btn-primary btn-sm" onclick="switchChartHuman('annotation_human')">Annotation</button>
        </div>

        <!-- 可变标题 -->
        <div id="chartTitleHuman" style="font-size: 18px; text-align: center; margin-bottom: 20px;">
            The number of enhancer in each tissue/cell line
        </div>

        <div id="viewhuman" style="height: 400px;"></div>
    </div>

    <div class="col-lg-6" style="position: relative; padding-left: 40px;">
        <div style="font-size: 18px; font-weight: bold; text-align: center; margin-bottom: 10px;">Mouse</div>

        <!-- 切换按钮 -->
        <div style="text-align: center; margin-bottom: 10px;">
            <button class="btn btn-primary btn-sm" onclick="switchChartMouse('tissue_mouse')">Tissue/Cell Line</button>
            <button class="btn btn-primary btn-sm" onclick="switchChartMouse('annotation_mouse')">Annotation</button>
        </div>

        <!-- 可变标题 -->
        <div id="chartTitleMouse" style="font-size: 18px; text-align: center; margin-bottom: 20px;">
            The number of enhancer in each tissue/cell line
        </div>

        <div id="viewmouse" style="height: 400px;"></div>
    </div>
</div>


<script>
const datasets = [
{
elementId: 'view_human',
color: '#5470c6',
xData: ['chr1', 'chr2', 'chr3', 'chr4', 'chr5', 'chr6', 'chr7', 'chr8', 'chr9', 'chr10', 'chr11', 'chr12', 'chr13', 'chr14', 'chr15', 'chr16', 'chr17', 'chr18', 'chr19', 'chr20', 'chr21', 'chr22', 'chrX', 'chrY'],
yData: [89979, 88335, 68897, 51437, 58598, 64815, 50674, 50282, 43831, 52884, 47518, 47853, 28718, 31838, 33574, 28772, 35824, 24913, 18514, 26905, 13307, 17146, 23160, 503]
},
{
elementId: 'view_mouse',
color: '#91cc75',
xData: ['chr1', 'chr2', 'chr3', 'chr4', 'chr5', 'chr6', 'chr7', 'chr8', 'chr9', 'chr10','chr11','chr12','chr13','chr14','chr15','chr16','chr17','chr18','chr19','chrX','chrY'],
yData: [15613,17291,11762,14684,13989,12574,11712,11663,12759,11440,14460,10515,11081,8186,8965,6556,7524,7316,5589,2154,2]
}
];

function renderBarChart({ elementId, color, xData, yData }) {
const chart = echarts.init(document.getElementById(elementId));
const option = {
color: [color],
tooltip: {
trigger: 'axis',
axisPointer: { type: 'shadow' }   //可选shadow or line
},
grid: { top: "18%", left: '0%', right: '4%', bottom: '7%', containLabel: true },
xAxis: {
type: 'category',
data: xData,
axisLabel: { interval: 0, rotate: 40 }
},
yAxis: { type: 'value' },
series: [{
type: 'bar',
barGap: 0,
label: { show: false },
data: yData
}]
};
chart.setOption(option);
}

// 渲染所有图表
datasets.forEach(renderBarChart);

</script>
<!-- Human数据 -->
<script>
    let currentChartTypeHuman = 'tissue_human'; // 默认类型

    function switchChartHuman(type) {
        currentChartTypeHuman = type;

        const titleDiv = document.getElementById('chartTitleHuman');
        titleDiv.innerText = (type === 'tissue_human')
            ? 'The number of enhancer in each tissue/cell line'
            : 'The number of enhancer annotation';

        drawPieChartViewhuman();
    }

    function drawPieChartViewhuman() {
        const chartDom = document.getElementById('viewhuman');
        if (!chartDom) return;

        const existing = echarts.getInstanceByDom(chartDom);
        if (existing) echarts.dispose(chartDom);

        const myChart = echarts.init(chartDom);

        const newData = (currentChartTypeHuman === 'tissue_human') ? [
            { value: 67258, name: 'VISTA' },
            { value: 28446, name: 'PC-3' },
            { value: 27603, name: 'GM23248' },
            { value: 24683, name: 'Astrocyte' },
            { value: 22072, name: 'Skeletal muscle myoblast' },
            { value: 20967, name: 'Stomach' },
            { value: 20097, name: 'IMR90' },
            { value: 20037, name: 'GM23338' },
            { value: 19447, name: 'Spinal cord' },
            { value: 19269, name: 'PC-9' },
        ] : [
            { value: 12000, name: 'Enhancer A' },
            { value: 9000, name: 'Enhancer B' },
            { value: 7500, name: 'Enhancer C' },
            { value: 5000, name: 'Enhancer D' },
            { value: 3000, name: 'Enhancer E' },
        ];

        const option = {
            legend: {
                top: 20,
                type: 'scroll'
            },
            tooltip: {
                trigger: 'item',
                formatter: "{b}: {c} ({d}%)"
            },
            series: [{
                type: 'pie',
                radius: '60%',
                center: ['50%', '70%'],
                label: {
                    show: true,
                    formatter: '{c} \n({d}%)',
                    position: 'inside'
                },
                data: newData
            }]
        };

        myChart.setOption(option);
    }

    document.addEventListener('DOMContentLoaded', function () {
        drawPieChartViewhuman();
    });
</script>
<!-- Mouse数据 -->
<script>
    let currentChartTypeMouse = 'tissue_mouse'; // 默认类型

    function switchChartMouse(type) {
        currentChartTypeMouse = type;

        const titleDiv = document.getElementById('chartTitleMouse');
        titleDiv.innerText = (type === 'tissue_mouse')
            ? 'The number of enhancer in each tissue/cell line'
            : 'The number of enhancer annotation';

        drawPieChartViewmouse();
    }

    function drawPieChartViewmouse() {
        const chartDom = document.getElementById('viewmouse');
        if (!chartDom) return;

        const existing = echarts.getInstanceByDom(chartDom);
        if (existing) echarts.dispose(chartDom);

        const myChart = echarts.init(chartDom);

        const newData = (currentChartTypeMouse === 'tissue_mouse') ? [
            { value: 67258, name: 'VISTA' },
            { value: 28446, name: 'PC-3' },
            { value: 27603, name: 'GM23248' },
            { value: 24683, name: 'Astrocyte' },
            { value: 22072, name: 'Skeletal muscle myoblast' },
            { value: 20967, name: 'Stomach' },
            { value: 20097, name: 'IMR90' },
            { value: 20037, name: 'GM23338' },
            { value: 19447, name: 'Spinal cord' },
            { value: 19269, name: 'PC-9' },
        ] : [
            { value: 12000, name: 'Enhancer A' },
            { value: 9000, name: 'Enhancer B' },
            { value: 7500, name: 'Enhancer C' },
            { value: 5000, name: 'Enhancer D' },
            { value: 3000, name: 'Enhancer E' },
        ];

        const option = {
            legend: {
                top: 20,
                type: 'scroll'
            },
            tooltip: {
                trigger: 'item',
                formatter: "{b}: {c} ({d}%)"
            },
            series: [{
                type: 'pie',
                radius: '60%',
                center: ['50%', '70%'],
                label: {
                    show: true,
                    formatter: '{c} \n({d}%)',
                    position: 'inside'
                },
                data: newData
            }]
        };

        myChart.setOption(option);
    }

    document.addEventListener('DOMContentLoaded', function () {
        drawPieChartViewmouse();
    });
</script>
    <!--include footer-->
<?php
include "./Template/footer.php";
?>


