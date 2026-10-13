<?php
include "./Template/base.php";
?>
<!--include header-->
<?php
include './Template/header.php';
?>

<style>
    #sample-info-card {
        background:linear-gradient(to bottom, #fdf6e3, #fafafa); /* 泛黄色书本背景 */
        border: 1px solid #e0d6b5;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        color: #333;
    }


    #sample-info-card .card-header {
        background: transparent;
        border-bottom: 1px solid #e0d6b5;
    }

    #sample-info-card .table {
        border: none;
    }

    #sample-info-card .table td {
        border: none !important;
        padding: 10px 12px;
        background: transparent;
        font-size: 16px;
        word-break: break-word;
    }

    #sample-info-card .table td:first-child {
        font-weight: bold;
        width: 30%;
    }

    #sample-info-card .table td:last-child a {
        color: #0077cc;
        text-decoration: underline;
    }
    .card-header span {
        font-size: 35px;
        color: #0362a4;
        font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', sans-serif;
        font-weight: 600;
        line-height: 1.4;
    }
    .noUi-tooltip {
        font-size: 12px;
        background: #fff;
        border: 1px solid #ccc;
        padding: 2px 6px;
        border-radius: 4px;
    }

    .noUi-handle-lower .noUi-tooltip {
        top: -35px; /* 上面的 */
    }

    .noUi-handle-upper .noUi-tooltip {
        bottom: -35px; /* 下面的 */
        top: auto;
    }
    .show-enhancers {
        background: none !important;
        border: none !important;
        color: #007bff !important;
        cursor: pointer;
        font-size: 14px;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }

    .show-enhancers .arrow {
        transition: transform 0.2s ease;
    }

    .show-enhancers.active .arrow {
        transform: rotate(180deg); /* 点击后箭头朝上 */
    }


    #gene-table,
    #gene-result-table,
    #enhancer-subtable {
        border-collapse: collapse !important;
        width: 100%;
        border: 1px solid #ccc; /* 外边框 */
    }

    /* 通用单元格样式 */
    #gene-table th, #gene-table td,
    #gene-result-table th, #gene-result-table td,
    #enhancer-subtable th, #enhancer-subtable td {
        text-align: center;
        border: 1px solid #ddd !important;
        padding: 8px 12px;
        font-weight: normal;
    }

    /* 只让内容区单元格继承背景色，保持行条纹一致 */
    #gene-table tbody td,
    #gene-result-table tbody td,
    #enhancer-subtable tbody td {
        background-color: inherit !important;
    }

    /* 表头样式 */
    #gene-table thead th,
    #gene-result-table thead th,
    #enhancer-subtable thead th {
        padding: 10px 30px;
        border: 1px solid #ccc;        /* 表头格子线 */
        background-color: #8cb0e6;     /* 蓝色背景 */
        color: #fff;                   /* 白色字体 */
        font-size: 17px;               /* 表头字体更大 */
        font-weight: bold;
    }

    /* 条纹背景 */
    #gene-table tbody tr:nth-child(odd),
    #gene-result-table tbody tr:nth-child(odd),
    #enhancer-subtable tbody tr:nth-child(odd) {
        background-color: #f9f9f9;
    }
    #gene-table tbody tr:nth-child(even),
    #gene-result-table tbody tr:nth-child(even),
    #enhancer-subtable tbody tr:nth-child(even) {
        background-color: #ffffff;
    }

    /* 三个表格的最底部黑色粗线 */
    #gene-table tbody tr:last-child td,
    #chr1-table-wrapper tbody tr:last-child td,
    #enhancer-subtable tbody tr:last-child td {
        border-bottom: 1px solid #000 !important;
    }
    /* 取消 DataTables 默认的整行 hover 高亮 */
    table.dataTable tbody tr:hover {
        background-color: inherit !important;
    }

    /* 设置单元格 hover 高亮 */
    #gene-table td:hover,
    #gene-result-table td:hover{
        background-color: #e0e0e0 !important;
        transition: background-color 0.2s ease;
    }
    #enhancer-subtable tbody tr:hover {
        background-color: #e6f2ff !important; /* 淡蓝色高亮 */
    }
    .img-btn {
        background-color: #007bff;
        color: #fff;
        border: none;
        padding: 10px 20px;
        margin: 0 5px;
        border-radius: 5px;
        cursor: pointer;
        font-size: 14px;
        transition: background-color 0.3s;
    }

    .img-btn:hover {
        background-color: #0056b3;
    }

    .img-btn.active {
        background-color: #0056b3;
    }
    #chr1-table-wrapper table,
    #chr2-table-wrapper table {
        border-collapse: collapse !important;
        width: 100%;
        border: 1px solid #ccc;
    }

    /* 表头样式 */
    #chr1-table-wrapper thead th,
    #chr2-table-wrapper thead th {
        padding: 10px 30px;
        border: 1px solid #ccc;        /* 表头格子线 */
        background-color: #8cb0e6;     /* 蓝色背景 */
        color: #fff;                   /* 白色字体 */
        font-size: 17px;               /* 表头字体更大 */
        font-weight: bold;
    }

    /* 单元格样式 */
    #chr1-table-wrapper td,
    #chr2-table-wrapper td {
        text-align: center;
        border: 1px solid #ddd !important;
        padding: 8px 12px;
        font-weight: normal;
    }

    /* 条纹背景 */
    #chr1-table-wrapper tbody tr:nth-child(odd),
    #chr2-table-wrapper tbody tr:nth-child(odd) {
        background-color: #f9f9f9;
    }
    #chr1-table-wrapper tbody tr:nth-child(even),
    #chr2-table-wrapper tbody tr:nth-child(even) {
        background-color: #ffffff;
    }

    /* hover 高亮 */
    #chr1-table-wrapper td:hover,
    #chr2-table-wrapper td:hover {
        background-color: #e0e0e0 !important;
        transition: background-color 0.2s ease;
    }

    /* 最底部黑色粗线 */
    #chr1-table-wrapper tbody tr:last-child td,
    #chr2-table-wrapper tbody tr:last-child td {
        border-bottom: 1px solid #000 !important;
    }

    /* 保持 info 和 paginate 在同一行（左右分布） */
    .dataTables_wrapper .dataTables_info {
        float: left !important;
        display: inline-block !important;
        margin-top: 10px;
    }

    .dataTables_wrapper .dataTables_paginate {
        float: right !important;
        display: inline-block !important;
        margin-top: 10px;
    }

    /* 给 enhancer 区域增加间距，与分页区域分开 */
    .enhancer-wrapper {
        clear: both;              /* 确保分页信息在上方单独一行 */
        margin-top: 20px;
        border-top: 1px solid #ddd;
        padding-top: 10px;
    }

    .enhancer-wrapper h5 {
        margin-bottom: 10px;
        font-size: 20px;
        font-weight: 600;
    }
    .enhancer-wrapper th:first-child,
    .enhancer-wrapper td:first-child {
        font-weight: normal !important;
    }
    /* 禁止 DataTables 默认整行 hover */
    #chr1-table-wrapper table.dataTable tbody tr:hover,
    #chr2-table-wrapper table.dataTable tbody tr:hover {
        background-color: inherit !important;
    }

    /* 自定义单元格 hover */
    #chr1-table-wrapper table.dataTable tbody td:hover,
    #chr2-table-wrapper table.dataTable tbody td:hover {
        background-color: #e0e0e0 !important;
        transition: background-color 0.2s ease;
    }
    /* 禁止 DataTables 默认整行 hover */
    #chr1-table-wrapper table.dataTable tbody tr:hover,
    #chr2-table-wrapper table.dataTable tbody tr:hover {
        background-color: inherit !important;
    }

    /* 只在悬停单元格时高亮 */
    #chr1-table-wrapper table.dataTable tbody td:hover,
    #chr2-table-wrapper table.dataTable tbody td:hover {
        background-color: #e0e0e0 !important;
        transition: background-color 0.2s ease;
    }

    /* 防止首列在整行 hover 时加深 */
    #chr1-table-wrapper table.dataTable tbody tr:hover td:first-child,
    #chr2-table-wrapper table.dataTable tbody tr:hover td:first-child {
        background-color: inherit !important;
    }

    .chromosome-diagram {
        display: flex;
        flex-direction: column;
    }

    .chromosome-label {
        font-weight: bold;
        margin-bottom: 10px;
        color: #0362a4;
    }

    .chromosome-bar {
        width: 40px;
        height: 500px;
        border-radius: 25px;
        background: linear-gradient(to bottom, #dcdcdc, #f7f7f7);
        position: relative;
        box-shadow: inset 0 0 10px rgba(0,0,0,0.2);
    }

    /* 染色体小节（1~22,X,Y） */
    .chromosome-segment {
        width: 100%;
        height: calc(100% / 24); /* 22+X+Y */
        border-top: 1px solid #ccc;
        box-sizing: border-box;
    }

    /* 高亮样式 */
    .segment-highlight-1 {
        background-color: #4a90e2 !important;
    }
    .segment-highlight-2 {
        background-color: #e24a4a !important;
    }
    #chromosome-visual-wrapper {
        position: relative;
        display: flex;
        flex-direction: column;
        align-items: center;     /* 水平居中 */
        justify-content: flex-start;
        margin-top: 10px;        /* 向上靠一点 */
        transform: translateY(-50px); /* 整体向上再提一点 */
    }

    #chromosome-visual-wrapper h5 {
        color: #0362a4;
        margin-bottom: 10px;
        font-size: 18px;
        font-weight: 600;
    }

    #chromosome-visual-wrapper > div {
        display: flex;
        justify-content: center;
        align-items: flex-start;
        gap: 60px;               /* 两条染色体的间距 */
        transform: translateX(-200px); /* 整体往左移一点（比负 margin 稳定） */
    }
    #chromosome-visual-wrapper .connection-line {
        position: absolute;
        height: 2px;
        background-color: #666;
        z-index: 2;
        transition: all 0.3s ease;
    }
    /* 自定义下载按钮样式 (浅蓝色主题) */
    .btn-custom-download {
        background-color: #8cb0e6 !important; /* 浅蓝色背景 */
        border: 1px solid #7a9fd3 !important;
        border-radius: 4px;
        padding: 5px 10px;
        cursor: pointer;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }

    .btn-custom-download:hover {
        background-color: #7a9fd3 !important; /* 悬停时加深 */
        border-color: #698ec2 !important;
    }

    /* 覆盖 DataTables 默认按钮的文字颜色限制 */
    .dt-buttons .btn-custom-download span {
        color: #ffffff !important;
    }
