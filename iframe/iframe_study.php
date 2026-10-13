<?php
include "./base_iframe_test.php";
?>

<script src="../echarts-5.5.0/dist/echarts.js"></script>
<style>
    .dropdown-menu {
        top: 100% !important;
        bottom: auto !important;
    }
</style>
<style>
    .custom-border {
        border: 3px dashed #0295ff; /* 虚线边框，颜色蓝色，宽度3px */
        /*border-radius: 10px;     /* 可选：为边框添加圆角 */
        padding: 20px;           /* 内部间距，确保内容不会紧贴边框 */
        margin: 10px 0;          /* 外部间距，确保与其他元素有一定距离 */
    }
    .chart-container {
        position: relative;       /* 作为定位参考 */
        width: 80%;               /* 宽度占网页 80% */
        max-width: 1400px;        /* 最大宽度限制 */
        min-width: 400px;         /* 最小宽度 */
        margin: 0 auto;           /* 水平居中 */
        height: 60vh;             /* 高度随视口高度变化 */
        min-height: 470px;        /* 最小高度 */
        max-height: 800px;        /* 最大高度 */
        top: -130px;              /* 向上偏移 */
        transform: translateX(10%); /* 向右偏移 10%，可调整比例 */
    }

    #main2 {
        width: 100%;
        height: 100%;
        position: absolute;       /* 固定在容器内 */
        top: 0;
        left: 0;
    }
</style>

<body style="overflow-x: hidden;overflow-y: hidden;">
<!-- 第一个表单 -->
<form>
    <div class="form-group">
        <div class="center-block">
            <label for="specie_lncs" class="font-weight-bold" style="font-size: 14px;">
                <span style="color: red;">Step 1</span>: Please choose a species
            </label>
            <select class="selectpicker form-control" id="Spe" title="Select a species (e.g. 'Homo sapiens')" data-container="body" data-live-search="true" data-hide-disabled="true" data-actions-box="true" data-virtual-scroll="false">
                <option value="Homo sapiens">Homo sapiens</option>
                <option value="Mus musculus">Mus musculus</option>
                <option value="Drosophila melanogaster">Drosophila melanogaster</option>
                <option value="Oryza sativa Japonica Group">Oryza sativa Japonica Group</option>
            </select>
            <!-- 正常/癌症/疾病的级联列表 -->
            <div class="center-block" id="t3">
                <label class="font-weight-bold text-justify" style="font-size: 14px;">
                    <span style="color: red;">Step 2</span>: Disease/Health
                </label>
                <select class="selectpicker form-control" id="DIS" title="Select Disease or Health" data-container="body" data-live-search="true" data-hide-disabled="true" data-actions-box="true" data-virtual-scroll="false">
                </select>
            </div>
            <!-- 结束 -->
        </div>
        <div class="row">
            <!-- 细胞系的级联列表 -->
            <div class="col-lg-12" id="t4">
                <label style="font-size: 14px;">
                    <span style="color: red;">Step 3</span>: Please choose a GEO study id
                </label>
                <select class="selectpicker form-control" id="studyid" title="Select a study ID" data-container="body" data-live-search="true" data-hide-disabled="true" data-actions-box="true" data-virtual-scroll="false" >
                </select>
            </div>
            <!-- 细胞系的级联列表结束 -->
            <!-- 组织的级联列表结束 -->
        </div>
        <div class="mt-2">
            <button type="button" class="btn btn-default" onclick="populateExamples()"><b>Example</b></button>
            <a class="btn btn-default" type="submit" onclick="study_url()"><b>Search</b></a>
            <button class="btn btn-default" id="reset"><b>Reset</b></button>
            <!-- 添加一个按钮用于填充示例数据 -->
            <!-- 暂时弄的一个刷新页面的东西，后面再看下 -->
        </div>
    </div>
</form>
<div style="color:darkgray;">
    <strong><i class="ni ni-tag text-warning"></i>Note:</strong></p>
    <strong><i class="ni ni-tag text-warning"></i>All steps must be selected.</strong>
    <!-- <p class="h5 text-justify  dashed border-primary"><strong><i class="ni ni-tag text-warning"></i>2.Step3 is an advanced search option for refining your search.</strong></p> -->
</div>


<div class="chart-container">
    <div id="main2"></div>
</div>


