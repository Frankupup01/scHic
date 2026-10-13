<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title></title>
    <link rel="stylesheet" href="../bootstrap5/bootstrap-3.4.1-dist/css/argon-design-system.css">
    <link rel="stylesheet" href="../bootstrap5/bootstrap-3.4.1-dist/css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="../bootstrap5/bootstrap-3.4.1-dist/css/bootstrap-select.min.css">
    <link rel="stylesheet" href="../bootstrap5/bootstrap-3.4.1-dist/css/style.css">
    <link rel="stylesheet" href="../bootstrap5/bootstrap-3.4.1-dist/css/fill-left.css">
    <link rel="stylesheet" href="../bootstrap5/bootstrap-3.4.1-dist/menu/dist/quantumalert.css">
    <script src="../bootstrap5/bootstrap-3.4.1-dist/js/jquery.min.js"></script>
 <!--   <script src="https://code.jquery.com/jquery-1.9.1.min.js"></script> -->
    <script src="../bootstrap5/bootstrap-3.4.1-dist/js/bootstrap.js"></script>
    <script src="../bootstrap5/bootstrap-3.4.1-dist/js/bootstrap-select.min.js"></script>
    <script src="../bootstrap5/bootstrap-3.4.1-dist/js/bootstrap3-typeahead.min.js"></script>
    <script src="../bootstrap5/bootstrap-3.4.1-dist/js/popper.min.js"></script>
    <script src="../bootstrap5/bootstrap-3.4.1-dist/menu/dist/quantumalert.js"></script>
