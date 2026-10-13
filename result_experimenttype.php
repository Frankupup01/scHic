<!--include base-->
<?php
include "./Template/base.php";
?>
<!--include header-->
<?php include './Template/header.php';
?>

<style>
    .btn-secondary {
        color: #fff !important;
        font-size: 15px !important;
        background-color: #8cb0e6 !important;
        border: none !important;
        margin-left: 10px !important;
        margin-top: -5px !important;
        margin-bottom: 10px !important;
    }
</style>
<div class="container-fluid d-flex justify-content-center" style="width:100%;">
    <div class="row w-100">
        <div class="col-12 col-lg-11 mx-auto">
            <div class="card shadow-sm" id="card_browser_tc"  style="margin: 20px auto; text-align: center; max-width: 1300px;">
                <div class="card-header d-flex align-items-center justify-content-center"
                     style="height: 60px; color: #0362a4; font-size: 1.2rem; font-weight: bold;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32"
                         viewBox="0 0 24 24" class="me-2">
                        <g fill="none">
                            <circle cx="12" cy="12" r="9.25" stroke="#0284c7" stroke-width="1.5"/>
                            <path stroke="#0284c7" stroke-linecap="round" stroke-width="1.5" d="M12 12.438v-5"/>
                            <circle cx="1.25" cy="1.25" r="1.25" fill="#0284c7"
                                    transform="matrix(1 0 0 -1 10.75 17.063)"/>
                        </g>
                    </svg>
                    Search result of Experiment type
                </div>
                <div class="card-body">
                    <!--DataTables pos-->
                    <table id="tc_sample" class="table table-hover table-bordered" style="width: 100%;max-width: 100%; overflow-x: auto; table-layout: auto;">
                        <thead>
                        <tr>
                            <th>SampleName</th>
                            <th>GEOStudy ID</th>
                            <th>Species</th>
                            <th>CellType</th>
                            <th>CellLine/Tissue</th>
                            <th>Disease</th>
                            <th>ExperimentType</th>
                            <th>PMID</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>



    <script>
        // 注册自定义排序函数：GEOStudy（如 GSE123456 -> 123456）
        jQuery.extend(jQuery.fn.dataTable.ext.type.order, {
            "geo-id-pre": function (data) {
                if (!data) return 0;
                const match = data.match(/\d+/);
                return match ? parseInt(match[0], 10) : 0;
            }
        });

        // 解析 URL 参数
        const params = new URLSearchParams(window.location.search);
        const select_specie = params.get("Species");
        const select_experimenttype = params.get("experimenttype");
        console.log(select_specie, select_experimenttype);

        // 初始化 DataTable
        $('#tc_sample').DataTable({
            processing: true,
            serverSide: true,
            serverMethod: 'post',
            ajax: {
                url: './api/experiment_search.php',
                type: 'POST',
                data: function (d) {
                    d.select_specie = select_specie;
                    d.select_experimenttype = select_experimenttype;
                    return d;
                },
            },
            order: [[0, 'asc']],  // 默认按 SampleName 升序排序
            columns: [
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
                    orderable: true,
                    render: function (data) {
                        return '<a href="https://www.ncbi.nlm.nih.gov/geo/query/acc.cgi?acc=' + data + '" target="_blank">' + data + '</a>';
                    }
                },
                { data: 'Organism', orderable: false },         // Species 不排序
                { data: 'CellType', orderable: false },   // CellLine 不排序
                { data: 'TissueCellLine', orderable: false },   // CellLine 不排序
                { data: 'DiseaseType', orderable: false },      //疾病 不排序
                { data: 'ExperimentType', orderable: false },   // ExperimentType 不排序
                {
                    data: 'PMID',
                    orderable: true,
                    render: function (data) {
                        return '<a href="https://pubmed.ncbi.nlm.nih.gov/' + data + '" target="_blank">' + data + '</a>';
                    }
                }
            ],
            columnDefs: [
                {
                    targets: 1,    // GEOStudy 按数字排序
                    type: 'geo-id'
                },
                {
                    targets: 5,    // PMID 强制数值排序
                    type: 'num'
                }
            ],
            dom: "<'top'lBf>rt<'bottom'ip>",
            buttons: [
                { extend: 'csv', text: 'Download' }
            ],
            lengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100]],
            pageLength: 25
        });
    </script>








    <?php
include "./Template/footer.php";
?>
