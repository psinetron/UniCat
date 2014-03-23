<?php
$otec=$_POST['parent'];
$child=$_POST['child'];
$content=$_POST['content'];
$contact=$wpdb->get_var("SELECT id FROM `" . $this->tbl_unicat . "unicat_list` WHERE fieldname='".$otec."' AND content='".$content."' LIMIT 1");
$result=$wpdb->get_results("SELECT * FROM `" . $this->tbl_unicat . "unicat_list` WHERE fieldname='".$child."' AND contact='".$contact."'", ARRAY_A);
print '<option value="">Не указано</option>';
for ($i=0;$i<count($result);$i++){
    print '<option value="'.$result[$i]['content'].'">'.$result[$i]['content'].'</option>';
}
 ?>