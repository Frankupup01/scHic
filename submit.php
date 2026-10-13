<!--include base-->
<?php
include "./Template/base.php";
?>
<!--include header-->
<?php include './Template/header.php';
?>
<style>
    /* 样式调整 - 保持不变 */
    body {
        margin: 0;
        font-family: Arial, sans-serif;
    }

    #myModal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.6);
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .modal-content {
        width: 300px;
        background-color: #fff;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        text-align: center;
        position: relative;
        color: #333;
    }

    .close {
        position: absolute;
        top: 10px;
        right: 10px;
        font-size: 18px;
        cursor: pointer;
        color: #666;
    }

    .modal-content input,
    .modal-content button {
        width: 100%;
        padding: 10px;
        margin: 10px 0;
        border: 1px solid #ccc;
        border-radius: 5px;
        box-sizing: border-box;
        font-size: 16px;
    }

    .modal-content button {
        background-color: #3498db;
        color: #fff;
        cursor: pointer;
    }
    .custom-fixed-box {
        overflow-x: auto;
        max-width: 100%;
    }
    html, body {
        height: 100%;
        margin: 0;
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

<div id="mainContain">
    <div class="container" >
        <br>
        <div class="card-header">
            <h4 style="font-size: 24px;color: rgb(41,101,124)" id="yhead">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-send-plus" viewBox="0 0 16 16">
                    <path d="M15.964.686a.5.5 0 0 0-.65-.65L.767 5.855a.75.75 0 0 0-.124 1.329l4.995 3.178 1.531 2.406a.5.5 0 0 0 .844-.536L6.637 10.07l7.494-7.494-1.895 4.738a.5.5 0 1 0 .928.372zm-2.54 1.183L5.93 9.363 1.591 6.602z"/>
                    <path d="M16 12.5a3.5 3.5 0 1 1-7 0 3.5 3.5 0 0 1 7 0m-3.5-2a.5.5 0 0 0-.5.5v1h-1a.5.5 0 0 0 0 1h1v1a.5.5 0 0 0 1 0v-1h1a.5.5 0 0 0 0-1h-1v-1a.5.5 0 0 0-.5-.5"/>
                </svg>
                <span class="glyphicon glyphicon-open" aria-hidden="true"></span> Submit Dataset
            </h4>
        </div>
        <div class="row">
            <hr>
        </div>
        <form action="" method="post" id="submitForm" onsubmit="return Post();">
            <div class="row" style="height:100%; margin:20px 0;background:#fff; border-radius: 30px;border:10px solid #8cb0e6;background-color:floralwhite">
                <div class="col-12">
                    <div class="alert alert-info" role="alert" style="background-color:floralwhite;margin-top: 9px; border:none; padding-bottom: 0;">

                        <div class="form-group">
                            <label class="control-label">Species</label>
                            <input id="Species" name="Species" class="form-control" type="text"
                                   placeholder="e.g. Human, Mouse, Drosophila" autocomplete="off">
                        </div>

                        <div class="form-group">
                            <label class="control-label">Tissue & Cell Type</label>
                            <input id="CellType" name="CellType" class="form-control" type="text"
                                   placeholder="e.g. Brain - Excitatory Neurons, PBMCs" autocomplete="off">
                        </div>

                        <div class="form-group">
                            <label class="control-label">scHi-C Protocol</label>
                            <input id="Protocol" name="Protocol" class="form-control" type="text"
                                   placeholder="e.g. sci-Hi-C, sn-Hi-C, Dip-C, scSPRITE" autocomplete="off">
                        </div>

                        <div class="form-group">
                            <label class="control-label">Resolution / Bin Size</label>
                            <input id="Resolution" name="Resolution" class="form-control" type="text"
                                   placeholder="e.g. 10 kb, 100 kb, 1 Mb" autocomplete="off">
                        </div>

                        <div class="form-group">
                            <label class="control-label">Data Accession / Download Link</label>
                            <textarea id="DataLink" name="DataLink" class="form-control" rows="4" type="text"
                                      placeholder="Please provide GEO accession (e.g. GSE123456) or a link to .cool/.hic matrices" autocomplete="off"></textarea>
                        </div>

                        <div class="form-group">
                            <label class="control-label">Your Email</label>
                            <input id="email" name="email" class="form-control" type="text" autocomplete="off"
                                   placeholder="Please enter a valid email address for contact">
                        </div>
                    </div>
                </div>

                <div class="col-12" style="padding: 0 30px 15px 30px;">
                    <div class="alert" style="background-color: #f8f9fa; border-left: 5px solid #8cb0e6; font-size: 15px; color: #333; margin-bottom: 0;" role="alert">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#8cb0e6" viewBox="0 0 16 16" style="margin-right: 5px; margin-bottom: 2px;">
                            <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
                        </svg>
                        <strong>Note:</strong> "We sincerely thank the research community for contributing valuable data to our database! Please ensure that all submitted content is authentic and valid. All submissions will undergo strict manual screening and verification. Approved data, along with your provided tags, will be officially incorporated and published in the next database update."
                    </div>
                </div>

                <div class="col-12">
                    <div class="form-group">
                        <div style="text-align: center;padding-bottom: 25px;">
                            <button class="btn btn-primary" type="submit" id="sub" style="border-radius: 10px; padding: 10px 30px; font-size: 16px;"><strong>Submit</strong></button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
    function Post() {
        var query = {
            Species: $('#Species').val(),
            CellType: $('#CellType').val(),
            Protocol: $('#Protocol').val(),
            Resolution: $('#Resolution').val(),
            DataLink: $('#DataLink').val(),
            email: $('#email').val(),
        };

        var search_str = /^[\w\-\.]+@[\w\-\.]+(\.\w+)+$/;
        var email_val = $("#email").val();

        console.log(query);

        if (email_val === '') {
            alert('You must input your email!');
            $('#email').focus();
            return false;
        }
        else if (!search_str.test(email_val)) {
            alert("Please input a valid email format!");
            $('#email').focus();
            return false;
        }
        else {
            $.ajax({
                url: '../php/submit.php',
                method: 'post',
                cache: false,
                async: true,
                data: query,
                success: function (result) {
                    console.log(result);
                    alert('Thank you! Your dataset has been successfully submitted. It will be presented in the database after our manual verification.');
                    $('#submitForm')[0].reset(); // 提交成功后清空表单
                },
                error: function (result) {
                    alert('There was an error uploading your submission, please contact the administrator.');
                }
            });
            return false;
        }
    }
</script>








<?php
include "./Template/footer.php";
?>
