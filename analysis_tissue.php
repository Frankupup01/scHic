<!--include base-->
<?php
include "./Template/base.php";
?>
<body>
<!--include header-->
<?php include './Template/header.php';
?>
<script>

    let params = new URLSearchParams(document.location.search.substring(1));
    let species = params.get("Species");
    console.log(species);
    let tissue1 = params.get("tissue1");
    console.log(tissue1);
    let tissue2 = params.get("tissue2");
    console.log(tissue2);


</script>

<!-- shujukuneirong -->
<br>
<div class="container">
    <div class="row">
        <div class="col-lg-12">

        </div>
    </div>
    <br>

    <br>
    <div class="card" id="item-1">
        <div class="card-header"> <h5 style="font-size: 20px;color: rgb(41,101,124)"> Biosample Information</h5></div>
        <div class="card-body position_judge_1" id="sample_information">
            <div class="row">
                <div class="col-6 col_left">
                    <div class="row">
                        <div class="col-12">
                            <table class="table align-items-center mb-0 table-hover table-striped" style="font-size: large;">
                                <tbody>
                                <tr><td class="head">Sample Name:</td><td id="sample_name1"></td></tr>
                                <tr><td class="head">Cell Type:</td><td id="cell_type1"></td></tr>
                                <tr><td class="head">Health/Disease Type:</td><td id="tissue_type1"></td></tr>
                                <tr><td class="head">Condition Type:</td><td id="source1"></td></tr>
                                <tr><td class="head">Enhancer Number:</td><td id="enum1"></td></tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
                <div class="col-6">
                    <div class="row">
                        <div class="col-12">
                            <table class="table align-items-center mb-0 table-hover table-striped" style="font-size: large;">
                                <tbody>
                                <tr><td class="head">Sample Name:</td><td id="sample_name2"></td></tr>
                                <tr><td class="head">Cell Type:</td><td id="cell_type2"></td></tr>
                                <tr><td class="head">Health/Disease Type:</td><td id="tissue_type2"></td></tr>
                                <tr><td class="head">Condition Type:</td><td id="source2"></td></tr>
                                <tr><td class="head">Enhancer Number:</td><td id="enum2"></td></tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-6 columns-left">
                    <h7 style="font-size: 17px;color: black"> Chromosomal distribution of enhancers in <font color="red" id="note1">enh1</font></h7>
                    <br>
                    <div id="piesample1" style="width: 400px; height: 400px; position: relative;">

                    </div>
                    <script>
                        // 定义全局变量存储 ECharts 实例和选项
                        var myChart;
                        var option;

                        document.addEventListener('DOMContentLoaded', function () {
                            myChart = echarts.init(document.getElementById('piesample1'));

                            option = {

                                tooltip: {
                                    trigger: 'item'
                                },
                                legend: {
                                    top: 'top',
                                    type: 'scroll'
                                },
                                series: [
                                    {
                                        // name: 'Access From',
                                        type: 'pie',
                                        radius: '50%',
                                        data: [],
                                        emphasis: {
                                            itemStyle: {
                                                shadowBlur: 10,
                                                shadowOffsetX: 0,
                                                shadowColor: 'rgba(0, 0, 0, 0.5)'
                                            }
                                        }
                                    }
                                ]
                            };

                            // 将 AJAX 请求移到 DOMContentLoaded 事件内部
                            $.ajax({
                                url: "./api/analysis_enhancer_num.php",
                                type: "POST",
                                async: false,
                                data: {
                                    name: tissue1,
                                    snum: 0,
                                    sp: species,
                                },
                                dataType: "json",
                                success: function (data) {
                                    console.log(data);
                                    var newData = data.data;
                                    console.log(newData);
                                    // 更新 ECharts 数据
                                    option.series[0].data = newData;
                                    // console.log(option);
                                    // 更新数据后渲染图表
                                    myChart.setOption(option);
                                }
                            });
                        });
                    </script>
                </div>
                <div class="col-6">
                    <h7 style="font-size: 17px;color: black"> Chromosomal distribution of enhancers in <font color="red" id="note2">enh1</font></h7>
                    <br>
                    <div id="piesample2" style="width: 400px; height: 400px; position: relative;">
                    </div>
                    <script>
                        // 定义全局变量存储 ECharts 实例和选项
                        var myChart;
                        var option;

                        document.addEventListener('DOMContentLoaded', function () {
                            myChart = echarts.init(document.getElementById('piesample2'));

                            option = {
                                tooltip: {
                                    trigger: 'item'
                                },
                                legend: {
                                    top: 'top',
                                    type: 'scroll'
                                },
                                series: [
                                    {
                                        // name: 'Access From',
                                        type: 'pie',
                                        radius: '50%',
                                        data: [],
                                        emphasis: {
                                            itemStyle: {
                                                shadowBlur: 10,
                                                shadowOffsetX: 0,
                                                shadowColor: 'rgba(0, 0, 0, 0.5)'
                                            }
                                        }
                                    }
                                ]
                            };

                            // 将 AJAX 请求移到 DOMContentLoaded 事件内部
                            $.ajax({
                                url: "./api/analysis_enhancer_num.php",
                                type: "POST",
                                async: false,
                                data: {
                                    name: tissue2,
                                    snum: 0,
                                    sp: species,
                                },
                                dataType: "json",
                                success: function (data) {
                                    console.log(data);
                                    var newData = data.data;
                                    console.log(newData);
                                    // 更新 ECharts 数据
                                    option.series[0].data = newData;
                                    // console.log(option);
                                    // 更新数据后渲染图表
                                    myChart.setOption(option);
                                }
                            });
                        });
                    </script>
                </div>
            </div>

            <div class="row">
                <div class="col-6 columns-left">
                    <h7 style="font-size: 17px;color: black"> Size distribution of enhancers in <font color="red" id="note3">enh1</font></h7>
                    <br>
                    <div id="colsample1" style="width: 400px; height: 400px; position: relative;">

                    </div>
                    <script>
                        // 定义全局变量存储 ECharts 实例和选项
                        var myChart;
                        var option;

                        document.addEventListener('DOMContentLoaded', function () {
                            myChart = echarts.init(document.getElementById('colsample1'));

                            option = {
                                tooltip: {
                                    trigger: 'item'
                                },
                                legend: {
                                    top: 'top',
                                    type: 'scroll'
                                },
                                series: [
                                    {
                                        // name: 'Access From',
                                        type: 'pie',
                                        radius: '50%',
                                        data: [],
                                        emphasis: {
                                            itemStyle: {
                                                shadowBlur: 10,
                                                shadowOffsetX: 0,
                                                shadowColor: 'rgba(0, 0, 0, 0.5)'
                                            }
                                        }
                                    }
                                ]
                            };

                            // 将 AJAX 请求移到 DOMContentLoaded 事件内部
                            $.ajax({
                                url: "./api/analysis_enhancer_frament.php",
                                type: "POST",
                                async: false,
                                data: {
                                    name: tissue1,
                                    snum: 0,
                                    sp: species,
                                },
                                dataType: "json",
                                success: function (data) {
                                    console.log(data);
                                    var newData = data.data;
                                    console.log(newData);
                                    // 更新 ECharts 数据
                                    option.series[0].data = newData;
                                    // console.log(option);
                                    // 更新数据后渲染图表
                                    myChart.setOption(option);
                                }
                            });
                        });
                    </script>
                </div>

                <div class="col-6">
                    <h7 style="font-size: 17px;color: black"> Size distribution of enhancers in <font color="red" id="note4">enh1</font></h7>
                    <br>
                    <div id="colsample2" style="width: 400px; height: 400px; position: relative;">

                    </div>
                    <script>
                        // 定义全局变量存储 ECharts 实例和选项
                        var myChart;
                        var option;

                        document.addEventListener('DOMContentLoaded', function () {
                            myChart = echarts.init(document.getElementById('colsample2'));

                            option = {
                                tooltip: {
                                    trigger: 'item'
                                },
                                legend: {
                                    top: 'top',
                                    type: 'scroll'
                                },
                                series: [
                                    {
                                        // name: 'Access From',
                                        type: 'pie',
                                        radius: '50%',
                                        data: [],
                                        emphasis: {
                                            itemStyle: {
                                                shadowBlur: 10,
                                                shadowOffsetX: 0,
                                                shadowColor: 'rgba(0, 0, 0, 0.5)'
                                            }
                                        }
                                    }
                                ]
                            };

                            // 将 AJAX 请求移到 DOMContentLoaded 事件内部
                            $.ajax({
                                url: "../php/analysis_enhancer_frament.php",
                                type: "POST",
                                async: false,
                                data: {
                                    name: tissue2,
                                    snum: 0,
                                    sp: species,
                                },
                                dataType: "json",
                                success: function (data) {
                                    console.log(data);
                                    var newData = data.data;
                                    console.log(newData);
                                    // 更新 ECharts 数据
                                    option.series[0].data = newData;
                                    // console.log(option);
                                    // 更新数据后渲染图表
                                    myChart.setOption(option);
                                }
                            });
                        });
                    </script>
                </div>
            </div>
        </div>
        <br>
    </div>
