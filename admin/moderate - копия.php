<?php

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
        $wpdb->query("UPDATE `" . $this->tbl_unicat . "sales_unicat` SET `moderated`='0', `postdate`=".time()." WHERE id='".$_POST['postid'][$i]."'");
    }
}



?>









<h1>Модерация данных</h1>
Фильтр<br/>
<form method="POST">
<select name="showfilter" id="showfltr">
    <?php
    $dopReq='';

    if (!isset($_POST['showfilter'])){$_POST['showfilter']='nopub';}
    if ((isset($_POST['showfilter'])&&($_POST['showfilter']=='all'))){print '<option selected="selected" value="all">Все записи</option>'; $dopReq='';} else {print '<option value="all">Все записи</option>';}
    if ((isset($_POST['showfilter'])&&($_POST['showfilter']=='nopub'))){print '<option selected="selected" value="nopub">Неопубликованные</option>'; $dopReq=" WHERE moderated='0'";} else {print '<option value="nopub">Неопубликованные</option>';}
    if ((isset($_POST['showfilter'])&&($_POST['showfilter']=='pub'))){print '<option selected="selected" value="pub">Опубликованные</option>'; $dopReq=" WHERE moderated='1'";} else {print '<option value="pub">Опубликованные</option>';}
    ?>
</select>
    <input type="submit" value="Показать" class="button" />
</form>
<br/>Действия с отмеченными:<br/>
<form method="POST" id="formallspeed" onsubmit="return speedform()">
<select name="otmech">
    <option value="delete">Удалить</option>
    <option value="publicate" selected="selected">Опубликовать</option>
    <option value="depublicate">Снять с публикации</option>
</select>
    <input type="submit" class="button" />
</form>
<span onclick="FSChexkAll()">Отметить все</span> / <span onclick="FSUnChexkAll()">Снять выделения</span> / <span onclick="FSChexkInvert()">Инвертировать</span>


    <?php
    //Постраничная навигация
    $pagesnum=$wpdb->get_var("SELECT COUNT(*) FROM `" . $this->tbl_unicat . "unicat_posts` WHERE formsid=1 LIMIT 1");
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
    echo '<p>Страницы: '.$pervpage.'&nbsp;&nbsp;&nbsp;'.$page2left.'&nbsp;&nbsp;&nbsp;'.$page1left.'&nbsp;&nbsp;&nbsp;'.'<b>'.$pageSet.'</b>'.'&nbsp;&nbsp;&nbsp;'.$page1right.'&nbsp;&nbsp;&nbsp;'.$page2right.'&nbsp;&nbsp;&nbsp;'.$nextpage . '</p>';





    <table class="wp-list-table widefat fixed pages UniCaTforms-table" width="400">
    <thead>
    <tr><th class="manage-column column-cb"></th><th class="manage-column column-title">Название</th></tr>
    </thead>
    <tbody>
    <tr><td>Название формы: </td><td><input type="text" name="newForm"></td></tr>
    <tr><td> e-mail уведомлений:</td><td><input type="text" name="newMail"></td></tr>
    <tr><td>Количество дней публикации:</td><td><input type="text" onkeyup="onlyNumbers(this)" value="30" name="pubdays"></td></tr>
    </tbody>
</table>





    print '<table class="moderTable" border="0">';
    $code=$wpdb->get_var("SELECT `outputform` FROM `" . $this->tbl_unicat . "unicat_forms` WHERE id=1 LIMIT 1");
    $codeinp=$wpdb->get_var("SELECT `inputform` FROM `" . $this->tbl_unicat . "unicat_forms` WHERE id=1 LIMIT 1");
    $posts=$wpdb->get_results("SELECT * FROM `" . $this->tbl_unicat . "unicat_posts` ".$dopReq." ORDER BY moderated ASC, postdate DESC LIMIT ".$start.",".$pagemax, ARRAY_A);
    for ($i=0;$i<count($posts);$i++){
        if ($posts[$i]['moderated']=='1'){$moderatedText='Опубликовано'; $tbodyclass="SFPublished";} else {$moderatedText='Не опубликовано';$tbodyclass="SFUnpublished";}
        print '<tbody class="'.$tbodyclass.'"><tr>

        <td width="10"><input type="checkbox" value="'.$posts[$i]['id'].'" name="ShortSnd" /></td>
        <form action="" id="" method="POST"><td>';
        $fields=$wpdb->get_results("SELECT * FROM `" . $this->tbl_unicat . "unicat_fields` WHERE `postsid`=" . $posts[$i]['id'] , ARRAY_A);
        $codeRepl=$code;
        for($i1=0;$i1<count($fields);$i1++){
            $needType=preg_match('#(\[SForm.*?)((?<=type:")(.*?)(?="))(.*?name:"'.$fields[$i1]['fieldtype'].'".*?\])#',$codeinp,$findtype);
            switch ($findtype[3]){
                case "text":$prevtag='<input type="text" name="'.$fields[$i1]['fieldtype'].'" value="';$endtag='" />';break;
                case "textarea":$prevtag='<textarea name="'.$fields[$i1]['fieldtype'].'">';$endtag='</textarea>';break;
                default:    $prevtag='';$endtag='';break;
            }
            $codeRepl=str_replace('[SForm name="'.$fields[$i1]['fieldtype'].'"]',$prevtag.$fields[$i1]['fielddata'].$endtag,$codeRepl);
        }
        $codeRepl=preg_replace('#\[SForm name="(.*)"\]#','',$codeRepl); //Убираем теги с несуществующими полями
        $codeRepl=str_replace('[SForm date]', date('d.m.Y H:i',$posts[$i]['postdate']), $codeRepl);//Вставляем дату
        $codeRepl=str_replace('[SForm user]', $posts[$i]['userlogin'], $codeRepl);//Вставляем имя пользователя
        print $codeRepl;

        print '</td>
        <td class="moderTableRightTD">

            <div>'.$moderatedText.'</div>
            <input type="submit" class="button action" value="Сохранить данные"><br/>
            <input type="checkbox" checked name="SFmoder" value="1" id="moder">Опубликовать
            <input type="hidden" name="act" value="Moderate">
            <input type="hidden" name="SFPostNum" value="'.$posts[$i]['id'].'">
            <br/><br/><br/><br/>
            <input type="submit" class="button action" name="DeleteZap" value="Удалить запись"><br/>
        </td>

        </form>
    </tr></tbody>';

    }

    ?>

</table>

<?php echo '<p>Страницы: '.$pervpage.'&nbsp;&nbsp;&nbsp;'.$page2left.'&nbsp;&nbsp;&nbsp;'.$page1left.'&nbsp;&nbsp;&nbsp;'.'<b>'.$pageSet.'</b>'.'&nbsp;&nbsp;&nbsp;'.$page1right.'&nbsp;&nbsp;&nbsp;'.$page2right.'&nbsp;&nbsp;&nbsp;'.$nextpage . '</p>'; ?>



