<!--include base-->
<?php
include "./Template/base.php";
?>

<style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        background-color: #fff;
    }
    #sample-table tbody td:nth-child(2) {
        background-color: inherit !important;
    }
    .browse-container {
        display: flex;
    }

    .sidebar {
        width: 200px;
        background-color: #c7d7f5;
        padding: 15px;
        font-weight: bold;
    }

    .main-content {
        flex: 1;
        padding: 20px;
    }

    .result-title {
        background-color: #8cb0e6;
        padding: 10px;
        color: white;
        font-weight: bold;
        text-align: center;
        font-size: 20px;
    }

    .table-container {
        margin-top: 10px;
    }

    table {
        border-collapse: collapse;
        width: 100%;
        text-align: center;
    }

    th, td {
        border: 1px solid #ccc;
        padding: 8px;
    }

    th {
        background-color: #f2f2f2;
    }

    .download-btn {
        background-color: white;
        border: 1px solid #999;
        border-radius: 4px;
        padding: 5px 10px;
        cursor: pointer;
    }

    .download-btn:hover {
        background-color: #a4002c;
        color: white;
        border-color: #a4002c;
    }

    .h4-box {
        background-color: #8cb0e6;
        padding: 20px;
        font-size: 24px;
        color: white;
        width: 100%;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }

    .dt-info-left {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .select-checkbox {
        text-align: center;
        vertical-align: middle;
    }

    th.no-sort::after {
        display: none !important;
    }
    .dt-buttons .btn {
        margin-left: 10px;
        padding: 5px 10px;
    }
    .sample-table-wrapper {
        overflow-x: hidden !important;
    }
    body > .container {
        flex: 1 0 auto;
        display: flex;
        flex-direction: column;
    }


    #mainContain {
        flex: 1 0 auto;
    }


    footer, .footer {
        margin-top: auto;
    }
</style>


<!--include header-->
<?php include './Template/header.php';
?>
<body>

<div class="container" style="padding-left:1px;padding-right: 1px;">
<!-- 左侧栏 -->
<div id="mainContain" role="main" style="margin-top:10px;margin-bottom:0px;">
    <br>
    <div class="sample-container">
        <!-- 左边：Browse by Sample -->
        <div class="sample-sidebar-box">
            <div class="sample-card-header-left">
                <h4 style="margin: 0;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="30" fill="white" class="bi bi-tree" viewBox="0 0 16 16">
                        <path d="M8.416.223a.5.5 0 0 0-.832 0l-3 4.5A.5.5 0 0 0 5 5.5h.098L3.076 8.735A.5.5 0 0 0 3.5 9.5h.191l-1.638 3.276a.5.5 0 0 0 .447.724H7V16h2v-2.5h4.5a.5.5 0 0 0 .447-.724L12.31 9.5h.191a.5.5 0 0 0 .424-.765L10.902 5.5H11a.5.5 0 0 0 .416-.777zM6.437 4.758A.5.5 0 0 0 6 4.5h-.066L8 1.401 10.066 4.5H10a.5.5 0 0 0-.424.765L11.598 8.5H11.5a.5.5 0 0 0-.447.724L12.69 12.5H3.309l1.638-3.276A.5.5 0 0 0 4.5 8.5h-.098l2.022-3.235a.5.5 0 0 0 .013-.507"/>
                    </svg>
                    <span class="glyphicon glyphicon-book" aria-hidden="true"></span> Browse by Sample
                </h4>
            </div>
            <ul id="tree" class="ztree">
                <!-- 树形结构 -->
            </ul>
        </div>

        <!-- 右边：Results -->
        <div class="sample-result-box">
            <div class="sample-card-header-right">
                <h4 style="margin: 0;">
                    <span class="glyphicon glyphicon-list" aria-hidden="true"></span> Results
                </h4>
            </div>
            <div class="sample-result-content">
                <div class="sample-table-wrapper">
                    <table id="sample-table" class="sample-data-table display">
                        <thead>
                        <tr>
                            <th class="no-sort"><input type="checkbox" id="select-all"></th>
                            <th >Source (hidden)</th>
                            <th>Sample ID</th>
                            <th>Dataset ID</th>
                            <th>Species</th>
                            <th>Tissue/Cell Line</th>
                            <th>Disease Type</th>
                            <th>Cell Type</th>
                            <th>Condition</th>
                            <th>PMID</th>
                            <th style="display:none;">Sort Order</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</body>

