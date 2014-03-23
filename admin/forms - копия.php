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


<h2 xmlns="http://www.w3.org/1999/html">Настройки формы</h2>
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
        <tr><td>Название формы: </td><td><input type="text" class="UniCatFullWidth" name="newForm" value="<?php print $params[0]['formname'] ?>"></td></tr>
        <tr><td> e-mail модераторов:</td><td><input type="text" class="UniCatFullWidth" name="newMail" value="<?php print $params[0]['mail'] ?>"></td></tr>
        <tr><td>Количество дней публикации:</td><td><input type="text" class="UniCatFullWidth" onkeyup="onlyNumbers(this)" value="<?php print $params[0]['pubdays'] ?>" name="pubdays"></td></tr>
        <tr><td>Сообщение об успешном добавлении:</td><td><textarea class="UniCatFullWidth" name="allok"><?php print $params[0]['allok'] ?></textarea></td></tr>
        </tbody>
    </table>
        <input type="hidden" value="updateparams" name="act">
        <input type="hidden" value="<?php print $SeeForm ;?>" name="SeeForm">
        <input type="submit" class="button" value="Редактировать настройки">
    </div>

</form>



<h2>Содержимое форм</h2>
<div class="mainSFdiv">


<h3 onclick="SowHideUniCatForm('inputForm')" class="UniCatPointer">форма ввода данных</h3>
<div class="postbox ">dads
<div>
<div class="UniCatDefaulthidden" id="inputForm">
<div class="titlediv">
    <div class="codeediv">Скопируйте этот код и вставьте его в свой пост или страницу.<br/>[UniCat <?php print 'id="'.$SeeForm . '" formtype="inp"'; ?>]</div>
</div>


<img id="ajaxloading" src="<?php print WP_PLUGIN_URL. '/unicat/admin/images/'; ?>ajax-loader.gif" style="position: fixed; right: 0px; top: 30px; display: none;"/>


<form action="" method="POST" enctype="application/x-www-form-urlencoded" >
<input type="hidden" name="SeeForm" value="<?php print $SeeForm?>">

<table border="0" class="admin-table wp-list-table bordertable">
    <tr><td colspan="2" class="tableheader">Управление формой ввода данных</td></tr>
    <tr>

        <td>
            <h3>Код формы</h3>
            <textarea class="inputFormsPosition" id="SFAdminForm" name="MainAdminForm"><?php echo htmlspecialchars($wpdb->get_var("SELECT `inputform` FROM `" . $this->tbl_unicat . "unicat_forms` WHERE id=".$SeeForm." LIMIT 1")); ?></textarea>
        </td>
        <td>

            <div>

            <h3>Вставка кода</h3>
            </div>
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
                пример:<br/>
                <input type="text" placeholder="Короткий текст">
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


            <div class="button action" onclick="SF_add_simpleText('SFAdminForm', '')">Вставить</div>

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
                пример:<br/>
                <input type="text" placeholder="Короткий текст">
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

                <input type="hidden" value="" name="sform">
                <div class="button action" onclick="SF_add_number('SFAdminForm', '')">Вставить</div>

            </div>





            <div class="formscreater" id="menuCheckbox">
                <strong>Чекбокс</strong><br>
                пример:<br/>
                <input type="checkbox">
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
                <div class="button action" onclick="SF_add_CheckBox('SFAdminForm', '')">Вставить</div>
            </div>


            <div class="formscreater" id="menuRadio">
                <strong>Переключатель</strong><br>
                пример:<br/>
                <input type="radio">
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
                <div class="button action" onclick="SF_add_Radio('SFAdminForm', '')">Вставить</div>
            </div>





            <div class="formscreater" id="menuTextArea">
                <strong>Многострочное текстовое поле</strong><br>
                пример:<br/>
                <textarea placeholder="Многострочное текстовое поле
                "></textarea>
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


                <div class="button action" onclick="SF_add_TextArea('SFAdminForm', '')">Вставить</div>

            </div>




            <div class="formscreater" id="menuImageLoad">
                <strong>Загрузка изображений</strong><br>
                пример:<br/>
                <input type="file" accept="image/jpeg,image/png,image/gif">
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
                <div class="button action" onclick="SF_add_ImageLoad('SFAdminForm', '')">Вставить</div>
            </div>







            <div class="formscreater" id="menuTextAjax">
                <strong>Текстовое поле с Ajax подсказкой</strong><br>
                пример:<br/>
                <input type="text">
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


                <div class="button action" onclick="SF_add_TextAjax('SFAdminForm', '')">Вставить</div>

            </div>




            <div class="formscreater" id="menuSelect">
                <strong>Меню выбора</strong><br>
                Пример:<br/>
                <select>
                    <option>Пункт 1</option>
                    <option>Пункт 2</option>
                </select>
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


                <div class="button action" onclick="SF_add_Select('SFAdminForm', '')">Вставить</div>

            </div>



            <div class="formscreater" id="menuSubmitButton">
                <strong>Кнопка отправки данных</strong><br>
                пример:<br/>
                <button>Отправка данных</button>
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
                пример:<br/>
                <button>поиск</button>
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





        </td>
    </tr>
