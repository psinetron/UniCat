<?php
if ((isset($_POST['act']))&&($_POST['act']==2)){
    $wpdb->query("UPDATE `".$this->tbl_unicat."unicat_forms` SET `inputform`='".$_POST['MainAdminForm']."'  WHERE id='".$_POST['SeeForm']."'");
}

if ((isset($_POST['act']))&&($_POST['act']==7)){
    $wpdb->query("UPDATE `".$this->tbl_unicat."unicat_forms` SET `findform`='".$_POST['MainAdminForm']."'  WHERE id='".$_POST['SeeForm']."'");
}

if ((isset($_POST['act']))&&($_POST['act']==3)){
    $wpdb->query("UPDATE `".$this->tbl_unicat."unicat_forms` SET `outputform`='".$_POST['MainUserForm']."'  WHERE id='".$_POST['SeeForm']."';");
}

if ((isset($_POST['act']))&&($_POST['act']==8)){
    $wpdb->query("UPDATE `".$this->tbl_unicat."unicat_forms` SET `podrobnoform`='".$_POST['MainUserForm']."'  WHERE id='".$_POST['SeeForm']."';");
}

if ((isset($_POST['act']))&&($_POST['act']=='updateparams')){
    $wpdb->query("UPDATE `".$this->tbl_unicat."unicat_forms` SET `formname`='".$_POST['newForm']."', `mail`='".$_POST['newMail']."', `pubdays`='".$_POST['pubdays']."', `allok`='".htmlspecialchars($_POST['allok'])."'  WHERE id='".$_POST['SeeForm']."';");
}


$SeeForm=$_GET['fullform'];
?>

<script src="http://wp.gu/wp-content/plugins/unicat/codemirror/codemirror.js"></script>
<script src="http://wp.gu/wp-content/plugins/unicat/codemirror/mode/htmlmixed.js"></script>
<script src="http://wp.gu/wp-content/plugins/unicat/codemirror/mode/javascript.js"></script>
<script src="http://wp.gu/wp-content/plugins/unicat/codemirror/mode/css.js"></script>
<script src="http://wp.gu/wp-content/plugins/unicat/codemirror/mode/xml.js"></script>
<link rel="stylesheet" href="http://wp.gu/wp-content/plugins/unicat/codemirror/codemirror.css">

<script type="text/javascript">
var myCodeMirror=Array();
function showCodeMirror(objarea){
    if (myCodeMirror[objarea]){myCodeMirror[objarea].save();
        myCodeMirror[objarea].toTextArea()
    }

    myCodeMirror[objarea] = CodeMirror.fromTextArea(document.getElementById(objarea), {
        lineNumbers: true,               // показывать номера строк
        matchBrackets: true,             // подсвечивать парные скобки
        mode: {name: "htmlmixed"}, // стиль подсветки

        indentUnit: 4                    // размер табуляции
    });
}
</script>


<div style="padding-right: 20px;">

<img id="ajaxloading" src="<?php print WP_PLUGIN_URL. '/unicat/admin/images/'; ?>ajax-loader.gif" class="UniCatAjaxLoaded"/>
<div id="icon-themes" class="icon32">
    <br>
</div>
<h2 xmlns="http://www.w3.org/1999/html">Настройки формы</h2>
<div class="button button-primary button-large UniCatFixedTopRight" onclick="AdmSaveAllForms(this, '<?php print $SeeForm; ?>')">Сохранить все</div>
<form method="POST">
    <?php
    $params=$wpdb->get_results("SELECT * FROM `".$this->tbl_unicat."unicat_forms` WHERE `id`='".$SeeForm."' LIMIT 1",ARRAY_A);
    ?>
    <div align="right">
    <table class="wp-list-table widefat fixed pages UniCaTforms-table">
        <thead>
        <tr><th class="manage-column column-cb" width="200"></th><th class="manage-column column-title">Параметр</th></tr>
        </thead>
        <tbody>
        <tr><td>Название формы: </td><td><input type="text" class="UniCatFullWidth" id="AdmMainNameForm" name="newForm" value="<?php print $params[0]['formname'] ?>"></td></tr>
        <tr><td> e-mail модераторов:</td><td><input type="text" class="UniCatFullWidth" id="AdmMainMailsForm" name="newMail" value="<?php print $params[0]['mail'] ?>"></td></tr>
        <tr><td>Количество дней публикации:</td><td><input type="text" class="UniCatFullWidth" id="AdmMainPubDaysForms" onkeyup="onlyNumbers(this)" value="<?php print $params[0]['pubdays'] ?>" name="pubdays"></td></tr>
        <tr><td>Сообщение об успешном добавлении:</td><td><textarea class="UniCatFullWidth" id="AdmMainMessForm" name="allok"><?php print $params[0]['allok'] ?></textarea></td></tr>
        </tbody>
    </table>
        <input type="hidden" value="updateparams" name="act">
        <input type="hidden" value="<?php print $SeeForm ;?>" name="SeeForm">
    </div>

</form>



<h2>Содержимое форм</h2>




<div class="postbox metabox-holder">
<h3 onclick="SowHideUniCatForm('inputForm','','')" class=" hndle UniCatPointer"><span>Форма ввода данных</span><span class="UniCatAbsoluteCode">&nbsp;[UniCat <?php print 'id="'.$SeeForm . '" formtype="inp"'; ?>]&nbsp;</span></h3>

<div class="UniCatDefaulthidden" id="inputForm">

<div class="titlediv">
    <div class="codeediv">Скопируйте этот код и вставьте его в свой пост или страницу.<br/>[UniCat <?php print 'id="'.$SeeForm . '" formtype="inp"'; ?>]</div>
</div>





<form action="" method="POST" enctype="application/x-www-form-urlencoded" >
<input type="hidden" name="SeeForm" value="<?php print $SeeForm?>">

<table border="0" class="admin-table wp-list-table bordertable ">

    <tr>

        <td>

            <span>Код формы</span>
            <textarea class="inputFormsPosition" id="SFAdminForm" name="MainAdminForm"><?php echo htmlspecialchars($wpdb->get_var("SELECT `inputform` FROM `" . $this->tbl_unicat . "unicat_forms` WHERE id=".$SeeForm." LIMIT 1")); ?></textarea>

        </td>
        <td>

            <div>

            <span>Вставка полей</span>
            </div>
            <div class="categorydiv">
            <ul id="category-tabs" class="category-tabs">
                <li class="tabs" onclick="SF_tabsSelect(this, 'InpBee', 'InpPanelOld', 'InpPanelNew', '<?php print $SeeForm; ?>', '');" id="InpNew">Новое поле</li>
                <li onclick="SF_tabsSelect(this, 'InpNew', 'InpPanelNew', 'InpPanelOld', '<?php print $SeeForm; ?>', 'InpOldPole');" id="InpBee">Существующие поля</li>
            </ul>

