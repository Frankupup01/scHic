<!--include base-->
<?php
include "./Template/base.php";
?>
<!--include header-->
<?php
include "./Template/header.php";
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
</style>
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <h1 style="font-size: 180%;margin-top: 1%">
                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="50" fill="currentColor" class="bi bi-envelope-paper-fill" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M6.5 9.5 3 7.5v-6A1.5 1.5 0 0 1 4.5 0h7A1.5 1.5 0 0 1 13 1.5v6l-3.5 2L8 8.75zM1.059 3.635 2 3.133v3.753L0 5.713V5.4a2 2 0 0 1 1.059-1.765M16 5.713l-2 1.173V3.133l.941.502A2 2 0 0 1 16 5.4zm0 1.16-5.693 3.337L16 13.372v-6.5Zm-8 3.199 7.941 4.412A2 2 0 0 1 14 16H2a2 2 0 0 1-1.941-1.516zm-8 3.3 5.693-3.162L0 6.873v6.5Z"/>
                </svg>
                Please contact us</h1>
            <hr/>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <iframe width="100%" height="450" align="center" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="./Template/map.php"></iframe>
        </div>
        <div class="col-lg-6">
            <div style="height:400px; padding-left:20px;">
                <p><strong>Associate Professor:</strong> Zhiyun Guo, Ph.D.</p>
                <p><strong>Affiliation:</strong> School of Life Sciences and Engineering, Southwest Jiaotong University, Chengdu 610000, China</p>
                <!-- <p><strong>Phone:</strong> 13438192585</p> -->
                <p><strong>Email: </strong> zhiyunguo@swjtu.edu.cn</p>
            </div>
        </div>
    </div>
    <hr/>
    <div class="row">
        <div class="col-lg-12">
            <div class="card-header">
                <h4 style="font-size: 20px;color: rgb(41,101,124)"> Visitor Map</h4>
            </div>

            <div class="container-fluid" style="margin-top: 25px; margin-bottom: 25px; display: flex; justify-content: center; align-items: center;">

                <div style="width: 100%; pointer-events: none;">
                    <script type="text/javascript" id="mapmyvisitors" src="//mapmyvisitors.com/map.js?d=VV8T-NYVjl9sU0A1x6WDxCkr-L4MgnBbZbkCYCK9Ljw&cl=ffffff&w=a"></script>
                </div>

            </div>
        </div>
    </div>
</div>


<!--include footer-->
<?php
include "./Template/footer.php";
?>