<?php

if ((isset($_POST['act']))&&($_POST['act']=='adminUpdatePost')){

    $fields=array_keys($_POST);//Все поля POST запроса
    if (isset($_POST['datepublic'])){

        if ((strtotime($_POST['datepublic'])>(time()+($maxpubdays*60*60*24)))||(strtotime($_POST['datepublic'])==0)){
            $pbdays=mktime()+($maxpubdays*60*60*24);
        } else {
            $pbdays=strtotime($_POST['datepublic']);
        }
    } else {$pbdays=mktime()+($maxpubdays*60*60*24);}

    for ($i=0;$i<count($fields);$i++){
        if (($fields[$i]!='act')&&($fields[$i]!='datepublic')){
            $wpdb->update(($this->tbl_unicat.'unicat_fields'), array( 'fieldtype'=>$fields[$i], 'fielddata'=>$_POST[$fields[$i]], 'objtype'=>$objtype[0]), array("postsid"=>intval($_POST['UniCatPostId']),"fieldtype"=>$fields[$i]));
        }
    }

    print 'Запись успешно отредактирована';
}


if (isset($_POST['UpdatePost'])){
    require_once(__DIR__ . '/redactinfo.php');
    exit();
}




if (isset($_POST['DeleteZap'])){
    $wpdb->show_errors();
    $wpdb->query("DELETE FROM `" . $this->tbl_unicat . "unicat_fields` WHERE postsid='".$_POST['SFPostNum']."'");
    $wpdb->query("DELETE FROM `" . $this->tbl_unicat . "unicat_posts` WHERE id='".$_POST['SFPostNum']."'");

} else {
    if ((isset($_POST['act']))&&($_POST['act']=='Moderate')){
        $fields=array_keys($_POST);//Все поля POST запроса
        if (!isset($_POST['SFmoder'])){$wpdb->query("UPDATE `" . $this->tbl_unicat . "unicat_posts` SET `moderated`='0', `postdate`=".time()." WHERE id='".$_POST['SFPostNum']."'");}
        for ($i=0;$i<count($fields);$i++){
            if ($fields[$i]!='act'){
                switch ($fields[$i]){
                    case 'SFmoder':$wpdb->query("UPDATE `" . $this->tbl_unicat . "unicat_posts` SET `moderated`='".$_POST[$fields[$i]]."', `postdate`=".time()." WHERE id='".$_POST['SFPostNum']."'");break;
                    case 'SFPostNum':break;
                    default:$wpdb->query("UPDATE `" . $this->tbl_unicat . "unicat_fields` SET `fielddata`='".$_POST[$fields[$i]]."' WHERE postsid='".$_POST['SFPostNum']."' AND `fieldtype`='".$fields[$i]."'");break;
                }
            }
        }
    }
}

if ((isset($_POST['otmech']))&&($_POST['otmech']=='delete')&&(isset($_POST['postid']))){
    for ($i=0;$i<count($_POST['postid']);$i++){
        $wpdb->query("DELETE FROM `" . $this->tbl_unicat . "unicat_fields` WHERE postsid='".$_POST['postid'][$i]."'");
        $wpdb->query("DELETE FROM `" . $this->tbl_unicat . "unicat_posts` WHERE id='".$_POST['postid'][$i]."'");
    }
}

if ((isset($_POST['otmech']))&&($_POST['otmech']=='publicate')&&(isset($_POST['postid']))){
    for ($i=0;$i<count($_POST['postid']);$i++){
        $wpdb->query("UPDATE `" . $this->tbl_unicat . "unicat_posts` SET `moderated`='1', `postdate`=".time()." WHERE id='".$_POST['postid'][$i]."'");
    }
}

if ((isset($_POST['otmech']))&&($_POST['otmech']=='depublicate')&&(isset($_POST['postid']))){
    for ($i=0;$i<count($_POST['postid']);$i++){
        $wpdb->query("UPDATE `" . $this->tbl_unicat . "unicat_posts` SET `moderated`='0', `postdate`=".time()." WHERE id='".$_POST['postid'][$i]."'");
    }
}

if (isset($_POST['seeform'])){$nowForm=$_POST['seeform'];} else {$nowForm=$wpdb->get_var("SELECT `id` FROM `" . $this->tbl_unicat . "unicat_forms` LIMIT 1");}

?>






<div style="padding-right: 20px;">

<div id="icon-edit" class="icon32 icon32-posts-post">
    <br>
</div>
<h1>Модерация данных</h1>


<table>
<tr>
<td>
    Действия с отмеченными:<br/>
    <form method="POST" id="formallspeed" onsubmit="return speedform()">
        <select name="otmech">
            <option value="delete">Удалить</option>
            <option value="publicate" selected="selected">Опубликовать</option>
            <option value="depublicate">Снять с публикации</option>
        </select>
        <input type="hidden" name="showfilter" value="<?php print $_POST['showfilter'] ?>">
        <input type="hidden" name="seeform" value="<?php print $_POST['seeform'] ?>">

        <input type="submit" class="button" value="применить" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    </form>
