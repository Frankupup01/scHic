<!--include base-->
<?php
include "./Template/base.php";
?>
<body>
<!--include header-->
<?php include './Template/header.php';
?>
<style>
    html,body{                   /* 保持全屏 flex 布局 */
        height:100%;
        margin:0;
        display:flex;
        flex-direction:column;
    }
    #mainContent{                /* 让正文区域吃掉所有剩余高度 */
        flex:1 0 auto;
    }
    footer,.footer{              /* footer 仍然被自动顶到底 */
        margin-top:auto;
    }
</style>


<style>
    .dashed {
        border-style: dashed;
    }



    /* 左侧滚动栏 */
    @media (min-width: 1200px) {
        .flex-xl-nowrap {
            flex-wrap: nowrap !important;
        }
    }

    @media (min-width: 768px) {
        .bd-sidebar {
            position: sticky;
            top: 4rem;
            z-index: 3;
            max-height: calc(100vh - 4rem);
        }

        .bd-sidebar {
            order: 0;
        }

        .bd-content {
            order: 1;
        }

        .bd-links {
            max-height: calc(100vh - 4rem);
            overflow-y: auto;
            overflow-x: hidden;
        }

        .bd-links>div {
            margin-right: -5px;
        }
    }

    /*背景图*/
    body {
        position: relative;
    }

    .background_body {
        position: fixed;
        z-index: -1;
        height: 100%;
        width: 100%;
        background-size: cover;
        background-position: center;
        opacity: 0.1;
    }

    /*DataTable*/
    div.dataTables_wrapper div.dataTables_processing {
        position: absolute;
        top: 50%;
        left: 50%;
        width: 200px;
        margin-left: -100px;
        margin-top: -26px;
        text-align: center;
        padding: 1em 0;
        background: #5e72e4;
        z-index: 1;
        border: 1px dotted;
        color: white;
        font-weight: bold;
        opacity: 0.8;
    }

    h2>a,
    b>a,
    .dashed,
    .navbar-brand,
    .navbar-nav .nav-link,
    .alert,

</style>
<style>

    img {
        width: 100%;
    }

    img[data-action="zoom"] {
        cursor: pointer;
        cursor: -webkit-zoom-in;
        cursor: -moz-zoom-in;
    }
    .zoom-img,
    .zoom-img-wrap {
        position: relative;
        z-index: 666;
        -webkit-transition: all 300ms;
        -o-transition: all 300ms;
        transition: all 300ms;
    }
    img.zoom-img {
        cursor: pointer;
        cursor: -webkit-zoom-out;
        cursor: -moz-zoom-out;
    }
    .zoom-overlay {
        z-index: 420;
        background: #fff;main
    position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        pointer-events: none;
        filter: "alpha(opacity=0)";
        opacity: 0;
        -webkit-transition:      opacity 300ms;
        -o-transition:      opacity 300ms;
        transition:      opacity 300ms;
    }
    .zoom-overlay-open .zoom-overlay {
        filter: "alpha(opacity=100)";
        opacity: 1;
    }
    .zoom-overlay-open,
    .zoom-overlay-transitioning {
        cursor: default;
    }
    .nam{
        text-align: center;color: #0c2e8a;
        padding-bottom: 7px;

        padding-top: 7px;
    }


</style>

