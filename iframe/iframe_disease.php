<?php
include "./base_iframe_test.php";
?>

<script src="../echarts-5.5.0/dist/echarts.js"></script>
<style>
    .bootstrap-select .dropdown-menu {
        max-width: 100vw !important;
        white-space: normal !important;
        word-break: break-word !important;
        overflow-wrap: break-word !important;
    }
    .bootstrap-select {
        width: 100% !important;
    }
    body {
        overflow-x: hidden !important;
    }
    .dropdown-menu {
        top: 100% !important;
        bottom: auto !important;
    }
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
        min-height: 400px;        /* 最小高度 */
        max-height: 800px;        /* 最大高度 */
        top: -50px;              /* 向上偏移 */
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

<body style="overflow-x: hidden;overflow-y: hidden;width: 95%;">
<form >
    <div class="center-block">
        <!-- 物种筛选 -->
        <div>
            <label for="specie_lncs" class="font-weight-bold" style="font-size: 14px;">
                <span style="color: red;">Step1</span>:Please choose a species
            </label>
            <select class="selectpicker form-control" id="Species"
                    title="Select a species(e.g.'Homo sapiens')" data-container="body"
                    data-live-search="true" data-hide-disabled="true" data-actions-box="true"
                    data-virtual-scroll="false">
                <!-- 标准小写 -->
                <option value="Homo sapiens">Homo sapiens</option>
                <option value="Mus musculus">Mus musculus</option>
            </select>
        </div>
        <!-- 物种筛选结束 -->
        <!-- 自动疾病级联列表 -->
        <div class="center-block" id="t1">
            <label style="font-size: 14px;">
                <span style="color: red;">Step2</span>:Please choose a disease
            </label>
            <select class="selectpicker form-control" id="disease"
                    title="Select a disease(e.g.'Ovarian Cancer')" data-container="body"
                    data-live-search="true" data-hide-disabled="true" data-actions-box="true"
                    data-virtual-scroll="false">
            </select>
        </div>
        <div class="mt-2" >
            <button type="button" class="btn btn-default" onclick="populateExamples()"><b>Example</b></button>
            <a class="btn btn-default" href="javascript:void(0);" onclick="disease()"><b>Search</b></a>
            <button class="btn btn-default"  id="reset" ><b>Reset</b></button>
        </div>
    </div>
</form>
<div style="color:darkgray;">
    <p class="h5 text-justify font-weight-300 dashed border-primary ">
        <strong><i class="ni ni-tag text-warning"></i>Note:</strong>
    </p>
    <p class="h5 text-justify font-weight-300 dashed border-primary ">
        <strong><i class="ni ni-tag text-warning"></i>1.Species must be selected.</strong>
    </p>
    <p class="h5 text-justify font-weight-300 dashed border-primary ">
        <strong><i class="ni ni-tag text-warning"></i>2.Select the disease you want to browse for searching.</strong>
    </p>
    <p class="h5 text-justify font-weight-300 dashed border-primary ">
        <strong><i class="ni ni-tag text-warning"></i>3.Drosophila melanogaster and Oryza sativa japonica group were not included.</strong>
    </p>
</div>

<div class="chart-container">
    <div id="main2"></div>
</div>

