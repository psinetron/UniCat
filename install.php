<?php
            global $wpdb; //Переменная для работы с БД
            $table = $this->tbl_unicat; //Выбираем таблицу, с которой мы будем работать
            // Определение версии mysql
            if ( version_compare(mysql_get_server_info(), '4.1.0', '>=') ) {
                if ( ! empty($wpdb->charset) )
                    $charset_collate = "DEFAULT CHARACTER SET $wpdb->charset";
                if ( ! empty($wpdb->collate) )
                    $charset_collate .= " COLLATE $wpdb->collate";
            }
            // Структура нашей таблицы для отзывов
            $sql_table1 = "
               CREATE TABLE IF NOT EXISTS `".$table."unicat_fields` (
              `id` int(255) unsigned NOT NULL AUTO_INCREMENT,
              `postsid` int(255) NOT NULL,
              `fieldtype` varchar(255) DEFAULT NULL,
              `fielddata` text,
              `objtype` varchar(255) DEFAULT NULL,
              PRIMARY KEY (`id`),
              KEY `postsid` (`postsid`)
              ) ENGINE=InnoDB ".$charset_collate." AUTO_INCREMENT=1;
              ";
            $sql_table2="CREATE TABLE IF NOT EXISTS `".$table."unicat_forms` (
              `id` int(255) NOT NULL AUTO_INCREMENT,
              `inputform` text,
              `outputform` text,
              `findform` text,
              `podrobnoform` text,
              `allok` text,
               `mail` VARCHAR( 255 ) NULL,
                `formname` VARCHAR( 255 ) NULL,
                `fromform` int(255) NULL,
                `pubdays` int(5) DEFAULT '0',
              PRIMARY KEY (`id`),
              KEY `id` (`id`)
            ) ENGINE=InnoDB ".$charset_collate." AUTO_INCREMENT=1;";

            $sql_table3="CREATE TABLE IF NOT EXISTS `".$table."unicat_posts` (
              `id` int(255) NOT NULL AUTO_INCREMENT,
              `formsid` int(255) DEFAULT NULL,
              `userid` int(255) DEFAULT NULL,
              `userlogin` varchar(255) DEFAULT 'Anonim',
              `postdate` int(20) DEFAULT 0,
              `endpub` int(20) DEFAULT 0,
              `moderated` int(10) DEFAULT NULL,
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB ".$charset_collate." AUTO_INCREMENT=1;";



            $sql_table4="CREATE TABLE IF NOT EXISTS `".$table."unicat_list` (
              `id` int(255) NOT NULL AUTO_INCREMENT,
              `fieldname` varchar(255) DEFAULT NULL,
              `content` varchar(255) DEFAULT NULL,
              `contact` varchar(255) DEFAULT '0',
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB ".$charset_collate." AUTO_INCREMENT=1;";



            $sql_table5="CREATE TABLE IF NOT EXISTS `".$table."unicat_settings` (
              `id` int(255) NOT NULL AUTO_INCREMENT,
              `postkey` varchar(255) DEFAULT NULL,
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB ".$charset_collate." AUTO_INCREMENT=1;";


            $sql_table6="CREATE TABLE IF NOT EXISTS `".$table."unicat_fld` (
              `id` int(255) NOT NULL AUTO_INCREMENT,
              `forma` int(255) DEFAULT NULL,
              `name` varchar(255) DEFAULT NULL,
              `params` text,
              `hint` text,
              `poltype` varchar(255) DEFAULT NULL,
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB ".$charset_collate." AUTO_INCREMENT=1;";

            // Проверка на существование таблицы
            if ( $wpdb->get_var("show tables like '".$table."unicat_fields'") != $table.'unicat_fields' ) {
                dbDelta($sql_table1); //Если нашей таблицы не существует - создаем ее
            }

            if ($wpdb->get_var("show tables like '".$table."unicat_forms'") != $table.'unicat_forms'){
                dbDelta($sql_table2);
                dbDelta("INSERT INTO `".$table."unicat_forms` (`id`, `inputform`, `outputform`, `formname`, `fromform`,`pubdays`) VALUES (1, 'Код таблицы', NULL, 'Форма 1','0', '30');");
            }

            if ( $wpdb->get_var("show tables like '".$table."unicat_posts'") != $table.'unicat_posts' ) {
                dbDelta($sql_table3); //Если нашей таблицы не существует - создаем ее
            }

            if ( $wpdb->get_var("show tables like '".$table."unicat_list'") != $table.'unicat_list' ) {
                dbDelta($sql_table4); //Если нашей таблицы не существует - создаем ее
            }

            if ( $wpdb->get_var("show tables like '".$table."unicat_settings'") != $table.'unicat_settings' ) {
                dbDelta($sql_table5); //Если нашей таблицы не существует - создаем ее
                dbDelta("INSERT INTO `".$table."unicat_settings` (`id`, `postkey`) VALUES (1, '". md5(rand(100,100000).microtime().time())  ."');");
            }

            if ( $wpdb->get_var("show tables like '".$table."unicat_fld'") != $table.'unicat_fld' ) {
                dbDelta($sql_table6); //Если нашей таблицы не существует - создаем ее
            }
 ?>