<div class="tabs-panel" style="max-height: 1000px;" id="InpPanelNew"><br/>
            <select onchange="SF_showMenuAdd(this, 'formscreater')" onclick="SF_showMenuAdd(this, 'formscreater')">
                <option selected="selected" disabled="disabled" >Выберите элемент</option>
                <option value="menuSimpleText">Короткий текст</option>
                <option value="menuNumber">Число</option>
                <option value="menuTextArea">Длинный текст</option>
                <option value="menuSelect">Строгий список</option>
                <option value="menuTextAjax">Текст с подсказкой</option>
                <option value="menuImageLoad">Загрузка изображений</option>
                <option value="menuRadio">Переключатель</option>
                <option value="menuCheckbox">Чекбокс</option>
                <option value="menuDatapicker">Срок публикации</option>
                <option value="menuSubmitButton">Кнопка "Отправить"</option>
            </select>

            <div class="formscreater" id="menuSimpleText">
            <strong>Текстовое поле</strong><br>

                <div class="codeediv">
                    пример:<br/>
                <input type="text" placeholder="Короткий текст">
                    </div>
                   <br/><br/>
            <strong>Параметры:</strong><br/>
                <table border="0" class="innerTable">
                    <tr><td>
                            Name (обязательно)<br/>
                            <input type="text" value="" placeholder="Name" id="NameSimpleText"><br/><br/>
                            id (не обязательно)<br/>
                            <input type="text" value="" placeholder="id" id="IdSimpleText"><br/><br/>
                            Значение по умолчанию (не обязательно)<br/>
                            <input type="text" value="" placeholder="Значение по умолчанию" id="ValueSimpleText"><br/><br/>
                            Обязательное поле? (не обязательно)<br/>
                            <input type="checkbox" id="ObzSimpleText"><br/><br/>
                        </td>
                <td>
                class (не обязательно)<br/>
                <input type="text" value="" placeholder="имя класса" id="ClassSimpleText"><br/><br/>
                maxlength (не обязательно)<br/>
                <input type="text" value="" placeholder="числовое значение" id="MaxLenSimpleText"><br/><br/>
                Подсказка (не обязательно)<br/>
                <input type="text" value="" placeholder="подсказка" id="PlaceholdSimpleText"><br/><br/>
                </td>
                    </tr>
                </table>

                Описание поля<br/>
                <textarea id="hintSimpleText" class="UniCatFullWidth"></textarea>

            <div class="button action" onclick="SF_add_simpleText('SFAdminForm', '', '<?php print $SeeForm; ?>')">Вставить</div>

            </div>

            <div class="formscreater" id="menuDatapicker">
                <strong>Поле с указанием срока публикации</strong><br>
                <br/><br/>
                <strong>Параметры:</strong><br/>
                <table border="0" class="innerTable">
                    <tr><td>
                            class (не обязательно)<br/>
                            <input type="text" value="" placeholder="имя класса" id="ClassDataPicker"><br/><br/>
                        </td>
                        <td>

                        </td>
                    </tr>
                </table>
                <div class="button action" onclick="SF_add_datapicker('SFAdminForm', '')">Вставить</div>
            </div>

            <div class="formscreater" id="menuNumber">
                <strong>Числовое поле</strong><br>
                 <div class="codeediv">
                    пример:<br/>
                <input type="text" placeholder="Короткий текст">
                    </div>
                <br/><br/>
                <strong>Параметры:</strong><br/>
                <table border="0" class="innerTable">
                    <tr><td>
                            Name (обязательно)<br/>
                            <input type="text" value="" placeholder="Name" id="NameNumber"><br/><br/>
                            id (не обязательно)<br/>
                            <input type="text" value="" placeholder="id" id="IdNumber"><br/><br/>
                            Значение по умолчанию (не обязательно)<br/>
                            <input type="text" value="" placeholder="Значение по умолчанию" id="ValueNumber"><br/><br/>
                            Привязано к полю (не обязательно)(для поиска)<br/>
                            <input type="text" value="" placeholder="name поля к которому будем ровняться" id="ValuePole"><br/><br/>
                            Обязательное поле? (не обязательно)<br/>
                            <input type="checkbox" id="ObzNumber"><br/><br/>
                        </td>
                        <td>
                            class (не обязательно)<br/>
                            <input type="text" value="" placeholder="имя класса" id="ClassNumber"><br/><br/>
                            maxlength (не обязательно)<br/>
                            <input type="text" value="" placeholder="числовое значение" id="MaxLenNumber"><br/><br/>
                            Подсказка (не обязательно)<br/>
                            <input type="text" value="" placeholder="подсказка" id="PlaceholdNumber"><br/><br/>
                            Логика привязки (не обязательно)<br/>
                            <select id="LogicNumber">
                                <option value="equally" selected="selected">равно</option>
                                <option value="more">больше либо равно</option>
                                <option value="less">меньше либо равно</option>
                            </select>

                            <br/><br/>

                        </td>
                    </tr>
                </table>
                Описание поля<br/>
                <textarea id="hintNumber" class="UniCatFullWidth"></textarea>
                <input type="hidden" value="" name="sform">
                <div class="button action" onclick="SF_add_number('SFAdminForm', '', '<?php print $SeeForm; ?>')">Вставить</div>

            </div>

            <div class="formscreater" id="menuCheckbox">
                <strong>Чекбокс</strong><br>
                <div class="codeediv">
                пример:<br/>
                <input type="checkbox">
                    </div>
                <br/><br/>
                <strong>Параметры:</strong><br/>
                <table border="0" class="innerTable">
                    <tr><td>
                            Name (обязательно)<br/>
                            <input type="text" value="" placeholder="Name" id="NameCheckBox"><br/><br/>
                            id (не обязательно)<br/>
                            <input type="text" value="" placeholder="id" id="IdCheckBox"><br/><br/>
                            Значение по умолчанию <br/>
                            <input type="checkbox" id="CheckedCheckbox"><br/><br/>
                        </td>
                        <td>
                            class (не обязательно)<br/>
                            <input type="text" value="" placeholder="имя класса" id="ClassCheckBox"><br/><br/>
                        </td>
                    </tr>
                </table>
                Описание поля<br/>
                <textarea id="hintCheckbox" class="UniCatFullWidth"></textarea>
                <div class="button action" onclick="SF_add_CheckBox('SFAdminForm', '', '<?php print $SeeForm; ?>')">Вставить</div>
            </div>

            <div class="formscreater" id="menuRadio">
                <strong>Переключатель</strong><br>
                <div class="codeediv">
                пример:<br/>
                <input type="radio">
                    </div>
                <br/><br/>
                <strong>Параметры:</strong><br/>
                <table border="0" class="innerTable">
                    <tr><td>
                            Name (обязательно)<br/>
                            <input type="text" value="" placeholder="Name" id="NameRadio"><br/><br/>
                            Значение (обязательно)<br/>
                            <input type="text" value="" placeholder="Value" id="ValueRadio"><br/><br/>
                            id (не обязательно)<br/>
                            <input type="text" value="" placeholder="id" id="IdRadio"><br/><br/>
                            Значение по умолчанию <br/>
                            <input type="checkbox" id="CheckedRadio"> вкл<br/><br/>
                        </td>
                        <td>
                            class (не обязательно)<br/>
                            <input type="text" value="" placeholder="имя класса" id="ClassRadio"><br/><br/>
                        </td>
                    </tr>
                </table>
                Описание поля<br/>
                <textarea id="hintRadio" class="UniCatFullWidth"></textarea>
                <div class="button action" onclick="SF_add_Radio('SFAdminForm', '', '<?php print $SeeForm; ?>')">Вставить</div>
            </div>

            <div class="formscreater" id="menuTextArea">
                <strong>Многострочное текстовое поле</strong><br>
                <div class="codeediv">
                пример:<br/>
                <textarea placeholder="Многострочное текстовое поле
                "></textarea>
                    </div>
                <br/><br/>
                <strong>Параметры:</strong><br/>
                <table border="0" class="innerTable">
                    <tr><td>
                            Name (обязательно)<br/>
                            <input type="text" value="" placeholder="Name" id="NameTextArea"><br/><br/>
                            id (не обязательно)<br/>
                            <input type="text" value="" placeholder="id" id="IdTextArea"><br/><br/>
                            Значение по умолчанию (не обязательно)<br/>
                            <input type="text" value="" placeholder="Значение по умолчанию" id="ValueTextArea"><br/><br/>
                            Обязательное поле? (не обязательно)<br/>
                            <input type="checkbox" id="ObzTextArea"><br/><br/>
                        </td>
                        <td>
                            class (не обязательно)<br/>
                            <input type="text" value="" placeholder="имя класса" id="ClassTextArea"><br/><br/>
                            maxlength (не обязательно)<br/>
                            <input type="text" value="" placeholder="числовое значение" id="MaxLenTextArea"><br/><br/>
                            Подсказка (не обязательно)<br/>
                            <input type="text" value="" placeholder="подсказка" id="PlaceholdTextArea"><br/><br/>
                        </td>
                    </tr>
                </table>

                Описание поля<br/>
                <textarea id="hintTextArea" class="UniCatFullWidth"></textarea>
                <div class="button action" onclick="SF_add_TextArea('SFAdminForm', '', '<?php print $SeeForm; ?>')">Вставить</div>

            </div>

            <div class="formscreater" id="menuImageLoad">
                <strong>Загрузка изображений</strong><br>
                <div class="codeediv">
                пример:<br/>
                <input type="file" accept="image/jpeg,image/png,image/gif">
                    </div>
                <br/><br/>
                <strong>Параметры:</strong><br/>
                <table border="0" class="innerTable">
                    <tr><td>
                            Name (не обязательно)<br/>
                            <input type="text" value="" placeholder="Name" id="NameImageLoad"><br/><br/>
                            id (не обязательно)<br/>
                            <input type="text" value="" placeholder="id" id="IdImageLoad"><br/><br/>
                            class (не обязательно)<br/>
                            <input type="text" value="" placeholder="имя класса" id="ClassImageLoad"><br/><br/>
                        </td>
                        <td>
                            <select id="resizeimage">
                                <option value="">Оставлять исходный размер</option>
                                <option value="resize">Изменить размер изображения</option>
                            </select>
                            <div>
                                Ширина <input type="text" id="WidthImage"> px<br/>
                                Высота <input type="text" id="HeightImage"> px<br/>
                            </div>
                            <br/><br/>
                            <input type="checkbox" id="watermarkImage"> Вставить водяной знак

                        </td>
                    </tr>
                </table>
                Описание поля<br/>
                <textarea id="hintImageLoad" class="UniCatFullWidth"></textarea>
                <div class="button action" onclick="SF_add_ImageLoad('SFAdminForm', '', '<?php print $SeeForm; ?>')">Вставить</div>
            </div>

            <div class="formscreater" id="menuTextAjax">
                <strong>Текстовое поле с Ajax подсказкой</strong><br>
                <div class="codeediv">
                пример:<br/>
                <input type="text">
                    </div>
                <br/><br/>
                <strong>Параметры:</strong><br/>
                <table border="0" class="innerTable">
                    <tr><td>
                            Name (обязательно)<br/>
                            <input type="text" value="" placeholder="Name" id="NameTextAjax"><br/><br/>
                            id (не обязательно)<br/>
                            <input type="text" value="" placeholder="id" id="IdTextAjax"><br/><br/>
                            Значение по умолчанию (не обязательно)<br/>
                            <input type="text" value="" placeholder="Значение по умолчанию" id="ValueTextAjax"><br/><br/>
                            Значение для поиска подсказки<br/>
                            <input type="text" id="FieldTextAjax" value=""><br/>
                            <select onchange="document.getElementById('FieldTextAjax').value=this.value">
                                <option value="" selected="selected">без подсказок</option>
                                <?php
                                $result=$wpdb->get_results("SELECT `fieldtype` FROM `" . $this->tbl_sales_form . "sales_form_fields` GROUP BY `fieldtype`",ARRAY_A);
                                for ($i=0;$i<count($result);$i++){
                                    print '<option value="'.$result[$i]['fieldtype'].'">'.$result[$i]['fieldtype'].'</option>';
                                }
                                ?>
                            </select>


                        </td>
                        <td>
                            class (не обязательно)<br/>
                            <input type="text" value="" placeholder="имя класса" id="ClassTextAjax"><br/><br/>
                            maxlength (не обязательно)<br/>
                            <input type="text" value="" placeholder="числовое значение" id="MaxLenTextAjax"><br/><br/>
                            Подсказка (не обязательно)<br/>
                            <input type="text" value="" placeholder="подсказка" id="PlaceholdTextAjax"><br/><br/>
                            Обязательное поле? (не обязательно)<br/>
                            <input type="checkbox" id="ObzTextAjax"><br/><br/>
                        </td>
                    </tr>
                </table>
                Описание поля<br/>
                <textarea id="hintTextAjax" class="UniCatFullWidth"></textarea>

                <div class="button action" onclick="SF_add_TextAjax('SFAdminForm', '', '<?php print $SeeForm; ?>')">Вставить</div>

            </div>

            <div class="formscreater" id="menuSelect">
                <strong>Меню выбора</strong><br>
                <div class="codeediv">
                Пример:<br/>
                <select>
                    <option>Пункт 1</option>
                    <option>Пункт 2</option>
                </select>
                    </div>
                <br/><br/>
                <strong>Параметры:</strong><br/>
                <table border="0" class="innerTable">
                    <tr><td>
                            Name (обязательно)<br/>
                            <input type="text" value="" onkeyup="GetFields(2)" onchange="GetFields(2)" placeholder="Name" id="NameSelect"><br/>
                            <select onchange="document.getElementById('NameSelect').value=this.value; GetFields(2)">
                                <option value="">выбрать из существующих</option>
                                <?php
                                $fields=$wpdb->get_results("SELECT * FROM `" . $this->tbl_sales_form . "sales_form_list` GROUP BY `fieldname`", ARRAY_A);
                                for ($i=0;$i<count($fields);$i++){
                                    print '<option value="'.$fields[$i]['fieldname'].'">'.$fields[$i]['fieldname'].'</option>';
                                }
                                ?>
                            </select>
                            <br/><br/>
                            id (не обязательно)<br/>
                            <input type="text" value="" placeholder="id" id="IdSelect"><br/><br/>
                            class (не обязательно)<br/>
                            <input type="text" value="" placeholder="имя класса" id="ClassSelect"><br/><br/>
                            Родитель для:<br/>
                            <select id="contactChildrenSelect">
                                <option value="0">Нет дочернего поля</option>
                                <?php
                                //$fields=$wpdb->get_results("SELECT * FROM `" . $this->tbl_sales_form . "sales_form_list` GROUP BY `fieldname`", ARRAY_A);
                                for ($i=0;$i<count($fields);$i++){
                                    print '<option value="'.$fields[$i]['fieldname'].'">'.$fields[$i]['fieldname'].'</option>';
                                }

                                ?>
                            </select>

                        </td>
                        <td>
                            <input type="checkbox" id="defaultEmptySelect">&nbsp;по умолчанию пустой<br/><br/>
                            <input type="checkbox" id="multiSelect">&nbsp;множественный выбор<br/><br/>
                            <input type="checkbox" id="checksSelect">&nbsp;Использовать чекбоксы<br/><br/>
                            Значения (по 1 в каждой строке)<br/>
                            <textarea id="ValueSelect">
                            </textarea><br/>
                            <div id="helper"></div>
                            Значения связаны с:<br/>
                            <select id="contactSelect" onchange="GetFields(1)">
                                <option value="0">Значения не связаны с родителем:</option>
                                <?php
                                for ($i=0;$i<count($fields);$i++){
                                    print '<option value="'.$fields[$i]['fieldname'].'">'.$fields[$i]['fieldname'].'</option>';
                                }
                                ?>
                            </select>
                            <div id="includeFormSelect"></div>
                            <div class="button" onclick="WriteFields('')">Сохранить значения</div>
                        </td>
                    </tr>
                </table>

                Описание поля<br/>
                <textarea id="hintSelect" class="UniCatFullWidth"></textarea>
                <div class="button action" onclick="SF_add_Select('SFAdminForm', '', '<?php print $SeeForm; ?>')">Вставить</div>

            </div>

            <div class="formscreater" id="menuSubmitButton">
                <strong>Кнопка отправки данных</strong><br>
                <div class="codeediv">
                пример:<br/>
                <button class="button">Отправка данных</button>
                    </div>
                <br/><br/>
                <strong>Параметры:</strong><br/>
                <table border="0" class="innerTable">
                    <tr><td>
                            id (не обязательно)<br/>
                            <input type="text" value="" placeholder="id" id="IdSubmit"><br/><br/>
                            текст на кнопке(не обязательно)<br/>
                            <input type="text" value="" placeholder="Значение по умолчанию" id="ValueSubmit"><br/><br/>
                        </td>
                        <td>
                            class (не обязательно)<br/>
                            <input type="text" value="" placeholder="имя класса" id="ClassSubmit"><br/><br/>
                        </td>
                    </tr>
                </table>


                <div class="button action" onclick="SF_add_Submit('SFAdminForm', '')">Вставить</div>

            </div>

            <div class="formscreater" id="menuFindButton">
                <strong>Кнопка поиска</strong><br>
                <div class="codeediv">
                пример:<br/>
                <button>поиск</button>
                    </div>
                <br/><br/>
                <strong>Параметры:</strong><br/>
                <table border="0" class="innerTable">
                    <tr><td>
                            id (не обязательно)<br/>
                            <input type="text" value="" placeholder="id" id="IdFind"><br/><br/>
                            текст на кнопке (не обязательно)<br/>
                            <input type="text" value="" placeholder="Значение по умолчанию" id="ValueFind"><br/><br/>
                        </td>
                        <td>
                            class (не обязательно)<br/>
                            <input type="text" value="" placeholder="имя класса" id="ClassFind"><br/><br/>
                        </td>
                    </tr>
                </table>


                <div class="button action" onclick="SF_add_Find('SFAdminForm', '')">Вставить</div>

            </div>