<script type="text/javascript">
    var myChart = echarts.init(document.getElementById('main2'));
    // 分层级的颜色方案 - 2层结构：[物种, 疾病]
    function getColorByDepth(depth, name) {
        const colorSchemes = {
            1: { // 物种层级 - 明亮的主色调
                'Homo sapiens': '#FF6B6B',
                'Danio rerio': '#45B7D1',
                'Mus musculus': '#96CEB4',
                'Gallus gallus': '#BA68C8',
            },
            2: { // 疾病层级 - 柔和的中间色调
                'Health': '#66BB6A',
                'Chronic Myelogenous Leukemia': '#EF5350',
                'Ovarian Cancer': '#EC407A',
                'Leukaemia': '#AB47BC',
                'Other Disease': '#FFA726',
                'Myelodysplastic Syndrome': '#FF7043',
                'Breast carcinoma': '#5C6BC0'
            }
        };

        if (depth <= 2 && colorSchemes[depth] && colorSchemes[depth][name]) {
            return colorSchemes[depth][name];
        }
        return '#CCCCCC';
    }

    // 数据路径 - 新的2层结构：[物种, 疾病]
    var paths = [
        // human
        ["Homo sapiens", "Chronic Myelogenous Leukemia"],
        ["Homo sapiens", "Ovarian Cancer"],
        ["Homo sapiens", "Leukaemia"],
        ["Homo sapiens", "Other Disease"],
        ["Homo sapiens", "Myelodysplastic Syndrome"],
        // mouse
        ["Mus musculus", "Breast carcinoma"],
    ];


        if (!window.sunburstInitialized) {
        window.sunburstInitialized = true;

        // ---------- 构建树 ----------
        function addPath(root, path) {
        let node = root;
        for (let i = 0; i < path.length; i++) {
        let name = path[i];
        if (!node.children) node.children = [];
        let child = node.children.find(n => n.name.toLowerCase() === name.toLowerCase());
        if (!child) {
        child = {
        name: name,
        id: path.slice(0, i + 1).join('_'), // 唯一 id
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

        // ---------- 计算父节点 value ----------
        function calculateValues(nodes) {
        if (!nodes || nodes.length === 0) return 0;
        nodes.forEach(node => {
        if (node.children && node.children.length > 0)
        node.value = calculateValues(node.children);
    });
        return nodes.reduce((sum, node) => sum + (node.value || 0), 0);
    }
        calculateValues(data);

        // ---------- Tooltip ----------
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

        // ---------- 配置 ----------
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
        formatter: function(info) {
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
        backgroundColor: 'rgba(255,255,255,0.8)',
        padding: [2, 4],
        borderRadius: 3
    },
        levels: [
    {},
    { r0: '10%', r: '50%', label: { rotate: 'tangential', fontSize: 14, fontWeight: 'bold' }, itemStyle: { borderWidth: 2, borderColor: '#fff' } },
    { r0: '50%', r: '80%', label: { fontSize: 11 }, itemStyle: { borderWidth: 1, borderColor: '#fff' } }
        ]
    }]
    };
        myChart.setOption(option);

        // ---------- 双向联动 ----------
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
        targetNodeId: targetNode.id
    });
        myChart.dispatchAction({ type: 'highlight', name: targetNode.name });
        setTimeout(() => { isSimulatingClick = false; }, 300);
    }

        function jumpToSelectedNode() {
        const species = $("#Species").val();
        const dis = $("#disease").val();
        let targetPath = [];
        if (species) targetPath.push(species);
        if (dis) targetPath.push(dis);
        if (targetPath.length > 0) simulateNodeClick(targetPath);
    }

        // 下拉框 → 图形
        $("#Species").on("change", function(e, fromInternal) {
        if (isUpdatingDropdown || fromInternal) return;
        const species = $(this).val();
        if (species) autoselect_disease(species);
        setTimeout(jumpToSelectedNode, 200);
    });

        $("#disease").on("change", function(e, fromInternal) {
        if (isUpdatingDropdown || fromInternal) return;
        jumpToSelectedNode();
    });

        // 图形 → 下拉框（含中心圈返回）
            myChart.on('click', function (params) {
                if (isSimulatingClick || isUpdatingDropdown) return;

                const depth = params.treePathInfo.length - 1; // 0=中心, 1=物种, 2=疾病
                const names = params.treePathInfo.map(item => item.name).filter(Boolean);
                const [species, dis] = names;

                isUpdatingDropdown = true;

                // ---- 点击中心圈返回时的处理逻辑 ----
                if (depth === 0) {
                    // 如果当前选中的是疾病层，返回后清空疾病
                    if ($("#disease").val()) {
                        $("#disease").val('').selectpicker('refresh');
                        isUpdatingDropdown = false;
                        return;
                    }
                    // 如果当前选中的是物种层，返回后清空物种与疾病
                    if ($("#Species").val()) {
                        $("#Species").val('').selectpicker('refresh');
                        $("#disease").val('').selectpicker('refresh');
                        isUpdatingDropdown = false;
                        return;
                    }
                    return;
                }

                // ---- 点击物种节点（进入第二层） ----
                if (depth === 1) {
                    $("#Species").val(species).trigger("change", [true]).selectpicker('refresh');
                    autoselect_disease(species, function () {
                        $("#disease").val('').selectpicker('refresh'); // 初始清空疾病选择
                        isUpdatingDropdown = false;
                    });
                    return;
                }

                // ---- 点击疾病节点（第二层） ----
                if (depth === 2) {
                    $("#Species").val(species).trigger("change", [true]).selectpicker('refresh');
                    autoselect_disease(species, function () {
                        $("#disease").val(dis).trigger("change", [true]).selectpicker('refresh');
                        isUpdatingDropdown = false;
                    });
                    return;
                }

                isUpdatingDropdown = false;
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
    function populateExamples() {
        console.log("populateExamples() called");

        // Step 1: Species
        var speciesSelect = document.getElementById('Species');
        if (!speciesSelect) {
            console.error("Element #Species not found!");
            return;
        }
        speciesSelect.selectedIndex = 1; // 默认选第2个物种项
        console.log("Species selected index:", speciesSelect.selectedIndex);

        // Step 2: Disease
        var diseaseSelect = document.getElementById('disease');
        if (!diseaseSelect) {
            console.error("Element #disease not found!");
            return;
        }
        // 如果“ Ovarian Cancer ”选项不存在则添加
        var hasOvarian = Array.from(diseaseSelect.options).some(opt => opt.value === 'Ovarian Cancer');
        if (!hasOvarian) {
            var exampleDiseaseOption = document.createElement('option');
            exampleDiseaseOption.text = 'Ovarian Cancer';
            exampleDiseaseOption.value = 'Ovarian Cancer';
            diseaseSelect.appendChild(exampleDiseaseOption);
        }
        diseaseSelect.value = 'Ovarian Cancer';

        $('.selectpicker').selectpicker('refresh');


        setTimeout(() => {
            if (typeof jumpToSelectedNode === 'function') {
                console.log('Triggering jumpToSelectedNode()...');
                isUpdatingDropdown = false;
                isSimulatingClick = false;
                jumpToSelectedNode();
            } else {
                console.warn('jumpToSelectedNode() not defined yet.');
            }
        }, 400); // 稍等一下确保旭日图初始化完毕
    }

    function disease() {
        var Species = $('#Species').val();
        var disease = $('#disease').val();
        if(!Species || !disease){
            alert("Please select both species and disease.");
            return;
        }
        Species = Species.replace(/ /g, "+");
        disease = disease.replace(/ /g, "+");
        parent.location.href = '../result_disease.php?Species=' + Species + '&disease=' + disease;
    }
</script>

<script>
    function autoselect_disease(Species, callback) {
        if (!Species) return;
        $.ajax({
            url: '../api/auto_select_disease.php',
            type: 'post',
            dataType: 'json',
            data: { select_specie: Species },
            success: function (res) {
                var filtered = res ? res.filter(item => item !== 'Health') : [];
                var options = filtered.map(item => '<option value="'+item+'">'+item+'</option>');
                $('#disease').html(options.join(''));
                $('#disease').selectpicker('refresh');
                if (callback) callback();
            },
            error: function () {
                alert('Sorry, no dataset Results.');
                if (callback) callback();
            }
        });
    }

    $(function () {
        // 当物种变化时，自动加载疾病列表
        $('#Species').on('changed.bs.select', function () {
            var specie = $(this).val();
            autoselect_disease(specie);
        });

        // 重置按钮刷新页面
        $("#reset").click(function(e){
            e.preventDefault();
            location.reload();
        });

        // 页面加载时触发一次物种变化事件，加载初始疾病
        $('#Species').trigger('changed.bs.select');
    });
</script>
</body>

