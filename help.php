<h1>UniCat - ниверсальный каталог</h1>

<h3>Содержание</h3>
<ul>
    <li><a href="#Install">Установка</a></li>
    <li><a href="#Menu">Меню</a></li>
    <li><a href="#Forms">Управление формами</a></li>
    <li><a href="#CreatePole">Создание полей</a></li>
    <li><a href="#ModeratePole">Модерация данных</a></li>
    <li><a href="#ManyPosts">Множественный постинг</a></li>
</ul>
<h3>Установка</h3>
<a name="Install"></a>
<p>Установка плагина производится стандартными методами Wordpress. Необходимо распаковать файл плагина в папку wp-cintent/plugins/ в директорию с установленным Wordpress.<br/>Затем, в мнею плагины необходимо активировать плагин UniCat</p>
<br/>
<a name="Menu"></a>
<h3>Меню</h3>
<p>Плагин имеет несколько пунктов меню:
<ul>
    <li><strong>UniCat</strong> - отвечает за модерацию данных</li>
    <li><strong>Формы</strong> - управление формами (создание/редактирование/удаление)</li>
    <li><strong>Импорт/экспорт</strong> - возможность сохранять и загружать настройки плагина</li>
    <li><strong>Помощь</strong> - справочная информация</li>
</ul>
</p><br/>


<a name="Forms"></a>
<h3>Управление формами</h3>
<p>При установке - плагин автоматически создает тестовую форму с именем "Форма 1".</p>
<p><strong>Создание формы:</strong><br/>
Для создания формы, в данном меню необходимо нажать кнопку "Добавить новую".<br/>
    В появившемся меню необходимо указать базовые настройки формы: Название, стандартное количество дней публикации формы и e-mail адреса модераторов формы. На указанные адреса будут приходить уведомления.<br/>
    В случае необходимости указать сразу несколько адресов - они указываются через запятую с пробелом. Например: <span style="background: #ddd; font-weight: bold">mail1@webaddress.com, mail2@webaddress.com</span><br/>
    Если нет необходимости следить за новыми публикациями - поле модераторских e-mail'ов можно оставить пустым.<br/>
    После вышеприведенных действий нажмите кнопку <span style="background: #ddd; font-weight: bold">Создать</span>. Вы попадете в меню форм, где их можно изменить.
</p>
<p><strong>Изменение форм</strong><br/>
Нажав на кнопку <span style="background: #ddd; font-weight: bold">изменить</span> под формой открывается меню содержания формы.<br/>
    Меню содержания формы содержит дополнительное поле <span style="background: #ddd; font-weight: bold">Сообщение об успешном добавлении:</span>, в котором необходимо ввести текст, который будет отображаться пользователю при успешном заполнении объявления.<br/>
    Так же меню форм содержит область <span style="background: #ddd; font-weight: bold">Содержимое форм</span>, в котором содержаться следующие пункты, разворачивающиеся при клике:
    <ul>
    <li><strong>Форма ввода данных</strong> - главная форма, предназначенная для создания объявлений. Имеет Short-code вида  <span style="background: #ddd; font-weight: bold">[UniCat id="#" formtype="inp"]</span></li>
    <li><strong>Форма поиска данных</strong> - форма поиска данных, должна выводиться на одной странице с формой вывода данных. Имеет Short-code вида  <span style="background: #ddd; font-weight: bold"> [UniCat id="#" formtype="fnd"]</span></li>
    <li><strong>Форма вывода данных</strong> - предназначена для вывода данных. Если данная форма находится на одной странице с формой поиска, то данная форма содержит результаты поиска. Имеет Short-code вида  <span style="background: #ddd; font-weight: bold"> [UniCat id="1" formtype="posts" postpages="30"] </span>, где <span style="background: #ddd; font-weight: bold">postpages="30"</span> - максимальное количество объявлений на страницу. Данное значение может быть изменено </li>
    <li><strong>Форма вывода подробных данных</strong> - повторяет назначение формы вывода данных. Рекомендуется использовать в качестве формы отображения более полных данных  <span style="background: #ddd; font-weight: bold"> [UniCat id="#" formtype="full"] </span></li>
    </ul>
