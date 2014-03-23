<?php
$json='';
$saver='';
//Экспорт формы
if ((isset($_POST['formsexport']))&&($_POST['formsexport']==1)){
    $result=$wpdb->get_results("SELECT * FROM `" . $this->tbl_unicat . "unicat_forms` WHERE `id`='".$_POST['forma']."'", ARRAY_A);
    $json='{';
    for ($i=0;$i<count($result);$i++){
        $json.='"form":{';
        $json.='"inputform":"'. base64_encode($result[$i]['inputform']).'", ';
        $json.='"outputform":"'.base64_encode($result[$i]['outputform']). '", ';
        $json.='"findform":"'.base64_encode($result[$i]['findform']). '", ';
        $json.='"podrobnoform":"'.base64_encode($result[$i]['podrobnoform']). '", ';
        $json.='"id":"'.base64_encode($result[$i]['id']). '", ';
        $json.='"mail":"'.base64_encode($result[$i]['mail']).'", ';
        $json.='"formname":"'.base64_encode($result[$i]['formname']).'", ';
        $json.='"fromform":"'.base64_encode($result[$i]['fromform']).'", ';
        $json.='"pubdays":"'.base64_encode($result[$i]['pubdays']).'", ';
        $json.='"allok":"'.base64_encode($result[$i]['allok']).'"} ';
        if ($i<count($result)-1) {$json.=',' . PHP_EOL;}
    }
    $json.=', "fields":{';
    $result=$wpdb->get_results("SELECT * FROM `" . $this->tbl_unicat . "unicat_fld` WHERE `forma`='".$_POST['forma']."'", ARRAY_A);
    for ($i=0;$i<count($result);$i++){
        $json.='"field'.$i.'":{';
        $json.='"forma":"'.base64_encode($result[$i]['forma']).'", ';
        $json.='"name":"'.base64_encode($result[$i]['name']).'", ';
        $json.='"params":"'.base64_encode($result[$i]['params']).'", ';
        $json.='"hint":"'.base64_encode($result[$i]['hint']).'", ';
        $json.='"poltype":"'.base64_encode($result[$i]['poltype']).'"} ';
        if ($i<count($result)-1) {$json.=',' . PHP_EOL;}
    }


    $json.='}';
    $json.='}';
    $filelistdump='dump_form_'. date('d-m-Y_H-i'). '.dat';
    $fp=fopen ($this->maindir . '/backups/' . $filelistdump, "w");
    fputs($fp,$json);
    fclose($fp);
    print 'Ссылка на скачивание дампа: <a target="_blank" id="SaveListLink" href="'.$this->plugin_url.'backups/'.$filelistdump.'">'.$filelistdump.'</a><script type="text/javascript">document.getElementById("SaveListLink").click()</script><br/><br/><br/>';
}

//Импорт формы
if ((isset($_POST['formsimport']))&&($_POST['formsimport']==1)){
    if ($_FILES['importfile']['error'] > 0)
    {
        echo 'Проблема: ';
        switch ($_FILES['importfile']['error'])
        {
            case 1: echo 'размер файла больше upload_max_filesize' ; break;
            case 2: echo 'размер файла больше max_file_size'; break;
            case 3: echo 'загружена только часть файла'; break;
            case 4: echo 'файл не загружен'; break;
        }

    } else {
    $filestr=json_decode(file_get_contents($_FILES['importfile']['tmp_name']));
        $wpdb->insert(($this->tbl_unicat.'unicat_forms'), array("inputform"=>base64_decode($filestr->form->inputform),
            "outputform"=>base64_decode($filestr->form->outputform),
            "findform"=>base64_decode($filestr->form->findform),
            "podrobnoform"=>base64_decode($filestr->form->podrobnoform),
            "mail"=>base64_decode($filestr->form->mail),
            "formname"=>base64_decode($filestr->form->formname),
            "fromform"=>base64_decode($filestr->form->fromform),
            "pubdays"=>base64_decode($filestr->form->pubdays),
            "allok"=>base64_decode($filestr->form->allok),

        ));
        $last_insert=$wpdb->insert_id;
        foreach($filestr->fields as $item){
        $wpdb->insert(($this->tbl_unicat.'unicat_fld'), array(
            "forma"=>base64_decode($last_insert),
            "name"=>base64_decode($item->name),
            "params"=>base64_decode($item->params),
            "hint"=>base64_decode($item->hint),
            "poltype"=>base64_decode($item->poltype)
        ));
        }
    print 'Форма успешно импортирована<br/><br/>';
    }
}

