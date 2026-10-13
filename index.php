<?php include "./Template/base.php"; ?>
<body>
<?php include './Template/header.php'; ?>

<style>
    body {
        background-color: #f8f9fa;
    }

    /* 上方与中间卡片样式（Introduction + Overview+Cloud） */
    .section-card {
        background: #fff;
        border-radius: 15px;
        box-shadow: 0 3px 10px rgba(0,0,0,0.08);
        padding: 30px;
        margin-bottom: 30px;
    }

    .typing-animation {
        font-weight: bold;
        color: #0362a4;
    }

    /* Keyword cloud 容器（右侧） */
    .keyword-cloud {
        width: 100%;
        height: 420px;
    }

    /* 图表容器 */
    #chart, #barChart {
        width: 100%;
        height: 420px;
    }

    /* Workflow 不方块化，使用简单间隔 */
    .workflow-section {
        margin: 40px 0;
    }

    footer, .footer {
        margin-top: auto;
    }

    @media (max-width: 991px) {
        .keyword-cloud, #chart {
            height: 320px;
        }
    }
</style>


<div class="container my-5 section-card">
    <div class="row">
        <div class="col-md-12 d-flex align-items-center">
            <div>
                <span class="typing-animation" style="font-size: 35px;">Welcome to scHi-Cdb!</span>
                <p class="mt-3 text-secondary" style="font-size: 16px; line-height: 1.7; max-width: 2000px;">
                    Single-cell Hi-C (scHi-C) is a high-throughput sequencing technology for studying the three-dimensional chromatin structure in single cells.
                    It reveals cell-to-cell heterogeneity and spatial chromatin dynamics, providing crucial insights into genome regulation and 3D organization.
                </p>
            </div>
        </div>
    </div>
</div>


<div class="container my-4 section-card">
    <div class="row g-4">
        <!-- 左侧：Overview（Group by + chart） -->
        <div class="col-md-7">
            <div>
                <h4 style="font-weight: bold; margin-bottom: 12px; text-align: center;">Overview of scHi-cdb</h4>

                <div class="d-flex align-items-center mb-2">
                    <label for="groupBy" class="me-2 fw-semibold" style="margin-right:8px;">Group by:</label>
                    <select id="groupBy" class="form-select" style="width: 220px;">
                        <option value="TissueCellLine">Tissue/Cell line</option>
                        <option value="ExperimentType">Experiment type</option>
                        <option value="DiseaseType">Disease type</option>
                        <option value="Enzyme">Enzyme</option>
                        <option value="LibraryStrategy">Library strategy</option>
                    </select>
                </div>

                <div class="text-end mt-1 small text-muted mb-2">
                    * Only up to the top 15 terms are shown.
                </div>

                <div id="chart" aria-label="Overview bar chart"></div>
            </div>
        </div>

        <!-- 右侧：Keyword Cloud -->
        <div class="col-md-5" style="text-align:center;">
            <h4 style="font-weight: bold; margin-bottom: 12px;">Keyword cloud</h4>
            <canvas width="500" height="400" id="myCanvas"></canvas>
            <div style="text-align:right; font-size:12px; color:gray; margin-top:40px;">
                Statistical data of scHi-Cdb as of 2025.10.15
            </div>
        </div>

        <!-- 隐藏的 tags 数据（可改为后端动态生成） -->
        <div id="tags" style="display:none;">
            <ul>
                <li><a href="#">Homo sapiens</a></li>
                <li><a href="#">Health</a></li>
                <li><a href="#">Hi-C</a></li>
                <li><a href="#">Mus musculus</a></li>
                <li><a href="#">Spleen</a></li>
                <li><a href="#">Ovarian Cancer</a></li>
                <li><a href="#">Oryza sativa Japonica Group	</a></li>
                <li><a href="#">Ovary</a></li>
                <li><a href="#">Leukaemia</a></li>
                <li><a href="#">Drosophila melanogaster</a></li>
                <li><a href="#">mESC</a></li>
                <li><a href="#">SRP026294</a></li>
                <li><a href="#">scHi-C</a></li>
            </ul>
        </div>
    </div>
</div>


