<?php

/*
Plugin Name: UniCat
Plugin URI: http://slybeaver.ru/
Description: Плагин произвольных форм
Version: 0.0.1
Author: psinetron
Author URI: http://slybeaver.ru/
*/


// Stop direct call
if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); }

if (!class_exists('TestPluginFail')) {
    class UnicatExL {

        //Конструктор класса
        function UnicatExL(){

            global $wpdb;

            require_once(ABSPATH . 'wp-admin/includes/upgrade.php'); //Подгружаем функции для работы с БД
            $this->plugin_name = plugin_basename(__FILE__);

            $this->plugin_url = trailingslashit(WP_PLUGIN_URL.'/'.dirname(plugin_basename(__FILE__)));
            $this->tbl_unicat   = $wpdb->prefix; //Таблица
            $this->filesupl=__DIR__ .'/files/'; //место загрузки файлов
            $this->maindir=__DIR__;
            $this->countunmoder=$wpdb->get_var("SELECT COUNT(*) FROM `".$wpdb->prefix."unicat_posts` WHERE `moderated`='0'");
            //$this->curr_user= wp_get_current_user();

            register_activation_hook( $this->plugin_name, array(&$this, 'activate') ); //Активация плагина
            register_deactivation_hook( $this->plugin_name, array(&$this, 'deactivate') ); //Деактивация плагина
            register_uninstall_hook( $this->plugin_name, array(__FILE__, 'uninstall_my_plugin') ); //Удаление плагина

            // Если мы в адм. интерфейсе
            if ( is_admin() ) {
                add_action('admin_menu', array(&$this, 'admin_generate_menu')); //Генерация меню
                add_action('init', array(&$this, 'admin_load_styles')); //Подключаем админские стили
                add_action('wp_print_scripts', array(&$this, 'admin_load_scripts')); //Подключаем админские скрипты
                add_action('wp_ajax_writeselect', array(&$this,'write_select')); //Запись содержимого селекта
                add_action('wp_ajax_getselect', array(&$this,'get_select')); //Получение содержимого селекта
                add_action('admin_bar_menu', array($this, "up_links"), 100); //Ссылка в верхнем меню (Admin Bar)
                add_action('wp_ajax_writePOLE', array(&$this,'write_POLE')); //Запись поля
                add_action('wp_ajax_getPOLE', array(&$this,'get_POLE')); //Чтение полей
                add_action('wp_ajax_ShowAdmHint', array(&$this,'ShowAdmHint')); //Показываем подсказку
                add_action('wp_ajax_AdmSaveAllForms', array(&$this,'AdmSaveAllFormsw')); //Чтение полей
                add_action('wp_ajax_deletePoleAdm', array(&$this,'AdmDeletePole')); //Удаление поля
                require_once(__DIR__ . '/admin/filter.php');
                wp_enqueue_script('tiny_mce', get_option('siteurl') . '/wp-includes/js/tinymce/tiny_mce.js', false, '3');

            } else {
                // Добавляем стили и скрипты
                add_action('wp_print_scripts', array(&$this, 'user_load_scripts'));
                add_action('init', array(&$this, 'user_load_styles'));
                require_once(__DIR__ . '/user/filter.php');
                add_shortcode('UniCat', array (&$this, 'site_show_forms'));
            }

            add_action('wp_ajax_nopriv_getchildren', array(&$this, 'getchildrenselect'));
            add_action('wp_ajax_getchildren', array(&$this, 'getchildrenselect'));
            add_action('wp_ajax_nopriv_showhiddenpodsk', array(&$this, 'showvballon'));
            add_action('wp_ajax_showhiddenpodsk', array(&$this, 'showvballon'));
            wp_register_style('UniCat-main-style',WP_PLUGIN_URL. '/unicat/mainstyle.css' );
            wp_enqueue_style('UniCat-main-style');
            wp_enqueue_script("jquery");


        }



        /**
         * Работаем с котортким кодом
         */
        function site_show_forms($atts, $content=null, $moderated=0){
            global $wpdb;
            if (( $atts['formtype']=="inp")||($atts['formtype']=="fnd")){
            $current_user = wp_get_current_user();
            $allfromform=$wpdb->get_results("SELECT * FROM `" . $this->tbl_unicat . "unicat_forms` WHERE `id`='".$atts['id']."' LIMIT 1", ARRAY_A);
            $code=$allfromform[0]['inputform'];
            if ($atts['formtype']=="fnd"){$code=$allfromform[0]['findform'];}
            $mails=$allfromform[0]['mail'];
            $maxpubdays=$allfromform[0]['pubdays'];

            $code='<form method="POST" enctype="multipart/form-data" onsubmit="return FSAllCorrect(this);">'.$code.'</form>';
                $codefind=array();
                $coderepl=array();
            require(__DIR__ . '/admin/addzap.php');

            $mails=explode('; ',$mails);

            for ($i=0;$i<count($mails);$i++){
                if (preg_match('#^(.*)@(.+)\.(.+)$#',$mails[$i])){
                    mail($mails[$i],"Новое объявление на модерацию", "Имеется новое объявление на модерацию", 'From: webmaster@' . str_replace('www.','',$_SERVER['HTTP_HOST']).'\r\n');
                }
            }


            if ((isset($_POST['withoutmoder']))&&($_POST['withoutmoder']=="needwrite")){

                require(__DIR__ . '/admin/withoutadmin.php');
            }



            return str_replace($codefind,$coderepl,$code);
            }

            if (($atts['formtype']=="posts")||($atts['formtype']=="full")){

                require(__DIR__ . '/showforms.php');
                return $result;
            }

        }



        function getchildrenselect(){
            global $wpdb;
            require_once(__DIR__ . '/user/getchildren.php');
            die();
        }



        /**
         * Скрипты для пользователя
         */
        function user_load_scripts(){
            wp_register_script('plugin_scripts', WP_PLUGIN_URL. '/unicat/user/js/scripts.js' );
            wp_enqueue_script('plugin_scripts');

            wp_enqueue_script( 'jquery' );
            wp_enqueue_script( 'jquery-ui-core' );
            wp_enqueue_script( 'jquery-datepicker', WP_PLUGIN_URL. '/unicat/user/js/jquery.ui.datepicker.js', array('jquery', 'jquery-ui-core' ) );
            wp_enqueue_script( 'jquery-language', WP_PLUGIN_URL. '/unicat/user/js/jquery.ui.datepicker-ru.js', array('jquery', 'jquery-ui-core' ) );





            wp_localize_script( 'plugin_scripts', 'ajaxurluser',
                array(
                    'url' => admin_url('admin-ajax.php'),
                    'loadingimage' =>WP_PLUGIN_URL. '/unicat/user/images/ajax-loader.gif'
                ));
        }

        /**
         * Загружаем стили для пользователя
         */
        function user_load_styles(){
            wp_register_style('plugin_style',WP_PLUGIN_URL. '/unicat/user/css/style.css' );
            wp_register_style('plugin_datapicker',WP_PLUGIN_URL. '/unicat/user/css/ui-lightness/jquery-ui-1.10.3.custom.css' );
            wp_enqueue_style('plugin_style');
            wp_enqueue_style('plugin_datapicker');
            wp_localize_script( 'plugin_scripts', 'ajaxurluser',
                array(
                    'url' => admin_url('admin-ajax.php'),
                    'loadingimage' =>WP_PLUGIN_URL. '/salesForm/sales-form/user/images/ajax-loader.gif'
                ));
        }


        /**
         * Показываем подсказу в админке
         */
         function ShowAdmHint(){
             global $wpdb;
             print htmlspecialchars($wpdb->get_var("SELECT `hint` FROM `" . $this->tbl_unicat . "unicat_fld` WHERE id='".intval($_POST['values'])."'"));
         }

        /*
         * Удаляем поле
         */

        function AdmDeletePole(){
            global $wpdb;
            $wpdb->query("DELETE FROM `" . $this->tbl_unicat . "unicat_fld` WHERE id='".intval($_POST['plid'])."'");
            $result=$wpdb->get_results("SELECT * FROM `".$this->tbl_unicat."unicat_fld` WHERE `forma`='".$_POST['forma']."' ORDER BY `forma`", ARRAY_A);
            for ($i=0;$i<count($result);$i++){
                print '<option value="'.$result[$i]['id'].htmlspecialchars($result[$i]['params']).'">'.$result[$i]['name'].'</option>';
            }
            die();
        }



        /**
         * Загружаем стили для админа
         */
        function admin_load_styles(){
            wp_register_style('unicatadm_style',WP_PLUGIN_URL. '/unicat/admin/css/style.css' );
            wp_enqueue_style('unicatadm_style');
        }


        /**
         * Загружаем яваскрипты
         */
        function admin_load_scripts(){
            wp_register_script('plugin_scripts', WP_PLUGIN_URL. '/unicat/admin/js/scripts.js' );
            wp_enqueue_script('plugin_scripts');
            wp_localize_script( 'plugin_scripts', 'ajaxurluser',
                array(
                    'url' => admin_url('admin-ajax.php'),
                    'loadingimage' =>WP_PLUGIN_URL. '/salesForm/sales-form/user/images/ajax-loader.gif'
                ));
        }


        /**
         * Показываем всю форму
         */
        function fullform(){
            print 'aaaaa';
        }

        /**
         * Активация плагина
         */
        function activate(){//Активация плагина
            require_once(__DIR__ . '/install.php');
        }

        /**
         * Деактивация плагина
         */
        function deactivate(){ //Деактивация плагина
            return true;
        }

        /****
         * Генерируем меню для админки
         */
        function admin_generate_menu()
        {

        if ($this->countunmoder>0){$dop=$this->countunmoder;} else {$dop='';}
            add_menu_page('uuicct', 'UniCat' .  '<span class="awaiting-mod "><span class="pending-count">'.$dop .'</span></span>', 'manage_options', 'unicat', array(&$this, 'moderate'), WP_PLUGIN_URL.'/unicat/admin/images/menu-icon.png',6);
            add_submenu_page('unicat', 'Формы', 'Формы', 'manage_options', 'unicat-forms', array(&$this,'admin_edit_forms'));
            add_submenu_page('unicat', 'Импорт/экспорт', 'Импорт / экспорт', 'manage_options', 'unicat-export', array(&$this,'savegetsettings'));
            add_submenu_page('unicat', 'Как пользоваться', 'Помощь', 'manage_options', 'unicat-help', array(&$this,'showhelp'));
        }


        /*
         * Помощь по плагину
         */
        function showhelp(){
            require_once(__DIR__.'/help.php');

        }



        /*
         * Админка - управление формами
         */
        function admin_edit_forms(){
            global $wpdb;
            require_once(__DIR__ . '/admin/showforms.php');
        }

        /**
         * Модерация данных
         */
        function moderate(){
            global $wpdb;
            require_once(__DIR__ . '/admin/moderate.php');
        }



        function savegetsettings(){
            global $wpdb;
            require_once(__DIR__ . '/admin/savesettings.php');
        }



        /**
         * Аяксовая функция записываем значения списка
         * @return string
         */
        function write_select(){
            global $wpdb;
            require_once(__DIR__ . '/admin/selectwritelist.php');
            die();
        }

        /*
         * Сохраняем все данные со всех форм в админке
         */
        function AdmSaveAllFormsw(){
            global $wpdb;



            $wpdb->update($this->tbl_unicat.'unicat_forms', array("inputform"=>stripslashes($_POST['forminputform']), "outputform"=>stripslashes($_POST['formpostsform']), "findform"=>stripslashes($_POST['formfindform']), "podrobnoform"=>stripslashes($_POST['formpodrobnoform']), "mail"=>stripslashes($_POST['formmails']), "formname"=>stripslashes($_POST['formname']), "pubdays"=>stripslashes($_POST['formpubdays']), "allok"=>stripslashes($_POST['formmessform'])), array("id"=>$_POST['forma']));
            die();
        }


        /**
         * Аяксовая функция
         * @return string
         */
        function get_select(){
            global $wpdb;
            require_once(__DIR__ . '/admin/selectgetlist.php');
            die();
        }

        /**
         * Записываем поля из админки
         */
        function write_POLE(){
            global $wpdb;
            $wpdb->insert(($this->tbl_unicat.'unicat_fld'), array("forma"=>$_POST['forma'], "name"=>$_POST['name'], "params"=>stripslashes($_POST['values']), "hint"=>$_POST['hint'], "poltype"=>$_POST['type']));
        }


        function get_POLE(){

            if (isset($_POST['dpzn'])){
                print '<option selected="selected" disabled="disabled" value="" >Выберите элемент</option>
                    <option value="SFdate" >Дата публикации(dd.mm.yyyy hh:mm)</option>
                    <option value="SFuser" >Имя пользователя</option>
                    <option value="SFpost" >Ссылка на пост</option>
                    <option value="SFpostid" >Идентификатор поста</option>
                    <option value="SFphp" >PHP код</option>
                    <option value="SFpubstat" >Статус публикации</option>';
            } else {print '<option value="" selected="selected"></option>';}

            global $wpdb;
            $result=$wpdb->get_results("SELECT * FROM `".$this->tbl_unicat."unicat_fld` WHERE `forma`='".$_POST['forma']."' ORDER BY `forma`", ARRAY_A);




            for ($i=0;$i<count($result);$i++){
                if (isset($_POST['dpzn'])){
                    $paster=htmlspecialchars('[SForm name="'.$result[$i]['name'].'"]');
                } else {
                    $paster=$result[$i]['id'].htmlspecialchars($result[$i]['params']);
                }
                print '<option value="'.$paster.'">'.$result[$i]['name'].'</option>';
            }
        }


        /**
         * Получаем значения всплывающей подсказки
         */
        function showvballon(){
            global $wpdb;
            require_once(__DIR__ . '/user/showvballon.php');
            die();
        }

        /**
         * Верхнее меню
         */
        function up_links() {
            global $wp_admin_bar;
            if ($this->countunmoder>0){$dop='<div class="AdminLinkUp">&nbsp</div>'.$this->countunmoder;} else {$dop='';}
            $wp_admin_bar->add_menu( array(
                'id' => 'UniCat',
                'title' => 'UniCat' . $dop,
                'href' => 'admin.php?page=unicat',
            ) );
            $wp_admin_bar->add_menu( array(
                'id'=>'UniCat-1',
                'parent' => 'UniCat',
                'title' => 'Формы',
                'href' => 'admin.php?page=unicat-forms',
                'meta' =>''
            ) );

        }

}
}
global $rprice;
$rprice = new UnicatExL ();

?>