</style>

<div style="display: flex; justify-content: center; width: 100%;">
    <div id="ChromosomeForm" style="width: 100%; max-width: 1440px; padding-inline: 5vw; box-sizing: border-box;padding-top: 2px">

        <!-- 标题栏 -->
        <div style="background-color: #ffe680; padding: 10px 20px; display: flex; align-items: center; justify-content: center;border: 1px solid #e0d6b5; border-radius: 12px">
            <span class="glyphicon glyphicon-book" style="font-size: 18px; margin-right: 10px;"></span>
            <span style="font-style: italic; font-weight: bold; font-size: 30px; color: black; display: flex; align-items: center; gap: 10px;">
        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="25" fill="currentColor" class="bi bi-bookmarks-fill" viewBox="0 0 16 16">
            <path d="M2 4a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v11.5a.5.5 0 0 1-.777.416L7 13.101l-4.223 2.815A.5.5 0 0 1 2 15.5z"/>
            <path d="M4.268 1A2 2 0 0 1 6 0h6a2 2 0 0 1 2 2v11.5a.5.5 0 0 1-.777.416L13 13.768V2a1 1 0 0 0-1-1z"/>
        </svg>
        Details of scHi-C
    </span>
        </div>

        <!-- Sample Info 卡片 -->
        <div class="card" id="sample-info-card" style="margin-bottom: 20px;border: 1px solid #e0d6b5;border-radius: 12px;">
            <div class="card-header" style="height: 80px; display: flex; align-items: center;">
                <span style="font-size: 28px; color: #0362a4; line-height: 1.4;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="28px" height="28px" fill="currentColor" class="bi bi-file-earmark-text-fill" viewBox="0 0 16 16">
                        <path d="M9.293 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.707A1 1 0 0 0 13.707 4L10 .293A1 1 0 0 0 9.293 0M9.5 3.5v-2l3 3h-2a1 1 0 0 1-1-1M4.5 9a.5.5 0 0 1 0-1h7a.5.5 0 0 1 0 1zM4 10.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5m.5 2.5a.5.5 0 0 1 0-1h4a.5.5 0 0 1 0 1z"/>
                    </svg>
                    Sample Information
                </span>
            </div>
            <div class="card-body" style="padding: 20px;">
                <table class="table" style="width: 100%;">
                    <tbody id="sample-info-body">
                    <!-- JavaScript 动态填充 -->
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Chromosome Information 卡片 -->
        <div class="card" id="sample-info-card" style="margin-top: 20px; max-width: 100%;">
            <div class="card-header" style="height: 80px; display: flex; align-items: center; justify-content: space-between;">

                <!-- 左侧标题 -->
                <span style="font-size: 28px; color: #0362a4; line-height: 1.4;">
        <svg xmlns="http://www.w3.org/2000/svg" width="28px" height="28px" fill="currentColor" class="bi bi-file-earmark-text-fill" viewBox="0 0 16 16">
            <path d="M9.293 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.707A1 1 0 0 0 13.707 4L10 .293A1 1 0 0 0 9.293 0M9.5 3.5v-2l3 3h-2a1 1 0 0 1-1-1M4.5 9a.5.5 0 0 1 0-1h7a.5.5 0 0 1 0 1zM4 10.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5m.5 2.5a.5.5 0 0 1 0-1h4a.5.5 0 0 1 0 1z"/>
        </svg>
        Chromosome Information
    </span>

                <!-- 右侧 Visualization 按钮 -->
                <button class="btn btn-primary"
                        data-bs-toggle="modal"
                        data-bs-target="#visualizationModal"
                        style="font-size:16px;padding:8px 18px;">
                    Visualization
                </button>

            </div>
            <div class="card-body" style="padding: 20px; display: flex; flex-direction: column;">
                <!-- 表格区域 -->
                <div id="gene-table-container" style="width: 100%;overflow-x: auto;">
                    <table id="gene-table" class="display" style="width: 100%;">
                        <thead>
                        <tr>
                            <th>Chr1</th>
                            <th>Chr1 region</th>
                            <th>Chr2</th>
                            <th>Chr2 region</th>
                            <th>Frequency</th>
                        </tr>
                        </thead>
                        <tbody>
                        <!-- 初始化为空 -->
                        </tbody>
                    </table>
                </div>
            </div> <!-- .card-body -->
        </div> <!-- .card -->
        <div class="card" id="sample-info-card" style="margin-top: 20px; max-width: 100%;">
            <div class="card-header" style="height: 80px; display: flex; align-items: center;">
                <span style="font-size: 28px; color: #0362a4; line-height: 1.4;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="28px" height="28px" fill="currentColor" class="bi bi-file-earmark-text-fill" viewBox="0 0 16 16">
                        <path d="M9.293 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.707A1 1 0 0 0 13.707 4L10 .293A1 1 0 0 0 9.293 0M9.5 3.5v-2l3 3h-2a1 1 0 0 1-1-1M4.5 9a.5.5 0 0 1 0-1h7a.5.5 0 0 1 0 1zM4 10.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5m.5 2.5a.5.5 0 0 1 0-1h4a.5.5 0 0 1 0 1z"/>
                    </svg>
                    Annotation
                </span>
            </div>
            <!-- 上部分布局 -->
            <div style="display: flex; justify-content: space-between; flex-wrap: wrap; padding-left: 3vw; margin-top: 10px;">
                <div style="margin: 20px 3vw 30px 0; font-size: 16px; line-height: 1.6; text-align: left;">
                    <span style="color: red; font-weight: bold;"><strong>Note：</strong></span>
                    <p style="color: darkgray; margin-bottom: 15px;"><strong><i class="ni ni-tag text-warning"></i> the data table in the Chromosome Information above shows Chr1 column (on the left side of the table)
                            and Chr2 column (on the right side of the table), and chromosomes at Chr1 interacts with chromosomes at Chr2,
                            which is explored in depth according to the choice of Chr1 or Chr2.</strong></p>
                </div>
                <!-- 左侧内容区 Option 1 -->
                <div style="flex: 1 1 48%; min-width: 400px; display: flex; flex-direction: column;">

                    <!-- 表单部分 -->
                    <div>
                        <!-- 椭圆包裹标题 -->
                        <div style="display: inline-block; background-color: #007bff; border-radius: 999px; padding: 8px 20px; margin-bottom: 15px;">
                            <span style="font-size: 20px; color: white;">Option 1: Search by  Chr1</span>
                        </div>

                        <!-- Step1 -->
                        <div class="form-group" style="display: flex; align-items: center; gap: 10px; margin-bottom: 15px;">
                            <label for="chrom" style="margin-bottom: 0;"><span style="color: red;">Step1</span>: Chromosome1 :</label>
                            <select class="form-control" id="chrom" name="chrom" required style="width: auto;">
                                <option value="">click here</option>
                            </select>
                        </div>
                        <p style="color: darkgray; margin-bottom: 30px;"><strong><i class="ni ni-tag text-warning"></i> Choose a chromosome as an anchor</strong></p>
                        <div class="form-group" style="display: flex; align-items: center; gap: 10px; margin-bottom: 30px;">
                            <label style="margin-bottom: 0;"><span style="color: red;">Step2</span>: Chromosome1 range :</label>
                            <div id="rangeSliderChr1" style="width: 250px; padding-left:10px"></div>
                            <div id="Chr1range"></div>
                        </div>
                        <p style="color: darkgray; margin-bottom: 15px;"><strong><i class="ni ni-tag text-warning"></i> Choose a range to view detailed annotation</strong></p>

                        <!-- Step2 -->
                        <div class="form-group" style="display: flex; align-items: center; gap: 10px; margin-bottom: 15px;">
                            <label for="gene" style="margin-bottom: 0;"><span style="color: red;">Step3</span>: Chromosome2 :</label>
                            <select class="form-control" id="GeneList" name="GeneList" required style="width: auto;">
                                <option value="">click here</option>
                            </select>
                        </div>
                        <p style="color: darkgray; margin-bottom: 30px;"><strong><i class="ni ni-tag text-warning"></i> Choose the Interacting chromosomes</strong></p>

                        <!-- Step 3 -->
                        <div class="form-group" style="display: flex; align-items: center; gap: 10px; margin-bottom: 30px;">
                            <label style="margin-bottom: 0;"><span style="color: red;">Step4</span>: Chromosome2 range :</label>
                            <div id="rangeSliderGene" style="width: 250px; padding-left:10px "></div>
                            <div id="Generange"></div>
                        </div>
                        <p style="color: darkgray; margin-bottom: 15px;"><strong><i class="ni ni-tag text-warning"></i> Choose a range to view detailed annotation</strong></p>
                    </div>

                    <!-- 按钮部分 -->
                    <div style="margin-top: 20px; margin-left: 320px;">
                        <button id="search-btn" class="btn btn-primary me-2" type="button"><b>Search</b></button>
                        <a class="btn btn-primary" id="reset"><b>Reset</b></a>
                    </div>
                </div>
                <!-- 染色体图区域 -->
                <div id="chromosome-visual-wrapper" style="display: none; margin-top: 40px;">
                    <h5 style="color: #0362a4; margin-bottom: 15px; transform: translateX(-200px); ">Chromosome visualization</h5>
                    <div style="display: flex; justify-content: center; align-items: flex-start; gap: 80px;">
                        <div class="chromosome-diagram" id="chr1-diagram">
                            <div class="chromosome-label">Chromosome 1</div>
                            <div class="chromosome-bar"></div>
                        </div>
                        <div class="chromosome-diagram" id="chr2-diagram">
                            <div class="chromosome-label">Chromosome 2</div>
                            <div class="chromosome-bar"></div>
                        </div>
                    </div>
                </div>

                <!-- 右侧内容区 Option 2 -->