<script type="text/javascript">
    var myChart = echarts.init(document.getElementById('main2'));


    // 分层级的颜色方案
    function getColorByDepth(depth, name) {
        const colorSchemes = {
            1: { // 物种层级 - 明亮的主色调
                'Homo sapiens': '#FF6B6B',
                'Caenorhabditis elegans': '#4ECDC4',
                'Danio rerio': '#45B7D1',
                'Mus musculus': '#96CEB4',
                'Drosophila melanogaster': '#FFA726',
                'Gallus gallus': '#BA68C8',
                'Oryza sativa Japonica Group': '#4DB6AC'
            },
            2: { // 疾病层级 - 柔和的中间色调
                'Health': '#66BB6A',
                'Chronic Myelogenous Leukemia': '#EF5350',
                'Ovarian Cancer': '#EC407A',
                'Leukaemia': '#AB47BC',
                'Other Disease': '#FFA726',
                'Myelodysplastic Syndrome': '#FF7043',
                'Breast carcinoma': '#5C6BC0'
            },
            3: [ // ID层级 - 清新明亮的浅色调
                '#A5D6A7', '#80CBC4', '#81D4FA', '#90CAF9',
                '#9FA8DA', '#B39DDB', '#CE93D8', '#F48FB1',
                '#FFAB91', '#FFCC80', '#FFE082', '#E6EE9C',
                '#C5E1A5', '#80DEEA', '#81C784', '#4DB6AC',
                '#4FC3F7', '#7986CB', '#BA68C8', '#F06292',
                '#FF8A65', '#FFD54F', '#AED581', '#4DD0E1',
                '#9575CD', '#F48FB1', '#FFB74D', '#FFF176'
            ]
        };

        if (depth <= 2 && colorSchemes[depth] && colorSchemes[depth][name]) {
            return colorSchemes[depth][name];
        } else if (depth === 3) {
            const index = Math.abs(name.split('').reduce((a,b)=>{a=((a<<5)-a)+b.charCodeAt(0);return a&a},0)) % colorSchemes[3].length;
            return colorSchemes[3][index];
        }
        return '#CCCCCC';
    }

    var paths = [

        //human
        ["Homo sapiens", "Health", "SRP149125"],
        ["Homo sapiens", "Health", "SRP174501"],
        ["Homo sapiens", "Health", "SRP195332"],
        ["Homo sapiens", "Health", "SRP324961"],
        ["Homo sapiens", "Health", "SRP421771"],
        ["Homo sapiens", "Health", "SRP421771"],
        ["Homo sapiens", "Health", "SRP421771"],
        ["Homo sapiens", "Health", "SRP416474"],
        ["Homo sapiens", "Health", "SRP453477"],
        ["Homo sapiens", "Health", "SRP453477"],
        ["Homo sapiens", "Health", "SRP453477"],
        ["Homo sapiens", "Chronic Myelogenous Leukemia", "SRP072973"],
        ["Homo sapiens", "Chronic Myelogenous Leukemia", "SRP453477"],
        ["Homo sapiens", "Ovarian Cancer", "SRP372893"],
        ["Homo sapiens", "Ovarian Cancer", "SRP372894"],
        ["Homo sapiens", "Leukaemia", "SRP386109"],
        ["Homo sapiens", "Leukaemia", "SRP386109"],
        ["Homo sapiens", "Other Disease", "SRP450826"],
        ["Homo sapiens", "Other Disease", "SRP450826"],
        ["Homo sapiens", "Myelodysplastic Syndrome", "SRP450826"],
        //mouse
        ["Mus musculus", "Health", "SRP026294"],
        ["Mus musculus", "Health", "SRP072973"],
        ["Mus musculus", "Health", "SRP072973"],
        ["Mus musculus", "Health", "SRP073306"],
        ["Mus musculus", "Health", "SRP098829"],
        ["Mus musculus", "Health", "SRP110616"],
        ["Mus musculus", "Health", "SRP159191"],
        ["Mus musculus", "Health", "SRP174501"],
        ["Mus musculus", "Health", "SRP189855"],
        ["Mus musculus", "Health", "SRP189855"],
        ["Mus musculus", "Health", "SRP194410"],
        ["Mus musculus", "Health", "SRP200567"],
        ["Mus musculus", "Health", "SRP218950"],
        ["Mus musculus", "Health", "SRP249897"],
        ["Mus musculus", "Health", "SRP249897"],
        ["Mus musculus", "Health", "SRP257959"],
        ["Mus musculus", "Health", "SRP292639"],
        ["Mus musculus", "Health", "SRP312751"],
        ["Mus musculus", "Health", "SRP340729"],
        ["Mus musculus", "Health", "SRP340729"],
        ["Mus musculus", "Health", "SRP340729"],
        ["Mus musculus", "Health", "SRP340729"],
        ["Mus musculus", "Health", "SRP340729"],
        ["Mus musculus", "Health", "SRP340729"],
        ["Mus musculus", "Health", "SRP340729"],
        ["Mus musculus", "Health", "SRP358754"],
        ["Mus musculus", "Health", "SRP390139"],
        ["Mus musculus", "Health", "SRP390139"],
        ["Mus musculus", "Health", "SRP400703"],
        ["Mus musculus", "Health", "SRP411150"],
        ["Mus musculus", "Health", "SRP411150"],
        ["Mus musculus", "Health", "SRP421771"],
        ["Mus musculus", "Health", "SRP450826"],
        ["Mus musculus", "Health", "SRP453147"],
        ["Mus musculus", "Health", "SRP457938"],
        ["Mus musculus", "Breast carcinoma", "SRP174501"],
        //fly
        ["Drosophila melanogaster", "Health", "SRP199618"],
        //rice
        ["Oryza sativa Japonica Group", "Health", "SRP171133"],
        ["Oryza sativa Japonica Group", "Health", "SRP171133"],
        ["Oryza sativa Japonica Group", "Health", "SRP171133"],
        ["Oryza sativa Japonica Group", "Health", "SRP171133"]
    ];

    // ---------- 防止重复绑定 ----------
    if (!window.sunburstInitialized) {
        window.sunburstInitialized = true;

        function addPath(root, path) {
            let node = root;
            for (let i = 0; i < path.length; i++) {
                let name = path[i];
                if (!node.children) node.children = [];
                let child = node.children.find(n => n.name.toLowerCase() === name.toLowerCase());
                if (!child) {
                    child = {
                        name: name,
                        depth: i + 1,
                        itemStyle: { color: getColorByDepth(i + 1, name) }
                    };
                    if (i === path.length - 1) child.value = 1;
                    node.children.push(child);
                }
                node = child;
            }
        }

        let root = { children: [] };
        paths.forEach(p => addPath(root, p));
        let data = root.children;

        function calculateValues(nodes) {
            if (!nodes || nodes.length === 0) return 0;
            nodes.forEach(node => {
                if (node.children && node.children.length > 0)
                    node.value = calculateValues(node.children);
            });
            return nodes.reduce((sum, node) => sum + (node.value || 0), 0);
        }
        calculateValues(data);

        function formatTooltip(info) {
            let parts = [];
            let node = info;
            while (node) {
                if (node.name) parts.unshift(node.name);
                node = node.treePathInfo && node.treePathInfo.length > 1
                    ? node.treePathInfo[node.treePathInfo.length - 2]
                    : null;
            }
            return `${parts.join(' → ')}<br/>count: ${info.value || 0}`;
        }

        var option = {
            tooltip: { trigger: 'item', formatter: formatTooltip },
            series: [{
                type: 'sunburst',
                data: data,
                radius: [0, '95%'],
                sort: null,
                emphasis: {
                    focus: 'ancestor',
                    itemStyle: {
                        shadowBlur: 10,
                        shadowColor: 'rgba(0,0,0,0.5)'
                    },
                    label: {
                        show: true,
                        rotate: 0,
                        formatter: function (info) {
                            const angle = (info.endAngle - info.startAngle) * 180 / Math.PI;

                            if (info.depth === 1) return info.name;

                            if (info.depth === 2) {
                                if (angle > 15) return info.name;
                                if (angle > 8) return info.name.substring(0, 8) + '...';
                                return '';
                            }
                            return '';
                        },
                        color: '#333',
                        textBorderColor: '#fff',
                        textBorderWidth: 2,
                        backgroundColor: 'rgba(255,255,255,0.85)',
                        padding: [2, 4],
                        borderRadius: 3
                    }
                },
                nodeClick: 'rootToNode',
                label: {
                    show: false,
                    rotate: 'radial',
                    minAngle: 10,
                    formatter: function (info) {
                        const angle = (info.endAngle - info.startAngle) * 180 / Math.PI;
                        if (info.depth === 1) return info.name;
                        if (info.depth === 2) {
                            if (angle > 15) return info.name;
                            if (angle > 8) return info.name.substring(0, 8) + '...';
                            return '';
                        }
                        if (info.depth === 3) {
                            if (angle > 20) return info.name;
                            if (angle > 10) return info.name.substring(0, 6) + '...';
                            return '';
                        }
                        return '';
                    },
                    color: '#333',
                    textBorderColor: '#fff',
                    textBorderWidth: 2,
                    backgroundColor: 'rgba(255,255,255,0.8)',
                    padding: [2, 4],
                    borderRadius: 3
                },
                levels: [
                    {},
                    { r0: '10%', r: '30%', label: { rotate: 'tangential', fontSize: 14, fontWeight: 'bold', minAngle: 5 }, itemStyle: { borderWidth: 2, borderColor: '#fff' } },
                    { r0: '30%', r: '55%', label: { rotate: 'tangential', fontSize: 11, minAngle: 8 }, itemStyle: { borderWidth: 1, borderColor: '#fff' } },
                    { r0: '55%', r: '80%', label: { show: true, fontSize: 9, minAngle: 12 } }
                ]
            }]
        };
        myChart.setOption(option);

        // ---------- 双向联动逻辑 ----------
        let isSimulatingClick = false;
        let isUpdatingDropdown = false;

        function findNodeByPath(nodes, path, depth = 0) {
            if (!nodes || depth >= path.length) return null;
            const targetName = path[depth].toLowerCase();
            const node = nodes.find(n => n.name.toLowerCase() === targetName);
            if (!node) return null;
            if (depth === path.length - 1) return node;
            return findNodeByPath(node.children, path, depth + 1);
        }

        function simulateNodeClick(nodePath) {
            const targetNode = findNodeByPath(data, nodePath);
            if (!targetNode) return;
            isSimulatingClick = true;
            myChart.dispatchAction({
                type: 'sunburstRootToNode',
                targetNodeId: targetNode.id || targetNode.name
            });
            myChart.dispatchAction({ type: 'highlight', name: targetNode.name });
            setTimeout(() => { isSimulatingClick = false; }, 300);
        }

        function jumpToSelectedNode() {
            const species = $("#Spe").val();
            const dis = $("#DIS").val();
            const study = $("#studyid").val();
            let targetPath = [];
            if (species) targetPath.push(species);
            if (dis) targetPath.push(dis);
            if (study) targetPath.push(study);
            if (targetPath.length > 0) simulateNodeClick(targetPath);
        }

        // 下拉框 → 图形
        $("#Spe").on("change", function (e, fromInternal) {
            if (isUpdatingDropdown || fromInternal) return;
            const species = $(this).val();
            if (species) autoselect_dis(species);
            setTimeout(jumpToSelectedNode, 200);
        });

        $("#DIS").on("change", function (e, fromInternal) {
            if (isUpdatingDropdown || fromInternal) return;
            const species = $("#Spe").val();
            const dis = $(this).val();
            if (species && dis) autoselect_studyid(species, dis);
            setTimeout(jumpToSelectedNode, 200);
        });

        $("#studyid").on("change", function (e, fromInternal) {
            if (isUpdatingDropdown || fromInternal) return;
            jumpToSelectedNode();
        });

        // 图形 → 下拉框（含中心圈返回）
        myChart.on('click', function (params) {
            if (isSimulatingClick || isUpdatingDropdown) return;
            const depth = params.treePathInfo.length - 1;
            const names = params.treePathInfo.map(item => item.name).filter(Boolean);
            const [species, dis, study] = names;

            // ---- 点击中心圈返回时的处理逻辑 ----
            if (depth === 0) {
                // 如果当前选中的是 studyid（第三层），返回后清空 studyid
                if ($("#studyid").val()) {
                    $("#studyid").val('').selectpicker('refresh');
                    return;
                }
                // 如果当前选中的是 disease（第二层），返回后清空 disease 和 studyid
                if ($("#DIS").val()) {
                    $("#DIS").val('').selectpicker('refresh');
                    $("#studyid").val('').selectpicker('refresh');
                    return;
                }
                // 如果当前选中的是 species（第一层），返回后清空所有
                if ($("#Spe").val()) {
                    $("#Spe").val('').selectpicker('refresh');
                    $("#DIS").val('').selectpicker('refresh');
                    $("#studyid").val('').selectpicker('refresh');
                    return;
                }
                return;
            }

            // ---- 正常点击旭日图时的选中联动 ----
            isUpdatingDropdown = true;

            if (species) {
                $("#Spe").val(species).trigger("change", [true]).selectpicker('refresh');
            }

            if (species && dis) {
                autoselect_dis(species);
                const waitDis = setInterval(() => {
                    const options = $("#DIS option").map((_, opt) => $(opt).val()).get();
                    if (options.length > 0) {
                        clearInterval(waitDis);
                        $("#DIS").val(dis).trigger("change", [true]).selectpicker('refresh');

                        if (study) {
                            autoselect_studyid(species, dis);
                            const waitStudy = setInterval(() => {
                                const opts = $("#studyid option").map((_, opt) => $(opt).val()).get();
                                if (opts.length > 0) {
                                    clearInterval(waitStudy);
                                    $("#studyid").val(study).trigger("change", [true]).selectpicker('refresh');
                                    isUpdatingDropdown = false;
                                }
                            }, 200);
                        } else {
                            isUpdatingDropdown = false;
                        }
                    }
                }, 200);
            } else {
                isUpdatingDropdown = false;
            }
        });
    }