</div>


<div class="tabs-panel UniCatDefaulthidden" style="max-height: 1000px; overflow: auto;" id="InpPanelOld"><br/>
    Старые поля

    <select id="InpOldPole" onchange="ShowAdmHint(this,'InpHint')">
    </select>


    <div class="button" onclick="PasteCodeInd('InpOldPole', 'SFAdminForm')">Вставить</div> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <div class="button" onclick="DeleteCodeInd('InpOldPole', '<?php print $SeeForm; ?>')">Удалить</div>

    <div id="InpHint">

    </div>
    <br/>
    <br/>
    <br/>
    <br/>
    <br/>

    </div>



        </td>
    </tr>
</table>
    <input type="hidden" name="nowform" value="">
    <input type="hidden" name="act" value="2">


</form>
</div>

</div>







<div class="postbox metabox-holder">

<h3 onclick="SowHideUniCatForm('findForm','','')" class="UniCatPointer"><span>Форма поиска данных</span><span class="UniCatAbsoluteCode">&nbsp;[UniCat <?php print 'id="'.$SeeForm . '" formtype="fnd"'; ?>]&nbsp;</span></h3>
<div class="UniCatDefaulthidden" id="findForm">
<div class="titlediv">
    <div class="codeediv">Скопируйте этот код и вставьте его в свой пост или страницу.<br/>[UniCat <?php print 'id="'.$SeeForm . '" formtype="fnd"'; ?>]</div>