<!--                <div style="flex: 1 1 48%; min-width: 400px; display: flex; flex-direction: column; justify-content: space-between; height: 420px;">-->
<!--                    <div>-->
<!--                        <div style="display: inline-block; background-color: #007bff; border-radius: 999px; padding: 8px 20px; margin-bottom: 15px;">-->
<!--                            <span style="font-size: 20px; color: white;">Option 2: Search by Chr2 </span>-->
<!--                        </div>-->
<!---->
<!--                        <!-- Step1 -->
<!--                        <div class="form-group" style="display: flex; align-items: center; gap: 10px; margin-bottom: 15px;">-->
<!--                            <label for="enh_chr" style="margin-bottom: 0;"><span style="color: red;">Step1</span>: Chromosome1 :</label>-->
<!--                            <select class="form-control" id="enh_chr" name="enh_chr" required style="width: auto;">-->
<!--                                <option value="">click here</option>-->
<!--                            </select>-->
<!--                        </div>-->
<!--                        <p style="color: darkgray; margin-bottom: 15px;"><strong><i class="ni ni-tag text-warning"></i> Choose a chromosome as an anchor</strong></p>-->
<!---->
<!--                        <!-- Step2 -->
<!--                        <div class="form-group" style="display: flex; align-items: center; gap: 10px; margin-bottom: 15px;">-->
<!--                            <label for="enhancer" style="margin-bottom: 0;"><span style="color: red;">Step2</span>: Chromosome2 :</label>-->
<!--                            <select class="form-control" id="enhancer" name="enhancer" required style="width: auto;">-->
<!--                                <option value="">click here</option>-->
<!--                            </select>-->
<!--                        </div>-->
<!--                        <p style="color: darkgray; margin-bottom: 30px;"><strong><i class="ni ni-tag text-warning"></i> Choose the Interacting chromosomes</strong></p>-->
<!--                    </div>-->
<!--                    <!-- Step3 -->
<!--                    <div class="form-group" style="display: flex; align-items: center; gap: 10px; margin-bottom: 30px;">-->
<!--                        <label style="margin-bottom: 0;"><span style="color: red;">Step3</span>: Chromosome2 range :</label>-->
<!--                        <div id="rangeSliderEnh" style="width: 250px; padding-left:10px "></div>-->
<!--                        <div id="Enhrange"></div>-->
<!--                    </div>-->
<!--                    <p style="color: darkgray; margin-bottom: 15px;"><strong><i class="ni ni-tag text-warning"></i> Choose a range to view detailed annotation</strong></p>-->
<!--                    <!-- 按钮 -->
<!--                    <div style="text-align: left;padding-left: 320px;">-->
<!--                    <div style="text-align: left;padding-left: 320px;">-->
<!--                        <button id="enhancer_search" class="btn btn-primary" type="button"><b>Search</b></button>-->
<!--                        <a class="btn btn-primary" id="enhancer_reset"><b>Reset</b></a>-->
<!--                    </div>-->
<!--                </div>-->
            </div>
            <div class="card-body" style="padding-left:20px;padding-right:20px;padding-top: 20px; display: flex; flex-direction: column;">
                <!-- 切换按钮 -->
                <div id="chromosome-toggle" style="margin-bottom: 15px; display:none;">
                    <button id="btn-chr1" class="btn btn-primary me-2 active">Chromosome1</button>
                    <button id="btn-chr2" class="btn btn-outline-primary">Chromosome2</button>
                </div>

                <!-- Chromosome1 表 -->
                <div id="chr1-table-wrapper" class="gene-table-wrapper">
                    <table id="chr1-result-table" class="display" style="width: 100%;">
                        <thead>
                        <tr>
                            <th>Chromosome1 Gene sites</th>
                            <th>Chromosome1 Strand</th>
                            <th>Chromosome1 Gene name</th>
                            <th>Chromosome1 Promoter region</th>
                            <th>Chromosome1 Enhancers</th>
                        </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>

                <!-- Chromosome2 表 -->
                <div id="chr2-table-wrapper" class="gene-table-wrapper" style="display:none;">
                    <table id="chr2-result-table" class="display" style="width: 100%;">
                        <thead>
                        <tr>
                            <th>Chromosome2 Gene sites</th>
                            <th>Chromosome2 Strand</th>
                            <th>Chromosome2 Gene name</th>
                            <th>Chromosome2 Promoter region</th>
                            <th>Chromosome2 Enhancers</th>
                        </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>

            </div>
        </div>
    </div> <!-- #ChromosomeForm -->
</div> <!-- outer container -->
<div class="modal fade" id="visualizationModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Select Visualization</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body text-center">

                <div id="visualizationButtons" class="d-flex justify-content-center gap-3">

                    <button id="btnUMAP"
                            class="btn btn-outline-primary"
                            style="width:150px"
                            onclick="goVisualization('2d')">
                        UMAP
                    </button>

                    <button id="btn3D"
                            class="btn btn-outline-success"
                            style="width:150px"
                            onclick="goVisualization('3d')">
                        3D Visualization
                    </button>

                </div>

                <div id="noDataMessage" style="display:none">
                    <p class="text-muted mt-3">No visualization available. please select other datasets.</p>
                </div>

            </div>

        </div>
    </div>
</div>




