<?php


function SF_ret_text($stroke='', $value=''){
    $stroke=str_replace('[SForm','<input ',$stroke);
    $stroke=substr($stroke,0,strlen($stroke)-1);
    if (preg_match('#value:"#',$stroke)){
        $stroke=preg_replace('#value:"\K(.*?)(?=")#',$value,$stroke);
    } else {
        $stroke.=' value:"'.$value.'"';
    }
    $stroke.=' />';
    $finding=array('name:', 'id:', 'class:', 'maxlen:', 'placehold:', 'value:', 'type:"text"');
    $repling=array('name=', 'id=', 'class=', 'maxlength=', 'placeholder=', 'value=', 'type="text"');
    $stroke=str_replace($finding,$repling,$stroke);
    $stroke=urldecode($stroke);
    return $stroke;
}


function SF_ret_radio($stroke='', $value){
    $stroke=str_replace('[SForm','<input ',$stroke);
    $stroke=substr($stroke,0,strlen($stroke)-1);
    preg_match('#(?<=value:")(.*?)(?=")#',$stroke,$val);
    if ($val[0]==$value){
        if (!preg_match('#checked:"checked"#',$stroke)){
            $stroke.= ' checked:"checked"';
        }
    } else {
        preg_replace('#checked:"checked"#','',$stroke);
    }
    $stroke.= ' />' . $val[0];
    $finding=array('name:', 'id:', 'class:',  'value:', 'type:"radio"', 'checked:"checked"');
    $repling=array('name=', 'id=', 'class=',  'value=', 'type="radio"', 'checked="checked"');
    $stroke=str_replace($finding,$repling,$stroke);
    $stroke=urldecode($stroke);
    return $stroke;
}



function SF_ret_number($stroke='',$valpost='',$value=''){
    $stroke=str_replace('[SForm','<input onkeyup="onlyNumbers(this)"',$stroke);
    $stroke=substr($stroke,0,strlen($stroke)-1);
    if (preg_match('#value:"#',$stroke)){
    $stroke=preg_replace('#value:"\K(.*?)(?=")#',$value,$stroke);
    } else {
        $stroke.=' value:"'.$value.'"';
    }


    $stroke.=' />';

    $finding=array('name:', 'id:', 'class:', 'maxlen:', 'placehold:', 'value:', 'type:"number"');
    $repling=array('name=', 'id=', 'class=', 'maxlength=', 'placeholder=', 'value=', 'type="text"');
    $stroke=preg_replace('#valp:"(.*?)"|logic:"(.*?)"#','',$stroke);
    $stroke=str_replace($finding,$repling,$stroke);


    $stroke=urldecode($stroke);
    return $stroke;
}


function SF_ret_textarea($stroke='',$value=''){
    $stroke=str_replace('[SForm','<textarea ',$stroke);
    $stroke=substr($stroke,0,strlen($stroke)-1);
    $stroke.='></textarea>';
    $stroke=preg_replace('#\>\K(.*?)(?=</textarea>)#',$value,$stroke);
    $finding=array('name:', 'id:', 'class:', 'maxlen:', 'placehold:', 'value:', 'type:"textarea"');
    $repling=array('name=', 'id=', 'class=', 'maxlength=', 'placeholder=', 'value=', '');
    $stroke=str_replace($finding,$repling,$stroke);
    $stroke=preg_replace('#(value="(.*)")(.*)(</textarea>)#', '$3$2$4',$stroke);
    $stroke=urldecode($stroke);
    return $stroke;

}