Каждая форма имееет поле  <span style="background: #ddd; font-weight: bold">Код формы</span>(место, куда записывается HTML/Javascript формы), меню создания и выбора полей.
</p><br/>

<a name="CreatePole"></a>
<h3>Создание полей</h3>
<p>
    При вставке нового поля - оно автоматически сохраняется. Позже к этому полю можно обратиться в меню "Существующие поля".<br/> Все поля имеют параметр "Обязвтельное поле?", при включении которого пользователь не сможет отправить данные формы, если данное поле будет незаполненным. Так же имеется параметр "Описание поля", служащий подсказкой администратору, и не выводится в форме. После настройки параметров формы -нажмите кнопку "Вставить", для вставки кода поля в код формы.
    Возможно создавать следующие типы полей:<br/>
    <p><strong>Короткий текст</strong> - стандартное поле с типом "text". Имеет параметры: <br/>
<div class="codeediv" style="width: 300px">
    пример:<br/>
    <input type="text" placeholder="Короткий текст">
</div>
    <strong>Name</strong> - обязательно для заполнения (в случае незаполнения сгенерируется автоматически). Служит идентификатором поля в базе данных. Задается латинскими буквами<br/>
    <strong>class</strong> - не обязательное поле, содержит класс css<br/>
    <strong>id</strong> - не обязательное поле, содержит идентификатор элемента<br/>
    <strong>maxlenght</strong> - максимально допустимое количество символов, доступное для данного поля<br/>
    <strong>Значение по умолчанию</strong> - значение, которое будет установлено по умолчанию, при загрузке страницы.<br/>
    <strong>Подсказка</strong> - текст подсказки (placeholder)<br/>
</p><br/>

<p><strong>Число</strong> - числовое поле позволяющее вводить только цифры. Имеет параметры: <br/>
<div class="codeediv" style="width: 300px">
    пример:<br/>
    <input type="text" placeholder="123456" onkeyup="onlyNumbers(this)">
</div>
<strong>Name</strong> - обязательно для заполнения (в случае незаполнения сгенерируется автоматически). Служит идентификатором поля в базе данных. Задается латинскими буквами<br/>
<strong>class</strong> - не обязательное поле, содержит класс css<br/>
<strong>id</strong> - не обязательное поле, содержит идентификатор элемента<br/>
<strong>maxlenght</strong> - максимально допустимое количество символов, доступное для данного поля<br/>
<strong>Значение по умолчанию</strong> - значение, которое будет установлено по умолчанию, при загрузке страницы.<br/>
<strong>Подсказка</strong> - текст подсказки (placeholder)<br/>
<strong>Привязка к полю</strong> - в случае, если заполняется форма поиска - данное параметр может содержать имя поля, с которым оно будет сравниваться<br/>
<strong>Логика привязки</strong> - в случае, если заполняется форма поска - устанавливает логику сравнения. Данное поле должно быть точно равно сравниваемому полю, больше его либо меньше<br/>
</p><br/>

<p><strong>Длинный текст</strong> - многострочное текстовое поле. Имеет параметры: <br/>
<div class="codeediv" style="width: 300px">
    пример:<br/>
    <textarea></textarea>
</div>
<strong>Name</strong> - обязательно для заполнения (в случае незаполнения сгенерируется автоматически). Служит идентификатором поля в базе данных. Задается латинскими буквами<br/>
<strong>class</strong> - не обязательное поле, содержит класс css<br/>
<strong>id</strong> - не обязательное поле, содержит идентификатор элемента<br/>
<strong>maxlenght</strong> - максимально допустимое количество символов, доступное для данного поля<br/>
<strong>Значение по умолчанию</strong> - значение, которое будет установлено по умолчанию, при загрузке страницы.<br/>
<strong>Подсказка</strong> - текст подсказки (placeholder)<br/>
</p><br/>

<p><strong>Строгий список</strong> - Выбираемый список. Имеет параметры: <br/>
<div class="codeediv" style="width: 300px">
    пример:<br/>
    <select>
        <option>Значение 1</option>
        <option>Значение 2</option>
        <option>Значение 3</option>
    </select>