<!-- 从 URL 获取参数的通用函数 -->
<script>
    function getQueryParam(param) {
        const urlParams = new URLSearchParams(window.location.search);
        return urlParams.get(param);
    }

    $(document).ready(function () {
        const sid = getQueryParam('source');
        const sampleName = getQueryParam('SampleName'); // 新增：提取样本名
        const geoStudy = getQueryParam('GEOStudy');     // 新增：提取研究名（备用）

        // 改为校验 SampleName，因为它是唯一标识
        if (!sampleName) {
            $('#sample-info-body').html('<tr><td colspan="2" style="color:red;">Missing SampleName parameter in URL.</td></tr>');
            return;
        }

        $.ajax({
            url: './api/sample_info.php',
            type: 'POST',
            dataType: 'json',
            // 新增：把 SampleName 一并传给后端
            data: {
                sid: sid,
                SampleName: sampleName,
                GEOStudy: geoStudy
            },
            success: function (data) {
                const tbody = $('#sample-info-body');
                tbody.empty(); // 清空旧内容

                const keys = [
                    ['SampleName', 'Sample Name:'],
                    ['GEOStudy', 'GEO Study:'],
                    ['Organism', 'Species:'],
                    ['TissueCellLine', 'Tissue/Cell Line:'],
                    ['CellType', 'Cell Type:'],
                    ['DiseaseType', 'Disease Type/Health:'],
                    ['ExperimentType', 'Experiment:'],
                    ['Enzyme', 'Enzyme:'],
                    ['Resolution', 'Size:'],
                    ['SRAStudy', 'SRAstudy:'],
                    ['Condition', 'Condition:'],
                    ['LibraryStrategy', 'Library Strategy:'],
                    ['Datasetid', 'Dataset:'],
                    ['PMID', 'PMID:'],
                ];

                keys.forEach(([field, label]) => {
                    const rawVal = data[field];
                    const val = (!rawVal || rawVal.trim() === '/' || rawVal.trim() === '') ? 'N/A' : rawVal;
                    let display = val;

                    if (field === 'PMID' && val !== 'N/A') {
                        display = `<a href="https://pubmed.ncbi.nlm.nih.gov/${encodeURIComponent(val)}/" target="_blank">${val}</a>`;
                    } else if (field === 'Datasetid' && val !== 'N/A') {
                        display = `<a href="https://www.ncbi.nlm.nih.gov/geo/query/acc.cgi?acc=${encodeURIComponent(val)}" target="_blank">${val}</a>`;
                    }

                    tbody.append(`
                        <tr>
                            <td style="font-family: system-ui, sans-serif; font-variant-numeric: tabular-nums; font-size: 16px;">${label}</td>
                           <td style="font-family: system-ui, sans-serif; font-variant-numeric: tabular-nums; font-size: 16px;">${display}</td>
                        </tr>
                    `);
                });
            },
            error: function () {
                $('#sample-info-body').html('<tr><td colspan="2" style="color:red;">Loading failed.</td></tr>');
            }
        });
    });
</script>



