<?php
$namefield=$_POST['name'];
if (isset($_POST['contact'])){$contact=$_POST['contact'];}else {$contact='0';}
$fields=$_POST['values'];
$fields=preg_split('@[\r\n]@', $fields, -1, PREG_SPLIT_NO_EMPTY);
$wpdb->query("DELETE FROM `" . $this->tbl_unicat . "unicat_list` WHERE fieldname='".$namefield."' AND contact='".$contact."'");
for ($i=0;$i<count($fields);$i++){
    $wpdb->insert (($this->tbl_unicat.'unicat_list'),array('content'=>$fields[$i],'fieldname'=>$namefield, 'contact'=>$contact));
}
print 'Список успешно сохранен';
?>