</div>
<strong>Name</strong> - обязательно для заполнения. Служит идентификатором поля в базе данных. Задается латинскими буквами<br/>
<strong>class</strong> - не обязательное поле, содержит класс css<br/>
<strong>id</strong> - не обязательное поле, содержит идентификатор элемента<br/>
<strong>Значения</strong> - указываются значения которые будут присутствовать в списке. по одному значению с новой строки.<br/>
<strong>Значения связаны с</strong> - в случае использования нескольких списков - указывает с каким значением другого списка будут связаны данные значения. Например нам необходимо создать два списка - "Производители автомобилей" и "Марки автомобилей". Сначала мы заполняем список производителей, и добавляем поле в код формы. Список марок автомобилей зависит от того, какой выбран производитель. Для этого списка мы указываем, что список связан со списком "Производители", затем указываем поле, к которому будет привязан список, после чего добавляем значения.<br/>
<strong>Родитель для</strong> - в случае использования нескольких зависимых списков в данном поле мы указываем имя списка, который необходимо обновить, после выбора значения в данном списке.<br/>
<strong>По усолчанию пустой</strong> - список будет содержать пустое значение<br/>
<strong>Множественный выбор</strong> - Возможность выбора сразу нескольких значений списка (дополнительным нажатием CTRL или SHIFT)<br/>
<strong>Использовать чекбоксы</strong> - Представить значения списка в виде чекбоксов (используется совместно с множественным выбором) В данном случае отредактируйте класс <span style="background: #ddd; font-weight: bold">UniCatCheckSelect</span> в файле ,ainstyle.css в корневом каталоге плагина<br/>
</p><br/>

<p><strong>Текст с подсказкой</strong> - стандартное поле с типом "text", с всплывающей подсказкой возможных значений. Имеет параметры: <br/>
<div class="codeediv" style="width: 300px">
    пример:<br/>
    <input type="text" placeholder="Короткий текст">
</div>
<strong>Name</strong> - обязательно для заполнения (в случае незаполнения сгенерируется автоматически). Служит идентификатором поля в базе данных. Задается латинскими буквами<br/>
<strong>class</strong> - не обязательное поле, содержит класс css<br/>
<strong>id</strong> - не обязательное поле, содержит идентификатор элемента<br/>
<strong>maxlenght</strong> - максимально допустимое количество символов, доступное для данного поля<br/>
<strong>Значение по умолчанию</strong> - значение, которое будет установлено по умолчанию, при загрузке страницы.<br/>
<strong>Подсказка</strong> - текст подсказки (placeholder)<br/>
<strong>Значение для поиска подсказки</strong> - имя поля, значения которого будут выводиться в подсказке<br/>
</p><br/>

<p><strong>Загрузка изображений</strong> - поле загрузки изображений. Имеет параметры: <br/>
<div class="codeediv" style="width: 300px">
    пример:<br/>
    <input type="file">
</div>
<strong>Name</strong> - обязательно для заполнения (в случае незаполнения сгенерируется автоматически). Служит идентификатором поля в базе данных. Задается латинскими буквами<br/>
<strong>class</strong> - не обязательное поле, содержит класс css<br/>
<strong>id</strong> - не обязательное поле, содержит идентификатор элемента<br/>
<strong>ширина</strong> - ширина изображения в пикселях, в которую будет преобразовано исходное изображение, если оно имеет большее значение<br/>
<strong>высота</strong> - высота изображения в пикселях, в которую будет преобразовано исходное изображение, если оно имеет большее значение<br/>
<strong>Вставить водяной знак </strong> - при включении будет накладывать водяной знак, хранящийся в файле <span style="background: #ddd; font-weight: bold">unicat/user/images/watermark.png</span><br/>
</p><br/>

<p><strong>Переключатель</strong> - составное поле, аозволяющее переключить значение. Имеет параметры: <br/>
<div class="codeediv" style="width: 300px">
    пример:<br/>
    <input type="radio" name="radio1"> <input type="radio" name="radio1">
</div>
<strong>Name</strong> - обязательно для заполнения (в случае незаполнения сгенерируется автоматически). Переключатели одной группы должны иметь одно имя<br/>
<strong>class</strong> - не обязательное поле, содержит класс css<br/>
<strong>id</strong> - не обязательное поле, содержит идентификатор элемента<br/>
<strong>value</strong> - значение переключателя - обязательное поле<br/>
<strong>Значение по умолчанию</strong> - будет ли являеться данный переключатель отмеченным.<br/>
</p><br/>

