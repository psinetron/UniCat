
<h2>Создать новую форму</h2>
<form method="POST" action="">
    <table class="wp-list-table widefat fixed pages UniCaTforms-table" width="400">
        <thead>
        <tr><th class="manage-column column-cb"></th><th class="manage-column column-title">Название</th></tr>
        </thead>
        <tbody>
        <tr><td>Название формы: </td><td><input type="text" name="newForm"></td></tr>
        <tr><td> e-mail уведомлений:</td><td><input type="text" name="newMail"></td></tr>
        <tr><td>Количество дней публикации:</td><td><input type="text" onkeyup="onlyNumbers(this)" value="30" name="pubdays"></td></tr>
        </tbody>
        </table>

    <input type="hidden" name="act" value="Create"><br/>
    <input type="submit" value="Создать" class="button"> <a href="<?php print 'http://'.$_SERVER['SERVER_NAME'].(preg_replace('#\&(.*)#','',$_SERVER['REQUEST_URI'])); ?>">Отмена</a>
</form>




<style>
    .UniCaTforms-table{
        border-collapse: collapse;
        width: inherit !important;
        border-radius: 3px 3px 3px 3px !important;
        border-style: solid !important;
        border-width: 1px !important;
    }
</style>