//импорт строгих списков
if ((isset($_POST['listsimport']))&&($_POST['listsimport']==1)){
if ($_FILES['importfile']['error'] > 0)
{
    echo 'Проблема: ';
    switch ($_FILES['importfile']['error'])
    {
        case 1: echo 'размер файла больше upload_max_filesize' ; break;
        case 2: echo 'размер файла больше max_file_size'; break;
        case 3: echo 'загружена только часть файла'; break;
        case 4: echo 'файл не загружен'; break;
    }

} else {
    $wpdb->query("DELETE FROM `" . $this->tbl_unicat . "unicat_list`");
    $filestr=json_decode(file_get_contents($_FILES['importfile']['tmp_name']));
    foreach($filestr as $item){
        $wpdb->insert(($this->tbl_unicat.'unicat_list'), array(
            "fieldname"=>base64_decode($item->fieldname),
            "content"=>base64_decode($item->content),
            "contact"=>base64_decode($item->contact),
            "id"=>base64_decode($item->id),
        ));
    }

}

}

//Экспорт строгих списков
if ((isset($_POST['listsexport']))&&($_POST['listsexport']==1)){
    $result=$wpdb->get_results("SELECT * FROM `" . $this->tbl_unicat . "unicat_list`", ARRAY_A);
    $json='{';
    for ($i=0;$i<count($result);$i++){
        $json.='"list'.$i.'":{';
        $json.='"id":"'. base64_encode($result[$i]['id']).'", ';
        $json.='"fieldname":"'.base64_encode($result[$i]['fieldname']). '", ';
        $json.='"content":"'.base64_encode($result[$i]['content']). '", ';
        $json.='"contact":"'.base64_encode($result[$i]['contact']).'"} ';
        if ($i<count($result)-1) {$json.=',' . PHP_EOL;}
    }
    $json.='}';
    $filelistdump='dump_list_'. date('d-m-Y_H-i'). '.dat';
    $fp=fopen ($this->maindir . '/backups/' . $filelistdump, "w");
    fputs($fp,$json);
    fclose($fp);
    print 'Ссылка на скачивание дампа: <a target="_blank" id="SaveListLink" href="'.$this->plugin_url.'backups/'.$filelistdump.'">'.$filelistdump.'</a><script type="text/javascript">document.getElementById("SaveListLink").click()</script><br/><br/><br/>';
}

//сохраняем секретный ключ
if ((isset($_POST['SaveSecretKey']))&&($_POST['SaveSecretKey']==1)){
$wpdb->query("UPDATE `" . $this->tbl_unicat . "unicat_settings` SET `postkey`='".$_POST['secretkey']."'");
}


?>
<div id="icon-tools" class="icon32"></div><h1>Импорт-экспорт настроек</h1>

<h2 style="clear: both">Формы</h1>
    <form method="POST" enctype="multipart/form-data">
    <select name="forma">
        <?php
        $result=$wpdb->get_results("SELECT `id`, `formname` FROM `" . $this->tbl_unicat . "unicat_forms`",ARRAY_A);
        for ($i=0;$i<count($result);$i++){
            print '<option value="'.$result[$i]['id'].'">'.$result[$i]['formname'].'</option>';
        }
        ?>
    </select><br/>
        <input type="file" name="importfile">
        <button name="formsimport" value="1" class="button" style="width: 100px;">Импорт</button>
        <button name="formsexport" value="1" class="button" style="width: 100px;">Экспорт</button>
    </form>



<br/><br/><br/><h2>Списки:</h1>
    <table>
        <tr>
            <td><form method="POST" enctype="multipart/form-data">
                    <input type="file" name="importfile">
                    <button name="listsimport" value="1" class="button" style="width: 100px;" >Импорт</button></form></td>
            <td> <form method="POST" enctype="multipart/form-data">    <button name="listsexport" value="1" class="button" style="width: 100px;">Экспорт</button></form></td>

        </tr>

    </table>



<br/><br/><br/><h2>Секретный ключ</h1>
<form method="POST">
    <input type="text" style="width: 330px;" value="<?php print $wpdb->get_var("SELECT `postkey` FROM `" . $this->tbl_unicat . "unicat_settings` WHERE id='1'"); ?>" name="secretkey">
    <button name="SaveSecretKey" value="1" class="button">Сохранить</button>
</form>