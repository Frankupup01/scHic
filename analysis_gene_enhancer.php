<input type="hidden" id="selected_gene" value="<?php echo htmlspecialchars($_GET['gene_id'] ?? '', ENT_QUOTES); ?>">
<!--include base-->
<?php
include "./Template/base.php";
?>


<!--include header-->
<?php include './Template/header.php';
?>
<body>

<div class="container">
    <div class="row">
        <div class="col-lg-12">

        </div>
    </div>
    <br>

    <div class="row">
        <div class="col-lg-12">

        </div>
    </div>
    <br>
    <div class="card" id="item-1">
        <div class="card-header"> <h5 style="font-size: 25px;color: rgb(41,101,124)"><strong>Gene Information</strong></h5></div>
        <div class="card-body position_judge_1" id="sample_information">
            <div class="row">
                <table id="table1" class="table table-hover table-striped table-bordered" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th style="text-align:center">Species</th>
                        <th style="text-align:center">Gene Name</th>
                        <th style="text-align:center">Chrom</th>
                        <th style="text-align:center">Start</th>
                        <th style="text-align:center">End</th>
                        <th style="text-align:center">Strand</th>
                        <th style="text-align:center">Size(bp)</th>
                    </tr>
                    </thead>
                </table>

            </div>

        </div>
    </div>
    <br>

    <div class="card" id="item-2">
        <div class="card-header"> <h5 style="font-size: 25px;color: rgb(41,101,124)"><strong>Batch analysis result of Gene-enhancer</strong></h5></div>
        <div class="card-body position_judge_1" id="enhancer_information">
            <div class="row">

                <table id="table2" class="table table-hover table-striped table-bordered" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th style="text-align:center">Species</th>
                        <th style="text-align:center">Related Gene</th>
                        <th style="text-align:center">Enhancerid</th>
                        <th style="text-align:center">Chrom</th>
                        <th style="text-align:center">Start</th>
                        <th style="text-align:center">End</th>
                        <th style="text-align:center">Size(bp)</th>
                        <th style="text-align:center">TF</th>
                    </tr>
                    </thead>
                </table>

            </div>
        </div>
    </div>
    <br>

    <!-- gene exp -->
    <div class="card" id="item-3">
        <div class="card-header"> <h5 style="font-size: 25px;color: rgb(41,101,124)"><strong>Expression levels of genes</strong></h5></div>

        <div class="bs-component jumbotron">
            <script>
                function get_option(label, data, row, col, max) {
                    option = {
                        title: {
                            text: 'Expression level of ' + label,
                            left: 0
                        },
                        dataZoom: [
                            {
                                type: 'slider',
                                xAxisIndex: [0],
                                filterMode: 'empty',
                                start: 0,
                                end: 100,
                                zoomlock: true,
                                bottom: "3%"
                            },

                        ],
                        animation: false,
                        //配置图的坐标
                        grid: { x: '10%', y: '10%', height: "65%" },
                        xAxis: {
                            gridIndex: 0,
                            type: 'category',
                            data: col,
                            splitArea: {
                                show: true,
                            },
                            axisLabel: {
                                interval: 0,
                                rotate: 30
                            }
                        },
                        yAxis: {
                            gridIndex: 0,
                            type: 'category',
                            data: row,
                            splitArea: {
                                show: true,
                            }
                        },
                        series: [{
                            name: label,
                            type: 'heatmap',
                            data: data,
                            label: {
                                normal: {
                                    show: false,
                                }
                            },
                            itemStyle: {
                                emphasis: {
                                    shadowBlur: 10,
                                    shadowColor: 'rgba(0, 0, 0, 0.5)'
                                }
                            }
                        }],
                    };
                    return option;
                };
            </script>
            <div id="gene_expression_gtex" style="width: 100%; height: 375px; -webkit-user-select: none; position: relative; background-color: transparent;"><div style="position: relative; overflow: hidden; width: 1046px; height: 300px; padding: 0px; margin: 0px; border-width: 0px; cursor: default;"><canvas width="2092" height="600" data-zr-dom-id="zr_0" style="position: absolute; left: 0px; top: 0px; width: 1046px; height: 300px; -webkit-user-select: none; padding: 0px; margin: 0px; border-width: 0px;"></canvas></div><div></div></div>
            <div id="gene_expression_encode" style="width: 100%; height: 375px; -webkit-user-select: none; position: relative; background-color: transparent;"><div style="position: relative; overflow: hidden; width: 1046px; height: 300px; padding: 0px; margin: 0px; border-width: 0px; cursor: default;"><canvas width="2092" height="600" data-zr-dom-id="zr_0" style="position: absolute; left: 0px; top: 0px; width: 1046px; height: 300px; -webkit-user-select: none; padding: 0px; margin: 0px; border-width: 0px;"></canvas></div><div style="position: absolute; display: none; border: 0px solid rgb(51, 51, 51); white-space: nowrap; z-index: 9999999; transition: left 0.4s cubic-bezier(0.23, 1, 0.32, 1) 0s, top 0.4s cubic-bezier(0.23, 1, 0.32, 1) 0s; background-color: rgba(50, 50, 50, 0.7); border-radius: 4px; color: rgb(255, 255, 255); font-style: normal; font-variant-caps: normal; font-weight: normal; font-stretch: normal; font-size: 14px; font-family: sans-serif; line-height: 21px; padding: 5px; left: 698.72381px; top: 36.5px;">Encode<br>Lung - FAM132A : 0.51</div></div>
            <div id="gene_expression_hpa" style="width: 100%; height: 375px; -webkit-user-select: none; position: relative; background-color: transparent;"><div style="position: relative; overflow: hidden; width: 1046px; height: 300px; padding: 0px; margin: 0px; border-width: 0px;"><canvas width="2092" height="600" data-zr-dom-id="zr_0" style="position: absolute; left: 0px; top: 0px; width: 1046px; height: 300px; -webkit-user-select: none; padding: 0px; margin: 0px; border-width: 0px;"></canvas></div><div></div></div>


        </div>
    </div>