</div>

<form action="" method="POST" enctype="application/x-www-form-urlencoded" >
<input type="hidden" name="SeeForm" value="<?php print $SeeForm?>">

<table border="0" class="admin-table wp-list-table bordertable">
<tr>
<td>
    Код формы
    <textarea class="inputFormsPosition" id="SFFindForm" name="MainAdminForm"><?php echo htmlspecialchars($wpdb->get_var("SELECT `findform` FROM `" . $this->tbl_unicat . "unicat_forms` WHERE id=".$SeeForm." LIMIT 1")); ?></textarea>
</td>

<td>
<div>
   Вставка полей
</div>
<div class="categorydiv">
<ul id="category-tabs" class="category-tabs">
    <li class="tabs" onclick="SF_tabsSelect(this, 'FndBee', 'FndPanelOld', 'FndPanelNew', '<?php print $SeeForm; ?>', '');" id="FndNew">Новое поле</li>
    <li onclick="SF_tabsSelect(this, 'FndNew', 'FndPanelNew', 'FndPanelOld', '<?php print $SeeForm; ?>', 'FndOldPole');" id="FndBee">Существующие поля</li>
</ul>
<div class="tabs-panel" style="max-height: 1000px;" id="FndPanelNew"><br/>
<select onchange="SF_showMenuAdd(this, 'formscreaterfind')" onclick="SF_showMenuAdd(this, 'formscreaterfind')">
    <option selected="selected" disabled="disabled" >Выберите элемент</option>
    <option value="menuSimpleTextFnd">Короткий текст</option>
    <option value="menuNumberFnd">Число</option>
    <option value="menuTextAreaFnd">Длинный текст</option>
    <option value="menuSelectFnd">Строгий список</option>
    <option value="menuTextAjaxFnd">Текст с подсказкой</option>
    <option value="menuImageLoadFnd">Загрузка изображений</option>
    <option value="menuRadioFnd">Переключатель</option>
    <option value="menuCheckboxFnd">Чекбокс</option>
    <option value="menuDatapickerFnd">Срок публикации</option>
    <option value="menuFindButtonFnd">Кнопка "Искать"</option>