</script>

<script>
    $(function(){
        var url =window.location.href;
        $("#reset").click(function(){
            window.location.href=url;
        });
    });
</script>

<script>
    //默认字符
    function populateExamples() {
        console.log("populateExamples() called");

        // Step 1: Species
        var speciesSelect = document.getElementById('Spe');
        speciesSelect.selectedIndex = 1;
        console.log("Species selected index:", speciesSelect.selectedIndex);

        // Step 2: Disease
        var diseaseSelect = document.getElementById('DIS');
        var exampleDiseaseOption = document.createElement('option');
        exampleDiseaseOption.text = 'Health';
        exampleDiseaseOption.value = 'Health';
        diseaseSelect.appendChild(exampleDiseaseOption);
        diseaseSelect.value = 'Health';

        // Step 3: Study ID
        var studyidSelect = document.getElementById('studyid');
        var examplestudyidOption = document.createElement('option');
        examplestudyidOption.text = 'SRP416474';
        examplestudyidOption.value = 'SRP416474';
        studyidSelect.appendChild(examplestudyidOption);
        studyidSelect.value = 'SRP416474';

        $('.selectpicker').selectpicker('refresh');

        //  手动调用旭日图跳转
        setTimeout(() => {
            if (typeof jumpToSelectedNode === 'function') {
                console.log('Triggering jumpToSelectedNode()...');
                isUpdatingDropdown = false;
                isSimulatingClick = false;
                jumpToSelectedNode();
            } else {
                console.warn('jumpToSelectedNode() not defined yet.');
            }
        }, 400);
    }