</div>





<script>
    $(document).ready(function () {
        // ======== 第一个表：Gene Information ========
        $('#table1').DataTable({
            processing: true,
            serverSide: true,
            serverMethod: 'post',
            ajax: {
                url: './api/get_gene_analysis.php',
                data: function (d) {
                    d.gene = $('#selected_gene').val() || '';
                }
            },
            columns: [
                { data: 'species' },
                { data: 'geneid' },
                { data: 'chr1' },
                { data: 'start1' },
                { data: 'end1' },
                { data: 'strand' },
                { data: 'Size' }
            ],
            columnDefs: [
                {
                    targets: "_all",
                    orderable: false,
                    searchable: false,
                    createdCell: function (td) {
                        $(td).css('text-align', 'center');
                    }
                }
            ],
            searching: false,
            pageLength: 10,
            lengthMenu: [[10, 25, 50], [10, 25, 50]]
        });

        // ======== 第二个表：Gene-enhancer 结果 ========
        $('#table2').DataTable({
            processing: true,
            serverSide: true,
            serverMethod: 'post',
            ajax: {
                url: './api/get_gene_enhancer_analysis.php',
                data: function (d) {
                    // 可以传递基因名或其他参数
                    d.gene = $('#selected_gene').val() || '';
                }
            },
            columns: [
                { data: 'species' },
                { data: 'geneid' },
                { data: 'Enhancerid' },
                { data: 'Chr' },
                { data: 'Start' },
                { data: 'End' },
                { data: 'Size' },
                { data: 'Unknown' }
            ],
            columnDefs: [
                {
                    targets: "_all",
                    orderable: false,
                    searchable: false,
                    createdCell: function (td) {
                        $(td).css('text-align', 'center');
                    }
                }
            ],
            searching: false,
            pageLength: 10,
            lengthMenu: [[10, 25, 50], [10, 25, 50]]
        });
    });
</script>

<script>
    // 获取当前 URL 中的 gene_id
    const queryString = window.location.search;
    const params = new URLSearchParams(queryString);
    const geneIdParam = params.get('gene_id');

    let geneIdArray = [];
    if (geneIdParam) {
        geneIdArray = geneIdParam.split(/\r?\n/).filter(item => item.trim() !== '');
    }
    console.log('Gene IDs:', geneIdArray);

    var gene;
    $.ajax({
        url:"./api/analysis_gexp.php",
        type:"POST",
        async: false,
        data:{ name: geneIdArray },
        dataType:"json",
        success: function (data){
            console.log("AJAX 返回：", data);
            if (!data || !data.data || !Array.isArray(data.data)) {
                console.error("后端返回的数据不合法，无法绘图！");
                return;
            }
            gene = data;
        }
    });

    function get_option(label, data, row, col, rawData) {
        // 计算每个基因（行）的最大值
        let rowMax = {};
        data.forEach(d => {
            let y = d[1];
            rowMax[y] = Math.max(rowMax[y] || 0, d[2]);
        });

        // 创建新的 data，用归一化值映射颜色
        let normData = data.map(d => {
            let y = d[1];
            let val = d[2];
            let maxVal = rowMax[y];
            let colorVal = maxVal > 0 ? val / maxVal : 0;
            return [d[0], y, colorVal];
        });

        return {
            title: { text: 'Expression level of ' + label, left: 0 },
            dataZoom: [{ type: 'slider', xAxisIndex: [0], filterMode: 'empty', start: 0, end: 100, zoomlock: true, bottom: "3%" }],
            tooltip: {
                position: 'left',
                formatter: function(params) {
                    var rawVal = rawData[params.value[1] + params.value[0]*row.length] || params.value[2];
                    return params.seriesName + '<br />' +
                        col[params.value[0]] + " - " + row[params.value[1]] +
                        " : " + rawVal.toFixed(3);
                }
            },
            animation: false,
            grid: { x: '10%', y: '10%', height: "65%" },
            xAxis: { type: 'category', data: col, splitArea: { show: true }, axisLabel: { interval: 0, rotate: 30 } },
            yAxis: { type: 'category', data: row, splitArea: { show: true } },
            visualMap: {
                min: 0,
                max: 1,  // 归一化后的值
                inRange: { color: ['#fff8dc', '#ff0000'] },
                orient: 'vertical',
                right: '0%',
                bottom: 'center'
            },
            series: [{
                name: label,
                type: 'heatmap',
                data: normData,
                label: { show: false },
                itemStyle: { emphasis: { shadowBlur: 10, shadowColor: 'rgba(0,0,0,0.5)' } }
            }]
        };
    }

    // 绘图
    echarts.init(document.getElementById("gene_expression_encode")).setOption(
        get_option("Encode", gene.data[0], gene.row, gene.col, gene.max[0], gene.raw[0])
    );
    echarts.init(document.getElementById("gene_expression_gtex")).setOption(
        get_option("GTEx", gene.data[1], gene.row, gene.col, gene.max[1], gene.raw[1])
    );
    echarts.init(document.getElementById("gene_expression_hpa")).setOption(
        get_option("HPA", gene.data[2], gene.row, gene.col, gene.max[2], gene.raw[2])
    );
</script>


<?php
include "./Template/footer.php";
?>