</select>


<div class="formscreaterfind" id="menuSimpleTextFnd">
    <strong>Текстовое поле</strong><br>
    <div class="codeediv">
    пример:<br/>
    <input type="text" placeholder="Короткий текст">
        </div>
    <br/><br/>
    <strong>Параметры:</strong><br/>
    <table border="0" class="innerTable">
        <tr><td>
                Name (обязательно)<br/>
                <input type="text" value="" placeholder="Name" id="NameSimpleTextFnd"><br/><br/>
                id (не обязательно)<br/>
                <input type="text" value="" placeholder="id" id="IdSimpleTextFnd"><br/><br/>
                Значение по умолчанию (не обязательно)<br/>
                <input type="text" value="" placeholder="Значение по умолчанию" id="ValueSimpleTextFnd"><br/><br/>
                Обязательное поле? (не обязательно)<br/>
                <input type="checkbox" id="ObzSimpleTextFnd"><br/><br/>
            </td>
            <td>
                class (не обязательно)<br/>
                <input type="text" value="" placeholder="имя класса" id="ClassSimpleTextFnd"><br/><br/>
                maxlength (не обязательно)<br/>
                <input type="text" value="" placeholder="числовое значение" id="MaxLenSimpleTextFnd"><br/><br/>
                Подсказка (не обязательно)<br/>
                <input type="text" value="" placeholder="подсказка" id="PlaceholdSimpleTextFnd"><br/><br/>
            </td>
        </tr>
    </table>

    Описание поля<br/>
    <textarea id="hintSimpleTextFnd" class="UniCatFullWidth"></textarea>
    <div class="button action" onclick="SF_add_simpleText('SFFindForm', 'Fnd', '<?php print $SeeForm; ?>')">Вставить</div>

</div>

<div class="formscreaterfind" id="menuDatapickerFnd">
    <strong>Поле с указанием срока публикации</strong><br>
    <br/><br/>
    <strong>Параметры:</strong><br/>
    <table border="0" class="innerTable">
        <tr><td>
                class (не обязательно)<br/>
                <input type="text" value="" placeholder="имя класса" id="ClassDataPickerFnd"><br/><br/>
            </td>
            <td>

            </td>
        </tr>
    </table>
    <div class="button action" onclick="SF_add_datapicker('SFFindForm', 'Fnd')">Вставить</div>
</div>

<div class="formscreaterfind" id="menuNumberFnd">
    <strong>Числовое поле</strong><br>
    <div class="codeediv">
    пример:<br/>
    <input type="text" placeholder="Короткий текст">
        </div>
    <br/><br/>
    <strong>Параметры:</strong><br/>
    <table border="0" class="innerTable">
        <tr><td>
                Name (обязательно)<br/>
                <input type="text" value="" placeholder="Name" id="NameNumberFnd"><br/><br/>
                id (не обязательно)<br/>
                <input type="text" value="" placeholder="id" id="IdNumberFnd"><br/><br/>
                Значение по умолчанию (не обязательно)<br/>
                <input type="text" value="" placeholder="Значение по умолчанию" id="ValueNumberFnd"><br/><br/>
                Привязано к полю (не обязательно)(для поиска)<br/>
                <input type="text" value="" placeholder="name поля к которому будем ровняться" id="ValuePoleFnd"><br/><br/>
                Обязательное поле? (не обязательно)<br/>
                <input type="checkbox" id="ObzNumberFnd"><br/><br/>
            </td>
            <td>
                class (не обязательно)<br/>
                <input type="text" value="" placeholder="имя класса" id="ClassNumberFnd"><br/><br/>
                maxlength (не обязательно)<br/>
                <input type="text" value="" placeholder="числовое значение" id="MaxLenNumberFnd"><br/><br/>
                Подсказка (не обязательно)<br/>
                <input type="text" value="" placeholder="подсказка" id="PlaceholdNumberFnd"><br/><br/>
                Логика привязки (не обязательно)<br/>
                <select id="LogicNumberFnd">
                    <option value="equally" selected="selected">равно</option>
                    <option value="more">больше либо равно</option>
                    <option value="less">меньше либо равно</option>
                </select>

                <br/><br/>
            </td>
        </tr>
    </table>
    Описание поля<br/>
    <textarea id="hintNumberFnd" class="UniCatFullWidth"></textarea>
    <input type="hidden" value="" name="sform">
    <div class="button action" onclick="SF_add_number('SFFindForm', 'Fnd', '<?php print $SeeForm; ?>')">Вставить</div>

