<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords" content="">
    <meta name="description" content="">
    <link href="../bootstrap5/css/bootstrap.min.css" rel="stylesheet">
    <link href="../bootstrap5/css/bootstrap-select.css" rel="stylesheet">
    <link href="../bootstrap5/DataTables/buttons.dataTables.min.css" rel="stylesheet">
    <link href="../bootstrap5/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="../bootstrap5/noUiSlider-15.8.1/dist/nouislider.css" rel="stylesheet" >
    <link href="../bootstrap5/bootstrap-3.4.1-dist/zTree_v3-master/css/zTreeStyle/zTreeStyle.css" type="text/css" rel="stylesheet">
    <link rel="stylesheet" href="../Template/style.css">
    <!-- jquery and popper -->
    <script src="../bootstrap5/js/jquery-3.6.1.js"></script>
    <script src="../bootstrap5/js/bootstrap.bundle.min.js"></script>
    <script src="../bootstrap5/js/bootstrap-select.min.js"></script>
    <!-- datatables -->
    <script src="../bootstrap5/js/jquery.dataTables.min.js"></script>
    <script src="../bootstrap5/bootstrap-3.4.1-dist/js/echarts.js"></script>
    <script src="../bootstrap5/noUiSlider-15.8.1/dist/nouislider.min.js"></script>
    <script src="../bootstrap5/DataTables/dataTables.buttons.min.js"></script>
    <script src="../bootstrap5/DataTables/jszip.min.js"></script>
    <script src="../bootstrap5/DataTables/buttons.bootstrap4.min.js"></script>
    <script src="../bootstrap5/DataTables/buttons.html5.min.js"></script>
    <script src="../bootstrap5/DataTables/buttons.print.min.js"></script>
    <script src="../bootstrap5/DataTables/buttons.colVis.min.js"></script>
    <script src="../bootstrap5/bootstrap-3.4.1-dist/js/popper.min.js"></script>
    <script src="../bootstrap5/bootstrap-3.4.1-dist/js/jquery.ztree.all.js"></script>

    <title>scHi-Cdb</title>
</head>
<style>

    /* 页面整体最小高度 100% */
    html, body {
        height: 100%;
        margin: 0;
        display: flex;
        flex-direction: column;
    }

    /* 主内容区域，占据剩余空间 */
    #mainContain,
    .container {
        flex: 1 0 auto;
    }

    /* footer 永远贴底 */
    footer, .footer {
        margin-top: auto;
    }
    /* 统一控制本次出现的 3 个按钮 */
    .btn-default {
        color: #555 !important;          /* 灰色文字 */
        background-color: #fff !important; /* 白色背景 */
        border-color: #ccc !important;   /* 浅灰边框 */
        text-transform: none;
    }
    /* 悬停高亮 */
    .btn-default:hover,
    .btn-default:focus {
        background-color: #f2f2f2 !important;
        border-color: #bbb !important;
        color: #555 !important;
    }
</style>

<div class="navbar container-fluid">
    <div class="container d-flex justify-content-between align-items-center">
        <a class="navbar-brand d-flex align-items-center ms-0" href="../index.php">
            <img src="../bootstrap5/images/logo.png" alt="scHi-Cdb" style="height: 50px; object-fit: contain;">
        </a>
        <div class="menu">
            <a href="../index.php" class="header-link">HOME</a>
            <a href="../browse.php" class="header-link">BROWSE</a>
            <a href="../search.php" class="header-link">SEARCH</a>
            <a href="../analysis.php" class="header-link">ANALYSIS</a>
            <a href="../download.php" class="header-link">DOWNLOAD</a>
            <a href="../submit.php"  class="header-link">SUBMIT</a>
            <a href="../contact.php" class="header-link">CONTACT</a>
            <a href="../help_manual.php" class="header-link">HELP</a>
        </div>
    </div>