</table>
    <input type="hidden" name="nowform" value="">
    <input type="hidden" name="act" value="2">
    <div class="SFmargin"><input type="submit" class="button button-primary button-large" value="Сохранить изменения"></div>

</form>
</div>
</div>
</div>









<h3 onclick="SowHideUniCatForm('findForm')" class="UniCatPointer">форма поиска данных</h3>
<div class="UniCatDefaulthidden" id="findForm">
<div class="titlediv">
    <div class="codeediv">Скопируйте этот код и вставьте его в свой пост или страницу.<br/>[UniCat <?php print 'id="'.$SeeForm . '" formtype="fnd"'; ?>]</div>
</div>

<form action="" method="POST" enctype="application/x-www-form-urlencoded" >
<input type="hidden" name="SeeForm" value="<?php print $SeeForm?>">

<table border="0" class="admin-table wp-list-table bordertable">
<tr><td colspan="2" class="tableheader">Управление формой ввода данных</td></tr>
<tr>

<td>
    <h3>Код формы</h3>
    <textarea class="inputFormsPosition" id="SFFindForm" name="MainAdminForm"><?php echo htmlspecialchars($wpdb->get_var("SELECT `findform` FROM `" . $this->tbl_unicat . "unicat_forms` WHERE id=".$SeeForm." LIMIT 1")); ?></textarea>
</td>
<td>

<div>
    <h3>Вставка кода</h3>
</div>
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
    пример:<br/>
    <input type="text" placeholder="Короткий текст">
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


    <div class="button action" onclick="SF_add_simpleText('SFFindForm', 'Fnd')">Вставить</div>

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
    пример:<br/>
    <input type="text" placeholder="Короткий текст">
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

    <input type="hidden" value="" name="sform">
    <div class="button action" onclick="SF_add_number('SFFindForm', 'Fnd')">Вставить</div>

</div>





<div class="formscreaterfind" id="menuCheckboxFnd">
    <strong>Чекбокс</strong><br>
    пример:<br/>
    <input type="checkbox">
    <br/><br/>
    <strong>Параметры:</strong><br/>
    <table border="0" class="innerTable">
        <tr><td>
                Name (обязательно)<br/>
                <input type="text" value="" placeholder="Name" id="NameCheckBoxFnd"><br/><br/>
                id (не обязательно)<br/>
                <input type="text" value="" placeholder="id" id="IdCheckBoxFnd"><br/><br/>
                Значение по умолчанию <br/>
                <input type="checkbox" id="CheckedCheckboxFnd"><br/><br/>
            </td>
            <td>
                class (не обязательно)<br/>
                <input type="text" value="" placeholder="имя класса" id="ClassCheckBoxFnd"><br/><br/>
            </td>
        </tr>
    </table>
    <div class="button action" onclick="SF_add_CheckBox('SFFindForm', 'Fnd')">Вставить</div>
</div>


<div class="formscreaterfind" id="menuRadioFnd">
    <strong>Переключатель</strong><br>
    пример:<br/>
    <input type="radio">
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
    <div class="button action" onclick="SF_add_Radio('SFFindForm', 'Fnd')">Вставить</div>
</div>





