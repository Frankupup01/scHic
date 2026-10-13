<?php
include "./base_iframe_test.php";
?>

<script src="../echarts-5.5.0/dist/echarts.js"></script>

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
                <option value="Homo sapiens">Homo sapiens</option>
                <option value="Mus musculus">Mus musculus</option>
                <option value="Drosophila melanogaster">Drosophila melanogaster</option>
                <option value="Oryza sativa Japonica Group">Oryza sativa Japonica Group</option>
            </select>
        </div>
        <!-- 物种筛选结束 -->
        <!-- 自动疾病级联列表 -->
        <div class="center-block" id="t1">
            <label style="font-size: 14px;">
                <span style="color: red;">Step2</span>:Please choose a experiment type
            </label>
            <select class="selectpicker form-control" id="experimenttype"
                    title="Select a experiment type(e.g.'scHi-C')" data-container="body"
                    data-live-search="true" data-hide-disabled="true" data-actions-box="true"
                    data-virtual-scroll="false">
            </select>
        </div>
        <div class="mt-2" >
            <button type="button" class="btn btn-default" onclick="populateExamples()"><b>Example</b></button>
            <a class="btn btn-default" href="javascript:void(0);" onclick="experimenttype()"><b>Search</b></a>
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
        <strong><i class="ni ni-tag text-warning"></i>2.Select the experiment type you want to browse for searching.</strong>
    </p>
</div>

<div class="chart-container">
    <div id="main2"></div>
</div>


<script type="text/javascript">
    var myChart = echarts.init(document.getElementById('main2'));
    // 分层级的颜色方案 - 2层结构：[物种, 方法]
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
            2: { // 方法层级 - 柔和的中间色调
                'Dip-C': '#66BB6A',
                'scHi-C': '#EF5350',
                'snHi-C': '#EC407A',
                'singlecellMethyl-HiC': '#AB47BC',
                'sn-m3C-seq': '#FFA726',
                'sciHi-C': '#FF7043',
                'sciDLO Hi-C': '#5C6BC0',
                'HiRES': '#26A69A',
                'GAGE-seq': '#7E57C2',
                'LiMCA': '#FF9800'
            }
        };

        if (depth <= 2 && colorSchemes[depth] && colorSchemes[depth][name]) {
            return colorSchemes[depth][name];
        }
        return '#CCCCCC';
    }

    // 数据路径 - 新的2层结构：[物种, 方法]
    var paths = [
        // human
        ["Homo sapiens", "Dip-C"],
        ["Homo sapiens", "snHi-C"],
        ["Homo sapiens", "sn-m3C-seq"],
        ["Homo sapiens", "sciHi-C"],
        ["Homo sapiens", "sciDLO Hi-C"],
        ["Homo sapiens", "scHi-C"],
        ["Homo sapiens", "GAGE-seq"],
        ["Homo sapiens", "LiMCA"],
        // mouse
        ["Mus musculus", "scHi-C"],
        ["Mus musculus", "snHi-C"],
        ["Mus musculus", "singlecellMethyl-HiC"],
        ["Mus musculus", "sn-m3C-seq"],
        ["Mus musculus", "sciHi-C"],
        ["Mus musculus", "HiRES"],
        ["Mus musculus", "Dip-C"],
        ["Mus musculus", "GAGE-seq"],
        ["Mus musculus", "LiMCA"],
        // fly
        ["Drosophila melanogaster", "snHi-C"],
        // rice
        ["Oryza sativa Japonica Group", "scHi-C"]
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
            const dis = $("#experimenttype").val();
            let targetPath = [];
            if (species) targetPath.push(species);
            if (dis) targetPath.push(dis);
            if (targetPath.length > 0) simulateNodeClick(targetPath);
        }

        // 下拉框 → 图形
        $("#Species").on("change", function(e, fromInternal) {
            if (isUpdatingDropdown || fromInternal) return;
            const species = $(this).val();
            if (species) autoselect_experimenttype(species);
            setTimeout(jumpToSelectedNode, 200);
        });

        $("#experimenttype").on("change", function(e, fromInternal) {
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
                if ($("#experimenttype").val()) {
                    $("#experimenttype").val('').selectpicker('refresh');
                    isUpdatingDropdown = false;
                    return;
                }
                // 如果当前选中的是物种层，返回后清空物种与疾病
                if ($("#Species").val()) {
                    $("#Species").val('').selectpicker('refresh');
                    $("#experimenttype").val('').selectpicker('refresh');
                    isUpdatingDropdown = false;
                    return;
                }
                return;
            }

            // ---- 点击物种节点（进入第二层） ----
            if (depth === 1) {
                $("#Species").val(species).trigger("change", [true]).selectpicker('refresh');
                autoselect_experimenttype(species, function () {
                    $("#experimenttype").val('').selectpicker('refresh'); // 初始清空疾病选择
                    isUpdatingDropdown = false;
                });
                return;
            }

            // ---- 点击疾病节点（第二层） ----
            if (depth === 2) {
                $("#Species").val(species).trigger("change", [true]).selectpicker('refresh');
                autoselect_experimenttype(species, function () {
                    $("#experimenttype").val(dis).trigger("change", [true]).selectpicker('refresh');
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

        // Step 2: Experiment Type
        var experimenttypeSelect = document.getElementById('experimenttype');
        if (!experimenttypeSelect) {
            console.error("Element #experimenttype not found!");
            return;
        }
        var hasScHiC = Array.from(experimenttypeSelect.options).some(opt => opt.value === 'scHi-C');
        if (!hasScHiC) {
            var exampleExperimentOption = document.createElement('option');
            exampleExperimentOption.text = 'scHi-C';
            exampleExperimentOption.value = 'scHi-C';
            experimenttypeSelect.appendChild(exampleExperimentOption);
        }
        experimenttypeSelect.value = 'scHi-C';


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
        }, 400); // 稍等确保旭日图初始化完毕
    }

    function experimenttype() {
        var Species = $('#Species').val();
        var experimenttype = $('#experimenttype').val();
        if(!Species || !experimenttype){
            alert("Please select both species and experiment type.");
            return;
        }
        Species = Species.replace(/ /g, "+");
        experimenttype = experimenttype.replace(/ /g, "+");
        parent.location.href = '../result_experimenttype.php?Species=' + Species + '&experimenttype=' + experimenttype;
    }
</script>

<script>
    function autoselect_experimenttype(Species, callback) {
        if (!Species) return;
        $.ajax({
            url: '../api/auto_select_experiment.php',
            type: 'post',
            dataType: 'json',
            data: { select_specie: Species },
            success: function (res) {
                var filtered = res ? res.filter(item => item !== 'Health') : [];
                var options = filtered.map(item => '<option value="' + item + '">' + item + '</option>');
                $('#experimenttype').html(options.join(''));
                $('#experimenttype').selectpicker('refresh');
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
            autoselect_experimenttype(specie);
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
</html>