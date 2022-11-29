<?php
require_once 'MyGenerator.php';
$generator = new MyGenerator();

$id = $_POST['id'];

$properties = $generator->getProperties($id);
//echo '<pre>'; print_r( $properties ); echo'</pre>';
?>

<p><b>Поля инфоблока</b></p>
<table class="add_table">
    <tr>
        <td class="add_td"><label for="ACTIVE">Активность</label></td>
        <td><input
                    type="checkbox"
                    id="ACTIVE"
                    value="newsletter"/></td>
    </tr>
    <tr>
        <td>
            <hr>
            <i>Сгенерировать случайные значения:</i>
        </td>
    </tr>
    <tr>
        <td class="add_td"><label for="NAME">Имя</label></td>
        <td><input
                    type="checkbox"
                    id="NAME"
                    value="newsletter"/></td>
    </tr>
    <tr>
        <td class="add_td"><label for="PREVIEW_TEXT">Предварительное описание</label></td>
        <td><input
                    type="checkbox"
                    id="PREVIEW_TEXT"
                    value="newsletter"/></td>
    </tr>
    <tr>
        <td class="add_td"><label for="DETAIL_TEXT">Детальное описание</label></td>
        <td><input
                    type="checkbox"
                    id="DETAIL_TEXT"
                    value="newsletter"/></td>
    </tr>

</table>


<p><b>Свойства инфоблока</b></p>
<table class="add_table">
    <tr>
        <td>
            <i>Сгенерировать случайные значения:</i>
        </td>
    </tr>
    <?php $i = 1; ?>
    <?php foreach ($properties as $key => $value): ?>
        <tr>
            <td class="add_td"><label for="<?= $key ?>"><?= $value['NAME'] ?></label></td>
            <td><input
                        type="checkbox"
                        id="<?= $key ?>"
                        value="newsletter"/></td>
        </tr>
        <?php $i++ ?>
    <?php endforeach; ?>
</table>
<br>
<button class="btn">Создать инфоблоки</button>
