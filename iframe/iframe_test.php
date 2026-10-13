<select id="Spe">
    <option value="Homo sapiens">Homo sapiens</option>
    <option value="Mus musculus">Mus musculus</option>
</select>

<select id="DIS"></select>


<script>
    $(document).ready(function () {
        $('#Spe').on('change', function () {
            var selectedSpecies = $(this).val();
            console.log('Selected species:', selectedSpecies);

            $.ajax({
                url: '../api/auto_select_disease.php',
                method: 'POST',
                dataType: 'json',
                data: { select_specie: selectedSpecies },
                success: function (res) {
                    console.log('AJAX response:', res);
                    var options = res.map(function(item) {
                        return '<option value="' + item + '">' + item + '</option>';
                    });
                    $('#DIS').html(options.join(''));
                },
                error: function () {
                    alert('Error getting diseases');
                }
            });
        });
    });
</script>