<div class="formscreaterfind" id="menuTextAreaFnd">
    <strong>Многострочное текстовое поле</strong><br>
    пример:<br/>
    <textarea placeholder="Многострочное текстовое поле
                "></textarea>
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


    <div class="button action" onclick="SF_add_TextArea('SFFindForm', 'Fnd')">Вставить</div>

</div>




<div class="formscreaterfind" id="menuImageLoadFnd">
    <strong>Загрузка изображений</strong><br>
    пример:<br/>
    <input type="file" accept="image/jpeg,image/png,image/gif">
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
    <div class="button action" onclick="SF_add_ImageLoad('SFFindForm', 'Fnd')">Вставить</div>
</div>







<div class="formscreaterfind" id="menuTextAjaxFnd">
    <strong>Текстовое поле с Ajax подсказкой</strong><br>
    пример:<br/>
    <input type="text">
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


    <div class="button action" onclick="SF_add_TextAjax('SFFindForm', 'Fnd')">Вставить</div>

</div>




<div class="formscreaterfind" id="menuSelectFnd">
    <strong>Меню выбора</strong><br>
    Пример:<br/>
    <select>
        <option>Пункт 1</option>
        <option>Пункт 2</option>
    </select>
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
                <div id="helper"></div>
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


    <div class="button action" onclick="SF_add_Select('SFFindForm', 'Fnd')">Вставить</div>

</div>



<div class="formscreaterfind" id="menuSubmitButtonFnd">
    <strong>Кнопка отправки данных</strong><br>
    пример:<br/>
    <button>Отправка данных</button>
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
    пример:<br/>
    <button>поиск</button>
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





</td>
</tr>
</table>
<input type="hidden" name="nowform" value="">
<input type="hidden" name="act" value="7">
<div class="SFmargin"><input type="submit" class="button button-primary button-large" value="Сохранить изменения"></div>

</form>

</div>

    <h3 onclick="SowHideUniCatForm('outputForm')" class="UniCatPointer">форма вывода данных</h3>
<div class="UniCatDefaulthidden" id="outputForm">
    <div class="titlediv">
        <div class="codeediv">Скопируйте этот код и вставьте его в свой пост или страницу.<br/>[UniCat <?php print 'id="'.$SeeForm . '" formtype="posts"'; ?> postpages="30"]</div>
    </div>
        <form action="" method="POST" enctype="application/x-www-form-urlencoded" >
            <input type="hidden" name="SeeForm" value="<?php print $SeeForm?>">
            <table border="0" class="admin-table wp-list-table bordertable">
                <tr><td colspan="2" class="tableheader">Управление формой вывода данных</td></tr>
                <tr>

                    <td>
                        <h3>Код формы</h3>
                        <textarea class="inputFormsPosition" id="SFUserForm" name="MainUserForm"><?php echo htmlspecialchars($wpdb->get_var("SELECT `outputform` FROM `" . $this->tbl_unicat . "unicat_forms` WHERE id=".$SeeForm." LIMIT 1")); ?></textarea>
                    </td>
                    <td>
                        <h3>Имеющиеся формы:</h3>
                        <?php
                        $needfr=$wpdb->get_var("SELECT `inputform` FROM `" . $this->tbl_unicat . "unicat_forms` WHERE id=".$SeeForm." LIMIT 1");
                        preg_match_all('#\[SForm(.*?)]#',$needfr,$short_codes);//Ищем коды полей
                        $short_codes[0]=array_unique($short_codes[0]);
                        ?>
                        <select id="SelectUserForms">
                            <option selected="selected" disabled="disabled" value="" >Выберите элемент</option>
                            <option value="SFdate" >Дата публикации(dd.mm.yyyy hh:mm)</option>
                            <option value="SFuser" >Имя пользователя</option>
                            <option value="SFpost" >Ссылка на пост</option>
                            <option value="SFphp" >PHP код</option>
                            <option value="SFpubstat" >Статус публикации</option>

                            <?php

                            preg_match_all('#\[SForm(.*?)]#',$needfr,$short_codes);//Ищем коды полей
                            $short_codes[0]=array_unique($short_codes[0]);
                            for ($i=0;$i<count($short_codes[0]);$i++){
                                preg_match('#(?<=name:")(.*?)(?=")#',$short_codes[0][$i],$finding);//Определяем тип поля
                                $flmass[]=$finding[0];
                            }
                            $flmass=array_unique($flmass);
                            for ($i=0;$i<count($flmass);$i++){
                            if ($flmass[$i]!=''){print '<option>'.$flmass[$i].'</option>';}
                            }

                            ?>
                        </select>
                        <br/>
                        Если значение истинно, выводить:<br/>
                        <input type="text" id="onTruePole"><br/>
                        <select onclick="document.getElementById('onTruePole').value=this.value">
                            <?php
                            for ($i=0;$i<count($short_codes[0]);$i++){
                                preg_match('#(?<=name:")(.*?)(?=")#',$short_codes[0][$i],$finding);//Определяем тип поля
                                if ($finding[0]!=''){print '<option>'.$finding[0].'</option>';}
                            }
                            ?>
                        </select>

                        <div class="button action" onclick="SF_outpMenuAdd('')">Вставить</div>
                    </td>
                </tr>
            </table>

            <input type="hidden" name="act" value="3">
            <div class="SFmargin"><input type="submit" class="button button-primary button-large" value="Сохранить изменения"></div>

        </form>