</div>
</div>
<br>
<div class="container" >
<form action="../analysis_gene_enhancer.php" method="get" enctype="multipart/form-data" ">
    <div class="center-block">
        <!-- 基因输入 -->
        <div>
            <p class="h6 mb-1" style="color:black"><strong>Please input some official gene symbol</strong></p>

            <textarea class="form-control" rows="6" name="gene_id" id="fuzzy_gene" value="MRPL20
        ANKRD65
         AMEM88B
         " spellcheck="false"></textarea>

        </div>

        <div class="mt-2" >
            <button class="btn btn-default" type="Submit"><b>Search</b></button>
            <button class="btn btn-default"  id="reset" ><b>Reset</b></button>
            <a class="btn btn-default" onclick="select_example()"><b>example</b></a>
        </div>
    </div>
</form>
<div style="color:darkgray;">
    <p class="h6 mb-1" style="color:red"><strong>Function introduction：</strong></p>
    <p class="h6 mb-1" style="color:black">Based on the this query, users can input some target official gene symbol, and then enhancers that regulate these target genes will appear in the query results.</p>
    <p class="h6 mb-1" style="color:red"><strong>Note:</strong></p>
    <p class="h6 mb-1" style="color:black">1. Default species include Homo sapiens, Mus musculus, Drosophila melanogaster and Oryza sativa Japonica Group	.</p>
    <p class="h6 mb-1" style="color:black">2. In order to make the website run smoothly, it is best to select less than 15 genes at once. If you need more information, please search in multiple times.</p>
    <p class="h6 mb-1" style="color:black">3. Enter some official gene symbols that interest you, and you can search for different genes, separated by Spaces or newlines.</p>

</div>
</div>
<!-- foot -->
<br>

<script>
    $(function(){
        var url ="./gene-enhancer.php";

        // 点击 Reset 按钮
        $("#reset").click(function(e){
            e.preventDefault();
            window.location.href=url;
        });

        // 拦截表单提交
        $("form").on("submit", function (e) {
            let geneInput = $("#fuzzy_gene").val().trim();

            if (geneInput === "") {
                e.preventDefault(); // 阻止表单提交
                alert("Sorry, you need to enter at least one gene to query, please re-enter the gene you need to query.");
                return false;
            }
        });
    });

    function select_example(){
        document.getElementById('fuzzy_gene').value ='UFM1\n'+ 'GCAT\n'+'FLG\n'+'Flg\n'+'NDOR1\n'+'TAF9\n';
    }

    $.ajaxSetup({
        cache: false //close AJAX cache
    });

</script>

<script>
    function select_example(){
        document.getElementById('fuzzy_gene').value ='UFM1\n'+ 'GCAT\n'+'FLG\n'+'Flg\n'+'NDOR1\n'+'TAF9\n';
       // document.getElementById('fuzzy_species').value ="Human";
    }

    $.ajaxSetup({
        cache: false //close AJAX cache
    });
</script>
</html>


<div class="footer">
    <p class="footer">
        For a better browsing experience, we recommend using
        <a href="https://www.mozilla.org/en-US/firefox/new/" class="footer-link" target="_blank" >Firefox</a> browser or
        <a href="https://www.google.com/chrome/" class="footer-link" target="_blank" >Google Chrome</a> browser.
    </p>
    <!-- 链接导航 -->
    <p>
        <a href="../index.php" class="footer-link">HOME</a> |
        <a href="../browse.php" class="footer-link">BROWSE</a> |
        <a href="../search.php" class="footer-link">SEARCH</a> |
        <a href="../analysis.php" class="footer-link">ANALYSIS</a> |
        <a href="../download.php" class="footer-link">DOWNLOAD</a> |
        <a href="../submit.php" class="footer-link">SUBMIT</a> |
        <a href="../contact.php" class="footer-link">CONTACT</a> |
        <a href="../help_manual.php" class="footer-link">HELP</a>
    </p>
    <p>&copy; scHi-C</p>
</div>