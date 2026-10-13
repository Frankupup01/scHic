<!--include base-->
<?php
include "./Template/base.php";
?>
<body>
<!--include header-->
<?php include './Template/header.php';
?>
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
    .i {
        transition: transform 0.5s ease, box-shadow 0.5s ease;
        display: block;
        margin: 0 auto;
    }
    .i:hover {
        transform: scale(1.05);
        box-shadow: 0 6px 18px rgba(0,0,0,.25);
    }
</style>


<div class="container" style="padding-bottom: 20px;">
    <br>
    <div class="card-header">

        <h4 style="font-size: 24px;color: rgb(41,101,124)" id="yhead"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-zoom-in" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M6.5 12a5.5 5.5 0 1 0 0-11 5.5 5.5 0 0 0 0 11M13 6.5a6.5 6.5 0 1 1-13 0 6.5 6.5 0 0 1 13 0"/>
                <path d="M10.344 11.742q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1 6.5 6.5 0 0 1-1.398 1.4z"/>
                <path fill-rule="evenodd" d="M6.5 3a.5.5 0 0 1 .5.5V6h2.5a.5.5 0 0 1 0 1H7v2.5a.5.5 0 0 1-1 0V7H3.5a.5.5 0 0 1 0-1H6V3.5a.5.5 0 0 1 .5-.5"/>
            </svg><span class="glyphicon glyphicon-open" aria-hidden="true"></span> Analysis</h4>
    </div>
    <div class="row">
        <hr>
    </div>
    <div class="parent-element" style="text-align: center;">
        <h1 style="font-size: 18px;margin-bottom: -10px;">
            <span class="glyphicon glyphicon-gift" aria-hidden="true" style="font-size: 25px;"></span><b>Analysis Interface of scHi-cdb</b>
        </h1>
        <hr class="simple" color="#36648B" style="height: 2px;" />
        <p style="font-size: 17px;margin-top: -15px; text-align: center;">Please click on the image to access the corresponding enhancer analysis section.<a href="./help.php"><span class="glyphicon glyphicon-question-sign"></span></a></p>
    </div>
    <div class="row col-lg-12">
        <div class="col-lg-3">
            <!-- <a href="./Browse_tissue_eccdna_mouse.php?Species=Mus musculus"><img class="i" src="./bootstrap-3.4.1-dist/img/Mus%20muscul.png"  style="width:100%;height:230px"/></a> -->
            <a href="./iframe2/GC_frame.php"><img class="i" src="./bootstrap5/analysis_pic/gc.png"  style="width:100%;height:250px"/></a>
            <b style="text-align: center; font-size: 15px; padding-left: 30px">Enhancer GC content analysis</b>
        </div>
        <div class="col-lg-3">
            <a href="./iframe2/gene-enhancer.php"><img class="i" src="./bootstrap5/analysis_pic/gene_e.jpg"  style="width:100%;height:250px"/></a>
            <b style="text-align: center;font-size: 15px; padding-left: 30px">Analysis of enhancer target genes</b>
        </div>
        <div class="col-lg-3">
            <!-- <a href="./Browse_tissue_eccdna_mouse.php?Species=Mus musculus"><img class="i" src="./bootstrap-3.4.1-dist/img/Mus%20muscul.png"  style="width:100%;height:230px"/></a> -->
            <a href="./iframe2/random_frame.php"><img class="i" src="./bootstrap5/analysis_pic/random.png"  style="width:100%;height:250px"/></a>
            <b style="text-align: center; font-size: 15px; padding-left: 30px">Generate random enhancer regions</b>
        </div>
        <div class="col-lg-3">
            <a href="./iframe2/distribution_frame.php"><img class="i" src="./bootstrap5/analysis_pic/dis.png"  style="width:100%;height:250px"/></a>
            <b style="text-align: center; font-size: 15px; padding-left: 30px">Enhancer chromosome distribution</b>
        </div>

    </div>
    <br>
    <br>
    <!-- 暂时取消该功能，望今后有时间做或者实验室其他师弟师妹能做下来该应用
    <div class="row col-lg-12">
    <div class="col-lg-3">
        <a href="./iframe2/compare_frame.php">
            <img class="i" src="./bootstrap5/analysis_pic/compare.png" style="width:100%; height:250px;"/>
        </a>
        <b style="display:block; text-align:center; font-size:15px; margin-right: 10px">
            Comparative analysis of enhancer<br/>
            between two samples
        </b>
    </div>
    </div>
       -->
</div>





<?php
include "./Template/footer.php";
?>

