<?php
global $wpdb;



$result='';

if ($atts['formtype']=="posts"){
$code=$wpdb->get_var("SELECT `outputform` FROM `" . $this->tbl_unicat . "unicat_forms` WHERE id='".$atts['id']."' LIMIT 1");
}
if ($atts['formtype']=="full"){
    $code=$wpdb->get_var("SELECT `podrobnoform` FROM `" . $this->tbl_unicat . "unicat_forms` WHERE id='".$atts['id']."' LIMIT 1");
}
$codeinp=$wpdb->get_var("SELECT `inputform` FROM `" . $this->tbl_unicat . "unicat_forms` WHERE id='".$atts['id']."' LIMIT 1");
;




if ((isset($_GET['act']))&&((($_GET['act']=='find')||($_GET['act']=='showall')||($_GET['act']=='find-all')))){
$_POST['act']=$_GET['act'];

preg_match_all('#(?<=name=")(.*?)(?=")|(?<=name:")(.*?)(?=")#',$code.$codeinp,$massive);

for ($i=0;$i<count($massive[0]);$i++){
if (isset($_GET[$massive[0][$i]])){$_POST[$massive[0][$i]]=$_GET[$massive[0][$i]];}
}
}




if (isset($_POST['act'])&&(($_POST['act']=='find')))
{
    $codeinp=$wpdb->get_var("SELECT `findform` FROM `" . $this->tbl_unicat . "unicat_forms` WHERE id='".$atts['id']."' LIMIT 1");
$_POST=$_GET;
$fields=array_keys($_POST);//Все поля POST запроса
$zapr='';
$dobav=false;
$havcount=0;
for ($i=0;$i<count($fields);$i++){
if ($fields[$i]=='act'){continue;}
if ($fields[$i]=='newfind'){continue;}
if ($fields[$i]=='page_id'){continue;}
if ($fields[$i]=='p'){continue;}
if ($_POST[$fields[$i]]!=''){


if (preg_match('#\[SForm (.*)name="'.$fields[$i].'"(.*)ontrue="\K(.*?)(?=")#',$code,$ontr)){
$zapr.="(`fieldtype`='" . $ontr[0] . "' AND `fielddata`<>'')";
}else {
if (is_array($_POST[$fields[$i]])){
if ($_POST[$fields[$i]][0]==''){$dobav=false; continue;}
$zapr.="(`fieldtype`='" . $fields[$i] . "' AND (";
$dobav2=false;
for ($i2=0;$i2<count($_POST[$fields[$i]]);$i2++){
if ($dobav2){$zapr.=' OR ';}
$zapr.=" `fielddata` like '%".$_POST[$fields[$i]][$i2]."%' ";
$dobav2=true;
}
$zapr.=') )';
}
else {
    //if (preg_match('#\[SForm(.*?)name:"'.$fields[$i].'"(.*?)valp:"\K(.*?)(?=")#',$codeinp,$valp)){$newtype=$valp[0]; print 'asdasdads';} else {$newtype=$fields[$i];}
if (preg_match('#\[SForm (.*?)name:"'.$fields[$i].'"(.*?)valp:"\K(.*?)(?=")#',$codeinp,$valp)){$newtype=$valp[0];} else {$newtype=$fields[$i];}
if (preg_match('#\[SForm (.*?)name:"'.$fields[$i].'"(.*?)logic:"\K(.*?)(?=")#',$codeinp,$valp)){

switch($valp[0]){
case 'equally':$prezap="=";$postzap="";break;
case 'more':$prezap=">=";$postzap="";break;
case 'less':$prezap="<=";$postzap="";break;
}
} else {$prezap="like '%";$postzap="%'";}
if (preg_match("#\`fieldtype\`\='".$newtype."'#",$zapr)){
$zapr=preg_replace("#(`fieldtype`='".$newtype."' AND `fielddata`(.*?)(?=\)))#",'$1 AND `fielddata`' . $prezap.$_POST[$fields[$i]].$postzap,$zapr);
continue;
}
if ($dobav){$zapr.=' OR ';}
$zapr.="(`fieldtype`='" . $newtype . "' AND `fielddata`".$prezap.$_POST[$fields[$i]].$postzap.")";
}
}
$dobav=true;
$havcount++;
}
}

    if ($zapr!=''){$zapr=' WHERE ' . $zapr;} else {$zapr=' WHERE 1';}

if ($havcount>0) {$havcount = "HAVING COUNT(`postsid`)=" . $havcount;} else {$havcount='';}
$zapr=$wpdb->get_results("SELECT `postsid` FROM `" . $this->tbl_unicat . "unicat_fields` ".$zapr . " GROUP BY `postsid` " . $havcount,ARRAY_A);
$subzapr='';
$dobav=false;
for ($i=0;$i<count($zapr);$i++){
if ($dobav){$subzapr.=' OR ';}
$subzapr.='`id`='.$zapr[$i]['postsid'];
$dobav=true;
}

$from=$atts['id'];
$endingzapr="SELECT * FROM `" . $this->tbl_unicat . "unicat_posts` WHERE `formsid`='".$from."' AND `moderated`=1";
if ($dobav){$endingzapr.=' AND ('.$subzapr.')';} else {$result= 'Поиск не дал результатов';    return $result;}
} else {


if (isset($_POST['act'])&&($_POST['act']=='showall')){
if (!isset($_GET['post'])){$_GET['post']=0;}
    $from=$atts['id'];
$endingzapr="SELECT * FROM `" . $this->tbl_unicat . "unicat_posts` WHERE `formsid`='".$from."' AND `moderated`=1 AND id='".$_GET['post']."'";
}
else {

if ((isset($atts['fromform']))&&($atts['fromform']!=0)){$from=$atts['fromform'];} else{$from=$atts['id'];}
$endingzapr="SELECT * FROM `" . $this->tbl_unicat . "unicat_posts` WHERE `formsid`='".$from."' AND `moderated`=1";
}
}
$mainsql=array('`', ' AND ', ' OR ');
$cutsql=array('', '-FExAnd-',);





