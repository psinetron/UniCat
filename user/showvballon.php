<?php
$field=$_POST['field'];
$needval=$_POST['ndvalue'];
$ndpost=$_POST['ndpole'];
$pastednc=$_POST['ndpole'];

if ($needval==''){exit;};
$result=$wpdb->get_results("SELECT `fielddata` FROM `" . $this->tbl_unicat . "unicat_fields` WHERE `fieldtype`='".$field."' AND `fielddata` like '%".$needval."%' GROUP BY `fielddata` LIMIT 5 ",ARRAY_A);



for ($i=0;$i<count($result);$i++){
    $result[$i]['fielddata']=preg_replace('#('.$needval.')#i','<span>$1</span>',$result[$i]['fielddata']);
    print '<div onclick="AddPodsk('."'" . $ndpost . "'".',this)">'.$result[$i]['fielddata'].'</div>';
}
?>