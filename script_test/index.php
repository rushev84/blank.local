<?php
require_once 'php/run.php';
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <title>Автозаполнение инфоблоков</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://snipp.ru/cdn/select2/4.0.13/dist/css/select2.min.css">
</head>

<body>

<div class="main">
    <select class="js-select2" id="js-select2" name="city" style="width: 300px" onchange="showSettingsForm()">
        <option value=""></option>
        <?php foreach ($iblocks as $iblock) {
            echo "<option value='{$iblock['id']}'>{$iblock['name']}</option>";
        }
        ?>
    </select>

    <div class="settings-form">



    </div>

</div>

<!--<script src="https://snipp.ru/cdn/jquery/2.1.1/jquery.min.js"></script>-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

<script src="https://snipp.ru/cdn/select2/4.0.13/dist/js/select2.min.js"></script>
<script src="https://snipp.ru/cdn/select2/4.0.13/dist/js/i18n/ru.js"></script>
<script src="js/ui.js"></script>

<script>

    function showSettingsForm() {
        $
            .ajax({
                method: "POST",
                url: "php/show_info.php",
                data: {
                    id: $('#js-select2').val()
                }
            })
            .done(function (response) {
                $("div.settings-form").html(response);
            })
    }

</script>


</body>
</html>