<!--include base-->
<?php
include "./Template/base.php";
?>
<!--include header-->
<?php include './Template/header.php';
?>
<style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        height: 100vh;
        display: flex;
        flex-direction: column;
    }

    #controls {
        padding: 10px;
        background: #f7f7f7;
        border-bottom: 1px solid #ddd;
    }

    #plot {
        flex: 1;
        min-height: 500px;
    }
</style>
</head>
<body>

<div id="controls">
    <label>Group:</label>
    <select id="groupSelect"></select>

    <label>Sample:</label>
    <select id="sampleSelect"></select>
</div>

<div id="plot"></div>

<script>
    const API_BASE = "http://localhost:5050/api";

    const groupSelect = document.getElementById("groupSelect");
    const sampleSelect = document.getElementById("sampleSelect");

    // =======================
    // 初始化：加载 group
    // =======================
    async function loadGroups() {
        const res = await fetch(`${API_BASE}/groups`);
        const groups = await res.json();

        groupSelect.innerHTML = "";
        groups.forEach(g => {
            const opt = document.createElement("option");
            opt.value = g;
            opt.textContent = g;
            groupSelect.appendChild(opt);
        });

        if (groups.length > 0) {
            loadSamples(groups[0]);
        }
    }

    // =======================
    // 加载 samples
    // =======================
    async function loadSamples(group) {
        const res = await fetch(`${API_BASE}/samples/${group}`);
        const samples = await res.json();

        sampleSelect.innerHTML = "";
        samples.forEach(s => {
            const opt = document.createElement("option");
            opt.value = s;
            opt.textContent = s.replace(".csv", "").replace(".gz", "");
            sampleSelect.appendChild(opt);
        });

        if (samples.length > 0) {
            load3D(group, samples[0]);
        }
    }

    // =======================
    // 加载并绘制 3D
    // =======================
    async function load3D(group, sample) {
        const res = await fetch(`${API_BASE}/data/${group}/${sample}`);
        const text = await res.text();

        const lines = text.trim().split("\n").slice(1);

        const xs = [], ys = [], zs = [], colors = [];

        for (const line of lines) {
            const [chrom, bin, x, y, z] = line.split(",");
            xs.push(+x);
            ys.push(+y);
            zs.push(+z);

            // 染色体转数值
            let c = chrom.replace("chr", "");
            if (c === "X") c = 23;
            if (c === "Y") c = 24;
            colors.push(+c);
        }

        const trace = {
            x: xs,
            y: ys,
            z: zs,
            mode: "markers",
            type: "scatter3d",
            marker: {
                size: 3,
                color: colors,
                colorscale: "Viridis",
                opacity: 0.85
            }
        };

        Plotly.react("plot", [trace], {
            autosize: true,
            scene: {
                xaxis: { title: "X" },
                yaxis: { title: "Y" },
                zaxis: { title: "Z" }
            },
            margin: { l: 0, r: 0, b: 0, t: 0 }
        });
    }

    // =======================
    // 事件绑定
    // =======================
    groupSelect.addEventListener("change", e => {
        loadSamples(e.target.value);
    });

    sampleSelect.addEventListener("change", e => {
        load3D(groupSelect.value, e.target.value);
    });

    // 启动
    loadGroups();
</script>









<!--include footer-->
<?php include './Template/footer.php';
?>