</script>

<!-- 级联列表 -->
<script>

    // DISEASE的级联列表
    function autoselect_dis(Species) {
        if (Species == "") {
            alert('Sorry. No result for your input.');
        }
        else {
            var query = {
                'select_specie': Species,
            };
            $.ajax({
                url: '../api/auto_select_disease.php',
                cache: false,
                type: 'post',
                dataType: 'json',
                data: query,
                async: true,
                success: function (res) {
                    console.log(res);
                    var data = res;
                    var options = [], _options;
                    // var d0 = 0;
                    for (var i = 0; i < data.length; i++) {
                        var option = '<option value="' + data[i] + '">' + data[i] + '</option>';
                        options.push(option);
                    }
                    var _options = options.join('');
                    $('#DIS')[0].innerHTML = _options;
                    $('#DIS').selectpicker('refresh');
                    $('#DIS').selectpicker('render');
                },
                error: function () {
                    alert('Sorry, no dataset Results.');
                }
            })
        }
    }


    // Cell line的级联列表
    function autoselect_studyid(Species, Disease) {
        if (Species === "" || Disease === "") {
            return;
        }

        var query = {
            'select_specie': Species,
            'select_disease': Disease
        };

        $.ajax({
            url: '../api/auto_select_studyid.php',
            type: 'POST',
            dataType: 'json',
            data: query,
            success: function (res) {
                console.log('Cell line response:', res);
                var options = res.map(function (item) {
                    return '<option value="' + item + '">' + item + '</option>';
                });
                $('#studyid').html(options.join(''));
                $('#studyid').selectpicker('refresh');
                $('#studyid').selectpicker('render');
            },
            error: function () {
                alert('Sorry, no sutdy id data available.');
            }
        });
    }

    function study_url() {
        var species = $("#Spe").val();
        var disease = $("#DIS").val();
        var cell = $("#studyid").val();

        if (!species || !disease || !cell) {
            alert("Please select all fields before search.");
            return;
        }

        var url = '../result_studyid.php?species=' + encodeURIComponent(species)
            + '&disease=' + encodeURIComponent(disease)
            + '&studyid=' + encodeURIComponent(cell);

        parent.location.href = url;
    }

</script>


<script>
    $.ajaxSetup({ cache: false });
    $(function () {
        $('#Spe').on('changed.bs.select', function () {
            autoselect_dis($(this).val());
        });
        $('#DIS').on('changed.bs.select', function () {
            autoselect_studyid($('#Spe').val(), $(this).val());
        });
    });
</script>
</body>