</td>

    <form method="POST">
<td>Фильтр:<br/>
    <input type="hidden" name="sortDesc" value="" id="hiddenSortDesc">
    <select name="seeform">
        <?php
        $rstform=$wpdb->get_results("SELECT * FROM `" . $this->tbl_unicat . "unicat_forms`",ARRAY_A);
        for ($i=0;$i<count($rstform);$i++){
            if ($_POST['seeform']==$rstform[$i]['id']){$slct='selected="selected"';} else {$slct='';}
            print '<option value="'.$rstform[$i]['id'].'" '.$slct.'>'.$rstform[$i]['formname'].'</option>';
        }
        ?>
    </select>
    </td>
<td><br/>
    <select name="showfilter" id="showfltr">
        <?php
        $dopReq='';

        if (!isset($_POST['showfilter'])){$_POST['showfilter']='nopub';}
        if ((isset($_POST['showfilter'])&&($_POST['showfilter']=='all'))){print '<option selected="selected" value="all">Все записи</option>'; $dopReq="WHERE `formsid`='".$nowForm."'";} else {print '<option value="all">Все записи</option>'; }
        if ((isset($_POST['showfilter'])&&($_POST['showfilter']=='nopub'))){print '<option selected="selected" value="nopub">Неопубликованные</option>'; $dopReq=" WHERE moderated='0' AND `formsid`='".$nowForm."'";} else {print '<option value="DESC">Неопубликованные</option>';}
        if ((isset($_POST['showfilter'])&&($_POST['showfilter']=='pub'))){print '<option selected="selected" value="pub">Опубликованные</option>'; $dopReq=" WHERE moderated='1' AND `formsid`='".$nowForm."'";} else {print '<option value="ASC">Опубликованные</option>';}
        if (isset($_POST['sortDesc'])){
            if ($_POST['sortDesc']=='DESC'){$publicnext='ASC'; $pastarrow='▲'; $publicold='DESC'; print 'aaa';}else {$publicnext='DESC'; $pastarrow='▼'; $publicold='ASC'; print 'bbb';}
        } else {
            $pastarrow='▼';
            $publicnext='DESC';
            $publicold='ASC';
            print 'ccc';
        }
        ?>
    </select>
    </td>
        <td>Содержит:<br/>
        <input type="text" name="keyword" value="<?php if (isset($_POST['keyword'])){print $_POST['keyword'];} ?>">
        </td>
        <td><br/>
    <input type="submit" id="FilterButton" value="Показать" class="button" /></td>
</tr>
</table>
</form>

