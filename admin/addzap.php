
<?php
if ((isset($_POST['act']))&&($_POST['act']=='submt')){ //Пользователь отправил запрос
    $fields=array_keys($_POST);//Все поля POST запроса
    if (isset($_POST['datepublic'])){

        if ((strtotime($_POST['datepublic'])>(time()+($maxpubdays*60*60*24)))||(strtotime($_POST['datepublic'])==0)){
            $pbdays=mktime()+($maxpubdays*60*60*24);
        } else {
            $pbdays=strtotime($_POST['datepublic']);
        }
    } else {$pbdays=mktime()+($maxpubdays*60*60*24);}

    $wpdb->insert(($this->tbl_unicat.'unicat_posts'), array('formsid'=>$atts['id'],'userid'=>$current_user->ID, 'userlogin'=>$current_user->display_name, 'postdate'=>time(), 'moderated'=>$moderated, 'endpub'=>$pbdays));
    $formid=$wpdb->insert_id;
    for ($i=0;$i<count($fields);$i++){
        if (($fields[$i]!='act')&&($fields[$i]!='datepublic')){
            preg_match('#(\[.*type:"\K)(.*)(?=".*name:"'.$fields[$i].'")#',$code,$objtype);
            $wpdb->insert(($this->tbl_unicat.'unicat_fields'), array('postsid'=>$formid, 'fieldtype'=>$fields[$i], 'fielddata'=>$_POST[$fields[$i]], 'objtype'=>$objtype[0]));
        }
    }

    $fields=array_keys($_FILES);
    //Обрабатываем файлы если есть
    for ($i=0;$i<count($fields);$i++){
        if (preg_match('#\.jpg\b|\.png\b|\.jpeg\b|\.gif\b#',$_FILES[$fields[$i]]['name'],$ftype)){
            preg_match('#(\[.*type:"\K)(.*)(?=".*name:"'.$fields[$i].'")#',$code,$objtype);
            $wpdb->insert(($this->tbl_unicat.'unicat_fields'), array('postsid'=>$formid, 'fieldtype'=>$fields[$i], 'fielddata'=>'', 'objtype'=>$objtype[0]));
            $picname=$wpdb->insert_id;
            $wpdb->query("UPDATE `" . $this->tbl_unicat . "unicat_fields` SET `fielddata`='".WP_PLUGIN_URL. '/unicat/files/'.$picname . $ftype[0]."' WHERE `id`='".$picname."'");

            //Сжимаем фотку если нужно
            preg_match('#(\[SForm.*?name:"'.$fields[$i].'".*?\])#',$code,$shrt);
            if (preg_match('#resize:"1"#',$shrt[0],$resize)){
                if (!preg_match('#(\width:"\K)(.*?)(?=".*?])#',$shrt[0],$imgWidth)){$imgWidth[0]=0;}
                if (!preg_match('#(\height:"\K)(.*?)(?=".*?])#',$shrt[0],$imgHeight)){$imgHeight[0]=0;}
                switch(strtolower($ftype[0])){
                    case ".gif":$im=imagecreatefromgif($_FILES[$fields[$i]]['tmp_name']);break;
                    case ".png":$im=imagecreatefrompng($_FILES[$fields[$i]]['tmp_name']);break;
                    case ".jpg":$im=imagecreatefromjpeg($_FILES[$fields[$i]]['tmp_name']);break;
                    case ".jpeg":$im=imagecreatefromjpeg($_FILES[$fields[$i]]['tmp_name']);break;
                }

                $ox = imagesx($im);
                $oy = imagesy($im);
                if (($ox>$imgWidth[0])&&($imgWidth[0]!=0)){
                    $nx = $imgWidth[0];
                    $perc=floor($nx*100/$ox);
                    $ny=floor($oy*($perc)/100);
                } else {
                    $nx=$ox;
                    $ny = $oy;
                }

                if (($ny>$imgHeight[0])&&($imgHeight[0]!=0)){
                    $perc=floor($imgHeight[0]*100/$ny);
                    $ny=$imgHeight[0];
                    $nx=floor($nx*($perc)/100);
                }


                $nm = imagecreatetruecolor($nx, $ny);
                imagecopyresampled($nm, $im, 0,0,0,0,$nx,$ny,$ox,$oy);
                imagejpeg($nm, $_FILES[$fields[$i]]['tmp_name'], 100);
            }
            // Добавляем водяной знак если нужно
            if (preg_match('#vatermark:"1"#',$shrt[0])){
                require_once($this->maindir . '/watermark.php');
                $watermark = new watermark3();
                $img = imagecreatefromjpeg($_FILES[$fields[$i]]['tmp_name']);
                $water = imagecreatefrompng($this->maindir . '/user/images/watermark.png');
                $im=$watermark->create_watermark($img,$water,100);
                imagejpeg($im,$_FILES[$fields[$i]]['tmp_name']);
            }

            move_uploaded_file($_FILES[$fields[$i]]['tmp_name'],$this->filesupl . $picname . $ftype[0]);
        }
    }

    $code='<div class="UniCatAllOK">'.(htmlspecialchars_decode($wpdb->get_var("SELECT `allok` FROM `". $this->tbl_unicat."unicat_forms` WHERE `id`='" . $atts['id'] . "'"))).'</div>'.$code;
}



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



    switch ($finding[0]){
        case 'text': $codefind[]=$short_codes[0][$i];$coderepl[]=SF_ret_text($short_codes[0][$i]);break;
        case 'textarea':$codefind[]=$short_codes[0][$i];$coderepl[]= SF_ret_textarea($short_codes[0][$i]);break;
        case 'submit':$codefind[]=$short_codes[0][$i];$coderepl[]= SF_ret_submit($short_codes[0][$i]);break;
        case 'find':$codefind[]=$short_codes[0][$i];$coderepl[]= SF_ret_find($short_codes[0][$i],$code);break;
        case 'Select':$codefind[]=$short_codes[0][$i];$coderepl[]= SF_ret_select($short_codes[0][$i], $this->tbl_unicat,$gtpost);break;
        case 'textajax':$codefind[]=$short_codes[0][$i];$coderepl[]= SF_ret_textajax($short_codes[0][$i],$gtpost);break;
        case 'image':$codefind[]=$short_codes[0][$i];$coderepl[]= SF_ret_image($short_codes[0][$i]);break;
        case 'checkbox':$codefind[]=$short_codes[0][$i];$coderepl[]= SF_ret_checkbox($short_codes[0][$i], $gtpost);break;
        case 'number':$codefind[]=$short_codes[0][$i];$coderepl[]= SF_ret_number($short_codes[0][$i],'', $gtpost);break;
        case 'radio':$codefind[]=$short_codes[0][$i];$coderepl[]= SF_ret_radio($short_codes[0][$i],$gtpost);break;
        case 'datapicker':$codefind[]=$short_codes[0][$i];$coderepl[]= SF_ret_datapicker($short_codes[0][$i]);break;
    }
}











?>