<!--include base-->
<?php
include "./Template/base.php";
?>
<!--include header-->
<?php include './Template/header.php';
?>




<style>

    html, body {
        height: 100%;
        margin: 0;
        display: flex;
        flex-direction: column;
    }

    #mainContain {
        max-width: 1470px;
        width: 95%;
        margin: 0 auto;
    }

    footer, .footer {
        margin-top: auto;
    }


    .quick-search {
        width: 100%;
        padding: 20px 80px;
        text-align: center;
    }
    .quick-search input {
        width: 60%;
        padding: 10px 15px;
        font-size: 16px;
        border: 1px solid #ccc;
        border-radius: 6px;
    }


    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 15px;
        padding: 0 80px 30px;
    }
    .stats-card {
        background: #f8f9fa;
        border-radius: 10px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        padding: 20px;
        text-align: center;
        font-size: 20px;
        font-weight: bold;
        color: #0362a4;
    }


    .search-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        padding: 20px 80px;
    }

    .search-thumb {
        display: flex;
        align-items: center;
        justify-content: flex-start;
        border-radius: 10px;
        overflow: hidden;
        cursor: pointer;
        transition: all 0.3s;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        background: #f0f0f0;
    }
    .search-thumb img {
        width: 50%;
        height: 200px;
        object-fit: cover;
        transition: filter 0.3s;
    }
    .search-thumb h2 {
        flex: 1;
        margin: 0;
        padding: 0 15px;
        font-size: 25px;
        color: #0362a4;
        font-weight: bold;
    }
    .search-thumb:hover img {
        filter: brightness(0.7);
    }
    .search-card {
        display: none;
    }

    /* 弹窗遮罩层 */
    .modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.5);
        display: none;
        justify-content: center;
        align-items: center;
        z-index: 1000;
    }

    .modal-content {
        position: relative;
        background: white;
        width: 80%;
        height: 80%;
        border-radius: 8px;
        overflow: hidden;
    }


    .modal-close {
        position: absolute;
        top: calc(10% - 20px);
        right: calc(10% - 23px);
        font-size: 28px;
        font-weight: bold;
        color: white;
        cursor: pointer;
        z-index: 1001;
    }
    .modal-close:hover {
        color: #ff4d4f;
    }


     .quick-search {
         width: 100%;
         padding: 20px 80px;
         text-align: center;
         position: relative;
     }
    .quick-search .search-wrapper {
        position: relative;
        display: inline-block;
        width: 60%;
    }
    .quick-search input {
        width: 100%;
        padding: 10px 50px 10px 15px;
        font-size: 16px;
        border: 1px solid #ccc;
        border-radius: 6px;
    }
    .quick-search button {
        position: absolute;
        right: 5px;
        top: 50%;
        transform: translateY(-50%);
        padding: 6px 15px;
        font-size: 14px;
        background: #fff;   /* 白色背景 */
        color: #000;        /* 黑色字体 */
        border: 1px solid #ccc;
        border-radius: 6px;
        cursor: pointer;
        display: none; /* 默认隐藏 */
    }
    .quick-search button:hover {
        background: #f5f5f5;
    }
    .quick-suggestions {
        margin-top: 10px;
        font-size: 14px;
        color: #555;
    }
    .quick-suggestions span {
        color: #0362a4;
        cursor: pointer;
        margin-right: 10px;
    }

    /* 统计区域 */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 0; /* 去掉间距 */
        padding: 0 80px 30px;
        text-align: center;
        font-size: 18px;
        color: #0362a4;
    }
    .stats-card {
        padding: 10px;
        font-weight: normal; /* 取消加粗 */
        border-right: 1px solid #ddd; /* 分隔竖线 */
    }
    .stats-card:last-child {
        border-right: none; /* 最后一个不加竖线 */
    }
    .stats-card svg {
        width: 28px;
        height: 28px;
        margin-bottom: 5px;
    }
    .detail-search-title {
        padding: 10px 80px;
        font-size: 22px;
        font-weight: bold;
        color: #0362a4;
    }
    .detail-divider {
        border: none;
        border-top: 2px solid #ccc;
        margin: 15px 80px; /* 左右和上下的间距 */
    }
    .cutoff-note {
        text-align: right;
        font-size: 12px;
        color: gray;
        margin-bottom: -5px;
        margin-right: 80px;
    }