</div>

<div class="formscreaterfind" id="menuCheckboxFnd">
    <strong>Чекбокс</strong><br>
    <div class="codeediv">
    пример:<br/>
    <input type="checkbox">
        </div>
    <br/><br/>
    <strong>Параметры:</strong><br/>
    <table border="0" class="innerTable">
        <tr><td>
                Name (обязательно)<br/>
                <input type="text" value="" placeholder="Name" id="NameCheckBoxFnd"><br/><br/>
                id (не обязательно)<br/>
                <input type="text" value="" placeholder="id" id="IdCheckBoxFnd"><br/><br/>
                Значение<br/>
                <input type="text" value="1" placeholder="1" id="valueCheckBoxFnd"><br/><br/>
                Значение по умолчанию <br/>
                <input type="checkbox" id="CheckedCheckboxFnd"><br/><br/>
            </td>
            <td>
                class (не обязательно)<br/>
                <input type="text" value="" placeholder="имя класса" id="ClassCheckBoxFnd"><br/><br/>
            </td>
        </tr>
    </table>
    Описание поля<br/>
    <textarea id="hintCheckboxFnd" class="UniCatFullWidth"></textarea>
    <div class="button action" onclick="SF_add_CheckBox('SFFindForm', 'Fnd', '<?php print $SeeForm; ?>')">Вставить</div>
</div>

<div class="formscreaterfind" id="menuRadioFnd">
    <strong>Переключатель</strong><br>
    <div class="codeediv">
    пример:<br/>
    <input type="radio">
        </div>
    <br/><br/>
    <strong>Параметры:</strong><br/>
    <table border="0" class="innerTable">
        <tr><td>
                Name (обязательно)<br/>
                <input type="text" value="" placeholder="Name" id="NameRadioFnd"><br/><br/>
                Значение (обязательно)<br/>
                <input type="text" value="" placeholder="Value" id="ValueRadioFnd"><br/><br/>
                id (не обязательно)<br/>
                <input type="text" value="" placeholder="id" id="IdRadioFnd"><br/><br/>
                Значение по умолчанию <br/>
                <input type="checkbox" id="CheckedRadioFnd"> вкл<br/><br/>
            </td>
            <td>
                class (не обязательно)<br/>
                <input type="text" value="" placeholder="имя класса" id="ClassRadioFnd"><br/><br/>
            </td>
        </tr>
    </table>
    Описание поля<br/>
    <textarea id="hintRadioFnd" class="UniCatFullWidth"></textarea>
    <div class="button action" onclick="SF_add_Radio('SFFindForm', 'Fnd', '<?php print $SeeForm; ?>')">Вставить</div>
</div>

<div class="formscreaterfind" id="menuTextAreaFnd">
    <strong>Многострочное текстовое поле</strong><br>
    <div class="codeediv">
    пример:<br/>
    <textarea placeholder="Многострочное текстовое поле"></textarea>
        </div>
    <br/><br/>
    <strong>Параметры:</strong><br/>
    <table border="0" class="innerTable">
        <tr><td>
                Name (обязательно)<br/>
                <input type="text" value="" placeholder="Name" id="NameTextAreaFnd"><br/><br/>
                id (не обязательно)<br/>
                <input type="text" value="" placeholder="id" id="IdTextAreaFnd"><br/><br/>
                Значение по умолчанию (не обязательно)<br/>
                <input type="text" value="" placeholder="Значение по умолчанию" id="ValueTextAreaFnd"><br/><br/>
                Обязательное поле? (не обязательно)<br/>
                <input type="checkbox" id="ObzTextAreaFnd"><br/><br/>
            </td>
            <td>
                class (не обязательно)<br/>
                <input type="text" value="" placeholder="имя класса" id="ClassTextAreaFnd"><br/><br/>
                maxlength (не обязательно)<br/>
                <input type="text" value="" placeholder="числовое значение" id="MaxLenTextAreaFnd"><br/><br/>
                Подсказка (не обязательно)<br/>
                <input type="text" value="" placeholder="подсказка" id="PlaceholdTextAreaFnd"><br/><br/>
            </td>
        </tr>
    </table>
    Описание поля<br/>
    <textarea id="hintTextAreaFnd" class="UniCatFullWidth"></textarea>

    <div class="button action" onclick="SF_add_TextArea('SFFindForm', 'Fnd', '<?php print $SeeForm; ?>')">Вставить</div>

</div>

<div class="formscreaterfind" id="menuImageLoadFnd">
    <strong>Загрузка изображений</strong><br>
    <div class="codeediv">
    пример:<br/>
    <input type="file" accept="image/jpeg,image/png,image/gif">
        </div>
    <br/><br/>
    <strong>Параметры:</strong><br/>
    <table border="0" class="innerTable">
        <tr><td>
                Name (не обязательно)<br/>
                <input type="text" value="" placeholder="Name" id="NameImageLoadFnd"><br/><br/>
                id (не обязательно)<br/>
                <input type="text" value="" placeholder="id" id="IdImageLoadFnd"><br/><br/>
                class (не обязательно)<br/>
                <input type="text" value="" placeholder="имя класса" id="ClassImageLoadFnd"><br/><br/>
            </td>
            <td>
                <select id="resizeimageFnd">
                    <option value="">Оставлять исходный размер</option>
                    <option value="resize">Изменить размер изображения</option>
                </select>
                <div>
                    Ширина <input type="text" id="WidthImageFnd"> px<br/>
                    Высота <input type="text" id="HeightImageFnd"> px<br/>
                </div>
                <br/><br/>
                <input type="checkbox" id="watermarkImageFnd"> Вставить водяной знак

            </td>
        </tr>
    </table>
    Описание поля<br/>
    <textarea id="hintImageLoadFnd" class="UniCatFullWidth"></textarea>
    <div class="button action" onclick="SF_add_ImageLoad('SFFindForm', 'Fnd', '<?php print $SeeForm; ?>')">Вставить</div>