function SF_ret_textajax($stroke='', $valpost='', $value=''){
    $stroke=str_replace('[SForm','<div class="Ajaxcont"><input ',$stroke);
    if (!preg_match('#value\:"(.*?)"#',$stroke)){$stroke=preg_replace('#<input#', '<input value=""',$stroke);}
    $stroke=substr($stroke,0,strlen($stroke)-1);
    preg_match('#(?<=name\:")(.*?)(?=")#',$stroke,$name);
    preg_match('#(?<=field:")(.*?)(?=")#',$stroke,$field);
    $stroke=preg_replace('#field:"(.*?)"#','',$stroke);
    $stroke.=' onkeyup="ShowPodsk('. "'" . $field[0] . "'"  .', '."'SFajax" . $name[0] . "', " . "'" . $name[0] . "'" .')" onblur="hidePodsk('. "'SFajax" . $name[0] . "'".')"';
    $stroke.=' autocomplete=off /><div id="SFajax'.$name[0].'" class="DownsDiv"></div></div>';
    $finding=array('name:', 'id:', 'class:', 'maxlen:', 'placehold:', 'value:', 'type:"textajax"');
    $repling=array('name=', 'id=', 'class=', 'maxlength=', 'placeholder=', 'value=', 'type="text"');

    $stroke=str_replace($finding,$repling,$stroke);
    $stroke=preg_replace('#value="\K(.*?)(?=")#',$value,$stroke);
    if ($valpost!=''){$stroke=preg_replace('#value\="(.*?)"#s','value="'.htmlspecialchars($valpost).'"',$stroke);} //else{$stroke=preg_replace('#(?<=value\:")(.*?)(?=")#','2221',$stroke);}
    $stroke=urldecode($stroke);
    return $stroke;
}


function SF_ret_checkbox($stroke='',$valpost='', $value){
    $stroke=str_replace('[SForm','<input  value="1" ',$stroke);
    $stroke=substr($stroke,0,strlen($stroke)-1);

    preg_match('#(?<=value:")(.*?)(?=")#',$stroke,$val);
    if ($val[0]!=$value){
        if (!preg_match('#checked:"checked"#',$stroke)){
            $stroke.= ' checked:"checked"';
        }
    } else {
        preg_replace('#checked:"checked"#','',$stroke);
    }

    $stroke.=' />';
    $finding=array('name:', 'id:', 'class:', 'type:"checkbox"', 'checked:"checked"');
    $repling=array('name=', 'id=', 'class=', 'type="checkbox"', 'checked="checked"');
    $stroke=str_replace($finding,$repling,$stroke);
    $stroke=urldecode($stroke);
    return $stroke;
}

function SF_ret_datapicker($stroke='',$value){
    $stroke=str_replace('[SForm','<input type="text" id="blablabla"   name="datepublic"',$stroke);
    $stroke=substr($stroke,0,strlen($stroke)-1);
    $stroke.=' value="'.date('d.m.Y',$value).'"';
    $stroke.=' />';

    $finding=array('class:', 'type:"datapicker"');
    $repling=array('class=', '');
    $stroke=str_replace($finding,$repling,$stroke);
    $stroke=urldecode($stroke);
    return $stroke;
}



function SF_ret_image($stroke='', $value){

    $stroke=str_replace('[SForm','<input style="width:400px;" ',$stroke);
    $stroke=substr($stroke,0,strlen($stroke)-1);
    if (preg_match('#value:"#',$stroke)){
        $stroke=preg_replace('#value:"\K(.*?)(?=")#',$value,$stroke);
    } else {
        $stroke.=' value:"'.$value.'"';
    }
    $stroke.=' />';
    $finding=array('name:', 'id:', 'class:', 'maxlen:', 'placehold:', 'value:', 'type:"text"');
    $repling=array('name=', 'id=', 'class=', 'maxlength=', 'placeholder=', 'value=', 'type="text"');
    $stroke=str_replace($finding,$repling,$stroke);
    $stroke=urldecode($stroke);
    return '<img src="'.$value.'" width="200" ><br/>'.$stroke;




}


function SF_ret_submit($stroke=''){
    return '';
}

function SF_ret_find($stroke='',$code){
    return '';
}