</style>

<div class="container " id="mainContain">
    <!-- Quick Search -->
    <div class="quick-search">
        <div class="search-wrapper">
            <input type="text" id="quickSearchInput" placeholder="Quick search...">
            <button id="quickSearchBtn">Search</button>
        </div>
        <div class="quick-suggestions">
            e.g.
            <span data-value="Homo sapiens">Homo sapiens</span>
            <span data-value="Ovarian Cancer">Ovarian Cancer</span>
            <span data-value="Embryo">Embryo</span>
            <span data-value="scHi-C">scHi-C</span>
            <span data-value="GSE48262">GSE48262</span>
        </div>
    </div>

    <!-- 统计区域 -->
    <div class="stats-grid">
        <div class="stats-card">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-piggy-bank" viewBox="0 0 16 16">
                <path d="M5 6.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0m1.138-1.496A6.6 6.6 0 0 1 7.964 4.5c.666 0 1.303.097 1.893.273a.5.5 0 0 0 .286-.958A7.6 7.6 0 0 0 7.964 3.5c-.734 0-1.441.103-2.102.292a.5.5 0 1 0 .276.962"/>
                <path fill-rule="evenodd" d="M7.964 1.527c-2.977 0-5.571 1.704-6.32 4.125h-.55A1 1 0 0 0 .11 6.824l.254 1.46a1.5 1.5 0 0 0 1.478 1.243h.263c.3.513.688.978 1.145 1.382l-.729 2.477a.5.5 0 0 0 .48.641h2a.5.5 0 0 0 .471-.332l.482-1.351c.635.173 1.31.267 2.011.267.707 0 1.388-.095 2.028-.272l.543 1.372a.5.5 0 0 0 .465.316h2a.5.5 0 0 0 .478-.645l-.761-2.506C13.81 9.895 14.5 8.559 14.5 7.069q0-.218-.02-.431c.261-.11.508-.266.705-.444.315.306.815.306.815-.417 0 .223-.5.223-.461-.026a1 1 0 0 0 .09-.255.7.7 0 0 0-.202-.645.58.58 0 0 0-.707-.098.74.74 0 0 0-.375.562c-.024.243.082.48.32.654a2 2 0 0 1-.259.153c-.534-2.664-3.284-4.595-6.442-4.595M2.516 6.26c.455-2.066 2.667-3.733 5.448-3.733 3.146 0 5.536 2.114 5.536 4.542 0 1.254-.624 2.41-1.67 3.248a.5.5 0 0 0-.165.535l.66 2.175h-.985l-.59-1.487a.5.5 0 0 0-.629-.288c-.661.23-1.39.359-2.157.359a6.6 6.6 0 0 1-2.157-.359.5.5 0 0 0-.635.304l-.525 1.471h-.979l.633-2.15a.5.5 0 0 0-.17-.534 4.65 4.65 0 0 1-1.284-1.541.5.5 0 0 0-.446-.275h-.56a.5.5 0 0 1-.492-.414l-.254-1.46h.933a.5.5 0 0 0 .488-.393m12.621-.857a.6.6 0 0 1-.098.21l-.044-.025c-.146-.09-.157-.175-.152-.223a.24.24 0 0 1 .117-.173c.049-.027.08-.021.113.012a.2.2 0 0 1 .064.199"/>
            </svg>
            Species: 4</div>
        <div class="stats-card">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-database-check" viewBox="0 0 16 16">
                <path d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7m1.679-4.493-1.335 2.226a.75.75 0 0 1-1.174.144l-.774-.773a.5.5 0 0 1 .708-.708l.547.548 1.17-1.951a.5.5 0 1 1 .858.514"/>
                <path d="M12.096 6.223A5 5 0 0 0 13 5.698V7c0 .289-.213.654-.753 1.007a4.5 4.5 0 0 1 1.753.25V4c0-1.007-.875-1.755-1.904-2.223C11.022 1.289 9.573 1 8 1s-3.022.289-4.096.777C2.875 2.245 2 2.993 2 4v9c0 1.007.875 1.755 1.904 2.223C4.978 15.71 6.427 16 8 16c.536 0 1.058-.034 1.555-.097a4.5 4.5 0 0 1-.813-.927Q8.378 15 8 15c-1.464 0-2.766-.27-3.682-.687C3.356 13.875 3 13.373 3 13v-1.302c.271.202.58.378.904.525C4.978 12.71 6.427 13 8 13h.027a4.6 4.6 0 0 1 0-1H8c-1.464 0-2.766-.27-3.682-.687C3.356 10.875 3 10.373 3 10V8.698c.271.202.58.378.904.525C4.978 9.71 6.427 10 8 10q.393 0 .774-.024a4.5 4.5 0 0 1 1.102-1.132C9.298 8.944 8.666 9 8 9c-1.464 0-2.766-.27-3.682-.687C3.356 7.875 3 7.373 3 7V5.698c.271.202.58.378.904.525C4.978 6.711 6.427 7 8 7s3.022-.289 4.096-.777M3 4c0-.374.356-.875 1.318-1.313C5.234 2.271 6.536 2 8 2s2.766.27 3.682.687C12.644 3.125 13 3.627 13 4c0 .374-.356.875-1.318 1.313C10.766 5.729 9.464 6 8 6s-2.766-.27-3.682-.687C3.356 4.875 3 4.373 3 4"/>
            </svg>
            Dataset: 35</div>
        <div class="stats-card">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-list-columns" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M0 .5A.5.5 0 0 1 .5 0h9a.5.5 0 0 1 0 1h-9A.5.5 0 0 1 0 .5m13 0a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5m-13 2A.5.5 0 0 1 .5 2h8a.5.5 0 0 1 0 1h-8a.5.5 0 0 1-.5-.5m13 0a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5m-13 2A.5.5 0 0 1 .5 4h10a.5.5 0 0 1 0 1H.5a.5.5 0 0 1-.5-.5m13 0a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5m-13 2A.5.5 0 0 1 .5 6h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5m13 0a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5m-13 2A.5.5 0 0 1 .5 8h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5m13 0a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5m-13 2a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5m13 0a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5m-13 2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5m13 0a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5m-13 2a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H.5a.5.5 0 0 1-.5-.5m13 0a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5"/>
            </svg>
            Tissues/Cell line: 38</div>
        <div class="stats-card">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-measuring-cup" viewBox="0 0 16 16">
                <path d="M.038.309A.5.5 0 0 1 .5 0H14a2 2 0 0 1 2 2v5.959a1.041 1.041 0 0 1-2.069.17l-.849-5.094A.041.041 0 0 0 13 3.04V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V3.743a2.5 2.5 0 0 0-.732-1.768L.146.854A.5.5 0 0 1 .038.309M1.708 1l.267.268A3.5 3.5 0 0 1 3 3.743V14a1 1 0 0 0 1 1h7a1 1 0 0 0 1-1V3.041a1.041 1.041 0 0 1 2.069-.17l.849 5.094A.041.041 0 0 0 15 7.96V2a1 1 0 0 0-1-1zM4 3h3.5a.5.5 0 1 1 0 1H4zm0 2h1.5a.5.5 0 1 1 0 1H4zm0 2h3.5a.5.5 0 1 1 0 1H4zm0 2h1.5a.5.5 0 1 1 0 1H4zm0 2h3.5a.5.5 0 0 1 0 1H4zm0 2h1.5a.5.5 0 0 1 0 1H4z"/>
            </svg>
            Experiment: 10</div>
    </div>
    <div class="cutoff-note">
        * The data was collected at 2025.09.28
    </div>
    <hr class="detail-divider">
    <div class="detail-search-title">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
            <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
        </svg>
        Detail Search
    </div>
    <hr class="detail-divider">
    <!-- 主搜索区域 -->
    <div class="search-grid">
        <!-- Disease -->
        <!-- 待修改为Disease 2025.10.05  //done-->
        <div>
            <div class="search-thumb" data-target="tissue">
                <img src="./public/image/search/tissue.png" alt="Tissue">
                <h2>Tissue / Cell Type</h2>
            </div>
            <div class="search-card" id="tissue">
                <iframe src="iframe/iframe_c.php"></iframe>
            </div>
        </div>


        <!-- Study -->
        <div>
            <div class="search-thumb" data-target="study">
                <img src="./public/image/search/study.png" alt="Study">
                <h2>Study</h2>
            </div>
            <div class="search-card" id="study">
                <iframe src="./iframe/iframe_study.php"></iframe>
            </div>
        </div>

        <!-- Tissue / Cell Type -->
        <div>
            <div class="search-thumb" data-target="disease">
                <img src="./public/image/search/disease.png" alt="Disease">
                <h2>Disease</h2>
            </div>
            <div class="search-card" id="disease">
                <iframe src="./iframe/iframe_disease.php"></iframe>
            </div>
        </div>

        <!-- Experiment -->
        <div>
            <div class="search-thumb" data-target="experiment">
                <img src="./public/image/search/experiment.png" alt="experiment">
                <h2>Experiment</h2>
            </div>
            <div class="search-card" id="experiment">
                <iframe src="./iframe/iframe_experiment.php"></iframe>
            </div>
        </div>
    </div>