</div>

<div class="formscreaterfind" id="menuTextAjaxFnd">
    <strong>Текстовое поле с Ajax подсказкой</strong><br>
    <div class="codeediv">
    пример:<br/>
    <input type="text">
        </div>
    <br/><br/>
    <strong>Параметры:</strong><br/>
    <table border="0" class="innerTable">
        <tr><td>
                Name (обязательно)<br/>
                <input type="text" value="" placeholder="Name" id="NameTextAjaxFnd"><br/><br/>
                id (не обязательно)<br/>
                <input type="text" value="" placeholder="id" id="IdTextAjaxFnd"><br/><br/>
                Значение по умолчанию (не обязательно)<br/>
                <input type="text" value="" placeholder="Значение по умолчанию" id="ValueTextAjaxFnd"><br/><br/>
                Значение для поиска подсказки<br/>
                <input type="text" id="FieldTextAjaxFnd" value=""><br/>
                <select onchange="document.getElementById('FieldTextAjaxFnd').value=this.value">
                    <option value="" selected="selected">без подсказок</option>
                    <?php
                    $result=$wpdb->get_results("SELECT `fieldtype` FROM `" . $this->tbl_unicat . "unicat_fields` GROUP BY `fieldtype`",ARRAY_A);
                    for ($i=0;$i<count($result);$i++){
                        print '<option value="'.$result[$i]['fieldtype'].'">'.$result[$i]['fieldtype'].'</option>';
                    }
                    ?>
                </select>


            </td>
            <td>
                class (не обязательно)<br/>
                <input type="text" value="" placeholder="имя класса" id="ClassTextAjaxFnd"><br/><br/>
                maxlength (не обязательно)<br/>
                <input type="text" value="" placeholder="числовое значение" id="MaxLenTextAjaxFnd"><br/><br/>
                Подсказка (не обязательно)<br/>
                <input type="text" value="" placeholder="подсказка" id="PlaceholdTextAjaxFnd"><br/><br/>
                Обязательное поле? (не обязательно)<br/>
                <input type="checkbox" id="ObzTextAjaxFnd"><br/><br/>
            </td>
        </tr>
    </table>
    Описание поля<br/>
    <textarea id="hintTextAjaxFnd" class="UniCatFullWidth"></textarea>

    <div class="button action" onclick="SF_add_TextAjax('SFFindForm', 'Fnd', '<?php print $SeeForm; ?>')">Вставить</div>

</div>

<div class="formscreaterfind" id="menuSelectFnd">
    <strong>Меню выбора</strong><br>
    <div class="codeediv">
    Пример:<br/>
    <select>
        <option>Пункт 1</option>
        <option>Пункт 2</option>
    </select>
        </div>
    <br/><br/>
    <strong>Параметры:</strong><br/>
    <table border="0" class="innerTable">
        <tr><td>
                Name (обязательно)<br/>
                <input type="text" value="" onkeyup="GetFields(2)" onchange="GetFields(2)" placeholder="Name" id="NameSelectFnd"><br/>
                <select onchange="document.getElementById('NameSelectFnd').value=this.value; GetFields(2)">
                    <option value="">выбрать из существующих</option>
                    <?php
                    $fields=$wpdb->get_results("SELECT * FROM `" . $this->tbl_unicat . "unicat_list` GROUP BY `fieldname`", ARRAY_A);
                    for ($i=0;$i<count($fields);$i++){
                        print '<option value="'.$fields[$i]['fieldname'].'">'.$fields[$i]['fieldname'].'</option>';
                    }
                    ?>
                </select>
                <br/><br/>
                id (не обязательно)<br/>
                <input type="text" value="" placeholder="id" id="IdSelectFnd"><br/><br/>
                class (не обязательно)<br/>
                <input type="text" value="" placeholder="имя класса" id="ClassSelectFnd"><br/><br/>
                Родитель для:<br/>
                <select id="contactChildrenSelectFnd">
                    <option value="0">Нет дочернего поля</option>
                    <?php
                    //$fields=$wpdb->get_results("SELECT * FROM `" . $this->tbl_sales_form . "sales_form_list` GROUP BY `fieldname`", ARRAY_A);
                    for ($i=0;$i<count($fields);$i++){
                        print '<option value="'.$fields[$i]['fieldname'].'">'.$fields[$i]['fieldname'].'</option>';
                    }

                    ?>
                </select>

            </td>
            <td>
                <input type="checkbox" id="defaultEmptySelectFnd">&nbsp;по умолчанию пустой<br/><br/>
                <input type="checkbox" id="multiSelectFnd">&nbsp;множественный выбор<br/><br/>
                <input type="checkbox" id="checksSelectFnd">&nbsp;Использовать чекбоксы<br/><br/>
                Значения (по 1 в каждой строке)<br/>
                <textarea id="ValueSelectFnd">
                </textarea><br/>
                <div id="helperFnd"></div>
                Значения связаны с:<br/>
                <select id="contactSelectFnd" onchange="GetFields(1)">
                    <option value="0">Значения не связаны с родителем:</option>
                    <?php
                    for ($i=0;$i<count($fields);$i++){
                        print '<option value="'.$fields[$i]['fieldname'].'">'.$fields[$i]['fieldname'].'</option>';
                    }
                    ?>
                </select>
                <div id="includeFormSelectFnd"></div>
                <div class="button" onclick="WriteFields('Fnd')">Сохранить значения</div>
            </td>
        </tr>
    </table>
    Описание поля<br/>
    <textarea id="hintSelectFnd" class="UniCatFullWidth"></textarea>

    <div class="button action" onclick="SF_add_Select('SFFindForm', 'Fnd', '<?php print $SeeForm; ?>')">Вставить</div>

</div>