<p><strong>Чекбокс</strong>. Имеет параметры: <br/>
<div class="codeediv" style="width: 300px">
    пример:<br/>
    <input type="checkbox">
</div>
<strong>Name</strong> - обязательно для заполнения (в случае незаполнения сгенерируется автоматически). Переключатели одной группы должны иметь одно имя<br/>
<strong>class</strong> - не обязательное поле, содержит класс css<br/>
<strong>id</strong> - не обязательное поле, содержит идентификатор элемента<br/>
<strong>Значение по умолчанию</strong> - будет ли являеться данный переключатель отмеченным.<br/>
В случае включения - данное поле имеет значение "1".
</p><br/>

<p><strong>Срок публикации</strong>. Поле ввода даты, с всплывающим календарем. Имеет параметры: <br/>
<strong>class</strong> - не обязательное поле, содержит класс css<br/>
<strong>Значение по умолчанию</strong> - будет ли являеться данный переключатель отмеченным.<br/>
Не более 1 поля на форму
</p><br/>

<p><strong>Кнопка "отправить"</strong>. Кнопка отправки данных на модерацию. Имеет параметры: <br/>
<div class="codeediv" style="width: 300px">
    пример:<br/>
    <button class="button">Создать объявление</button>
</div>
    <strong>class</strong> - не обязательное поле, содержит класс css<br/>
    <strong>текст на кнопке</strong> - текст, который будет отображаться на кнопке<br/>
    <strong>id</strong> - не обязательное поле, содержит идентификатор элемента<br/>
</p><br/>


<p><strong>Кнопка "искать"</strong>. Кнопка поиска данных по полям имеющимся на форме. Имеет параметры: <br/>
<div class="codeediv" style="width: 300px">
    пример:<br/>
    <button class="button">Создать объявление</button>
</div>
<strong>class</strong> - не обязательное поле, содержит класс css<br/>
<strong>текст на кнопке</strong> - текст, который будет отображаться на кнопке<br/>
<strong>id</strong> - не обязательное поле, содержит идентификатор элемента<br/>
</p><br/>


<p>Формы вывода информации имеют собственные поля, помимо созданых:</p>

<p><strong>Дата публикации</strong>. Вставит на форму дату побликации <br/></p><br/>
<p><strong>Имя пользователя</strong>. Вставит на форму имя пользователя создавшего запись <br/></p><br/>
<p><strong>Ссылка на пост</strong>. Вставит параметры GET запроса на пост (например &post=21&act=showall) используется совместно с указанием ссылки на страницу с формой подробных данных. <br/></p><br/>
<p><strong>Идентификатор поста</strong>. Вставит на форму уникальный идентификатор поста<br/></p><br/>
<p><strong>Статус поста</strong>. Вставит на форму статус публикации поста. имеет занчения: 0 - срок публикации не истек, 1 - срок публикации истек<br/></p><br/>
<p><strong>PHP код</strong>. Вставит BB-код php крипта [SForm php][/SForm php]. В параметрах BB кода указывается php скрипт.<div class="codeediv" style="width: 300px">
    пример:<br/>
    [SForm php]if ([SForm pubstatus]==0){print 'еще действует';} else {print 'снято с публикации';}[/SForm php]
</div> <br/>

</p><br/>
</p>

<a name="ModeratePole"></a>
<h3>Модерация данных</h3>
Меню плагина UniCat ткрывает окно модерации, с возможность корректировать введенные пользователем данные, и отправлять их в паблик.
<br/>

<a name="ManyPosts"></a>
<h3>Множественный постинг</h3>
<p>
Множественный постинг позволяет подавать несколько объявлений исключая модерацию данных.<br/>
Для множественного постинга необходимо отправить post-запрос на адрес с формой ввода данных.<br/>
post-запрос должен содержать следующие данные:
    <ul>
    <li><strong>withoutmoder=needwrite</strong> - указываем форме что мы используем множественный постинг</li>
    <li><strong>secretcode=SECRET_CODE</strong> - секретный ключ можно изменить в меню "Импорт/экспорт"</li>
    <li><strong>dataposts=JSON</strong> - данные в формате json</li>
    </ul>