<br/>
<span onclick="FSChexkAll()" class="UniCatEditlabel">Отметить все</span> / <span onclick="FSUnChexkAll()" class="UniCatEditlabel">Снять выделения</span> / <span onclick="FSChexkInvert()" class="UniCatEditlabel">Инвертировать</span>

    <?php


    if ((isset($_POST['keyword']))&&($_POST['keyword']!='')){
        $dopReq=" INNER JOIN `" . $this->tbl_unicat . "unicat_fields` ON `" . $this->tbl_unicat . "unicat_fields`.postsid=`" . $this->tbl_unicat . "unicat_posts`.id ".$dopReq. " AND `" . $this->tbl_unicat . "unicat_fields`.`fielddata` like '%".$_POST['keyword']."%' GROUP BY `" . $this->tbl_unicat . "unicat_posts`.id";
    }

    //Постраничная навигация
    $pagesnum=$wpdb->get_var("SELECT COUNT(*) FROM `" . $this->tbl_unicat . "unicat_posts` " .$dopReq." LIMIT 1");



    if ((isset($_GET['SF_page']))){
        $pageSet=$_GET['SF_page'];
    } else {$pageSet=1;}
    $pagemax=25; //Количество постов на странице
    $total = intval(($pagesnum - 1) / $pagemax) + 1;
    $pageSet=intval($pageSet);
    if(empty($pageSet) or $pageSet < 0) $pageSet = 1;
    if($pageSet > $total) $pageSet = $total;
    $start = $pageSet * $pagemax - $pagemax;

    $page2left=$page1left=$page2right=$page1right=$pervpage=$nextpage='';
    $querySTR=preg_replace('#&SF_page=\d?|SF_page=\d?#','',$_SERVER['REQUEST_URI']);
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
    //echo '<p>Страницы: '.$pervpage.'&nbsp;&nbsp;&nbsp;'.$page2left.'&nbsp;&nbsp;&nbsp;'.$page1left.'&nbsp;&nbsp;&nbsp;'.'<b>'.$pageSet.'</b>'.'&nbsp;&nbsp;&nbsp;'.$page1right.'&nbsp;&nbsp;&nbsp;'.$page2right.'&nbsp;&nbsp;&nbsp;'.$nextpage . '</p>';







    print '<table class="wp-list-table widefat fixed pages UniCaTforms-table" width="400">
    <thead>
    <tr><th class="manage-column column-cb" width="10"></th><th class="manage-column column-cb UniCatAdminTblDiv" width="70"></th><th class="manage-column column-cb UniCatAdminTblDiv" width="120" onclick="document.getElementById(' . "'hiddenSortDesc'" . ').value=' . "'" . $publicnext .  "'" . '; document.getElementById('. "'FilterButton'" . ').click();">Опубликовано '.$pastarrow.'</th><th class="manage-column column-title">Объявление</th></tr>
    </thead>';
    $code=$wpdb->get_var("SELECT `outputform` FROM `" . $this->tbl_unicat . "unicat_forms` WHERE id='".$nowForm."' LIMIT 1");
    $codeinp=$wpdb->get_var("SELECT `inputform` FROM `" . $this->tbl_unicat . "unicat_forms` WHERE id='".$nowForm."' LIMIT 1");
    $posts=$wpdb->get_results("SELECT `" . $this->tbl_unicat . "unicat_posts`.* FROM `" . $this->tbl_unicat . "unicat_posts` ".$dopReq."  ORDER BY moderated ".$publicold.", postdate DESC LIMIT ".$start.",".$pagemax, ARRAY_A);
    for ($i=0;$i<count($posts);$i++){
        if ($posts[$i]['moderated']=='1'){$moderatedText='Опубликовано'; $tbodyclass="SFPublished";} else {$moderatedText='Не опубликовано';$tbodyclass="SFUnpublished";}
        print '<tbody ><tr';
            if ($i%2==0 ){print ' class="alternate" ';}
            print '>

        <td width="10" style="vertical-align: middle"><input type="checkbox" value="'.$posts[$i]['id'].'" name="ShortSnd" /></td>
        <td width="70" class="UniCatAdminTblDiv">
       '.$posts[$i]['id'].'

        </td>
         <td width="120" class="UniCatAdminTblDiv">
            ';
        if ($posts[$i]['moderated']){print 'опубликовано';} else {print 'не опубликовано';}
        print '
        </td>
        <form action="" id="" method="POST"><td>
        ';
        $fields=$wpdb->get_results("SELECT * FROM `" . $this->tbl_unicat . "unicat_fields` WHERE `postsid`=" . $posts[$i]['id'] , ARRAY_A);
        $codeRepl=$code;
        for($i1=0;$i1<count($fields);$i1++){

            $codeRepl=str_replace('[SForm name="'.$fields[$i1]['fieldtype'].'"]',$prevtag.$fields[$i1]['fielddata'].$endtag,$codeRepl);
        }



        if (mktime()<$posts[$i]['endpub']) {
            $statuspbl=1;
        } else {
            $statuspbl=0;
        }

        $codeRepl=preg_replace('#\[SForm name="(.*?)"\]#','',$codeRepl); //Убираем теги с несуществующими полями
        $codeRepl=str_replace('[SForm date]', date('d.m.Y H:i',$posts[$i]['postdate']), $codeRepl);//Вставляем дату
        $codeRepl=str_replace('[SForm user]', $posts[$i]['userlogin'], $codeRepl);//Вставляем имя пользователя
        $codeRepl=str_replace('[SForm pubstatus]', $statuspbl, $codeRepl);//Вставляем имя пользователя
        $codeRepl=str_replace('[SForm post]', 'post=' . $posts[$i]['id'] . '&act=showall', $codeRepl);//Вставляем ссылку поста
        $codeRepl=str_replace('[SForm postid]', $posts[$i]['id'], $codeRepl);//Вставляем номер поста
        //$codeRepl=preg_replace('#\[SFormphp\](.*?)\[/SFormphp\]#s', '', $codeRepl);//Удаляем PHP


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



        print $codeRepl;

        print '

        <div>';

        if ($posts[$i]['moderated']=='1'){
            print '<button name="depub" class="UniCatEditlabel" value="1">снять с публикации</button> | ';
        } else {
            print '<button name="SFmoder" class="UniCatEditlabel" value="1">Опубликовать</button> | ';
        }

            print '<input type="submit" class="UniCatEditlabel" name="DeleteZap" value="Удалить запись"> |
            <button name="UpdatePost" value="1" class="UniCatEditlabel">Редактировать</button>
        </div>
        <input type="hidden" name="showfilter" value="'.$_POST['showfilter'] .'">
        <input type="hidden" name="seeform" value="'. $_POST['seeform'] .'">
            <input type="hidden" name="act" value="Moderate">
            <input type="hidden" name="FormsId" value="'.$nowForm.'">
            <input type="hidden" name="SFPostNum" value="'.$posts[$i]['id'].'">
        </td>

        </form>
    </tr></tbody>';

    }

    ?>


</table>
</div>
<?php echo '<p>Страницы: '.$pervpage.'&nbsp;&nbsp;&nbsp;'.$page2left.'&nbsp;&nbsp;&nbsp;'.$page1left.'&nbsp;&nbsp;&nbsp;'.'<b>'.$pageSet.'</b>'.'&nbsp;&nbsp;&nbsp;'.$page1right.'&nbsp;&nbsp;&nbsp;'.$page2right.'&nbsp;&nbsp;&nbsp;'.$nextpage . '</p>'; ?>