<div class="formscreaterfind" id="menuSubmitButtonFnd">
    <strong>Кнопка отправки данных</strong><br>
    <div class="codeediv">
    пример:<br/>
    <button>Отправка данных</button>
        </div>
    <br/><br/>
    <strong>Параметры:</strong><br/>
    <table border="0" class="innerTable">
        <tr><td>
                id (не обязательно)<br/>
                <input type="text" value="" placeholder="id" id="IdSubmitFnd"><br/><br/>
                текст на кнопке(не обязательно)<br/>
                <input type="text" value="" placeholder="Значение по умолчанию" id="ValueSubmitFnd"><br/><br/>
            </td>
            <td>
                class (не обязательно)<br/>
                <input type="text" value="" placeholder="имя класса" id="ClassSubmitFnd"><br/><br/>
            </td>
        </tr>
    </table>


    <div class="button action" onclick="SF_add_Submit('SFFindForm', 'Fnd')">Вставить</div>

</div>

<div class="formscreaterfind" id="menuFindButtonFnd">
    <strong>Кнопка поиска</strong><br>
    <div class="codeediv">
    пример:<br/>
    <button class="button">поиск</button>
        </div>
    <br/><br/>
    <strong>Параметры:</strong><br/>
    <table border="0" class="innerTable">
        <tr><td>
                id (не обязательно)<br/>
                <input type="text" value="" placeholder="id" id="IdFindFnd"><br/><br/>
                текст на кнопке (не обязательно)<br/>
                <input type="text" value="" placeholder="Значение по умолчанию" id="ValueFindFnd"><br/><br/>
            </td>
            <td>
                class (не обязательно)<br/>
                <input type="text" value="" placeholder="имя класса" id="ClassFindFnd"><br/><br/>
            </td>
        </tr>
    </table>


    <div class="button action" onclick="SF_add_Find('SFFindForm', 'Fnd')">Вставить</div>

</div>

</div>

<div class="tabs-panel UniCatDefaulthidden" style="max-height: 1000px; overflow: auto;" id="FndPanelOld"><br/>
    Старые поля

    <select id="FndOldPole" onchange="ShowAdmHint(this,'FndHint')">
    </select>


    <div class="button" onclick="PasteCodeInd('FndOldPole', 'SFFindForm')">Вставить</div>&nbsp;&nbsp;&nbsp;&nbsp;
    <div class="button" onclick="DeleteCodeInd('FndOldPole', '<?php print $SeeForm; ?>')">Удалить</div>

    <div id="FndHint">

    </div>
    <br/>
    <br/>
    <br/>
    <br/>
    <br/>

</div>


</td>
</tr>
</table>
<input type="hidden" name="nowform" value="">
<input type="hidden" name="act" value="7">


</form>

</div></div>





<div class="postbox metabox-holder">
    <h3 onclick="SowHideUniCatForm('outputForm','SelectUserForms', '<?php print  $SeeForm; ?>')" class="UniCatPointer">Форма вывода данных <span class="UniCatAbsoluteCode">&nbsp;[UniCat <?php print 'id="'.$SeeForm . '" formtype="posts"'; ?> postpages="30"]&nbsp;</span></h3>
<div class="UniCatDefaulthidden" id="outputForm">
    <div class="titlediv">
        <div class="codeediv">Скопируйте этот код и вставьте его в свой пост или страницу.<br/>[UniCat <?php print 'id="'.$SeeForm . '" formtype="posts"'; ?> postpages="30"]</div>
    </div>
        <form action="" method="POST" enctype="application/x-www-form-urlencoded" >
            <input type="hidden" name="SeeForm" value="<?php print $SeeForm?>">
            <table border="0" class="admin-table wp-list-table bordertable">

                <tr>

                    <td>
                        Код формы
                        <textarea class="inputFormsPosition" id="SFUserForm" name="MainUserForm"><?php echo htmlspecialchars($wpdb->get_var("SELECT `outputform` FROM `" . $this->tbl_unicat . "unicat_forms` WHERE id=".$SeeForm." LIMIT 1")); ?></textarea>
                    </td>
                    <td>
                        Вставка полей:<br/>
                        <?php
                        $needfr=$wpdb->get_var("SELECT `inputform` FROM `" . $this->tbl_unicat . "unicat_forms` WHERE id=".$SeeForm." LIMIT 1");
                        preg_match_all('#\[SForm(.*?)]#',$needfr,$short_codes);//Ищем коды полей
                        $short_codes[0]=array_unique($short_codes[0]);
                        ?>
                        <select id="SelectUserForms">
                        </select>
                        <br/>
                        <div class="button action" onclick="SF_outpMenuAdd('')">Вставить</div>
                    </td>
                </tr>
            </table>

            <input type="hidden" name="act" value="3">


        </form>
</div>
</div>



<div class="postbox metabox-holder">
<h3 onclick="SowHideUniCatForm('podrForm','SelectUserFormsPodr', '<?php print  $SeeForm; ?>')" class="UniCatPointer">форма вывода подробных данных<span class="UniCatAbsoluteCode">&nbsp;[UniCat <?php print 'id="'.$SeeForm . '" formtype="full"'; ?>]&nbsp;</span></h3>
<div class="UniCatDefaulthidden" id="podrForm">
<div class="titlediv">
    <div class="codeediv">Скопируйте этот код и вставьте его в свой пост или страницу.<br/>[UniCat <?php print 'id="'.$SeeForm . '" formtype="full"'; ?>]</div>
</div>
<form action="" method="POST" enctype="application/x-www-form-urlencoded" >
    <input type="hidden" name="SeeForm" value="<?php print $SeeForm?>">
    <table border="0" class="admin-table wp-list-table bordertable">
        <tr>

            <td>
                Код формы
                <textarea class="inputFormsPosition" id="SFUserFormPodr" name="MainUserForm"><?php echo htmlspecialchars($wpdb->get_var("SELECT `podrobnoform` FROM `" . $this->tbl_unicat . "unicat_forms` WHERE id=".$SeeForm." LIMIT 1")); ?></textarea>
            </td>
            <td>
                Вставка полей:<br/>
                <?php
                $needfr=$wpdb->get_var("SELECT `inputform` FROM `" . $this->tbl_unicat . "unicat_forms` WHERE id=".$SeeForm." LIMIT 1");
                preg_match_all('#\[SForm(.*?)]#',$needfr,$short_codes);//Ищем коды полей
                $short_codes[0]=array_unique($short_codes[0]);
                ?>
                <select id="SelectUserFormsPodr">
                </select>
                <br/>


                <div class="button action" onclick="SF_outpMenuAdd('Podr')">Вставить</div>
            </td>
        </tr>
    </table>

    <input type="hidden" name="act" value="8">

</form>
</div>
</div>




</div>

</div>