</div>

<h3 onclick="SowHideUniCatForm('podrForm')" class="UniCatPointer">форма вывода подробных данных</h3>
<div class="UniCatDefaulthidden" id="podrForm">
<div class="titlediv">
    <div class="codeediv">Скопируйте этот код и вставьте его в свой пост или страницу.<br/>[UniCat <?php print 'id="'.$SeeForm . '" formtype="full"'; ?>]</div>
</div>
<form action="" method="POST" enctype="application/x-www-form-urlencoded" >
    <input type="hidden" name="SeeForm" value="<?php print $SeeForm?>">
    <table border="0" class="admin-table wp-list-table bordertable">
        <tr><td colspan="2" class="tableheader">Управление формой вывода данных</td></tr>
        <tr>

            <td>
                <h3>Код формы</h3>
                <textarea class="inputFormsPosition" id="SFUserFormPodr" name="MainUserForm"><?php echo htmlspecialchars($wpdb->get_var("SELECT `podrobnoform` FROM `" . $this->tbl_unicat . "unicat_forms` WHERE id=".$SeeForm." LIMIT 1")); ?></textarea>
            </td>
            <td>
                <h3>Имеющиеся формы:</h3>
                <?php
                $needfr=$wpdb->get_var("SELECT `inputform` FROM `" . $this->tbl_unicat . "unicat_forms` WHERE id=".$SeeForm." LIMIT 1");
                preg_match_all('#\[SForm(.*?)]#',$needfr,$short_codes);//Ищем коды полей
                $short_codes[0]=array_unique($short_codes[0]);
                ?>
                <select id="SelectUserFormsPodr">
                    <option selected="selected" disabled="disabled" value="" >Выберите элемент</option>
                    <option value="SFdate" >Дата публикации(dd.mm.yyyy hh:mm)</option>
                    <option value="SFuser" >Имя пользователя</option>
                    <option value="SFpost" >Ссылка на пост</option>
                    <option value="SFphp" >PHP код</option>
                    <option value="SFpubstat" >Статус публикации</option>

                    <?php

                    preg_match_all('#\[SForm(.*?)]#',$needfr,$short_codes);//Ищем коды полей
                    $short_codes[0]=array_unique($short_codes[0]);
                    for ($i=0;$i<count($short_codes[0]);$i++){
                        preg_match('#(?<=name:")(.*?)(?=")#',$short_codes[0][$i],$finding);//Определяем тип поля
                        $flmass[]=$finding[0];
                    }
                    $flmass=array_unique($flmass);
                    for ($i=0;$i<count($flmass);$i++){
                        if ($flmass[$i]!=''){print '<option>'.$flmass[$i].'</option>';}
                    }

                    ?>
                </select>
                <br/>


                <div class="button action" onclick="SF_outpMenuAdd('Podr')">Вставить</div>
            </td>
        </tr>
    </table>

    <input type="hidden" name="act" value="8">
    <div class="SFmargin"><input type="submit" class="button button-primary button-large" value="Сохранить изменения"></div>

</form>
</div>





</div>

