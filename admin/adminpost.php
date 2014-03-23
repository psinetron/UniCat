<form action="" method="POST">
    <h2>Выберите форму</h2>
    <select name="SeeForm">
        <?php

        if(isset($_POST['SeeForm'])){$SeeForm=$_POST['SeeForm'];} else {$SeeForm=$wpdb->get_var("SELECT id FROM `".$this->tbl_unicat . "unicat_forms` LIMIT 1");}
        $fromform=$wpdb->get_var("SELECT fromform FROM `".$this->tbl_unicat . "unicat_forms` WHERE id='".$SeeForm."'");
        $forms=$wpdb->get_results("SELECT * FROM `".$this->tbl_unicat . "unicat_forms`", ARRAY_A);
        for ($i=0;$i<count($forms);$i++){
            if ($forms[$i]['id']==$SeeForm){$selected='selected="selected"'; $idform=$forms[$i]['id']; $inpform=$wpdb->get_var("SELECT `inputform` FROM `".$this->tbl_unicat . "unicat_forms` WHERE `id`='".$forms[$i]['id']."'");} else {$selected='';}
            print '<option value="'.$forms[$i]['id'].'" '.$selected.'>'.$forms[$i]['formname'].'</option>';
        }
        ?>
    </select>
    <input type="submit" class="button" value="Выбрать">
</form>

<?php
$atts['id']=$idform;
global $wpdb;
$moderated=1;
$current_user = wp_get_current_user();
$code=$inpform;
$code='<form method="POST" enctype="multipart/form-data">
<input type="hidden" name="'.$SeeForm .'" value="'.$idform.'" />
'.$code.'</form>';
require_once(__DIR__ . '/addzap.php');
print str_replace($codefind,$coderepl,$code);
?>