</div>



<!-- 弹窗区域 -->
<div class="modal-overlay" id="searchModal">
    <span class="modal-close" id="modalClose">&times;</span>
    <div class="modal-content">
        <div class="modal-body" id="modalBody"></div>
    </div>
</div>

<script>
    document.querySelectorAll('.search-thumb').forEach(thumb => {
        thumb.addEventListener('click', () => {
            const targetId = thumb.dataset.target;
            const modal = document.getElementById('searchModal');
            const modalBody = document.getElementById('modalBody');

            modalBody.innerHTML = ''; // 清空

            if (targetId === 'tissue') {
                // 左右两个 iframe
                modalBody.innerHTML = `
                    <div style="display:flex; gap:10px; width:100%; height:100%;">
                        <iframe src="iframe/iframe_t.php" style="flex:1; height:100%; border:none;"></iframe>
                        <iframe src="iframe/iframe_c.php" style="flex:1; height:100%; border:none;"></iframe>
                    </div>
                `;
            } else {
                // 普通单 iframe
                const iframe = document.querySelector(`#${targetId} iframe`);
                modalBody.innerHTML = `<iframe src="${iframe.src}" style="width:100%; height:100%; border:none;"></iframe>`;
            }

            modal.style.display = 'flex';
        });
    });

    // 关闭 modal
    document.getElementById('modalClose').addEventListener('click', () => {
        document.getElementById('searchModal').style.display = 'none';
        document.getElementById('modalBody').innerHTML = '';
    });

    document.getElementById('searchModal').addEventListener('click', (e) => {
        if (e.target === e.currentTarget) {
            e.currentTarget.style.display = 'none';
            document.getElementById('modalBody').innerHTML = '';
        }
    });

    // 输入框和按钮
    const input = document.getElementById('quickSearchInput');
    const btn = document.getElementById('quickSearchBtn');

    // 公共搜索方法
    function doQuickSearch() {
        let keyword = input.value.trim();
        if (keyword) {
            window.location.href = "quick_search.php?keyword=" + encodeURIComponent(keyword);
        }
    }

    // 输入时显示/隐藏按钮
    input.addEventListener('input', () => {
        btn.style.display = input.value.trim() ? 'inline-block' : 'none';
    });

    // 点击示例词填充到输入框
    document.querySelectorAll('.quick-suggestions span').forEach(span => {
        span.addEventListener('click', () => {
            input.value = span.dataset.value;
            btn.style.display = 'inline-block';

            // 让输入框获得焦点，这样回车键能生效
            input.focus();
        });
    });

    // 点击Search按钮
    btn.addEventListener('click', () => {
        doQuickSearch();
    });

    // 按下回车触发搜索
    input.addEventListener('keydown', function (e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            doQuickSearch();
        }
    });
</script>


<!--include footer-->
<?php include './Template/footer.php';
?>