<!-- Section 3: Workflow -->
<div class="container my-5 section-card">
    <h2 class="text-center mb-4" style="font-weight: bold;">scHi-Cdb Construction Workflow</h2>
<hr>
    <div class="text-center mb-4">
        <img src="./public/image/helppic/workflow.jpg"
             class="img-fluid"
             alt="Construction Process"
             style="max-width: 900px;">
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="p-3 rounded shadow-sm" style="background:#f9fafc;">
                <h5 class="fw-bold text-primary">News</h5>
                <ul class="mb-0">
                    <li>2025-10-01: Database launched successfully!</li>
                    <li>2025-06-03: First update with new datasets.</li>
                    <li>2025-03-04: Integration with new analysis tools.</li>
                </ul>
            </div>
        </div>

        <div class="col-md-6">
            <div class="p-3 rounded shadow-sm" style="background:#f9fafc;">
                <h5 class="fw-bold text-primary">Publication</h5>
                <p class="text-muted mb-0">xxxx.xx.xx</p>
            </div>
        </div>
    </div>
</div>


<script>
    // === Overview bar chart ===
    function fetchDataAndDrawChart(groupBy) {
        $.post('./api/database_data.php', { groupBy: groupBy }, function (res) {
            const data = JSON.parse(res || '[]');
            const categories = data.map(item => item.label).slice(0, 15);
            const values = data.map(item => item.count).slice(0, 15);

            const chartDom = document.getElementById('chart');
            const chart = echarts.init(chartDom);

            chart.setOption({
                tooltip: { trigger: 'axis' },
                grid: { left: '5%', right: '5%', bottom: '18%', containLabel: true },
                xAxis: {
                    type: 'category',
                    data: categories,
                    axisLabel: {
                        rotate: 30,
                        interval: 0,
                        formatter: function (value) {
                            return value.length > 18 ? value.slice(0, 18) + '…' : value;
                        }
                    }
                },
                yAxis: { type: 'value' },
                series: [{
                    type: 'bar',
                    data: values,
                    label: { show: true, position: 'top' },
                    itemStyle: {
                        color: function (params) {
                            const colors = ['#8cb0e6', '#f4a582', '#92c5de', '#d6604d', '#4393c3', '#e08214', '#5aae61', '#b2182b', '#01665e', '#542788'];
                            return colors[params.dataIndex % colors.length];
                        }
                    }
                }]
            });

            /* ================= 核心新增：点击跳转 ================= */
            chart.off('click'); // 防止重复绑定
            chart.on('click', function (params) {
                const clickedValue = params.name;   // x 轴分类名
                const groupType = groupBy;           // 当前 Group by

                // URL 编码，防止空格/特殊字符
                const url = `Overview_search.php?groupBy=${encodeURIComponent(groupType)}&value=${encodeURIComponent(clickedValue)}`;

                window.location.href = url;
            });
            /* ====================================================== */

            window.addEventListener('resize', () => chart.resize());
        });
    }

    // Bar chart 初始化
    $('#groupBy').change(function () {
        fetchDataAndDrawChart($(this).val());
    });
    fetchDataAndDrawChart($('#groupBy').val());

    window.onload = function () {
        const colors = ["#2c7bb6","#fdae61","#1a9850","#d7191c","#abd9e9"];
        document.querySelectorAll('#tags a').forEach((a, i) => {
            // 设置颜色
            a.style.color = colors[i % colors.length];
            // 绑定点击事件
            a.addEventListener('click', function (e) {
                e.preventDefault();
                const keyword = encodeURIComponent(this.textContent.trim());
                window.location.href = "Cloud_search.php?keyword=" + keyword;
            });
        });

        try {
            TagCanvas.Start('myCanvas', 'tags', {
                textColour: null,   // 由行内样式控制颜色
                textHeight: 22,     // 字体大小统一
                outlineColour: 'transparent',
                reverse: true,
                depth: 0.8,
                maxSpeed: 0.01,
                initial: [0.2, -0.2],
                decel: 0.95,
                shuffleTags: true,
                wheelZoom: false   // 禁止鼠标滚轮缩放
            });
        } catch (e) {
            console.log("Canvas error:", e);
        }
    };
</script>

<?php include './Template/footer.php'; ?>
</body>
</html>