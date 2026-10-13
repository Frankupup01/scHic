<!--include base-->
<?php
include "./Template/base.php";
?>
<!--include header-->
<?php include './Template/header.php';
?>
<style>
    /* 样式调整 */
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
        background-color: rgba(0, 0, 0, 0.6); /* 半透明黑色遮罩层 */
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
    /* 页面整体最小高度 100% */
    html, body {
        height: 100%;
        margin: 0;
        display: flex;
        flex-direction: column;
    }

    /* 主体内容区域，占据剩余空间 */
    #mainContain {
        flex: 1 0 auto;
    }

    /* footer 永远贴底 */
    footer, .footer {
        margin-top: auto;
    }
</style>
<body>

<div class="container">
    <br>
    <div class="card-header">
        <h4 style="font-size: 24px;color: rgb(41,101,124)" id="yhead">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-cloud-download" viewBox="0 0 16 16">
                <path d="M4.406 1.342A5.53 5.53 0 0 1 8 0c2.69 0 4.923 2 5.166 4.579C14.758 4.804 16 6.137 16 7.773 16 9.569 14.502 11 12.687 11H10a.5.5 0 0 1 0-1h2.688C13.979 10 15 8.988 15 7.773c0-1.216-1.02-2.228-2.313-2.228h-.5v-.5C12.188 2.825 10.328 1 8 1a4.53 4.53 0 0 0-2.941 1.1c-.757.652-1.153 1.438-1.153 2.055v.448l-.445.049C2.064 4.805 1 5.952 1 7.318 1 8.785 2.23 10 3.781 10H6a.5.5 0 0 1 0 1H3.781C1.708 11 0 9.366 0 7.318c0-1.763 1.266-3.223 2.942-3.593.143-.863.698-1.723 1.464-2.383"/>
                <path d="M7.646 15.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 14.293V5.5a.5.5 0 0 0-1 0v8.793l-2.146-2.147a.5.5 0 0 0-.708.708z"/>
            </svg>
            <span class="glyphicon glyphicon-open" aria-hidden="true"></span> Download
        </h4>
    </div>
    <div class="row">
        <hr>
    </div>

    <div class="row">
        <div class="row" style="height:100%; margin:20px 0;background:#fff; border-radius: 30px;border:10px solid #8cb0e6;background-color:floralwhite">

            <table class="table table-hover col-lg-12">
                <thead>
                <tr>
                    <th style="padding: 15px 20px; font-size: 18px; color: #333;">Dataset Description</th>
                    <th style="padding: 15px 20px; text-align: center; font-size: 18px; color: #333;">Size</th>
                    <th style="padding: 15px 20px; text-align: center; font-size: 18px; color: #333;">Last Updated</th>
                    <th style="padding: 15px 20px; text-align: center; font-size: 18px; color: #333;">Action</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td style="padding: 20px;font-size: 18px; display: flex; align-items: center;">
                        1. Human datasets
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="#1D6F42" viewBox="0 0 16 16" style="margin-left: 8px;" title="Excel File"><path d="M5.884 6.68a.5.5 0 1 0-.768.64L7.349 10l-2.233 2.68a.5.5 0 0 0 .768.64L8 10.781l2.116 2.54a.5.5 0 0 0 .768-.641L8.651 10l2.233-2.68a.5.5 0 0 0-.768-.64L8 9.219l-2.116-2.54z"/><path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2zM9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5v2z"/></svg>
                    </td>
                    <td style="vertical-align: middle; text-align: center; font-size: 16px; color: #555;">0.692 MB</td>
                    <td style="vertical-align: middle; text-align: center; font-size: 16px; color: #555;">Feb 03, 2026</td>
                    <td style="vertical-align: middle; text-align: center;">
                        <a href="./Download/Homo sapiens.xlsx" download="Homo sapiens.xlsx" class="btn btn-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" style="margin-right: 4px; margin-bottom: 2px;"><path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z"/><path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z"/></svg> Download
                        </a>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 20px;font-size: 18px; display: flex; align-items: center;">
                        2. Mouse datasets
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="#1D6F42" viewBox="0 0 16 16" style="margin-left: 8px;" title="Excel File"><path d="M5.884 6.68a.5.5 0 1 0-.768.64L7.349 10l-2.233 2.68a.5.5 0 0 0 .768.64L8 10.781l2.116 2.54a.5.5 0 0 0 .768-.641L8.651 10l2.233-2.68a.5.5 0 0 0-.768-.64L8 9.219l-2.116-2.54z"/><path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2zM9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5v2z"/></svg>
                    </td>
                    <td style="vertical-align: middle; text-align: center; font-size: 16px; color: #555;">1.4 MB</td>
                    <td style="vertical-align: middle; text-align: center; font-size: 16px; color: #555;">Mar 15, 2026</td>
                    <td style="vertical-align: middle; text-align: center;">
                        <a href="./Download/Mus musculus.xlsx" download="Mus musculus.xlsx" class="btn btn-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" style="margin-right: 4px; margin-bottom: 2px;"><path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z"/><path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z"/></svg> Download
                        </a>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 20px;font-size: 18px; display: flex; align-items: center;">
                        3. Fruit fly (Drosophila) datasets
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="#1D6F42" viewBox="0 0 16 16" style="margin-left: 8px;" title="Excel File"><path d="M5.884 6.68a.5.5 0 1 0-.768.64L7.349 10l-2.233 2.68a.5.5 0 0 0 .768.64L8 10.781l2.116 2.54a.5.5 0 0 0 .768-.641L8.651 10l2.233-2.68a.5.5 0 0 0-.768-.64L8 9.219l-2.116-2.54z"/><path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2zM9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5v2z"/></svg>
                    </td>
                    <td style="vertical-align: middle; text-align: center; font-size: 16px; color: #555;">0.012 MB</td>
                    <td style="vertical-align: middle; text-align: center; font-size: 16px; color: #555;">Jun 17, 2025</td>
                    <td style="vertical-align: middle; text-align: center;">
                        <a href="./Download/Drosophila melanogaster.xlsx" download="Drosophila melanogaster.xlsx" class="btn btn-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" style="margin-right: 4px; margin-bottom: 2px;"><path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z"/><path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z"/></svg> Download
                        </a>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 20px;font-size: 18px; display: flex; align-items: center;">
                        4. Rice (Oryza sativa) datasets
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="#1D6F42" viewBox="0 0 16 16" style="margin-left: 8px;" title="Excel File"><path d="M5.884 6.68a.5.5 0 1 0-.768.64L7.349 10l-2.233 2.68a.5.5 0 0 0 .768.64L8 10.781l2.116 2.54a.5.5 0 0 0 .768-.641L8.651 10l2.233-2.68a.5.5 0 0 0-.768-.64L8 9.219l-2.116-2.54z"/><path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2zM9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5v2z"/></svg>
                    </td>
                    <td style="vertical-align: middle; text-align: center; font-size: 16px; color: #555;">0.012 MB</td>
                    <td style="vertical-align: middle; text-align: center; font-size: 16px; color: #555;">Jun 17, 2025</td>
                    <td style="vertical-align: middle; text-align: center;">
                        <a href="./Download/Oryza sativa Japonica Group.xlsx" download="Oryza sativa Japonica Group.xlsx" class="btn btn-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" style="margin-right: 4px; margin-bottom: 2px;"><path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z"/><path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z"/></svg> Download
                        </a>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 20px;font-size: 18px; display: flex; align-items: center;">
                        5. All species datasets collection
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="#d9831f" viewBox="0 0 16 16" style="margin-left: 8px;" title="ZIP Archive"><path d="M5 7.5a1 1 0 0 1 1-1h1a1 1 0 0 1 1 1v.938l.4 1.599a1 1 0 0 1-.416 1.074l-.93.62a1 1 0 0 1-1.109 0l-.93-.62a1 1 0 0 1-.415-1.074l.4-1.599V7.5zm2 0H6v.938a1 1 0 0 1-.03.243l-.4 1.598.93.62.93-.62-.4-1.598a1 1 0 0 1-.03-.243V7.5z"/><path d="M14 4.5V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h5.5L14 4.5zm-3 0A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V4.5h-2z"/></svg>
                    </td>
                    <td style="vertical-align: middle; text-align: center; font-size: 16px; color: #555;">0.631 MB</td>
                    <td style="vertical-align: middle; text-align: center; font-size: 16px; color: #555;">Nov 08, 2025</td>
                    <td style="vertical-align: middle; text-align: center;">
                        <a href="./Download/database.zip" download="database.zip" class="btn btn-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" style="margin-right: 4px; margin-bottom: 2px;"><path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z"/><path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z"/></svg> Download
                        </a>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 20px;font-size: 18px; display: flex; align-items: center;">
                        6. Database genes
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="#d9831f" viewBox="0 0 16 16" style="margin-left: 8px;" title="ZIP Archive"><path d="M5 7.5a1 1 0 0 1 1-1h1a1 1 0 0 1 1 1v.938l.4 1.599a1 1 0 0 1-.416 1.074l-.93.62a1 1 0 0 1-1.109 0l-.93-.62a1 1 0 0 1-.415-1.074l.4-1.599V7.5zm2 0H6v.938a1 1 0 0 1-.03.243l-.4 1.598.93.62.93-.62-.4-1.598a1 1 0 0 1-.03-.243V7.5z"/><path d="M14 4.5V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h5.5L14 4.5zm-3 0A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V4.5h-2z"/></svg>
                    </td>
                    <td style="vertical-align: middle; text-align: center; font-size: 16px; color: #555;">3 MB</td>
                    <td style="vertical-align: middle; text-align: center; font-size: 16px; color: #555;">Sep 21, 2025</td>
                    <td style="vertical-align: middle; text-align: center;">
                        <a href="./Download/gene_browse.zip" download="gene_browse.zip" class="btn btn-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" style="margin-right: 4px; margin-bottom: 2px;"><path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z"/><path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z"/></svg> Download
                        </a>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 20px;font-size: 18px; display: flex; align-items: center;">
                        7. Database enhancers
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="#d9831f" viewBox="0 0 16 16" style="margin-left: 8px;" title="ZIP Archive"><path d="M5 7.5a1 1 0 0 1 1-1h1a1 1 0 0 1 1 1v.938l.4 1.599a1 1 0 0 1-.416 1.074l-.93.62a1 1 0 0 1-1.109 0l-.93-.62a1 1 0 0 1-.415-1.074l.4-1.599V7.5zm2 0H6v.938a1 1 0 0 1-.03.243l-.4 1.598.93.62.93-.62-.4-1.598a1 1 0 0 1-.03-.243V7.5z"/><path d="M14 4.5V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h5.5L14 4.5zm-3 0A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V4.5h-2z"/></svg>
                    </td>
                    <td style="vertical-align: middle; text-align: center; font-size: 16px; color: #555;">29.2 MB</td>
                    <td style="vertical-align: middle; text-align: center; font-size: 16px; color: #555;">Sep 21, 2025</td>
                    <td style="vertical-align: middle; text-align: center;">
                        <a href="./Download/enhancer_browse.zip" download="enhancer_browse.zip" class="btn btn-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" style="margin-right: 4px; margin-bottom: 2px;"><path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z"/><path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z"/></svg> Download
                        </a>
                    </td>
                </tr>
                </tbody>
            </table>

            <div style="padding: 15px 30px 10px 30px; margin-top: -10px;">
                <div class="alert alert-info" role="alert" style="font-size: 16px;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" style="margin-right: 5px; margin-bottom: 2px;"><path d="8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/></svg>
                    <strong>Note:</strong> To obtain the data, simply click the <strong>"Download"</strong> button next to the desired dataset. The files will be automatically saved to your local device.
                </div>
            </div>

            <div style="padding: 0 30px 30px 30px;">
                <div class="alert" style="background-color: #f8f9fa; border-left: 5px solid #8cb0e6; font-size: 16px; color: #333;" role="alert">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#8cb0e6" viewBox="0 0 16 16" style="margin-right: 5px; margin-bottom: 2px;"><path d="M12 12a1 1 0 0 0 1-1V8.558a1 1 0 0 0-1-1h-1.388c0-.351.021-.703.062-1.054.062-.372.166-.703.31-.992.145-.29.331-.517.559-.683.227-.186.516-.279.868-.279V3c-.579 0-1.085.124-1.52.372a3.322 3.322 0 0 0-1.085.992 4.92 4.92 0 0 0-.62 1.458A7.712 7.712 0 0 0 9 7.558V11a1 1 0 0 0 1 1h2Zm-6 0a1 1 0 0 0 1-1V8.558a1 1 0 0 0-1-1H4.612c0-.351.021-.703.062-1.054.062-.372.166-.703.31-.992.145-.29.331-.517.559-.683.227-.186.516-.279.868-.279V3c-.579 0-1.085.124-1.52.372a3.322 3.322 0 0 0-1.085.992 4.92 4.92 0 0 0-.62 1.458A7.712 7.712 0 0 0 3 7.558V11a1 1 0 0 0 1 1h2Z"/></svg>
                    <strong>How to cite us:</strong><br>
                    <span style="display: block; margin-top: 8px; font-style: italic;">
                        If you use these datasets in your research, please cite: <br>
                        DOI: 10.xxxx/xxxxx.
                    </span>
                </div>
            </div>

        </div>
    </div>
</div>

</body>
    <script>
        $(document).ready(function() {
            // 点击下载链接时阻止默认行为，直接下载文件
            $(".btn-primary").click(function(event) {
                // 阻止默认行为
                event.preventDefault();

                // 获取下载链接
                var url = $(this).attr("href");

                // 下载文件
                downloadFile(url);
            });

            // 下载文件函数
            function downloadFile(url) {
                var link = document.createElement('a');
                link.href = url;
                link.download = url.substring(url.lastIndexOf('/') + 1);
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
            }
        });
    </script>



<?php
include "./Template/footer.php";
?>