<main id="mainContent">
<div class="container" style="width: 100%; padding-left: 15px; padding-right: 20px;">


    <br>
    <div class="row flex-xl-nowrap">
        <div class="col-lg-4 bd-sidebar">
            <nav class="bd-links" style="background-color: #FFFFFF;">
                <div class="row" style="background-color: #FFFFFF; margin-top: -15px; margin-bottom: 20px">
                    <div class="col-lg-12">
                        <table class="mt-4 w-100">
                            <thead>
                            <tr>
                                <th>
                                    <div class="alert alert-secondary" role="alert" style="background-color: #8cb0e6;height: 60px;">
                                        <p class="font-weight-bold text-center">
                                            <span style="color: white;font-size: 25px;">Help Navigation</span>
                                        </p>
                                    </div>
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            <!-- 一级目录 -->
                            <tr><td><a class="btn border px-3 py-1 text-start w-100" href="#1-what-information-is-avaiable-in-ernascatlas">
                                        1 What information is available in scHi-cdb?
                                    </a></td></tr>

                            <tr><td><a class="btn border px-3 py-1 text-start w-100" href="#4-how-to-use-the-ernascatlas">
                                        2 How to use the scHi-cdb?
                                    </a></td></tr>

                            <!-- 二级目录：2.1 - 2.6 -->
                            <tr><td><a class="btn border px-3 py-1 text-start w-100" href="#21-browse">
                                        2.1 Browse
                                    </a></td></tr>
                            <tr><td><a class="btn border px-3 py-1 text-start w-100" href="#22-search">
                                        2.2 Search
                                    </a></td></tr>

                            <!-- 三级目录：Search 子项 -->
                            <tr><td><a class="btn border px-3 py-1 text-start w-100" href="#421-search-tc">
                                        2.2.1 Search by Tissue / Cell type
                                    </a></td></tr>
                            <tr><td><a class="btn border px-3 py-1 text-start w-100" href="#422-search-disease">
                                        2.2.2 Search by Disease
                                    </a></td></tr>
                            <tr><td><a class="btn border px-3 py-1 text-start w-100" href="#423-search-study">
                                        2.2.3 Search by Study
                                    </a></td></tr>
                            <tr><td><a class="btn border px-3 py-1 text-start w-100" href="#424-search-experiment">
                                        2.2.4 Search by Experiment
                                    </a></td></tr>

                            <tr><td><a class="btn border px-3 py-1 text-start w-100" href="#23-dataset">
                                        2.3 Dataset detail
                                    </a></td></tr>

                            <!-- 三级目录：Dataset 子项 -->
                            <tr><td><a class="btn border px-3 py-1 text-start w-100" href="#231-dataset-summary">
                                        2.3.1 Dataset summary
                                    </a></td></tr>
                            <tr><td><a class="btn border px-3 py-1 text-start w-100" href="#233-dataset-chromosome">
                                        2.3.2 Chromosome information
                                    </a></td></tr>
                            <tr><td><a class="btn border px-3 py-1 text-start w-100" href="#234-dataset-annotation">
                                        2.3.3 Annotation
                                    </a></td></tr>

                            <tr><td><a class="btn border px-3 py-1 text-start w-100" href="#24-analysis">
                                        2.4 Visualization
                                    </a></td></tr>

                            <!-- 三级目录：Analysis 子项 -->
                            <tr><td><a class="btn border px-3 py-1 text-start w-100" href="#241-GC-content">
                                        2.4.1 UMAP
                                    </a></td></tr>
                            <tr><td><a class="btn border px-3 py-1 text-start w-100" href="#242-gene-enhancer">
                                        2.4.2 3D genome
                                    </a></td></tr>

                            <tr><td><a class="btn border px-3 py-1 text-start w-100" href="#25-download">
                                        2.5 Download
                                    </a></td></tr>

                            <tr><td><a class="btn border px-3 py-1 text-start w-100" href="#26-download">
                                        2.6 Submit
                                    </a></td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </nav>
        </div>
        <div class="col-lg-8 bd-content">
            <b id="1-what-information-is-avaiable-in-ernascatlas" style="font-size: 20px;">1. What information is avaiable in scHi-cdb?</b>
            <p> The three-dimensional (3D) organization of the genome is tightly linked to transcriptional regulation and cellular identity. While single-cell Hi-C (scHi-C) technologies have revolutionized our ability to detect cell-to-cell variability in chromatin folding, the immense computational challenges associated with data sparsity and volume have hindered the widespread use of these datasets by the broader biological community. To bridge this gap, we present scHiCdb, a comprehensive and user-friendly database dedicated to the high-resolution landscape of single-cell 3D genomes. This database was established by conducting keyword searches in public databases to gather published studies, which were subsequently screened according to standardized criteria. Currently, the database catalogs processed data from 33 distinct studies, encompassing diverse physiological and pathological conditions. Following the same workflow, we processed these chromatin contacts into interaction files. To facilitate in-depth exploration of 3D genome contacts, we annotated all chromatin sites. We then performed UMAP dimensionality reduction and simulation modeling to further characterize the 3D chromatin architecture. scHiCdb features an intuitive web interface equipped with dynamic visualization tools, enabling researchers to seamlessly query chromatin contacts and enhancer-promoter loops at the single-cell level. By facilitating the exploration of structural heterogeneity, scHiCdb serves as a vital computational resource for uncovering novel mechanistic insights into the regulatory logic of complex biological systems.</p>
            <br>

            <b id="4-how-to-use-the-ernascatlas" style="font-size: 20px;">2. How to use the scHi-cdb?</b>
            <br>

            <h3 id="21-browse">2.1 Browse</h3>
            <p>Here are the results of the Browse by dataset.</p>
            <p><b>URL:<a href="https://lcbb.swjtu.edu.cn/scHic/browse.php">https://lcbb.swjtu.edu.cn/scHic/browse.php</a></b></p>
            <p><img alt="browse" src="./public/image/helppic/browse_dataset.png"/></p>


            <br>
            <h3 id="22-search">2.2 Search</h3>
            <p><b>URL:<a href="https://lcbb.swjtu.edu.cn/scHic/search.php">https://lcbb.swjtu.edu.cn/scHic/search.php</a></b></p>
            <h4 id="421-search-tc">2.2.1 Search scHi-c by Tissue / Cell type</h4>
            <p><img alt="regions" src="./public/image/helppic/search_tc.png" /></p>
            <h4 id="422-search-disease">2.2.2 Search scHi-c by Disease</h4>
            <p><img alt="regions-r1" src="./public/image/helppic/search_disease.png" /></p>
            <h4 id="423-search-study">2.2.3 Search scHi-c by Study</h4>
            <p><img alt="regions-r2" src="./public/image/helppic/search_study.png" /></p>
            <h4 id="424-search-experiment">2.2.4 Search scHi-c by Experiment</h4>
            <p><img alt="regions-r3" src="./public/image/helppic/search_experiment.png" /></p>
            <br>


            <h3 id="23-dataset">2.3 Dataset detail</h3>
            <p><b>URL:<a href="https://lcbb.swjtu.edu.cn/scHic/detail_browse.php?source=SRR921526&SampleName=GSM1173493">https://lcbb.swjtu.edu.cn/scHic/detail_browse.php</a></b></p>
            <br>
            <h4 id="231-dataset-summary">2.3.1 dataset summary</h4>
            <p>This module is dataset summary information. </p>
            <p><img alt="regions-r5" src="./public/image/helppic/dataset-summary.png" /></p>
            <br>

            <h4 id="233-dataset-chromosome">2.3.2 dataset chromosome information</h4>
            <p>This module is dataset chromosome information. </p>
            <p><img alt="regions-r5" src="./public/image/helppic/dataset-chromosome.png" /></p>
            <br>
            <h4 id="234-dataset-annotation">2.3.3 annotation</h4>
            <p>This module has two cascading searches to explore annotation information in the deep layers of chromosomes. </p>
            <p><img alt="regions-r5" src="./public/image/helppic/dataset-annotation.png" /></p>
            <br>

            <h3 id="24-analysis">2.4 visualization</h3>
            <p>Here are some procedures to analyze the data in database.</p>
            <p><b>URL:<a href="https://lcbb.swjtu.edu.cn/genome3d/">https://lcbb.swjtu.edu.cn/genome3d/</a></b></p>
            <br>

            <h4 id="241-GC-content">2.4.1 GC content analysis</h4>
            <p>This module is for analyzing the GC content of enhancer. Users first input a bed file of enhancer coordinates, then submit it, and finally generate publication-quality GC enrichment figure of enhancer. </p>
            <p><img alt="gc-r1" src="./public/image/helppic/umap.png" /></p>
            <br>
            <p>The results of the analysis of the example data are as follows. </p>
            <p><img alt="gc-r2" src="./public/image/helppic/3dgene.png" /></p>
            <br>



            <h3 id="25-download">2.5 Download</h3>
            <p>Here is the download page of the database.</p>
            <p><b>URL:<a href="https://lcbb.swjtu.edu.cn/scHic/download.php">https://lcbb.swjtu.edu.cn/scHic/download.php</a></b></p>
            <br>
            <p><img alt="download" src="./public/image/helppic/download.png"/></p>

            <h3 id="26-download">2.6 Submit</h3>
            <p>Here is the submit data page of the database.</p>
            <p><b>URL:<a href="https://lcbb.swjtu.edu.cn/scHic/submit.php">https://lcbb.swjtu.edu.cn/scHic/submit.php</a></b></p>
            <br>
            <p><img alt="submit" src="./public/image/helppic/submit.png"/></p>


        </div>
    </div>
</div>
</main>

<script>
    $(document).ready(() => {
        var sp1 = location.toString().split('/');
        sp1.reverse();
        var sp2 = sp1.length === 5 ? sp1[0] : (sp1[1] + ".php");
        if (sp2 === '')
            sp2 = 'index.php';
        $('a[href*="/' + sp2 + '"]').parents('li').addClass('active');

        setTimeout(function() {
            $("*[height-to]").each(function(t, e) {
                var height_to = $(e).attr("height-to");
                if (height_to) {
                    $(e).css("height", $("#" + height_to).css("height"));
                    $(e).css("overflow-y", "auto");
                    $(e).css("overflow-x", "hidden");
                }
            })
        }, 500);

    });
    // 这段 JavaScript 代码的主要作用是为当前页面的导航菜单项添加 "active" 类，并处理一些带有 height-to 属性的元素，以确保它们的高度与指定的目标元素相匹配，并可以滚动显示超出高度的内容。这通常用于页面导航和显示效果的改进。
</script>







<?php
include "./Template/footer.php";
?>

