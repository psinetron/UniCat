<?php



if ($_POST['ct']==1){
    if ($_POST['field']=='0'){
        return false;
    }
print '
Поле:<br/>
<select id="subContact" onchange="GetFields(3)"><option value="0" selected="selected">Без привязки к полю</option> ';
$field=$_POST['field'];
$result=$wpdb->get_results("SELECT * FROM `" . $this->tbl_unicat . "unicat_list` WHERE `fieldname`='".$field."'",ARRAY_A);
for ($i=0;$i<count($result);$i++){
    print '<option value="'.$result[$i]['id'].'">'.$result[$i]['content'].'</option>';
}
print '</select>';}

if ($_POST['ct']==2){
    $field=$_POST['field'];
    $result=$wpdb->get_results("SELECT * FROM `" . $this->tbl_unicat . "unicat_list` WHERE `fieldname`='".$field."'",ARRAY_A);
    for ($i=0;$i<count($result);$i++){
        print $result[$i]['content'].PHP_EOL;
    }
}

if ($_POST['ct']==3){
    $field=$_POST['field'];
    $result=$wpdb->get_results("SELECT * FROM `" . $this->unicat_form . "unicat_list` WHERE `contact`='".$field."'",ARRAY_A);
    for ($i=0;$i<count($result);$i++){
        print $result[$i]['content'].PHP_EOL;
    }
}



?>