</head>
<style>
    .dashed {
        border-style: dashed;
    }

    .container {
        max-width: 80%;
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
        background: url("/LncSEAv2/public/img/header/background.png");
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

    @font-face {
        font-family: 'Comic Sans MS';
        src: url('/LncSEAv2/public/font/Comic Sans MS.ttf');
    }

    h2>a,
    b>a,
    .dashed,
    .navbar-brand,
    .navbar-nav .nav-link,
    .alert,
    .text-green {
        font-family: 'Comic Sans MS';
    }

    .btn {
        text-transform: none;
    }
    .navbar-brand {
        font-weight: 800;
        font-size: 1.875rem;
        letter-spacing: 4.05px;
    }

    .navmenu:hover .submenu{
        text-align: left;
        display: inline-block;
    }
    .dropdown-margin-1>.dropdown-menu {
        margin-left: -5.5%;
    }
    .dropdown-margin-2>.dropdown-menu {
        margin-left: -11.5%;
    }
    /* 限制 selectpicker 宽度，避免因内容过长导致页面变宽 */
    .bootstrap-select .dropdown-toggle {
        max-width: 100%;
        width: 100%;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .bootstrap-select .dropdown-menu.inner {
        max-width: 500px;
        word-wrap: break-word;
        white-space: normal;
    }

</style>
<body style="overflow-x: hidden;overflow-y: hidden;margin-left: 5%;margin-right: 5%;">
<form >
    <div class="center-block">
        <!-- 物种筛选 -->
        <div>
            <label for="specie_lncs" class="font-weight-bold" style="font-size: 14px;"><span style="color: red;">Step1</span>:Please to choose a species</label>
            <select class="selectpicker form-control dropdown-margin-1" id="Species"
                    title="Select a species(e.g.'Homo sapiens')" data-container="body"
                    data-live-search="true" data-hide-disabled="true" data-actions-box="true"
                    data-virtual-scroll="false">
                <!-- 修改一下物种的大小写  Sapiens-->
                <option value="Homo sapiens">Homo sapiens</option>
                <option value="Mus musculus">Mus musculus</option>
            </select>
        </div>
        <!-- 组织筛选 -->
        <div class="center-block">
            <label style="font-size: 14px;"><span style="color: red;">Step2</span>: Please choose two biosamples</label>
            <br>
            <div class="row">
                <div class="col-6" id="t1">
                    <select class="selectpicker form-control dropdown-margin-2" id="tissue1"
                            title="Select a Tissue or Cell line (e.g. 'OVCA429')" data-container="body"
                            data-live-search="true" data-hide-disabled="true" data-actions-box="true"
                            data-virtual-scroll="false">
                        <option value="OVCA429">OVCA429</option>
                    </select>
                </div>
                <div class="col-6" id="t2">
                    <select class="selectpicker form-control dropdown-margin-2" id="tissue2"
                            title="Select a Tissue or Cell line (e.g. 'GM12878')" data-container="body"
                            data-live-search="true" data-hide-disabled="true" data-actions-box="true"
                            data-virtual-scroll="false">
                        <option value="GM12878">GM12878</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="mt-2" >
            <a class="btn btn-default" type="submit"  onclick="speciests()"><b>Search</b></a>
            <button class="btn btn-default"  id="reset" ><b>Reset</b></button>
            <a class="btn btn-default" onclick="select_example()"><b>example</b></a>
        </div>
    </div>
</form>
<div style="color:darkgray;">
    <p class="h5" style="color:red"><strong><i class="ni ni-tag text-warning"></i>Function introduction：</strong></p>
    <p class="h5" style="color:black"><strong><i class="ni ni-tag text-warning"></i>Based on the this query, user can query the similar and different enhancer between two biosamples.</strong></p>
    <p class="h5" style="color:red"><strong><i class="ni ni-tag text-warning"></i>Note:</strong></p>
    <p class="h5" style="color:black"><strong><i class="ni ni-tag text-warning"></i>1.Species must be selected.</strong></p>
    <p class="h5" style="color:black"><strong><i class="ni ni-tag text-warning"></i>2.Select two biosamples that you interst.</strong></p>
    <p class="h5" style="color:black"><strong><i class="ni ni-tag text-warning"></i>3.Oryza sativa Japonica Group and Drosophila melanogaster were not included in this query because the sample size for Oryza sativa Japonica Group and Drosophila melanogaster was too small.</strong></p>

</div>
<script>
    $(function(){
        var url =window.location.href;
        $("#reset").click(function(){
            window.location.href=url;
        });
    });

    var selectedValue = '';
    function handleRadioButton(radio) {
        // 获取选中的单选按钮的值
        selectedValue = radio.value;
        // 打印选中的值到控制台
        console.log("Selected Value: " + selectedValue);
    }


    var Species = '';
    var tissue1 = '';
    var tissue2 = '';
    function speciests() {
        Species = $('#Species').val();
        tissue1 = $('#tissue1').val();
        console.log(tissue1);
        tissue2 = $('#tissue2').val();
        console.log(tissue2);

        parent.location.href = '../analysis_tissue.php?Species=' + Species + '&tissue1=' + tissue1  +  '&tissue2=' + tissue2 + "";
    }


</script>
<script>
    // 去除数组的重复
    function removeDuplicates(array) {
        return Array.from(new Set(array)).sort();
    }

    function autoselect_tissue1(Species) {
        if (Species == "") return;

        $.getJSON("../api/tissues.php", {species: Species}, function (options) {
            var t2_val = $('#tissue2').val() || "";
            var current_t1 = $('#tissue1').val() || ""; // 记录当前选中的 tissue1

            var html = '';
            options.forEach(function(opt){
                if(opt[0] !== t2_val){
                    html += '<option value="'+opt[0]+'">'+opt[0]+'</option>';
                }
            });

            $('#tissue1')[0].innerHTML = html;
            $('#tissue1').selectpicker('refresh');

            // 恢复之前选中的值（如果还在 options 里）
            if(current_t1 && $('#tissue1 option[value="'+current_t1+'"]').length > 0){
                $('#tissue1').val(current_t1);
                $('#tissue1').selectpicker('refresh');
            }
        });
    }

    function autoselect_tissue2(Species) {
        if (Species == "") return;

        $.getJSON("../api/tissues.php", {species: Species}, function (options) {
            var t1_val = $('#tissue1').val() || "";
            var current_t2 = $('#tissue2').val() || ""; // 记录当前选中的 tissue2

            var html = '';
            options.forEach(function(opt){
                if(opt[0] !== t1_val){
                    html += '<option value="'+opt[0]+'">'+opt[0]+'</option>';
                }
            });

            $('#tissue2')[0].innerHTML = html;
            $('#tissue2').selectpicker('refresh');

            // 恢复之前选中的值（如果还在 options 里）
            if(current_t2 && $('#tissue2 option[value="'+current_t2+'"]').length > 0){
                $('#tissue2').val(current_t2);
                $('#tissue2').selectpicker('refresh');
            }
        });
    }

    // 监听选择事件
    $('#tissue1').on('changed.bs.select', function(){
        autoselect_tissue2($('#Species').val());
    });

    $('#tissue2').on('changed.bs.select', function(){
        autoselect_tissue1($('#Species').val());
    });

    // 当Species改变时刷新两个下拉框
    $('#Species').on('changed.bs.select', function(){
        var species = $(this).val();
        autoselect_tissue1(species);
        autoselect_tissue2(species);
    });

</script>
<script>
    $.ajaxSetup({
        cache: false //close AJAX cache
    });
    $(function () {
        $('#t1').on('click', function () {
            autoselect_tissue1($('#Species').val());
        });

    })
    $(function () {
        $('#t2').on('click', function () {
            autoselect_tissue2($('#Species').val());
        });

    })

    function select_example() {
        // 设置选择 Homo sapiens
        document.getElementById("Species").value = "Homo sapiens";
        $('#Species').selectpicker('refresh');

        setTimeout(function() {
            document.getElementById("tissue1").value = "OVCA429";
            // 更新 Bootstrap Selectpicker，确保选择框显示正确
            $('#tissue1').selectpicker('refresh');
        }, 0);
        setTimeout(function() {
            document.getElementById("tissue2").value = "GM12878";
            // 更新 Bootstrap Selectpicker，确保选择框显示正确
            $('#tissue2').selectpicker('refresh');
        }, 2);

    }

</script>
</body>
</html>