<div class="codeediv" >
    пример:<br/>
    withoutmoder=needwrite&secretcode=123456789101112131415&dataposts={post...}
</div>
Параметр dataposts должен содержать json запрос следующего вида:
<div class="codeediv" >
    <pre>
{
    "post1":{"formsid":"<strong>FORMID</strong>", "userid":"<strong>USERID</strong>", "userlogin":"<strong>USERLOGIN</strong>", "postdate":"<strong>POSTDATE</strong>", "endpub":"<strong>ENDDATE</strong>", "moderated":"<strong>MODERATED</strong>",
        "fields":{
            "field1":{"fieldtype":"<strong>FIELDNAME</strong>", "fielddata":"<strong>FIELDDATA</strong>", "objtype":"<strong>OBJTYPE</strong>"},
            "field2":{"fieldtype":"<strong>FIELDNAME</strong>", "fielddata":"<strong>FIELDDATA</strong>", "objtype":"<strong>OBJTYPE</strong>", "filename":"<strong>FILENAME</strong>"}
        }
    }
}
        </pre>
</div>
где:<br/>
<strong>FORMID</strong> - идентификатор формы<br/>
<strong>USERID</strong> - идентификатор пользователя, от имени которого будет производиться пост<br/>
<strong>USERLOGIN</strong> - логин пользователя, от имени которого будет производиться пост<br/>
<strong>POSTDATE</strong> - время в формате UNIXTIME, указывающее время создания поста<br/>
<strong>ENDDATE</strong> - время в формате UNIXTIME, указывающее время окончания публикации поста<br/>
<strong>MODERATED</strong> - статус модерации поста. Принимает значения: <strong>0</strong> - запись отправляется на модерацию, <strong>1</strong> - апись сразу публикуется<br/>
<strong>FIELDNAME</strong> - имя поля, в которое будет производиться запись<br/>
<strong>FIELDDATA</strong> - содержимое поля<br/>
<strong>OBJTYPE</strong> - тип поля. Может принимать следующие значения:<br/>
&nbsp;&nbsp;&nbsp;&nbsp;<strong>text</strong>  - обычное текстовое поле<br/>
&nbsp;&nbsp;&nbsp;&nbsp;<strong>textarea</strong> - многострочное текстовое поле<br/>
&nbsp;&nbsp;&nbsp;&nbsp;<strong>Select</strong> - список<br/>
&nbsp;&nbsp;&nbsp;&nbsp;<strong>textajax</strong> - текст с подсказкой<br/>
&nbsp;&nbsp;&nbsp;&nbsp;<strong>image</strong> - изображение<br/>
&nbsp;&nbsp;&nbsp;&nbsp;<strong>imageURI</strong> - ссылка на изображение<br/>
&nbsp;&nbsp;&nbsp;&nbsp;<strong>checkbox</strong> - чекбокс<br/>
&nbsp;&nbsp;&nbsp;&nbsp;<strong>number</strong> - цифровое поле<br/>
&nbsp;&nbsp;&nbsp;&nbsp;<strong>radio</strong> - переключатель<br/>
<strong>FILENAME</strong> - имя передаваемого изображения (например kertinka.jpg) Данное поле является обязательным, если <strong>OBJTYPE</strong> принимает значение <strong>image</strong><br/>
<span style="color:#ff0000; font-weight: bold">Все вышеуказанные параметры обязательно должны быть зашифрованы в base64.</span>