/********
* Постраничная навигация
*/
$pagesnumquery=preg_replace('#\*#','COUNT(*)',$endingzapr );
$pagesnum=$wpdb->get_var($pagesnumquery . "  ORDER BY CASE WHEN `endpub` >".mktime()." THEN 1 ELSE 2 END , `postdate` DESC, `endpub` DESC"
);

if ((isset($_GET['SF_page']))){
$pageSet=$_GET['SF_page'];
} else {$pageSet=1;}
if ((isset($_GET['newfind']))&&($_GET['newfind']=="1")){$pageSet=1;}
if (isset($atts['postpages'])){$pagemax=$atts['postpages'];} else{$pagemax=1;} //Количество постов на странице
$total = intval(($pagesnum - 1) / $pagemax) + 1;
$pageSet=intval($pageSet);
if(empty($pageSet) or $pageSet < 0) $pageSet = 1;
if($pageSet > $total) $pageSet = $total;
$start = $pageSet * $pagemax - $pagemax;




$page2left=$page1left=$page2right=$page1right=$pervpage=$nextpage='';
$querySTR=preg_replace('#&SF_page=\d?|&SF_page=\d?|&newfind=1#','',$_SERVER['REQUEST_URI']);
if (preg_match('#\?#',$querySTR)){$querySTR.='&';} else {$querySTR.='?';}
// Проверяем нужны ли стрелки назад
if ($pageSet != 1) {$pervpage = '<a href="'.$querySTR.'SF_page=1">1</a>&nbsp;&nbsp;&nbsp;
<a href="'.$querySTR.'SF_page='. ($pageSet - 1) .'">назад</a> ';};
// Проверяем нужны ли стрелки вперед
if ($pageSet != $total) {$nextpage = ' <a href="'.$querySTR.'SF_page='. ($pageSet + 1) .'">вперед</a>&nbsp;&nbsp;&nbsp;
<a href="'.$querySTR.'SF_page=' .$total. '">'.$total.'</a>';}
if($pageSet - 2 > 0) $page2left = ' <a href="'.$querySTR.'SF_page=' . ($pageSet - 2) .'">'. ($pageSet - 2) .'</a> | ';
if($pageSet - 1 > 0) $page1left = '<a href="'.$querySTR.'SF_page='. ($pageSet - 1) .'">'. ($pageSet - 1) .'</a> | ';
if($pageSet + 2 <= $total) $page2right = ' | <a href="'.$querySTR.'SF_page='. ($pageSet + 2) .'">'. ($pageSet + 2) .'</a>';
if($pageSet + 1 <= $total) $page1right = ' | <a href="'.$querySTR.'SF_page='. ($pageSet + 1) .'">'. ($pageSet + 1) .'</a>';

/**********
* //Постраничная навигация
*/




$posts=$wpdb->get_results($endingzapr . "  ORDER BY CASE WHEN `endpub` >".mktime()." THEN 1 ELSE 2 END , `postdate` DESC, `endpub` DESC  LIMIT " . (($pageSet-1)*$pagemax) . ", ".$pagemax, ARRAY_A);



for ($i=0;$i<count($posts);$i++){
$fields=$wpdb->get_results("SELECT * FROM `" . $this->tbl_unicat . "unicat_fields` WHERE `postsid`='" . $posts[$i]['id'] ."'" , ARRAY_A);
$codeRepl=$code;
for($i1=0;$i1<count($fields);$i1++){
$precode='';$postcode='';
if ($fields[$i1]['objtype']=='image'){$precode= ''; $postcode='';}
if (preg_match('#(\[SForm .*name="'.$fields[$i1]['fieldtype'].'".*ontrue="\K)(.*?)(?=")#', $codeRepl,$ontruePole)){
if ($fields[$i1]['fielddata']=='1'){ //Значение true
$newZhach=$wpdb->get_results("SELECT * FROM `" . $this->tbl_unicat . "unicat_fields` WHERE `postsid`='" . $posts[$i]['id'] ."' AND `fieldtype`='".$ontruePole[0]."' LIMIT 1",ARRAY_A);
if ((!isset($newZhach[0]))||(!isset($newZhach[0]['objtype']))){continue;}
if ($newZhach[0]['objtype']=='image'){$precode=''; $postcode='';}
$codeRepl=str_replace('[SForm name="'.$fields[$i1]['fieldtype'].'" ontrue="'.$ontruePole[0].'"]',$precode.htmlspecialchars($newZhach[0]['fielddata']).$postcode,$codeRepl);
$i1--;
continue;

}
}

if (($fields[$i1]['fielddata']=='')&&(preg_match('#\[SFormphp\](.*?)\[SForm name="'.$fields[$i1]['fieldtype'].'"\](.*?)(\[/SFormphp\])#s',$codeRepl))){$fields[$i1]['fielddata']='0';}
$codeRepl=str_replace('[SForm name="'.$fields[$i1]['fieldtype'].'"]',$precode.htmlspecialchars(stripslashes($fields[$i1]['fielddata'])).$postcode,$codeRepl);

}
if (mktime()<$posts[$i]['endpub']) {
$statuspbl=1;
} else {
$statuspbl=0;
}
//return ($codeRepl);
$codeRepl=preg_replace('#\[SFormphp\](.*?)\K\[SForm name="(.*?)"\](?=(.*?)\[/SFormphp\])#','0',$codeRepl); //Убираем теги с несуществующими полями
$codeRepl=preg_replace('#\[SForm name="(.*?)"\]#','',$codeRepl); //Убираем теги с несуществующими полями
$codeRepl=str_replace('[SForm date]', date('d.m.Y H:i',$posts[$i]['postdate']), $codeRepl);//Вставляем дату
$codeRepl=str_replace('[SForm user]', $posts[$i]['userlogin'], $codeRepl);//Вставляем имя пользователя
$codeRepl=str_replace('[SForm pubstatus]', $statuspbl, $codeRepl);//Вставляем имя пользователя
$codeRepl=str_replace('[SForm post]', 'post=' . $posts[$i]['id'] . '&act=showall', $codeRepl);//Вставляем ссылку поста
$codeRepl=str_replace('[SForm postid]', $posts[$i]['id'], $codeRepl);//Вставляем номер поста


$ReplPhP= $codeRepl;
preg_match_all('#(?<=\[SFormphp\])(.*?)(?=\[\/SFormphp\])#s',$ReplPhP,$scripts);

for ($iCd=0;$iCd<count($scripts[0]);$iCd++){
//if ($iCd>0){continue;}

    //print_r ($scripts);
    $newScript=preg_replace('#(\s\K|;\K)\bprint\b|^\bprint\b|(\{\K)\bprint\b#s','$SFPrint.=',$scripts[0][$iCd]);



$newScript=preg_replace('#(\s\K|;\K)\becho\b|^\becho\b|(\{\K)\becho\b#s','$SFPrint.=',$newScript);

$newScript='$SFPrint=""; ' . $newScript . '; return($SFPrint);';
/*
* Переменные, которые объявлены через $- - не будут иметь преффикса
*/
$newScript=preg_replace('#\$\w#','$SFromPrefix',$newScript);
$newScript=preg_replace('#\$-#','$',$newScript);



$PhpEval=eval($newScript);
$ReplPhP=str_replace('[SFormphp]'.$scripts[0][$iCd].'[/SFormphp]',$PhpEval,$ReplPhP);


}


$codeRepl=$ReplPhP;

$result.=$codeRepl;

}

if ($total>1){$result.= '<p>Страницы: '.$pervpage.'&nbsp;&nbsp;&nbsp;'.$page2left.'&nbsp;&nbsp;&nbsp;'.$page1left.'&nbsp;&nbsp;&nbsp;'.'<b>'.$pageSet.'</b>'.'&nbsp;&nbsp;&nbsp;'.$page1right.'&nbsp;&nbsp;&nbsp;'.$page2right.'&nbsp;&nbsp;&nbsp;'.$nextpage . '</p>';}

?>