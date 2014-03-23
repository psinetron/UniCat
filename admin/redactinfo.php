<?php
global $wpdb;

$code=$wpdb->get_var("SELECT `inputform` FROM `" . $this->tbl_unicat . "unicat_forms` WHERE id='".intval($_POST['FormsId'])."'");

$short_codes=array();
$codefind=array();
$coderepl=array();

preg_match_all('#\[SForm(.*?)]#',$code,$short_codes);//Ищем коды полей

//ищем параметры
for ($i=0;$i<count($short_codes[0]);$i++){
    preg_match('#(?<=type:")(.*?)(?=")#',$short_codes[0][$i],$finding);//Определяем тип поля
    $gtpost='';
    if (preg_match('#(?<=name:")(.*?)(?=")#',$short_codes[0][$i],$findingnames)){
        if (isset($_GET[$findingnames[0]])){
            $gtpost=$_GET[$findingnames[0]];
        }
    }

if ($finding[0]!='datapicker'){$valuePost=$wpdb->get_var("SELECT `fielddata` FROM `" . $this->tbl_unicat . "unicat_fields` WHERE `postsid`='".intval($_POST['SFPostNum'])."' AND `fieldtype`='".$findingnames[0]."' LIMIT 1");}
    else {
        $valuePost=$wpdb->get_var("SELECT `endpub` FROM `" . $this->tbl_unicat . "unicat_posts` WHERE `id`='".intval($_POST['SFPostNum'])."' LIMIT 1");
    }

    switch ($finding[0]){
        case 'text': $codefind[]=$short_codes[0][$i];$coderepl[]=SF_ret_text($short_codes[0][$i],$valuePost);break;
        case 'textarea':$codefind[]=$short_codes[0][$i];$coderepl[]= SF_ret_textarea($short_codes[0][$i],$valuePost);break;
        case 'submit':$codefind[]=$short_codes[0][$i];$coderepl[]= SF_ret_submit($short_codes[0][$i]);break;
        case 'find':$codefind[]=$short_codes[0][$i];$coderepl[]= SF_ret_find($short_codes[0][$i],$code);break;
        case 'Select':$codefind[]=$short_codes[0][$i];$coderepl[]= SF_ret_select($short_codes[0][$i], $this->tbl_unicat,$gtpost,$valuePost);break;
        case 'textajax':$codefind[]=$short_codes[0][$i];$coderepl[]= SF_ret_textajax($short_codes[0][$i],$gtpost,$valuePost);break;
        case 'image':$codefind[]=$short_codes[0][$i];$coderepl[]= SF_ret_image($short_codes[0][$i], $valuePost);break;
        case 'checkbox':$codefind[]=$short_codes[0][$i];$coderepl[]= SF_ret_checkbox($short_codes[0][$i], $gtpost,$valuePost);break;
        case 'number':$codefind[]=$short_codes[0][$i];$coderepl[]= SF_ret_number($short_codes[0][$i], $gtpost,$valuePost);break;
        case 'radio':$codefind[]=$short_codes[0][$i];$coderepl[]= SF_ret_radio($short_codes[0][$i],$valuePost);break;
        case 'datapicker':$codefind[]=$short_codes[0][$i];$coderepl[]= SF_ret_datapicker($short_codes[0][$i],$valuePost);break;
    }
}
print '<form method="POST" >';
print str_replace($codefind,$coderepl,$code);
print '
<input type="hidden" name="UniCatPostId" value="'.intval($_POST['SFPostNum']).'">
<button name="act" value="adminUpdatePost" class="button">Редактировать даныне</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="'.$_SERVER['REQUEST_URI'].'">Отмена</a>
</form>';

?>