<div class="codeediv" >
    Пример json запроса
    <pre>
{
    "post1":{"formsid":"MQ==", "userid":"MTAw", "userlogin":"dGVzdFVzZXI=", "postdate":"MTM3MTYyMzQwNg==", "endpub":"MTM3MjA1NTQwNg==", "moderated":"MQ==",
        "fields":{
        "field1":{"fieldtype":"cHJvaXp2b2Q=", "fielddata":"TGFuZCBSb3Zlcg==", "objtype":"U2VsZWN0"},
        "field2":{"fieldtype":"TWFya2E=", "fielddata":"UmFuZ2UgUm92ZXI=", "objtype":"U2VsZWN0"},
        "field3":{"fieldtype":"eWVhcg==", "fielddata":"", "objtype":"U2VsZWN0"},
        "field4":{"fieldtype":"cnVs", "fielddata":"0LvQtdCy0YvQuQ==", "objtype":"cmFkaW8="},
        "field5":{"fieldtype":"cHJvYmVn", "fielddata":"", "objtype":"bnVtYmVy"},
        "field6":{"fieldtype":"b2JqZW0=", "fielddata":"", "objtype":"bnVtYmVy"},
        "field7":{"fieldtype":"cHJvYmVncG9yZg==", "fielddata":"", "objtype":"Y2hlY2tib3g="},
        "field8":{"fieldtype":"bmV3YXV0bw==", "fielddata":"", "objtype":"Y2hlY2tib3g="},
        "field9":{"fieldtype":"dG9wbGl2bw==", "fielddata":"0LHQtdC90LfQuNC9", "objtype":"cmFkaW8="},
        "field10":{"fieldtype":"a29yb2JrYQ==", "fielddata":"0LDQstGC0L7QvNCw0YI=", "objtype":"cmFkaW8="},
        "field11":{"fieldtype":"cHJpdm9k", "fielddata":"0L/QtdGA0LXQtNC90LjQuQ==", "objtype":"cmFkaW8="},
        "field12":{"fieldtype":"YmV6ZG9j", "fielddata":"", "objtype":"Y2hlY2tib3g="},
        "field13":{"fieldtype":"Yml0eWo=", "fielddata":"", "objtype":"Y2hlY2tib3g="},
        "field14":{"fieldtype":"b3Bpc2FuaWU=", "fielddata":"", "objtype":"dGV4dGFyZWE="},
        "field15":{"fieldtype":"Z3RjYXI=", "fielddata":"", "objtype":"Y2hlY2tib3g="},
        "field16":{"fieldtype":"cHJpY2U=", "fielddata":"", "objtype":"bnVtYmVy"},
        "field17":{"fieldtype":"c3RhdHVzbmFsaWNoaWU=", "fielddata":"0LIg0L3QsNC70LjRh9C40Lg=", "objtype":"cmFkaW8="},
        "field18":{"fieldtype":"cGhvbmUx", "fielddata":"", "objtype":"dGV4dA=="},
        "field19":{"fieldtype":"cGhvbmUy", "fielddata":"", "objtype":"dGV4dA=="},
        "field20":{"fieldtype":"ZW1haWw=", "fielddata":"", "objtype":"dGV4dA=="},
        "field21":{"fieldtype":"aW1hZ2Ux", "fielddata":"aHR0cDovL3d3dy50ZWFtLWJocC5jb20vZm9ydW0vaWlwY2FjaGUvODEzNTIuanBn", "objtype":"aW1hZ2VVUkk="},
        "field22":{"fieldtype":"aW1hZ2Uy", "fielddata":"/9j/4AAQSkZJRgABAQAAAQABAAD//gA8Q1JFQVRPUjogZ2QtanBlZyB2MS4wICh1c2luZyB ...
        JSkcgSlBFRyB2NjIpLCBxdWFsaXR5ID0gMTAwCv/S3E8pTKyk7DJI23JAJ24zgZzivLftd1/z8Tf8Afx/8aKK6zA//2Q==", "objtype":"aW1hZ2U=", "filename":"MTIzLmpwZw=="}
        }
    },
    "post2":{"formsid":"MQ==", "userid":"MTAw", "userlogin":"dGVzdFVzZXI=", "postdate":"MTM3MTYyMzQwNg==", "endpub":"MTM3MjA1NTQwNg==", "moderated":"MQ==",
        "fields":{
        "field1":{"fieldtype":"cHJvaXp2b2Q=", "fielddata":"TGFuZCBSb3Zlcg==", "objtype":"U2VsZWN0"},
        "field2":{"fieldtype":"TWFya2E=", "fielddata":"UmFuZ2UgUm92ZXI=", "objtype":"U2VsZWN0"},
        "field3":{"fieldtype":"eWVhcg==", "fielddata":"", "objtype":"U2VsZWN0"}
        }
    }
 }
        </pre>
</div>



</p>