</div>




<script>
    var elements1 = document.getElementById('note1');
    var elements3 = document.getElementById('note3');
    var elements5 = document.getElementById('note5');
    elements1.innerHTML = tissue1;
    elements3.innerHTML = tissue1;
    elements5.innerHTML = tissue1;

    var elements2 = document.getElementById('note2');
    var elements4 = document.getElementById('note4');
    var elements6 = document.getElementById('note6');
    elements2.innerHTML = tissue2;
    elements4.innerHTML = tissue2;
    elements6.innerHTML = tissue2;

    $(document).ready(function() {

        var table1 = $('#table1').DataTable({
            ajax: {
                url:'./api/analysis_enhancer_inf.php',
                //url:'/php/test.json/'
                type:'post',
                data:{
                    name:tissue1,
                    snum:0,
                    sp:species,
                },
                dataType:'json',
                //dataSrc:""
            },
            dom: 'lBfrtip',
            language: {
                emptyTable: "No data available"
            },
            "serverSide": true,
            "serverMethod": 'post',
            pagingType: "full_numbers",
            "order":[[0,"desc"]],//初始状态是按第一列降序排列
            //  11.30把order去掉，不会出现DataTables warning: table id=table - Ajax error. For more information about this error, please see http://datatables.net/tn/7
            "columns": [

                {
                    data: "eid",
                    //添加详情页链接
                    render: function( data, type, row, meta ){
                        return '<a href="details.php?eid=' + data + '" title="Click for more details">' + data + '</a>'
                    }
                },
                { data: "location"},
                { data:"size"},
                {
                    data: "tissue_s",orderable:false,
                    "searchable": false,
                    "render": function(data, type, row, meta) {
                        var tissueArray = data.split(', ');
                        if (meta.row === 8 || meta.row === 9) {
                            var url = '<td>' +
                                '<div class="btn-group">' +
                                '<button data-toggle="dropdown" class="btn btn-outline-primary dropdown-toggle" type="button" aria-expanded="false">' +
                                'View all ' + tissueArray.length + ' tissues' +
                                '</button>' +
                                '<div class="dropdown-menu" style="position: absolute;transform: translate3d(0px, 36px, 0px); top: -230px; left: 0px; will-change: transform; max-height: 200px; overflow-y: auto;">';
                            for (var i=0; i < tissueArray.length; i++) {
                                url += '<a class="dropdown-item">' + tissueArray[i] + '</a>';
                            };
                            url += "</div></div></td>";
                            return url;
                        }else {
                            var url = '<td>' +
                                '<div class="btn-group">' +
                                '<button data-toggle="dropdown" class="btn btn-outline-primary dropdown-toggle" type="button" aria-expanded="false">' +
                                'View all ' + tissueArray.length + ' tissues' +
                                '</button>' +
                                '<div class="dropdown-menu" style="position: absolute;transform: translate3d(0px, 36px, 0px); top: 0px; left: 0px; will-change: transform; max-height: 200px; overflow-y: auto;">';
                            for (var i=0; i < tissueArray.length; i++) {
                                url += '<a class="dropdown-item">' + tissueArray[i] + '</a>';
                            };
                            url += "</div></div></td>";
                            return url;
                        }

                    }
                },
                {data: "gv",orderable:false},
                {data: "ds",orderable:false,
                    render: function( data, type, row, meta ){
                        // var prefix = data.substring(0, 3);
                        var prefixMatch = data.match(/[a-zA-Z]+/); // 匹配英文字符
                        var prefix = prefixMatch ? prefixMatch[0] : ""; // 获取匹配到的英文字符部分
                        if(prefix === "ENCODE") {
                            return '<a href="https://www.encodeproject.org" title="Click for more details">' + data + '</a>'
                        }
                        else if (prefix === "Enhancer") {
                            return '<a href="https://enhanceratlas.org/index.php" title="Click for more details">' + data + '</a>';
                        }
                        else if (prefix === "Fantom") {
                            return '<a href="https://fantom.gsc.riken.jp/5/" title="Click for more details">' + data + '</a>';
                        }
                        else if (prefix === "Vista") {
                            return '<a href="https://enhancer.lbl.gov/vista/" title="Click for more details">' + data + '</a>';
                        }

                    }},
                {
                    "className":      'details-control',
                    "orderable":      false,
                    "data":           null,
                    "defaultContent": '',
                    "searchable": false,
                    render: function (data, type, row,meta) {
                        // var Location = row.Location + "";
                        return '<a href="http://genome.ucsc.edu/cgi-bin/hgTracks?db=hg19' +
                            '&lastVirtModeType=default&lastVirtModeExtraState=&virtModeType=' +
                            'default&virtMode=0&nonVirtPosition=&position=' +
                            data.chrom + ':' + data.start + '-' + data.end + '">' +
                            '<img src="../bootstrap-3.4.1-dist/img/ucsc.ico" class="b" style="width: 65px; height: 25px;">' +
                            '</a>';
                    }
                },

            ],
            "createdRow": function (row, data, rowIndex) {
                // Per-cell function to do whatever needed with cells
                $.each($('td', row), function (colIndex) {
                    // 设置文本水平居中和向上移动一点（例如，向上移动 5px）
                    $(this).css({
                        'text-align': 'center',
                        'vertical-align': 'middle', // 可选，确保文本在单元格中垂直居中（如果你需要的话）

                    });
                });
            }
        } );

        var table2 = $('#table2').DataTable({
            ajax: {
                url:'./api/analysis_enhancer_inf.php',
                //url:'/php/test.json/'
                type:'post',
                data:{
                    name:tissue2,
                    snum:0,
                    sp:species,
                },
                dataType:'json',
                //dataSrc:""
            },
            dom: 'lBfrtip',
            language: {
                emptyTable: "No data available"
            },
            "serverSide": true,
            "serverMethod": 'post',
            pagingType: "full_numbers",
            "order":[[0,"desc"]],//初始状态是按第一列降序排列
            //  11.30把order去掉，不会出现DataTables warning: table id=table - Ajax error. For more information about this error, please see http://datatables.net/tn/7
            "columns": [

                {
                    data: "eid",
                    //添加详情页链接
                    render: function( data, type, row, meta ){
                        return '<a href="details.php?eid=' + data + '" title="Click for more details">' + data + '</a>'
                    }
                },
                { data: "location"},
                { data:"size"},
                {
                    data: "tissue_s",orderable:false,
                    "searchable": false,
                    "render": function(data, type, row, meta) {
                        var tissueArray = data.split(', ');
                        if (meta.row === 8 || meta.row === 9) {
                            var url = '<td>' +
                                '<div class="btn-group">' +
                                '<button data-toggle="dropdown" class="btn btn-outline-primary dropdown-toggle" type="button" aria-expanded="false">' +
                                'View all ' + tissueArray.length + ' tissues' +
                                '</button>' +
                                '<div class="dropdown-menu" style="position: absolute;transform: translate3d(0px, 36px, 0px); top: -230px; left: 0px; will-change: transform; max-height: 200px; overflow-y: auto;">';
                            for (var i=0; i < tissueArray.length; i++) {
                                url += '<a class="dropdown-item">' + tissueArray[i] + '</a>';
                            };
                            url += "</div></div></td>";
                            return url;
                        }else {
                            var url = '<td>' +
                                '<div class="btn-group">' +
                                '<button data-toggle="dropdown" class="btn btn-outline-primary dropdown-toggle" type="button" aria-expanded="false">' +
                                'View all ' + tissueArray.length + ' tissues' +
                                '</button>' +
                                '<div class="dropdown-menu" style="position: absolute;transform: translate3d(0px, 36px, 0px); top: 0px; left: 0px; will-change: transform; max-height: 200px; overflow-y: auto;">';
                            for (var i=0; i < tissueArray.length; i++) {
                                url += '<a class="dropdown-item">' + tissueArray[i] + '</a>';
                            };
                            url += "</div></div></td>";
                            return url;
                        }

                    }
                },
                {data: "gv",orderable:false},
                {data: "ds",orderable:false,
                    render: function( data, type, row, meta ){
                        // var prefix = data.substring(0, 3);
                        var prefixMatch = data.match(/[a-zA-Z]+/); // 匹配英文字符
                        var prefix = prefixMatch ? prefixMatch[0] : ""; // 获取匹配到的英文字符部分
                        if(prefix === "ENCODE") {
                            return '<a href="https://www.encodeproject.org" title="Click for more details">' + data + '</a>'
                        }
                        else if (prefix === "Enhancer") {
                            return '<a href="https://enhanceratlas.org/index.php" title="Click for more details">' + data + '</a>';
                        }
                        else if (prefix === "Fantom") {
                            return '<a href="https://fantom.gsc.riken.jp/5/" title="Click for more details">' + data + '</a>';
                        }
                        else if (prefix === "Vista") {
                            return '<a href="https://enhancer.lbl.gov/vista/" title="Click for more details">' + data + '</a>';
                        }

                    }},
                {
                    "className":      'details-control',
                    "orderable":      false,
                    "data":           null,
                    "defaultContent": '',
                    "searchable": false,
                    render: function (data, type, row,meta) {
                        // var Location = row.Location + "";
                        return '<a href="http://genome.ucsc.edu/cgi-bin/hgTracks?db=hg19' +
                            '&lastVirtModeType=default&lastVirtModeExtraState=&virtModeType=' +
                            'default&virtMode=0&nonVirtPosition=&position=' +
                            data.chrom + ':' + data.start + '-' + data.end + '">' +
                            '<img src="../bootstrap-3.4.1-dist/img/ucsc.ico" class="b" style="width: 65px; height: 25px;">' +
                            '</a>';
                    }
                },
            ],
            "createdRow": function (row, data, rowIndex) {
                // Per-cell function to do whatever needed with cells
                $.each($('td', row), function (colIndex) {
                    // 设置文本水平居中和向上移动一点（例如，向上移动 5px）
                    $(this).css({
                        'text-align': 'center',
                        'vertical-align': 'middle', // 可选，确保文本在单元格中垂直居中（如果你需要的话）

                    });
                });
            }

        } );

        var table3 = $('#table3').DataTable({
            ajax: {
                url:'./api/analysis_enhancer_inf2.php',
                //url:'/php/test.json/'
                type:'post',
                data:{
                    name:tissue1,
                    nam:tissue2,
                    snum:0,
                    sp:species,
                },
                dataType:'json',
                //dataSrc:""
            },
            dom: 'lBfrtip',
            language: {
                emptyTable: "No data available"
            },
            "serverMethod": 'post',
            pagingType: "full_numbers",
            "order":[[0,"desc"]],//初始状态是按第一列降序排列
            //  11.30把order去掉，不会出现DataTables warning: table id=table - Ajax error. For more information about this error, please see http://datatables.net/tn/7
            "columns": [

                {
                    data: "eid",
                    //添加详情页链接
                    render: function( data, type, row, meta ){
                        return '<a href="details.php?eid=' + data + '" title="Click for more details">' + data + '</a>'
                    }
                },
                { data: "location"},
                { data:"size"},
                {
                    data: "tissue_s",orderable:false,
                    "searchable": false,
                    "render": function(data, type, row, meta) {
                        var tissueArray = data.split(', ');
                        var url = '<td>' +
                            '<div class="btn-group">' +
                            '<button data-toggle="dropdown" class="btn btn-outline-primary dropdown-toggle" type="button" aria-expanded="false">' +
                            'View all ' + tissueArray.length + ' tissues' +
                            '</button>' +
                            '<div class="dropdown-menu" style="position: absolute;transform: translate3d(0px, 36px, 0px); top: 0px; left: 0px; will-change: transform; max-height: 180px; overflow-y: auto;">';
                        for (var i=0; i < tissueArray.length; i++) {
                            url += '<a class="dropdown-item">' + tissueArray[i] + '</a>';
                        };
                        url += "</div></div></td>";
                        return url;
                    }
                },
                {data: "gv",orderable:false},
                {data: "ds",orderable:false,
                    render: function( data, type, row, meta ){
                        // var prefix = data.substring(0, 3);
                        var prefixMatch = data.match(/[a-zA-Z]+/); // 匹配英文字符
                        var prefix = prefixMatch ? prefixMatch[0] : ""; // 获取匹配到的英文字符部分
                        if(prefix === "ENCODE") {
                            return '<a href="https://www.encodeproject.org" title="Click for more details">' + data + '</a>'
                        }
                        else if (prefix === "Enhancer") {
                            return '<a href="https://enhanceratlas.org/index.php" title="Click for more details">' + data + '</a>';
                        }
                        else if (prefix === "Fantom") {
                            return '<a href="https://fantom.gsc.riken.jp/5/" title="Click for more details">' + data + '</a>';
                        }
                        else if (prefix === "Vista") {
                            return '<a href="https://enhancer.lbl.gov/vista/" title="Click for more details">' + data + '</a>';
                        }

                    }},
                {

                    "className":      'details-control',
                    "orderable":      false,
                    "data":           null,
                    "defaultContent": '',
                    "searchable": false,
                    render: function (data, type, row,meta) {
                        // var Location = row.Location + "";
                        return '<a href="http://genome.ucsc.edu/cgi-bin/hgTracks?db=hg19' +
                            '&lastVirtModeType=default&lastVirtModeExtraState=&virtModeType=' +
                            'default&virtMode=0&nonVirtPosition=&position=' +
                            data.chrom + ':' + data.start + '-' + data.end + '">' +
                            '<img src="../bootstrap-3.4.1-dist/img/ucsc.ico" class="b" style="width: 65px; height: 25px;">' +
                            '</a>';
                    }
                },

            ],
            "createdRow": function (row, data, rowIndex) {
                // Per-cell function to do whatever needed with cells
                $.each($('td', row), function (colIndex) {
                    // 设置文本水平居中和向上移动一点（例如，向上移动 5px）
                    $(this).css({
                        'text-align': 'center',
                        'vertical-align': 'middle', // 可选，确保文本在单元格中垂直居中（如果你需要的话）

                    });
                });
            }

        } );

    })