<!-- Ztree初始化 -->
<script>
    // 定义全局变量，供不同函数使用
    window.table = null;
    window.currentNodeName = '';
    window.currentOrganism = '';

    $(document).ready(function () {

        // ==========================================
        // 1. 初始化 zTree
        // ==========================================
        var setting = {
            check: { enable: false },
            callback: {
                onClick: zTreeOnClick
            }
        };

        function zTreeOnClick(event, treeId, treeNode) {
            if (!treeNode.isParent) {
                let nodeName = treeNode.name;
                window.currentNodeName = nodeName;
                window.currentOrganism = treeNode.organism || '';

                let regex = nodeName;

                // 清除之前的搜索
                window.table.columns().search('');

                // 在三列里都加 regex (Organism=4, Tissue=5, Disease=6)
                window.table.column(4).search(regex, true, false);
                window.table.column(5).search(regex, true, false);
                window.table.column(6).search(regex, true, false);

                // 关键：用 OR 逻辑过滤
                $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
                    let organism = data[4] || '';
                    let tissue   = data[5] || '';
                    let disease  = data[6] || '';

                    return organism.includes(nodeName) || tissue.includes(nodeName) || disease.includes(nodeName);
                });

                window.table.draw();
                $.fn.dataTable.ext.search.pop(); // 用完移除，避免影响后续搜索

                $('#sample-table td').each(function() {
                    var cellText = $(this).html();
                    if (cellText.includes(nodeName)) {
                        var highlightRegex = new RegExp('(' + nodeName + ')', 'gi');
                        var newText = cellText.replace(highlightRegex, '<span class="highlight">$1</span>');
                        $(this).html(newText);
                    }
                });
            } else {
                // 展开父节点 + 清空筛选
                var zTree = $.fn.zTree.getZTreeObj("tree");
                zTree.expandNode(treeNode);
                window.currentNodeName = '';
                window.currentOrganism = '';
                window.table.ajax.reload();
            }
        }

        // 1.5 数据树结构
        var zTreeNodes = [
            {
                name: "All data", open: true, children: [
                    {
                        name: "Homo Sapiens", open: true, children: [
                            {
                                name: "Disease", open: true, children: [
                                    { name: "Ovarian Cancer" },
                                    { name: "Leukaemia"},
                                    { name: "Chronic Myelogenous Leukemia"},
                                ]
                            },
                            {
                                name: "Health", open: true, children: [
                                    {
                                        name: "Cell Line Source", open: true, children: [
                                            { name: "GM12878" },
                                            { name: "K562" },
                                            { name: "HTERT RPE-1" },
                                            { name: "BJ" },
                                            { name: "THP-1" },
                                            { name: "eHAP" },
                                            { name: "PEO1/HEYA8" },
                                            { name: "OVCA429" },
                                        ]
                                    },
                                    {
                                        name: "Tissue Source", open: true, children: [
                                            { name: "Frontal Cortex", organism: "Homo sapiens" },
                                            { name: "Blood" },
                                            { name: "Peripheral Blood" },
                                        ]
                                    }
                                ]
                            }
                        ]
                    },
                    {
                        name: "Mus Musculus", open: true, children: [
                            {
                                name: "Disease", open: false, children: [
                                    { name: "Breast carcinoma" },
                                ]
                            },
                            {
                                name: "Health", open: true, children: [
                                    {
                                        name: "Cell Line Source", open: false, children: [
                                            { name: "mESC" },
                                            { name: "mNPC" },
                                            { name: "NMuMG" },
                                            { name: "F123-CASTx129, F121-6-CASTx129, ES_Tsix-stop differentiated to neuronal stem cell, F121-6-CASTx129 differentiated to neuronal stem cell, F123-CASTx129 differentiated to neuronal stem cell" },
                                            { name: "undifferentiated ES_Tsix-stop, or ES_Tsix-stop differentiated to embryoid body" },
                                            { name: "undifferentiated ES_Tsix-stop cells, or F123-CASTx129, ES_Tsix-stop, F121-6-CASTx129 cells differentiated to embryoid body" },
                                            { name: "F123-CASTx129, F1 2-1 mESC line, F121-6-CASTx129" },
                                            { name: "F121-6-CASTx129, F123-CASTx129" },
                                            { name: "undifferentiated F121-6-CASTx129, or F121-6-CASTx128 differentiated to embryoid body" },
                                        ]
                                    },
                                    {
                                        name: "Tissue Source", open: false, children: [
                                            { name: "Embryo" },
                                            { name: "Visual Cortex" },
                                            { name: "cerebellum",organism: "Mus musculus" },
                                            { name: "Ovary",organism: "Mus musculus" },
                                            { name: "Cortex",organism: "Mus musculus" },
                                            { name: "Hippocampus" },
                                            { name: "Olfactory Epithelium" },
                                            { name: "Brain" },
                                            { name: "Spleen" },
                                        ]
                                    },
                                ]
                            }
                        ]
                    },
                    {
                        name: "Drosophila melanogaster", open: false, children: [
                            {name: "Drosophila melanogaster",}
                        ]
                    },
                    {
                        name: "Oryza sativa Japonica Group", open: false, children: [
                            { name: "Oryza sativa Japonica Group" }
                        ]
                    },
                ]
            }
        ];
        $.fn.zTree.init($("#tree"), setting, zTreeNodes);

        // ==========================================
        // 2. 自定义 DataTable 排序类型
        // ==========================================
        jQuery.extend(jQuery.fn.dataTable.ext.type.order, {
            "source-custom-pre": function (data) {
                if (!data) return '';
                const text = $('<div>').html(data).text().trim();
                return text.length.toString().padStart(3, '0') + text;
            },
            "source-custom-asc": function (a, b) {
                return a.localeCompare(b, undefined, { numeric: true });
            },
            "source-custom-desc": function (a, b) {
                return b.localeCompare(a, undefined, { numeric: true });
            },
            "geo-id-pre": function (data) {
                const text = $('<div>').html(data).text().trim();
                const match = text.match(/\d+/);
                return match ? parseInt(match[0]) : 0;
            }
        });

        // ==========================================
        // 3. DataTable 初始化
        // ==========================================
        window.table = $('#sample-table').DataTable({
            serverSide: true,
            processing: true,
            scrollX: true,
            dom: '<"row"<"col-md-6 d-flex align-items-center"lB><"col-md-6"f>>' +
                '<"row"<"col-sm-12"tr>>' +
                '<"row"<"col-md-6 info-left"i><"col-md-6"p>>',
            buttons: [
                {
                    text: `
                        <span style="display: flex; align-items: center; gap: 5px;">
                            <span style="color: #fff;font-size: 15px;">Download</span>
                        </span>
                    `,
                    titleAttr: 'Download selected rows',
                    action: function () {
                        const selectedData = [];
                        $('#sample-table tbody tr').each(function () {
                            const $row = $(this);
                            if ($row.find('input.row-select').is(':checked')) {
                                const rowData = window.table.row($row).data();
                                if (rowData) selectedData.push(rowData);
                            }
                        });

                        if (selectedData.length === 0) {
                            alert("Please select at least one row.");
                            return;
                        }

                        const csvHeader = Object.keys(selectedData[0]).join(',') + '\n';
                        const csvBody = selectedData.map(row =>
                            Object.values(row).map(v => `"${v}"`).join(',')
                        ).join('\n');

                        const csvContent = csvHeader + csvBody;
                        const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
                        const link = document.createElement("a");
                        link.href = URL.createObjectURL(blob);
                        link.download = "selected_rows.csv";
                        link.click();
                    },
                    className: 'btn-custom-download'
                }
            ],
            ajax: {
                url: './api/data_browse.php',
                type: 'POST',
                data: function (d) {
                    d.treeFilter = window.currentNodeName || '';
                    d.organismFilter = window.currentOrganism || '';
                }
            },
            columnDefs: [
                { targets: 1, orderable: false }, // Source
                { targets: 2, type: 'source-custom' }, // Sample ID
                { targets: 3, type: 'geo-id' }, // Dataset ID
                { targets: 8, type: 'num' }, // PMID
                { targets: [4, 5, 6, 7, 8], orderable: false }
            ],
            // 🌟 默认按新增的 sort_order 列升序排列
            order: [[10, 'asc']],
            columns: [
                {
                    data: null,
                    orderable: false,
                    className: 'select-checkbox text-center',
                    render: function () {
                        return '<input type="checkbox" class="row-select">';
                    }
                },
                { data: 'Source', visible: false },
                {
                    data: 'SampleName',
                    render: function (data, type, row) {
                        let studyVal = row.SRAStudy ? encodeURIComponent(row.SRAStudy) : (row.GEOStudy ? encodeURIComponent(row.GEOStudy) : '');
                        return '<a href="detail_browse.php?' +
                            'source=' + encodeURIComponent(row.Source) +
                            '&SampleName=' + encodeURIComponent(data) +
                            (studyVal ? '&GEOStudy=' + studyVal : '') +
                            '" target="_blank">' + data + '</a>';
                    }
                },
                {
                    data: 'GEOStudy',
                    render: function (data) {
                        return '<a href="https://www.ncbi.nlm.nih.gov/geo/query/acc.cgi?acc=' + encodeURIComponent(data) + '" target="_blank">' + data + '</a>';
                    }
                },
                { data: 'Organism' },
                { data: 'TissueCellLine' },
                { data: 'DiseaseType' },
                { data: 'CellType' },
                { data: 'Condition' },
                {
                    data: 'PMID',
                    render: function (data) {
                        return '<a href="https://pubmed.ncbi.nlm.nih.gov/' + encodeURIComponent(data) + '" target="_blank">' + data + '</a>';
                    }
                },
                // 🌟 新增的排序列
                {
                    data: 'sort_order',
                    visible: false,
                    searchable: false
                }
            ]
        });

        // ==========================================
        // 4. 事件绑定
        // ==========================================

        // 自定义搜索框
        $('#custom-search').on('keyup', function () {
            window.table.search(this.value).draw();
        });

        // 全选可选框
        $('#select-all').on('click', function () {
            var isChecked = this.checked;
            window.table.rows({ search: 'applied' }).nodes().each(function (row) {
                $(row).find('input.row-select').prop('checked', isChecked);
            });
        });

    }); // 唯一的 document.ready 结束
</script>

<?php
include "./Template/footer.php";
?>

