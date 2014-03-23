<?php
$secretcode=$wpdb->get_var("SELECT `postkey` FROM `" . $this->tbl_unicat . "unicat_settings` WHERE `id`=1 LIMIT 1");

if ($secretcode==$_POST['secretcode']){
    $decods=json_decode(str_replace('\"','"',$_POST['dataposts']));
    foreach ($decods as $item){
        $wpdb->insert(($this->tbl_unicat.'unicat_posts'),array("formsid"=>base64_decode(str_replace(' ', '+',$item->formsid)),"userid"=>base64_decode(str_replace(' ', '+',$item->userid)), "userlogin"=>base64_decode(str_replace(' ', '+',$item->userlogin)), "postdate"=>base64_decode(str_replace(' ', '+',$item->postdate)), "endpub"=>base64_decode(str_replace(' ', '+',$item->endpub)), "moderated"=>base64_decode(str_replace(' ', '+',$item->moderated))));
        $lastinsertId=$wpdb->insert_id;
        foreach ($item->fields as $item2){

            if ((base64_decode(str_replace(' ', '+',$item2->objtype))=='image')||(base64_decode(str_replace(' ', '+',$item2->objtype))=='imageURI')){
                $wpdb->insert(($this->tbl_unicat.'unicat_fields'), array("postsid"=>$lastinsertId, "fieldtype"=>base64_decode(str_replace(' ', '+',$item2->fieldtype)), "objtype"=>base64_decode(str_replace(' ', '+',$item2->objtype))));

                if (base64_decode(str_replace(' ', '+',$item2->objtype))=='imageURI'){
                    preg_match('#\.(.{1,3})$#',base64_decode(str_replace(' ', '+',$item2->fielddata)),$filetype);
                    $filename=$this->filesupl . $wpdb->insert_id . $filetype[0];
                    $file=fopen($filename, 'wb');
                    fputs($file,file_get_contents(base64_decode(str_replace(' ', '+',$item2->fielddata))));
                    fclose($file);
                } else {
                    preg_match('#\.(.{1,4})$#',base64_decode(str_replace(' ', '+',$item2->filename)),$filetype);
                    $filename=$this->filesupl . $wpdb->insert_id . $filetype[0];
                    $file=fopen($filename, 'wb');
                    fputs($file,base64_decode(str_replace(' ', '+',$item2->fielddata)));
                    fclose($file);
                }


                //Сжимаем фотку если нужно

                preg_match('#(\[SForm.*?name:"'.base64_decode(str_replace(' ', '+',$item2->fieldtype)).'".*?\])#',$code,$shrt);
                if (preg_match('#resize:"1"#',$shrt[0],$resize)){
                    if (!preg_match('#(\width:"\K)(.*?)(?=".*?])#',$shrt[0],$imgWidth)){$imgWidth[0]=0;}
                    if (!preg_match('#(\height:"\K)(.*?)(?=".*?])#',$shrt[0],$imgHeight)){$imgHeight[0]=0;}
                    switch(strtolower($ftype[0])){
                        case ".gif":$im=imagecreatefromgif($filename);break;
                        case ".png":$im=imagecreatefrompng($filename);break;
                        case ".jpg":$im=imagecreatefromjpeg($filename);break;
                        case ".jpeg":$im=imagecreatefromjpeg($filename);break;
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
                    imagejpeg($nm, $$filename, 100);
                }
                // Добавляем водяной знак если нужно
                if (preg_match('#vatermark:"1"#',$shrt[0])){
                    require_once($this->maindir . '/watermark.php');
                    $watermark = new watermark3();
                    $img = imagecreatefromjpeg($filename);
                    $water = imagecreatefrompng($this->maindir . '/user/images/watermark.png');
                    $im=$watermark->create_watermark($img,$water,100);
                    imagejpeg($im,$filename);
                }







                $wpdb->update(($this->tbl_unicat.'unicat_fields'), array("fielddata"=>WP_PLUGIN_URL. '/unicat/files/' . $wpdb->insert_id . $filetype[0], "objtype"=>"image"), array("id"=>$wpdb->insert_id));
                continue;
            }
            $wpdb->insert(($this->tbl_unicat.'unicat_fields'), array("postsid"=>$lastinsertId, "fieldtype"=>base64_decode(str_replace(' ', '+',$item2->fieldtype)), "fielddata"=>base64_decode(str_replace(' ', '+',$item2->fielddata)), "objtype"=>base64_decode(str_replace(' ', '+',$item2->objtype))));
        }
    }
}

?>