<script>
    $(document).ready(function () {
        // 直接获取 SampleName
        const sampleName = getQueryParam('SampleName');
        console.log('SampleName from URL:', sampleName);

        if (!sampleName) {
            $('#gene-table').html('<tr><td colspan="9" style="color:red;">Missing SampleName parameter.</td></tr>');
            return;
        }

        $('#gene-table').DataTable({
            processing: true,
            serverSide: true,
            dom: '<"row"<"col-md-6 d-flex align-items-center"lB><"col-md-6"f>>' +
                '<"row"<"col-sm-12"tr>>' +
                '<"row"<"col-md-6 info-left"i><"col-md-6"p>>',
            buttons: [
                {
                    text: `
            <span style="display: flex; align-items: center; gap: 5px;">
                <span style="color: #fff; font-size: 15px;">Download</span>
            </span>
        `,
                    className: 'btn-custom-download', // 核心：应用浅蓝色类名
                    attr: { style: 'margin-left: 10px;' }, // 保持原有边距
                    action: function (e, dt) {
                        // 注意：这里要改成对应的文件名，比如 'chr1_data.csv'
                        downloadCurrentPageCSV(dt, 'your_filename.csv');
                    }
                }
            ],
            ajax: {
                url: './api/get_chrom_data.php',
                type: 'POST',
                data: function (d) {
                    d.SampleName = sampleName;
                }
            },
            columns: [
                { data: 'Chr1' },
                { data: 'Chr1Region' },
                { data: 'Chr2' },
                { data: 'Chr2Region' },
                { data: 'Frequency' }
            ],
            order: [[0, 'asc']],
            columnDefs: [
                {
                    targets: '_all',
                    orderable: false,
                    searchable: false,
                }
            ]
        });
    });

    function getQueryParam(name) {
        const urlParams = new URLSearchParams(window.location.search);
        return urlParams.get(name);
    }

    function downloadCurrentPageCSV(dt, filename) {
        const data = dt.data().toArray();
        if (data.length === 0) {
            alert("No data on the current page to download.");
            return;
        }
        const cols = dt.settings()[0].aoColumns;
        const headers = cols.map(c => $(c.nTh).text().trim());
        const csvHeader = headers.join(',') + '\n';

        const csvBody = data.map(row => {
            return cols.map(c => {
                let val = row[c.mData];
                if (val === null || val === undefined) val = '';
                if (typeof val === 'string') {
                    val = $('<div>').html(val).text().replace(/"/g, '""');
                }
                return `"${val}"`;
            }).join(',');
        }).join('\n');

        const blob = new Blob([csvHeader + csvBody], { type: 'text/csv;charset=utf-8;' });
        const link = document.createElement("a");
        link.href = URL.createObjectURL(blob);
        link.download = filename;
        link.click();
    }
</script>

<!--   Chr1级联搜索  -->
<script>
    $(document).ready(function () {
        const sid = getQueryParam('source');
        console.log('sid from URL:', sid);

        // 初始化两个滑块
        initRangeSlider('#rangeSliderChr1', 1, 100);
        initRangeSlider('#rangeSliderGene', 1, 100);

        // 辅助函数：专门用于给标签显示添加 Chr 前缀
        function formatChrLabel(str) {
            // 用正则分离出核心名称和后面的附加说明 (如 "(left)")
            let match = str.match(/^([a-zA-Z0-9_]+)(\s*\(.*\))?$/);
            if (match) {
                let core = match[1];
                let suffix = match[2] || '';
                // 如果核心名字不包含 chr，则补上大写的 Chr
                if (!/^chr/i.test(core)) core = 'Chr' + core;
                return core + suffix;
            }
            return /^chr/i.test(str) ? str : 'Chr' + str;
        }

        // Step1: 加载 Chr1 列表
        $.ajax({
            url: './api/get_chr1_list.php',
            type: 'POST',
            data: { sid: sid },
            dataType: 'json',
            success: function (res) {
                const $chrom = $('#chrom');
                $chrom.empty().append('<option value="">click here</option>');
                if (res.status === 'success') {
                    res.data.forEach(item => {
                        let value = (typeof item === 'string') ? item : (item.value ?? item);
                        let label = (typeof item === 'string') ? item : (item.label ?? item.value ?? item);

                        // 给要展示的文字加上 Chr 前缀
                        let displayLabel = formatChrLabel(label);

                        if (String(value).includes('|')) {
                            $chrom.append(`<option value="${value}">${displayLabel}</option>`);
                        } else {
                            const chr = String(value);
                            const displayChr = formatChrLabel(chr);
                            $chrom.append(`<option value="${chr}|left">${displayChr} (left)</option>`);
                            $chrom.append(`<option value="${chr}|right">${displayChr} (right)</option>`);
                        }
                    });
                    console.log('Chrom options loaded. count:', $('#chrom option').length - 1);
                } else {
                    $chrom.append(`<option>${res.message}</option>`);
                }
            },
            error: function (xhr) {
                console.error('get_chr1_list.php error:', xhr.responseText);
            }
        });
    });

    // 获取 URL 参数
    function getQueryParam(name) {
        const urlParams = new URLSearchParams(window.location.search);
        return urlParams.get(name);
    }

    // 初始化滑块
    function initRangeSlider(selector, minVal, maxVal) {
        const slider = document.querySelector(selector);
        if (!slider) return;
        if (slider.noUiSlider) slider.noUiSlider.destroy();

        noUiSlider.create(slider, {
            start: [minVal, maxVal],
            connect: true,
            range: { min: minVal, max: maxVal },
            step: 1,
            tooltips: [
                { to: value => Math.round(value) },  // 左侧滑块手柄浮窗
                { to: value => Math.round(value) }   // 右侧滑块手柄浮窗
            ]
        });

        return slider;
    }

    // Step2: 选择 Chr1 后加载范围并自动加载对应 Chr2
    $('#chrom').on('change', function () {
        const sid = getQueryParam('source');
        const raw = $(this).val();
        if (!raw || !sid) return;

        $.post('./api/get_chr1_range.php', { sid: sid, chr: raw }, function (res) {
            if (res.status === 'success') {
                const min = res.data.min;
                const max = res.data.max;

                const slider = initRangeSlider('#rangeSliderChr1', Math.max(1, min), Math.max(Math.max(1, min)+1, max));

                // 🌟 核心修复1：直接从初始化好的滑块中提取真实边界值，代替原始的 min/max
                const initVals = slider.noUiSlider.get();
                const initStart = Math.round(initVals[0]);
                const initEnd = Math.round(initVals[1]);

                // 初次加载 Chr2 (按照滑块的默认范围)
                loadRelativeList(sid, raw, initStart, initEnd);

                // 滑块变动时重新加载 Chr2
                slider.noUiSlider.on('set', function (values) {
                    const start = Math.round(values[0]);
                    const end = Math.round(values[1]);
                    loadRelativeList(sid, raw, start, end);
                });
            } else {
                alert(res.message || 'Failed to obtain the range');
            }
        }, 'json');
    });

    // Step3: 根据 Chr1 范围加载 Chr2 列表
    function loadRelativeList(sid, chrFull, start, end) {
        $.post('./api/get_chr2_list.php', { sid: sid, chr: chrFull, start: start, end: end }, function (res) {
            const $gene = $('#GeneList');
            $gene.empty().append('<option value="">click here</option>');
            if (res.status === 'success') {
                let opposite = 'left';
                if (chrFull.includes('|')) {
                    const [, side] = chrFull.split('|');
                    opposite = (side === 'left') ? 'right' : 'left';
                }
                res.data.forEach(chr2 => {
                    // 🌟 核心修复2：给 Chr2 下拉列表补全 Chr 前缀
                    let displayChr2 = /^chr/i.test(chr2) ? chr2 : 'Chr' + chr2;
                    $gene.append(`<option value="${chr2}">${displayChr2} (${opposite})</option>`);
                });
            } else {
                $gene.append(`<option>${res.message}</option>`);
            }
        }, 'json');
    }

    // Step4: Chr2 选择后加载其范围
    $('#GeneList').on('change', function () {
        const sid = getQueryParam('source');
        const chrFull = $('#chrom').val();
        const chr2 = $(this).val();
        if (!chr2 || !sid || !chrFull) return;

        const [chr, side] = chrFull.split('|');

        const range = document.getElementById('rangeSliderChr1').noUiSlider.get();
        const start = Math.round(range[0]);
        const end = Math.round(range[1]);

        $.post('./api/get_range1.php', {
            sid: sid,
            chr: chr,
            side: side,
            relativeChr: chr2,
            start: start,
            end: end
        }, function (res) {
            if (res.status === 'success') {
                initRangeSlider('#rangeSliderGene', res.data.min, res.data.max);
            } else {
                alert(res.message || 'Failed to obtain the Chr2 range');
            }
        }, 'json');
    });
</script>

<script>
    let chr1Table = null;
    let chr2Table = null;

    // =============== 初始化/重载 Chr1 表 ===================
    function initChr1Table() {
        if ($.fn.DataTable.isDataTable('#chr1-result-table')) {
            chr1Table.ajax.reload(null, false);
            return;
        }

        chr1Table = $('#chr1-result-table').DataTable({
            processing: true,
            scrollX: true,
            serverSide: true,
            dom: '<"row"<"col-md-6 d-flex align-items-center"lB><"col-md-6"f>>' +
                '<"row"<"col-sm-12"tr>>' +
                '<"row"<"col-md-6 info-left"i><"col-md-6"p>>',
            buttons: [
                {
                    text: `
            <span style="display: flex; align-items: center; gap: 5px;">
                <span style="color: #fff; font-size: 15px;">Download</span>
            </span>
        `,
                    className: 'btn-custom-download', // 核心：应用浅蓝色类名
                    attr: { style: 'margin-left: 10px;' }, // 保持原有边距
                    action: function (e, dt) {
                        // 注意：这里要改成对应的文件名，比如 'chr1_data.csv'
                        downloadCurrentPageCSV(dt, 'your_filename.csv');
                    }
                }
            ],
            ajax: {
                url: './api/chr1_table.php',
                type: 'POST',
                data: function (d) {
                    const chr1Full = $('#chrom').val();
                    const slider1 = document.getElementById('rangeSliderChr1');
                    let range1 = slider1.noUiSlider ? slider1.noUiSlider.get() : [0, 0];
                    const chr2Full = $('#GeneList').val();
                    const slider2 = document.getElementById('rangeSliderGene');
                    let range2 = slider2.noUiSlider ? slider2.noUiSlider.get() : [0, 0];

                    let c1 = chr1Full ? chr1Full.split('|')[0] : '';
                    let c2 = chr2Full ? chr2Full.split('|')[0] : '';
                    d.chr1 = (c1 && !/^chr/i.test(c1)) ? 'chr' + c1 : c1;
                    d.range1Min = Math.round(range1[0]);
                    d.range1Max = Math.round(range1[1]);
                    d.chr2 = (c2 && !/^chr/i.test(c2)) ? 'chr' + c2 : c2;
                    d.range2Min = Math.round(range2[0]);
                    d.range2Max = Math.round(range2[1]);
                }
            },
            columns: [
                { data: 'chr1_gene_sites', orderable: false },
                { data: 'chr1_strand', orderable: false },
                { data: 'chr1_gene_name', orderable: false },
                { data: 'chr1_promoter_region', orderable: false },
                {
                    data: 'chr1_enhancer_count',
                    orderable: false,
                    render: function (count) {
                        if (!count || count === 0) return `<span>No enhancer</span>`;
                        let label = count === 1 ? `Show 1<br>Enhancer` : `Show ${count}<br>Enhancers`;
                        return `<div class="enhancer-cell"><button class="show-enhancers">${label}<br><span class="arrow">▼</span></button></div>`;
                    }
                }
            ],
            columnDefs: [{ targets: '_all', className: 'text-center' }],
            language: { emptyTable: "Sorry, no annotation information, please select another chromosome" }
        });

        bindEnhancerClick('#chr1-result-table', chr1Table, true);
    }

    // =============== 初始化/重载 Chr2 表 ===================
    function initChr2Table() {
        if ($.fn.DataTable.isDataTable('#chr2-result-table')) {
            chr2Table.ajax.reload(null, false);
            return;
        }

        chr2Table = $('#chr2-result-table').DataTable({
            processing: true,
            scrollX: true,
            serverSide: true,
            dom: '<"row"<"col-md-6 d-flex align-items-center"lB><"col-md-6"f>>' +
                '<"row"<"col-sm-12"tr>>' +
                '<"row"<"col-md-6 info-left"i><"col-md-6"p>>',
            buttons: [
                {
                    text: `
            <span style="display: flex; align-items: center; gap: 5px;">
                <span style="color: #fff; font-size: 15px;">Download</span>
            </span>
        `,
                    className: 'btn-custom-download', // 核心：应用浅蓝色类名
                    attr: { style: 'margin-left: 10px;' }, // 保持原有边距
                    action: function (e, dt) {
                        // 注意：这里要改成对应的文件名，比如 'chr1_data.csv'
                        downloadCurrentPageCSV(dt, 'your_filename.csv');
                    }
                }
            ],
            ajax: {
                url: './api/chr2_table.php',
                type: 'POST',
                data: function (d) {
                    const chr1Full = $('#chrom').val();
                    const slider1 = document.getElementById('rangeSliderChr1');
                    let range1 = slider1.noUiSlider ? slider1.noUiSlider.get() : [0, 0];
                    const chr2Full = $('#GeneList').val();
                    const slider2 = document.getElementById('rangeSliderGene');
                    let range2 = slider2.noUiSlider ? slider2.noUiSlider.get() : [0, 0];

                    let c1 = chr1Full ? chr1Full.split('|')[0] : '';
                    let c2 = chr2Full ? chr2Full.split('|')[0] : '';
                    d.chr1 = (c1 && !/^chr/i.test(c1)) ? 'chr' + c1 : c1;
                    d.range1Min = Math.round(range1[0]);
                    d.range1Max = Math.round(range1[1]);
                    d.chr2 = (c2 && !/^chr/i.test(c2)) ? 'chr' + c2 : c2;
                    d.range2Min = Math.round(range2[0]);
                    d.range2Max = Math.round(range2[1]);
                }
            },
            columns: [
                { data: 'chr2_gene_sites', orderable: false },
                { data: 'chr2_strand', orderable: false },
                { data: 'chr2_gene_name', orderable: false },
                { data: 'chr2_promoter_region', orderable: false },
                {
                    data: 'chr2_enhancer_count',
                    orderable: false,
                    render: function (count) {
                        if (!count || count === 0) return `<span>No enhancer</span>`;
                        let label = count === 1 ? `Show 1<br>Enhancer` : `Show ${count}<br>Enhancers`;
                        return `<div class="enhancer-cell"><button class="show-enhancers">${label}<br><span class="arrow">▼</span></button></div>`;
                    }
                }
            ],
            columnDefs: [{ targets: '_all', className: 'text-center' }],
            language: { emptyTable: "Sorry, no annotation information, please select another chromosome" }
        });

        bindEnhancerClick('#chr2-result-table', chr2Table, false);
    }

    function drawChromosomeDiagrams(chr1, chr2) {
        const $wrapper = $('#chromosome-visual-wrapper');
        $wrapper.show();

        const chromosomes = Array.from({length: 22}, (_, i) => (i + 1).toString()).concat(['X', 'Y']);
        $('#chr1-diagram .chromosome-bar, #chr2-diagram .chromosome-bar').empty();

        chromosomes.forEach(c => {
            const seg1 = $('<div class="chromosome-segment"></div>').attr('data-label', 'chr' + c);
            const seg2 = $('<div class="chromosome-segment"></div>').attr('data-label', 'chr' + c);

            if (`chr${c}`.toLowerCase() === chr1.toLowerCase()) seg1.addClass('segment-highlight-1');
            if (`chr${c}`.toLowerCase() === chr2.toLowerCase()) seg2.addClass('segment-highlight-2');

            $('#chr1-diagram .chromosome-bar').append(seg1);
            $('#chr2-diagram .chromosome-bar').append(seg2);
        });

        $('#chr1-diagram .chromosome-label').text(chr1.toUpperCase());
        $('#chr2-diagram .chromosome-label').text(chr2.toUpperCase());
    }

    // =============== enhancer 子表绑定逻辑 ===================
    function bindEnhancerClick(tableSelector, dataTable, isChr1) {
        const wrapperId = isChr1 ? '#enhancer-table-wrapper-chr1' : '#enhancer-table-wrapper-chr2';

        if (!$(wrapperId).length) {
            const tableWrapper = $(tableSelector).closest('.dataTables_wrapper');
            tableWrapper.append(`
                <div id="${wrapperId.replace('#', '')}" class="enhancer-wrapper" style="display:none; margin-top: 15px;">
                    <h5>Enhancer Information</h5>
                    <div class="enhancer-table-container"></div>
                </div>
            `);
        }

        $(`${tableSelector} tbody`)
            .off('click', 'button.show-enhancers')
            .on('click', 'button.show-enhancers', function (e) {
                e.stopPropagation();
                const $btn = $(this);
                const row = dataTable.row($btn.closest('tr'));
                const rowData = row.data();
                if (!rowData) return;

                const targetGeneSite = isChr1 ? rowData.chr1_gene_sites : rowData.chr2_gene_sites;
                if (!targetGeneSite) return;

                const $wrapper = $(wrapperId);
                const $container = $wrapper.find('.enhancer-table-container');
                const isActive = $btn.hasClass('active');

                $(`${tableSelector} button.show-enhancers`).removeClass('active');
                $(`${tableSelector} .arrow`).text('▼');

                $('.enhancer-wrapper').hide();

                if (!isActive) {
                    $btn.addClass('active');
                    $btn.find('.arrow').text('▲');

                    const subTableId = isChr1 ? 'enhancer-subtable-chr1' : 'enhancer-subtable-chr2';
                    $container.html(`
                        <table id="${subTableId}" class="table table-bordered table-sm enhancer-subtable" style="width:100%; font-size:14px;">
                            <thead>
                                <tr>
                                    <th>Enhancerid</th>
                                    <th>Enhancer region</th>
                                    <th>Transcription factor</th>
                                </tr>
                            </thead>
                        </table>
                    `);

                    $wrapper.find('h5').text(`${targetGeneSite} Enhancer Information :`);
                    $wrapper.show();

                    $(`#${subTableId}`).DataTable({
                        processing: true,
                        serverSide: true,
                        searching: false,
                        ordering: false,
                        paging: true,
                        dom: '<"row"<"col-md-6 d-flex align-items-center"lB><"col-md-6"f>>' +
                            '<"row"<"col-sm-12"tr>>' +
                            '<"row"<"col-md-6 info-left"i><"col-md-6"p>>',
                        buttons: [
                            {
                                text: `
            <span style="display: flex; align-items: center; gap: 5px;">
                <span style="color: #fff; font-size: 15px;">Download</span>
            </span>
        `,
                                className: 'btn-custom-download', // 核心：应用浅蓝色类名
                                attr: { style: 'margin-left: 10px;' }, // 保持原有边距
                                action: function (e, dt) {
                                    // 注意：这里要改成对应的文件名，比如 'chr1_data.csv'
                                    downloadCurrentPageCSV(dt, 'your_filename.csv');
                                }
                            }
                        ],
                        ajax: {
                            url: './api/enhancer_table.php',
                            type: 'POST',
                            data: { gene_site: targetGeneSite }
                        },
                        columns: [
                            { data: 'enhancerid' },
                            { data: 'region' },
                            { data: 'tf' }
                        ],
                        columnDefs: [{ targets: '_all', className: 'text-center' }],
                        language: { emptyTable: "No enhancer information" }
                    });
                }
            });
    }

    // =============== 页面绑定逻辑 ===================
    $(document).ready(function () {
        $('#chromosome-toggle, #chr1-table-wrapper, #chr2-table-wrapper').hide();

        $('#search-btn').click(function () {
            const chr2 = $('#GeneList').val();
            if (!chr2) {
                alert("Please select chromosomes 1 and 2 first！");
                return;
            }

            $('#chromosome-toggle').show();
            $('#btn-chr1').addClass('active btn-primary').removeClass('btn-outline-primary');
            $('#btn-chr2').removeClass('active btn-primary').addClass('btn-outline-primary');

            $('#chr1-table-wrapper').show();
            $('#chr2-table-wrapper').hide();
            $('.enhancer-wrapper').hide();

            initChr1Table();
            initChr2Table();

            if (chr1Table) chr1Table.columns.adjust();

            const chr1Full = $('#chrom').val();
            const chr2Full = $('#GeneList').val();

            let tempChr1 = chr1Full ? chr1Full.split('|')[0] : '';
            let tempChr2 = chr2Full ? chr2Full.split('|')[0] : '';

            const chr1 = (tempChr1 && !/^chr/i.test(tempChr1)) ? 'chr' + tempChr1 : tempChr1;
            const chrB = (tempChr2 && !/^chr/i.test(tempChr2)) ? 'chr' + tempChr2 : tempChr2;

            if ($('#chromosome-visual-wrapper').length === 0) {
                $('#chr1-table-wrapper').parent().append(`
                    <div id="chromosome-visual-wrapper" style="display:none; margin-top: 24px; text-align: center;">
                        <h5 style="color: #0362a4; margin-bottom: 12px;">Chromosome Overview</h5>
                        <div style="display:flex; justify-content:center; gap:60px; align-items:flex-start;">
                            <div id="chr1-diagram" class="chromosome-diagram">
                                <div class="chromosome-label">CHR1</div>
                                <div class="chromosome-bar" style="display:flex; flex-direction:column; gap:4px;"></div>
                            </div>
                            <div id="chr2-diagram" class="chromosome-diagram">
                                <div class="chromosome-label">CHR2</div>
                                <div class="chromosome-bar" style="display:flex; flex-direction:column; gap:4px;"></div>
                            </div>
                        </div>
                    </div>
                `);
            }

            if (typeof drawChromosomeDiagrams === 'function') {
                try {
                    drawChromosomeDiagrams(chr1, chrB);
                } catch (err) {
                    console.error('drawChromosomeDiagrams 执行出错：', err);
                }
            }
        });

        $('#btn-chr1').click(function () {
            $('#btn-chr1').addClass('active btn-primary').removeClass('btn-outline-primary');
            $('#btn-chr2').removeClass('active btn-primary').addClass('btn-outline-primary');

            $('#chr2-table-wrapper').hide();
            $('#enhancer-table-wrapper-chr2').hide();

            $('#chr1-table-wrapper').show();
            if (chr1Table) chr1Table.columns.adjust();
        });

        $('#btn-chr2').click(function () {
            $('#btn-chr2').addClass('active btn-primary').removeClass('btn-outline-primary');
            $('#btn-chr1').removeClass('active btn-primary').addClass('btn-outline-primary');

            $('#chr1-table-wrapper').hide();
            $('#enhancer-table-wrapper-chr1').hide();

            $('#chr2-table-wrapper').show();
            if (chr2Table) chr2Table.columns.adjust();
        });

        $('#reset').click(function () {
            $('#chromosome-toggle').hide();
            $('#chr1-table-wrapper, #chr2-table-wrapper').hide();

            if (chr1Table) { chr1Table.destroy(); $('#chr1-result-table tbody').empty(); chr1Table = null; }
            if (chr2Table) { chr2Table.destroy(); $('#chr2-result-table tbody').empty(); chr2Table = null; }

            $('.enhancer-wrapper').hide().find('.enhancer-table-container').empty();
        });
    });
</script>

<script>
    function getQueryParam(param) {
        const urlParams = new URLSearchParams(window.location.search);
        return urlParams.get(param);
    }

    const UMAP_DATA = [
        "SRP026294","SRP174501","SRP218950","SRP358754","SRP400703",
        "SRP073306","SRP189855","SRP249897","SRP372893","SRP411150",
        "SRP110616","SRP194410","SRP287308","SRP372894","SRP416474",
        "SRP149125","SRP195332","SRP292639","SRP386109","SRP453147",
        "SRP171133","SRP200567","SRP312751","SRP390139","SRP453477"
    ];

    const DATA_3D = [
        "SRP026294","SRP189855","SRP292639","SRP400703",
        "SRP073306","SRP218950","SRP372893","SRP421771",
        "SRP171133","SRP249897","SRP372894","SRP453147",
        "SRP174501","SRP287308","SRP390139","SRP453477"
    ];

    function updateVisualizationButtons(){
        const group = getQueryParam("GEOStudy");

        const umapBtn = document.getElementById("btnUMAP");
        const d3Btn = document.getElementById("btn3D");
        const noMsg = document.getElementById("noDataMessage");

        let hasUMAP = UMAP_DATA.includes(group);
        let has3D   = DATA_3D.includes(group);

        umapBtn.style.display = hasUMAP ? "inline-block" : "none";
        d3Btn.style.display   = has3D ? "inline-block" : "none";

        if(!hasUMAP && !has3D){
            document.getElementById("visualizationButtons").style.display="none";
            noMsg.style.display="block";
        }
    }

    document.addEventListener("DOMContentLoaded", updateVisualizationButtons);

    function goVisualization(type) {
        const sample = getQueryParam("SampleName");
        const group  = getQueryParam("GEOStudy");

        if (!sample || !group) {
            alert("Missing parameters");
            return;
        }

        // ================= 核心修改逻辑 =================
        if (group === "SRP421771") {
            // 为了防止浏览器拦截 Ajax 成功后的 window.open，先打开一个加载中的空白页
            const newWin = window.open('about:blank', '_blank');
            newWin.document.write('Loading 3D visualization...');

            // 去后端查 C0 列的值
            $.ajax({
                url: './api/get_c0.php',
                type: 'POST',
                data: { SampleName: sample },
                dataType: 'json',
                success: function(res) {
                    let targetSample = sample; // 默认使用原 sample

                    // 如果查到了 C0 且不为空，替换掉 targetSample
                    if (res.status === 'success' && res.data && res.data.C0) {
                        // 去掉可能包含的 .csv 或 .gz 等后缀，确保 3D 端能正确匹配
                        targetSample = res.data.C0.replace(/\.(csv|txt|tsv|gz|zip)+$/gi, '');
                    }

                    const url = "https://lcbb.swjtu.edu.cn/genome3d/" +
                        "?group=" + encodeURIComponent(group) +
                        "&sample=" + encodeURIComponent(targetSample) +
                        "&view=" + type;

                    // 将刚才打开的空白页重定向到真实的 3D 图表地址
                    newWin.location.href = url;
                },
                error: function() {
                    // 如果请求出错，回退到使用原 sample 跳转
                    const url = "https://lcbb.swjtu.edu.cn/genome3d/" +
                        "?group=" + encodeURIComponent(group) +
                        "&sample=" + encodeURIComponent(sample) +
                        "&view=" + type;
                    newWin.location.href = url;
                }
            });
        } else {
            // 其他普通的 group，走原逻辑直接跳
            const url = "https://lcbb.swjtu.edu.cn/genome3d/" +
                "?group=" + encodeURIComponent(group) +
                "&sample=" + encodeURIComponent(sample) +
                "&view=" + type;

            window.open(url, "_blank");
        }
    }
</script>
<!--  Chr2级联搜索  -->
<!--<script>-->
<!--    $(document).ready(function () {-->
<!--        const sid = getQueryParam('source');-->
<!--        console.log('sid from URL:', sid);-->
<!---->
<!---->
<!--        // 请求后端接口，获取 Chromosome 列表-->
<!--        $.ajax({-->
<!--            url: './api/enh_get_chr1_list.php',-->
<!--            method: 'POST',-->
<!--            data: { sid: sid },-->
<!--            dataType: 'json',-->
<!--            success: function (response) {-->
<!--                if (response.status === 'success') {-->
<!--                    const chromList = response.data;-->
<!--                    const $chromSelect = $('#enh_chr');-->
<!--                    $chromSelect.empty().append('<option value="">click here</option>');-->
<!--                    chromList.forEach(function (chr) {-->
<!--                        $chromSelect.append(`<option value="${chr}">${chr}</option>`);-->
<!--                    });-->
<!--                } else {-->
<!--                    $('#enh_chr').html(`<option value="">${response.message}</option>`);-->
<!--                }-->
<!--            },-->
<!--            error: function () {-->
<!--                $('#enh_chr').html('<option value="">Error fetching chromosome list.</option>');-->
<!--            }-->
<!--        });-->
<!--    });-->
<!---->
<!--    // 获取 URL 参数-->
<!--    function getQueryParam(name) {-->
<!--        const urlParams = new URLSearchParams(window.location.search);-->
<!--        return urlParams.get(name);-->
<!--    }-->
<!---->
<!---->
<!--    $('#enh_chr').on('change', function () {-->
<!--        const chr2 = $(this).val();-->
<!--        const sid = getQueryParam('source');-->
<!---->
<!--        // 打印日志查看值-->
<!--        console.log('Chromosome changed to:', chr2);-->
<!--        console.log('sid:', sid);-->
<!---->
<!--        if (!chr2 || !sid) {-->
<!--            console.warn("缺少 sid 或 chr2");-->
<!--            return;-->
<!--        }-->
<!---->
<!--        $.ajax({-->
<!--            url: './api/enh_get_chr2_list.php',-->
<!--            type: 'POST',-->
<!--            data: {-->
<!--                sid: sid,-->
<!--                chr2: chr2-->
<!--            },-->
<!--            dataType: 'json',-->
<!--            success: function (res) {-->
<!--                if (res.status === 'success') {-->
<!--                    const enhancerList = res.data;-->
<!--                    const $enhancerSelect = $('#enhancer');-->
<!--                    $enhancerSelect.empty().append(`<option value="">click here</option>`);-->
<!--                    enhancerList.forEach(geneid => {-->
<!--                        $enhancerSelect.append(`<option value="${geneid}">${geneid}</option>`);-->
<!--                    });-->
<!--                } else {-->
<!--                    console.error("获取 Enhancer 列表失败：", res.message);-->
<!--                    alert(res.message);-->
<!--                }-->
<!--            },-->
<!--            error: function (xhr, status, error) {-->
<!--                console.error("AJAX 错误：", error);-->
<!--            }-->
<!--        });-->
<!--    });-->
<!--    // 初始化 noUiSlider-->
<!--    function initRangeSliderEnh(minVal, maxVal) {-->
<!--        const slider = document.getElementById('rangeSliderEnh');-->
<!--        if (slider.noUiSlider) {-->
<!--            slider.noUiSlider.destroy(); // 避免重复初始化-->
<!--        }-->
<!---->
<!--        noUiSlider.create(slider, {-->
<!--            start: [minVal, maxVal],-->
<!--            connect: true,-->
<!--            range: {-->
<!--                'min': minVal,-->
<!--                'max': maxVal-->
<!--            },-->
<!--            tooltips: [-->
<!--                { to: value => Math.round(value) },  // 左取整数-->
<!--                { to: value => Math.round(value) }   // 右取整数-->
<!--            ],-->
<!--            step: 1-->
<!--        });-->
<!--    }-->
<!---->
<!--    // 页面一进来就先初始化一个默认范围-->
<!--    initRangeSliderEnh(0, 100);-->
<!---->
<!--    // enhancer 改变时，从后端获取真实范围-->
<!--    $('#enhancer').on('change', function () {-->
<!--        const chr1 = $(this).val();       // 第二级（Chr1）-->
<!--        const chr2 = $('#enh_chr').val(); // 第一级（Chr2）-->
<!--        const sid = getQueryParam('source');-->
<!---->
<!--        if (!chr1 || !sid || !chr2) {-->
<!--            console.warn("缺少 sid / chr1 / chr2");-->
<!--            return;-->
<!--        }-->
<!---->
<!--        $.ajax({-->
<!--            url: './api/get_range2.php',-->
<!--            type: 'POST',-->
<!--            data: { sid, chr2, chr1 },-->
<!--            dataType: 'json',-->
<!--            success: function (res) {-->
<!--                if (res.status === 'success') {-->
<!--                    const minVal = res.data.min;-->
<!--                    const maxVal = res.data.max;-->
<!--                    initRangeSliderEnh(minVal, maxVal); // 更新滑块-->
<!--                } else {-->
<!--                    console.error("获取范围失败：", res.message);-->
<!--                    alert(res.message);-->
<!--                }-->
<!--            },-->
<!--            error: function (xhr, status, error) {-->
<!--                console.error("AJAX 错误：", error);-->
<!--            }-->
<!--        });-->
<!--    });-->
<!--</script>-->
<!--<script>-->
<!--    $(document).ready(function () {-->
<!--        let geneTable2 = null;-->
<!---->
<!--        // 点击 Search 按钮-->
<!--        $('#enhancer_search').click(function () {-->
<!--            const chr2 = $('#enhancer').val();-->
<!--            if (!chr2) {-->
<!--                alert("Please select chromosome 1 and chromosome 2 first！");-->
<!--                return;-->
<!--            }-->
<!--        // 清理已有的子表-->
<!--            $('#enhancer-table-wrapper').fadeOut(200, function () {-->
<!--                $('#enhancer-table-container').empty();-->
<!--            });-->
<!--            $('#gene-result-table button.show-enhancers.active').removeClass('active');-->
<!--            // 如果表格已存在，销毁并清空-->
<!--            if ($.fn.DataTable.isDataTable('#gene-result-table')) {-->
<!--                $('#gene-result-table').DataTable().destroy();-->
<!--                $('#gene-result-table tbody').empty();-->
<!--            }-->
<!---->
<!--            // 初始化 gene-result-table-->
<!--            geneTable2 = $('#gene-result-table').DataTable({-->
<!--                processing: true,-->
<!--                serverSide: true,-->
<!--                ajax: {-->
<!--                    url: './api/chr2_table.php',-->
<!--                    type: 'POST',-->
<!--                    data: function (d) {-->
<!--                        const slider = document.getElementById('rangeSliderEnh');-->
<!--                        let range = [0, 0];-->
<!--                        if (slider && slider.noUiSlider) {-->
<!--                            range = slider.noUiSlider.get();-->
<!--                        }-->
<!--                        d.chr2 = $('#enhancer').val();-->
<!--                        d.rangeMin = Math.round(range[0]);-->
<!--                        d.rangeMax = Math.round(range[1]);-->
<!--                    }-->
<!--                },-->
<!--                columns: [-->
<!--                    { data: 'Gene_sites', orderable: false },-->
<!--                    { data: 'Strand', orderable: false },-->
<!--                    { data: 'Gene_name', orderable: false },-->
<!--                    { data: 'Promoter_region', orderable: false },-->
<!--                    {-->
<!--                        data: 'Enhancers',-->
<!--                        orderable: false,-->
<!--                        render: function (count) {-->
<!--                            if (!count || count === 0) {-->
<!--                                return `<span>No enhancer</span>`;-->
<!--                            }-->
<!--                            let label = count === 1-->
<!--                                ? `Show 1 Enhancer`-->
<!--                                : `Show ${count} Enhancers`;-->
<!--                            return `-->
<!--                            <div class="enhancer-cell">-->
<!--                                <button class="show-enhancers">-->
<!--                                    ${label} <span class="arrow">▼</span>-->
<!--                                </button>-->
<!--                            </div>-->
<!--                        `;-->
<!--                        }-->
<!--                    }-->
<!--                ],-->
<!--                order: [[0, 'asc']],-->
<!--                columnDefs: [-->
<!--                    { targets: '_all', className: 'text-center' }-->
<!--                ],-->
<!--                language: {-->
<!--                    emptyTable: "Sorry, no annotation information, please select another chromosome"-->
<!--                }-->
<!--            });-->
<!---->
<!--            $('#gene-table-wrapper').show();-->
<!---->
<!--            // ----------- 子表逻辑 ------------->
<!--            if (!$('#enhancer-table-wrapper').length) {-->
<!--                $('#gene-table-wrapper').after(`-->
<!--                <div id="enhancer-table-wrapper" style="margin-top:20px; display:none;">-->
<!--                    <h5>Enhancer Information</h5>-->
<!--                    <div id="enhancer-table-container"></div>-->
<!--                </div>-->
<!--            `);-->
<!--            }-->
<!---->
<!--            $('#gene-result-table tbody')-->
<!--                .off('click', 'button.show-enhancers')-->
<!--                .on('click', 'button.show-enhancers', function (e) {-->
<!--                    e.stopPropagation();-->
<!--                    let $btn = $(this);-->
<!--                    let row = geneTable2.row($btn.closest('tr'));-->
<!--                    let rowData = row.data();-->
<!---->
<!--                    if (!rowData || !rowData.Gene_sites) return;-->
<!---->
<!--                    if ($btn.hasClass('active')) {-->
<!--                        $('#enhancer-table-wrapper').fadeOut(200, function () {-->
<!--                            $('#enhancer-table-container').empty();-->
<!--                        });-->
<!--                        $btn.removeClass('active');-->
<!--                        return;-->
<!--                    }-->
<!---->
<!--                    $('#gene-result-table button.show-enhancers.active').removeClass('active');-->
<!---->
<!--                    let childTableHtml = `-->
<!--                    <table id="enhancer-subtable" class="table table-bordered table-sm" style="width:100%; font-size:14px; background:#f9f9f9;">-->
<!--                        <thead>-->
<!--                            <tr>-->
<!--                                <th>Enhancerid</th>-->
<!--                                <th>Enhancer region</th>-->
<!--                                <th>Transcription factor</th>-->
<!--                            </tr>-->
<!--                        </thead>-->
<!--                    </table>-->
<!--                `;-->
<!---->
<!--                    $('#enhancer-table-container').html(childTableHtml);-->
<!--                    $('#enhancer-table-wrapper h5').text(`${rowData.Gene_sites} Enhancer Information :`);-->
<!--                    $('#enhancer-table-wrapper').fadeIn(200);-->
<!---->
<!--                    $('#enhancer-subtable').DataTable({-->
<!--                        processing: true,-->
<!--                        serverSide: true,-->
<!--                        searching: false,-->
<!--                        ordering: false,-->
<!--                        paging: true,-->
<!--                        ajax: {-->
<!--                            url: './api/enhancer_table.php',-->
<!--                            type: 'POST',-->
<!--                            data: function(d) {-->
<!--                                d.gene_site = rowData.Gene_sites;-->
<!--                            }-->
<!--                        },-->
<!--                        columns: [-->
<!--                            { data: 'enhancerid', orderable: false },-->
<!--                            { data: 'region', orderable: false },-->
<!--                            { data: 'tf', orderable: false }-->
<!--                        ],-->
<!--                        columnDefs: [-->
<!--                            { targets: '_all', className: 'text-center', createdCell: function(td) {-->
<!--                                    $(td).css('font-weight', 'normal');-->
<!--                                }}-->
<!--                        ],-->
<!--                        language: {-->
<!--                            emptyTable: "No enhancer information"-->
<!--                        }-->
<!--                    });-->
<!---->
<!--                    $btn.addClass('active');-->
<!--                });-->
<!--            // ------------------------------------------------------------>
<!--        });-->
<!---->
<!--        // Reset 按钮-->
<!--        $('#enhancer_reset').click(function () {-->
<!--            $('#enh_chr').val('');-->
<!--            $('#enhancer').val('');-->
<!--            initRangeSliderEnh(0, 100);  // 重置 slider-->
<!---->
<!--            if ($.fn.DataTable.isDataTable('#gene-result-table')) {-->
<!--                $('#gene-result-table').DataTable().clear().draw();-->
<!--            }-->
<!---->
<!--            $('#gene-table-wrapper').hide();-->
<!--            $('#enhancer-table-wrapper').hide();-->
<!--        });-->
<!--    });-->
<!--</script>-->
<?php
include "./Template/footer.php";
?>