</script>

<!-- detail表 -->
<script>
    $(document).ready(function() {
        // 调用第一个样本
        $.getJSON("./api/analysis_database.php", { SampleName: tissue1 }, function(res) {
            if (res.error) {
                console.error("Sample1 error:", res.error);
                $("#sample_name1").text(tissue1);
                $("#cell_type1").text('');
                $("#tissue_type1").text('');
                $("#source1").text('');
                return;
            }
            $("#sample_name1").text(res.SampleName || tissue1);
            $("#cell_type1").text(res.CellType || '');
            $("#tissue_type1").text(res.DiseaseType || '');
            $("#source1").text(res.Condition || '');
        });

        // 调用第二个样本
        $.getJSON("./api/analysis_database.php", { SampleName: tissue2 }, function(res) {
            if (res.error) {
                console.error("Sample2 error:", res.error);
                $("#sample_name2").text(tissue2);
                $("#cell_type2").text('');
                $("#tissue_type2").text('');
                $("#source2").text('');
                $("#enum2").text('0');
                return;
            }
            $("#sample_name2").text(res.SampleName || tissue2);
            $("#cell_type2").text(res.CellType || '');
            $("#tissue_type2").text(res.DiseaseType || '');
            $("#source2").text(res.Condition || '');
        });
    });
</script>









<?php
include "./Template/footer.php";
?>