function SF_ret_select($stroke='', $tbl='',$valpost='',$value){
    //[SForm type:"Select" name:"list1" child:"list2" parent:"0"]
    global $wpdb;
    preg_match('#(?<=name:")(.*?)(?=")#',$stroke,$arr);
    preg_match('#(?<=child:")(.*?)(?=")#',$stroke,$child);
    $checks=preg_match('#cheks:"1"#',$stroke);
    $pastemult='';
    if (preg_match('#multi:"1"#',$stroke)){$pastemult='[]';}
    if (!$checks){$stroke=str_replace('[SForm','<select onchange="getChilds('. "'" . $child[0] . "', '".$arr[0]."', 'multi'".')" onclick="getChilds('. "'" . $child[0] . "', '".$arr[0]."', 'multi'".')"',$stroke);}
    $finding=array('name:', 'id:', 'class:', 'type:"Select"', 'multi:"1"');
    $repling=array('name=', 'id=', 'class=', '', 'multiple="multiple"');
    $stroke=str_replace($finding,$repling,$stroke);
    $stroke=substr($stroke,0,strlen($stroke)-1);
    if (!$checks){$stroke.='>';}


    if (!$checks){
        if ($valpost!=''){
            $stroke.='<option value="'.$valpost.'" selected="selected" class="SFbold">'.$valpost.'</option>';
        } else {
            if (preg_match('#empty:"1"#',$stroke)){
                $stroke.='<option value="" selected="selected">не указано</option>';
                $stroke=str_replace('empty:"1"','',$stroke);
            }
        }


        if ((preg_match('#parent:"0"#',$stroke)||(!preg_match('#parent:"(.*?)"#',$stroke)))){
            $result=$wpdb->get_results("SELECT * FROM `" . $tbl . "unicat_list` WHERE `fieldname`='".$arr[0]."'", ARRAY_A);
            if (count($result)==0){$result=$wpdb->get_results("SELECT * FROM `" . $tbl . "unicat_fields` WHERE `fieldtype`='".$arr[0]."' GROUP BY `fielddata`", ARRAY_A);
                for ($i=0;$i<count($result);$i++){
                    if ($value==$result[$i]['fielddata']){$selected=' selected="selected" ';} else {$selected='';}
                    $stroke.= '<option value="'.$result[$i]['fielddata'].'" '.$selected.'>'.$result[$i]['fielddata'].'</option>';
                }
            } else {
                for ($i=0;$i<count($result);$i++){
                    if ($value==$result[$i]['content']){$selected=' selected="selected" ';} else {$selected='';}
                    $stroke.= '<option value="'.$result[$i]['content'].'" '.$selected.'>'.$result[$i]['content'].'</option>';
                }
            }
        }
        $stroke.='</select>';
    } else {
        $stroke=str_replace('[SForm','',$stroke);
        $stroke=preg_replace('#name="(.*?)"|id="(.*?)"|class="(.*?)"|multiple="multiple"|cheks:"1"|empty:"1"#','',$stroke);
        if ((preg_match('#parent:"0"#',$stroke)||(!preg_match('#parent:"(.*?)"#',$stroke)))){
            $result=$wpdb->get_results("SELECT * FROM `" . $tbl . "unicat_list` WHERE `fieldname`='".$arr[0]."'", ARRAY_A);
            for ($i=0;$i<count($result);$i++){
                $stroke.= '<div class="UniCatCheckSelect"><input type="checkbox" name="'.$arr[0].$pastemult.'" value="'.$result[$i]['content'].'" />'.$result[$i]['content'].'</div>';
            }

        }


    }

    $stroke=preg_replace('#child:"(.*?)"#','',$stroke);
    $stroke=preg_replace('#parent:"(.*?)"#','',$stroke);
    if ($pastemult=='[]'){$stroke=preg_replace('#name="'.$arr[0].'"#','name="'.$arr[0].'[]"', $stroke);}
    $stroke=urldecode($stroke);

    return $stroke;
}





?>