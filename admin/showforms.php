<?php
if (isset($_GET['fullform'])){
    require_once(__DIR__ . '/forms.php');
    exit();
}


if (isset($_GET['delform'])){
    $wpdb->query("DELETE FROM `".$this->tbl_unicat."unicat_forms` WHERE id='".$_GET['delform']."'");
}



if (isset($_GET['createnewform'])){
         if ((isset($_POST['act']))&&($_POST['act']=='Create')){
            $wpdb->insert(($this->tbl_unicat.'unicat_forms'), array('mail'=>$_POST['newMail'],'formname'=>$_POST['newForm'],'fromform'=>$_POST['fromform'], 'pubdays'=>$_POST['pubdays']));
        } else {
        require_once(__DIR__ . '/createform.php');
        exit;
         }
}
$_SERVER['REQUEST_URI']=preg_replace('#\&(.*)#','',$_SERVER['REQUEST_URI']);
?>
<div style="padding-right: 20px;">
<div class="wrap" >
<img src="<?php print $this->plugin_url; ?>admin/images/form.png" class="SFfloatleft">
<h2>Формы <a class="add-new-h2" href="<?php print 'http://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'].'&createnewform=1'; ?> ">Добавить новую</a></h2>
</div>
<table class="wp-list-table widefat fixed posts">
    <thead>
        <tr><th width="50">№</th><th class="manage-column column-title">Название</th><th class="manage-column column-title">e-mails</th></tr>
    </thead>
    <tbody>
    <?php

    $result=$wpdb->get_results("SELECT `id`, `formname`, `mail` FROM `".$this->tbl_unicat."unicat_forms`", ARRAY_A);
    for ($i=0;$i<count($result);$i++){
        print '<tr><td class="post-title page-title column-title">'.($i+1).'</td><td class="post-title page-title column-title">'.$result[$i]['formname'].'<div><a href="http://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'].'&fullform='.$result[$i]['id'].'">Изменить</a> | <a href="http://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'].'&delform='.$result[$i]['id'].'">Удалить</a></div></td><td class="post-title page-title column-title">'.$result[$i]['mail'].'</td></tr>';
    }


    ?>
    </tbody>
    <tfoot>
    <tr><th class="manage-column column-cb check-column"></th><th class="manage-column column-title ">Название</th><th class="manage-column column-title ">e-mails</th></tr>
    </tfoot>
</table>
</div>
<script type="text/javascript">
    window.history.pushState(null, null, window.location.href.replace(new RegExp("&(.*)",''),''));
</script>
