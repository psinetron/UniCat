
function SF_add_simpleText(txarea, postfix, formaid){ //Вставляем простой текст
    var MainF='';

    MainF+='\r\n[SForm type:"text"';
    if (document.getElementById('NameSimpleText'+postfix).value==''){
        MainF+=' name:"SFt'+(Math.round(Math.random()*1001)+'"');
    } else {
        MainF+=' name:"'+document.getElementById('NameSimpleText'+postfix).value+'"';
    }
    if (document.getElementById('IdSimpleText'+postfix).value!=''){MainF+=' id:"'+ document.getElementById('IdSimpleText'+postfix).value+'"';}
    var Obz=''
    var Clsobj='';
    if (document.getElementById('ObzSimpleText'+postfix).checked){Obz=' FSneeedlePL ';}
    if (document.getElementById('ClassSimpleText'+postfix).value!=''){Clsobj= document.getElementById('ClassSimpleText'+postfix).value;}
    MainF+=' class:"'+ Obz + Clsobj +'"';

    if (document.getElementById('MaxLenSimpleText'+postfix).value!=''){MainF+=' maxlen:' + document.getElementById('MaxLenSimpleText'+postfix).value;}
    if (document.getElementById('PlaceholdSimpleText'+postfix).value!=''){MainF+=' placehold:"' +  encodeURIComponent(document.getElementById('PlaceholdSimpleText'+postfix).value)+'"';}
    if (document.getElementById('ValueSimpleText'+postfix).value!=''){MainF+=' value:"' + encodeURIComponent(document.getElementById('ValueSimpleText'+postfix).value)+'"';}
    MainF+=']';
    document.getElementById(txarea).value+=MainF;
    myCodeMirror[txarea].setValue(myCodeMirror[txarea].getValue()+MainF)
    SavePole(formaid, MainF, document.getElementById('hintSimpleText'+postfix).value)

}



function SF_add_number(txarea, postfix, formaid){
    var MainF=''
    MainF+='\r\n[SForm type:"number"';
    if (document.getElementById('NameNumber'+postfix).value==''){
        MainF+=' name:"SFnum'+(Math.round(Math.random()*1001)+'"');
    } else {
        MainF+=' name:"'+document.getElementById('NameNumber'+postfix).value+'"';
    }
    if (document.getElementById('IdNumber'+postfix).value!=''){MainF+=' id:"'+ document.getElementById('IdNumber'+postfix).value+'"';}
    var Obz=''
    var Clsobj='';
    if (document.getElementById('ObzNumber'+postfix).checked){Obz=' FSneeedlePL ';}
    if (document.getElementById('ClassNumber'+postfix).value!=''){Clsobj= document.getElementById('ClassNumber'+postfix).value;}
    MainF+=' class:"'+ Obz + Clsobj +'"';
    if (document.getElementById('ValuePole'+postfix).value!=''){MainF+=' valp:"'+ document.getElementById('ValuePole'+postfix).value+'"';}
    if (document.getElementById('MaxLenNumber'+postfix).value!=''){MainF+=' maxlen:' + document.getElementById('MaxLenNumber'+postfix).value;}
    if (document.getElementById('PlaceholdNumber'+postfix).value!=''){MainF+=' placehold:"' +  encodeURIComponent(document.getElementById('PlaceholdNumber'+postfix).value)+'"';}
    if (document.getElementById('ValueNumber'+postfix).value!=''){MainF+=' value:"' + encodeURIComponent(document.getElementById('ValueNumber'+postfix).value)+'"';}
    MainF+=' logic:"'+document.getElementById('LogicNumber'+postfix).value+'"';
    MainF+=']';
    document.getElementById(txarea).value+=MainF;
    myCodeMirror[txarea].setValue(myCodeMirror[txarea].getValue()+MainF)
    SavePole(formaid, MainF, document.getElementById('hintNumber'+postfix).value)
}


function SF_tabsSelect(tabshow, untabname, tabhide, tabneed, ndform, returnedselect){
tabshow.className='tabs';
document.getElementById(untabname).className='';
document.getElementById(tabhide).style.display='none';
document.getElementById(tabneed).style.display='block';

if (returnedselect!=''){
    GetPole(ndform, returnedselect);
}


}





function SF_add_TextArea(txarea, postfix,formaid){ //Вставляем простой текст
    var MainF='';
    MainF+='\r\n[SForm type:"textarea"';
    if (document.getElementById('NameTextArea'+postfix).value==''){
        MainF+=' name:"SFta'+(Math.round(Math.random()*1001) + '"');
    } else {
        MainF+=' name:"'+document.getElementById('NameTextArea'+postfix).value+'"';
    }
    if (document.getElementById('IdTextArea'+postfix).value!=''){MainF+=' id:"'+ document.getElementById('IdTextArea'+postfix).value+'"';}
    var Obz=''
    var Clsobj='';
    if (document.getElementById('ObzTextArea'+postfix).checked){Obz=' FSneeedlePL ';}
    if (document.getElementById('ClassTextArea'+postfix).value!=''){Clsobj= document.getElementById('ClassTextArea'+postfix).value;}
    MainF+=' class:"'+ Obz + Clsobj +'"';

    if (document.getElementById('MaxLenTextArea'+postfix).value!=''){MainF+=' maxlen:' + document.getElementById('MaxLenTextArea'+postfix).value;}
    if (document.getElementById('PlaceholdTextArea'+postfix).value!=''){MainF+=' placehold:"' + encodeURIComponent(document.getElementById('PlaceholdTextArea'+postfix).value) + '"'; }
    if (document.getElementById('ValueTextArea'+postfix).value!=''){MainF+=' value:"' + encodeURIComponent(document.getElementById('ValueTextArea'+postfix).value) + '"';}
    MainF+=']';
    document.getElementById(txarea).value+=MainF;
    myCodeMirror[txarea].setValue(myCodeMirror[txarea].getValue()+MainF)
    SavePole(formaid, MainF, document.getElementById('hintTextArea'+postfix).value)
}


function SF_add_ImageLoad(txarea, postfix, formaid){ //Вставляем простой текст
    var MainF='';
    MainF+='\r\n[SForm type:"image"';
    if (document.getElementById('NameImageLoad'+postfix).value==''){
        MainF+=' name:"SFim'+(Math.round(Math.random()*1001) + '"');
    } else {
        MainF+=' name:"'+document.getElementById('NameImageLoad'+postfix).value+'"';
    }
    if (document.getElementById('IdImageLoad'+postfix).value!=''){MainF+=' id:"'+ document.getElementById('IdImageLoad'+postfix).value+'"';}
    if (document.getElementById('resizeimage'+postfix).value=='resize'){MainF+=' resize:"1" width:"'+ document.getElementById('WidthImage'+postfix).value+'" height:"'+document.getElementById('HeightImage'+postfix).value+'"';}
    if (document.getElementById('ClassImageLoad'+postfix).value!=''){MainF+=' class:"'+ document.getElementById('ClassImageLoad'+postfix).value+'"';}
    if (document.getElementById('watermarkImage'+postfix).checked){MainF+=' vatermark:"1"';}
    MainF+=']';
    document.getElementById(txarea).value+=MainF;
    myCodeMirror[txarea].setValue(myCodeMirror[txarea].getValue()+MainF)
    SavePole(formaid, MainF, document.getElementById('hintImageLoad'+postfix).value)
}

/**Быстрая отправка формы с отмеченными галочками*/
function speedform(){
    frms=document.getElementsByName('ShortSnd');
    for (i=0;i<frms.length;i++){
        if (frms[i].checked){
            var newInp = document.createElement('input')
            newInp.type='hidden';
            newInp.name='postid[]';
            newInp.value=frms[i].value;
            document.getElementById('formallspeed').appendChild(newInp);
        }
        var newInp = document.createElement('input')
        newInp.type='hidden';
        newInp.name='showfilter';
        newInp.value=document.getElementById('showfltr').value;
        document.getElementById('formallspeed').appendChild(newInp);

    }
return true;
}


/**
 * Отмечаем все галочки
 * @constructor
 */
function FSChexkAll(){
    frms=document.getElementsByName('ShortSnd');
    for (i=0;i<frms.length;i++){
        frms[i].checked=true;
    }
}

/**
 *
 * @constructor
 */
function FSUnChexkAll(){
    frms=document.getElementsByName('ShortSnd');
    for (i=0;i<frms.length;i++){
        frms[i].checked=false;
    }
}

function FSChexkInvert(){
    frms=document.getElementsByName('ShortSnd');
    for (i=0;i<frms.length;i++){
        frms[i].checked=!frms[i].checked;
    }
}






function SF_add_TextAjax(txarea, postfix, formaid){ //Вставляем простой текст
    var MainF='';
    MainF+='\r\n[SForm type:"textajax"';
    if (document.getElementById('NameTextAjax'+postfix).value==''){
        MainF+=' name:"SFtaj'+(Math.round(Math.random()*1001) + '"');
    } else {
        MainF+=' name:"'+document.getElementById('NameTextAjax'+postfix).value+'"';
    }
    if (document.getElementById('IdTextAjax'+postfix).value!=''){MainF+=' id:"'+ document.getElementById('IdTextAjax'+postfix).value+'"';}
    var Obz=''
    var Clsobj='';
    if (document.getElementById('ObzTextAjax'+postfix).checked){Obz=' FSneeedlePL ';}
    if (document.getElementById('ClassTextAjax'+postfix).value!=''){Clsobj= document.getElementById('ClassTextAjax'+postfix).value;}
    MainF+=' class:"'+ Obz + Clsobj +'"';

    if (document.getElementById('MaxLenTextAjax'+postfix).value!=''){MainF+=' maxlen:' + document.getElementById('MaxLenTextAjax'+postfix).value;}
    if (document.getElementById('FieldTextAjax'+postfix).value!=''){MainF+=' field:"' + document.getElementById('FieldTextAjax'+postfix).value+'"';}
    if (document.getElementById('PlaceholdTextAjax'+postfix).value!=''){MainF+=' placehold:"' + encodeURIComponent(document.getElementById('PlaceholdTextAjax'+postfix).value) + '"'; }
    if (document.getElementById('ValueTextAjax'+postfix).value!=''){MainF+=' value:"' + encodeURIComponent(document.getElementById('ValueTextAjax'+postfix).value) + '"';}
    MainF+=']';
    document.getElementById(txarea).value+=MainF;
    myCodeMirror[txarea].setValue(myCodeMirror[txarea].getValue()+MainF)
    SavePole(formaid, MainF, document.getElementById('hintTextAjax'+postfix).value);
}



function SF_add_CheckBox(txarea, postfix,formaid){ //Вставляем простой текст
    var MainF='';
    MainF+='\r\n[SForm type:"checkbox"';
    if (document.getElementById('NameCheckBox'+postfix).value==''){
        MainF+=' name:"SFch'+(Math.round(Math.random()*1001) + '"');
    } else {
        MainF+=' name:"'+document.getElementById('NameCheckBox'+postfix).value+'"';
    }
    if (document.getElementById('IdCheckBox'+postfix).value!=''){MainF+=' id:"'+ document.getElementById('IdCheckBox'+postfix).value+'"';}
    if (document.getElementById('ClassCheckBox'+postfix).value!=''){MainF+=' class:"'+ document.getElementById('ClassCheckBox'+postfix).value+'"';}
    if (document.getElementById('CheckedCheckbox'+postfix).checked){MainF+=' checked:"checked"';}
    if (document.getElementById('valueCheckBox' + postfix)){MainF+=' value:"'+document.getElementById('valueCheckBox' + postfix).value+'"';}
    MainF+=']';
    document.getElementById(txarea).value+=MainF;
    myCodeMirror[txarea].setValue(myCodeMirror[txarea].getValue()+MainF)
    SavePole(formaid, MainF, document.getElementById('hintCheckbox'+postfix).value);
}



function SF_add_Radio(txarea, postfix,formaid){ //Вставляем простой текст
    var MainF='';
    MainF+='\r\n[SForm type:"radio"';
    if (document.getElementById('NameRadio'+postfix).value==''){
        MainF+=' name:"SFrad'+(Math.round(Math.random()*1001) + '"');
    } else {
        MainF+=' name:"'+document.getElementById('NameRadio'+postfix).value+'"';
    }
    if (document.getElementById('IdRadio'+postfix).value!=''){MainF+=' id:"'+ document.getElementById('IdRadio'+postfix).value+'"';}
    if (document.getElementById('ValueRadio'+postfix).value!=''){MainF+=' value:"'+ document.getElementById('ValueRadio'+postfix).value+'"';}
    if (document.getElementById('ClassRadio'+postfix).value!=''){MainF+=' class:"'+ document.getElementById('ClassRadio'+postfix).value+'"';}
    if (document.getElementById('CheckedRadio'+postfix).checked){MainF+=' checked:"checked"';}
    MainF+=']';
    document.getElementById(txarea).value+=MainF;
    myCodeMirror[txarea].setValue(myCodeMirror[txarea].getValue()+MainF)
    SavePole(formaid, MainF, document.getElementById('hintRadio'+postfix).value);
}




function SF_add_Submit(txarea, postfix){
    var MainF='';
    MainF+='\r\n[SForm type:"submit"';
    if (document.getElementById('IdSubmit'+postfix).value!=''){MainF+=' id:"'+ document.getElementById('IdSubmit'+postfix).value+'"';}
    if (document.getElementById('ClassSubmit'+postfix).value!=''){MainF+=' class:"'+ document.getElementById('ClassSubmit'+postfix).value+'"';}
    if (document.getElementById('ValueSubmit'+postfix).value!=''){MainF+=' value:"' + encodeURIComponent(document.getElementById('ValueSubmit'+postfix).value) + '"';}
    MainF+=']';
    myCodeMirror[txarea].setValue(myCodeMirror[txarea].getValue()+MainF)
}


function SF_add_datapicker(txarea, postfix){
    var MainF='';
    MainF+='\r\n[SForm type:"datapicker"';
    if (document.getElementById('ClassDataPicker'+postfix).value!=''){MainF+=' class:"'+ document.getElementById('ClassDataPicker'+postfix).value+'"';}
    MainF+=']';
    myCodeMirror[txarea].setValue(myCodeMirror[txarea].getValue()+MainF)
}



function SF_add_Find(txarea, postfix){
    var MainF='';
    MainF+='\r\n[SForm type:"find"';
    if (document.getElementById('IdFind'+postfix).value!=''){MainF+=' id:"'+ document.getElementById('IdFind'+postfix).value+'"';}
    if (document.getElementById('ClassFind'+postfix).value!=''){MainF+=' class:"'+ document.getElementById('ClassFind'+postfix).value+'"';}
    if (document.getElementById('ValueFind'+postfix).value!=''){MainF+=' value:"' + encodeURIComponent(document.getElementById('ValueFind'+postfix).value) + '"';}
    MainF+=']';
    myCodeMirror[txarea].setValue(myCodeMirror[txarea].getValue()+MainF)
}


function SF_add_Select(txarea, postfix, formaid){ //Вставляем простой текст
    var MainF='';
    MainF+='\r\n[SForm type:"Select"';
    if (document.getElementById('NameSelect'+postfix).value==''){
        MainF+=' name:"SFsel'+(Math.round(Math.random()*1001) + '"');
    } else {
        MainF+=' name:"'+document.getElementById('NameSelect'+postfix).value+'"';
    }
    if (document.getElementById('IdSelect'+postfix).value!=''){MainF+=' id:"'+ document.getElementById('IdSelect'+postfix).value+'"';}
    if (document.getElementById('ClassSelect'+postfix).value!=''){MainF+=' class:"'+ document.getElementById('ClassSelect'+postfix).value+'"';}
    if (document.getElementById('defaultEmptySelect'+postfix).checked){MainF+=' empty:"1"';}
    if (document.getElementById('multiSelect'+postfix).checked){MainF+=' multi:"1"';}
    if (document.getElementById('checksSelect'+postfix).checked){MainF+=' cheks:"1"';}
    MainF+=' child:"'+document.getElementById('contactChildrenSelect'+postfix).value+'"';
    MainF+=' parent:"'+document.getElementById('contactSelect'+postfix).value+'"';
    MainF+=']';
    document.getElementById(txarea).value+=MainF;
    myCodeMirror[txarea].setValue(myCodeMirror[txarea].getValue()+MainF)
    SavePole(formaid, MainF, document.getElementById('hintSelect'+postfix).value);
}



function SF_showMenuAdd(obj, clsname){ //Отображаем нужное нам меню
    var elms=document.getElementsByClassName(clsname);
    for (var i=0;i<elms.length;i++){
        elms[i].style.display='none';
    }
    document.getElementById(obj.value).style.display='block';

}



/*
Удаляем поле
 */
function DeleteCodeInd(SelectVal, forma){
    var Findim=document.getElementById(SelectVal).value.replace(/^\d+/,'');
    if (document.getElementById('SFAdminForm').value.indexOf(Findim)+1){
        alert ('Данное поле присутствует в форме ввода данных!');
        return true;
    }
    if (document.getElementById('SFFindForm').value.indexOf(Findim)+1){
        alert ('Данное поле присутствует в форме поиска данных!');
        return true;
    }
    if (document.getElementById('SFUserForm').value.indexOf(Findim)+1){
        alert ('Данное поле присутствует в форме вывода данных!');
        return true;
    }
    if (document.getElementById('SFUserFormPodr').value.indexOf(Findim)+1){
        alert ('Данное поле присутствует в форме вывода подробных данных!');
        return true;
    }
    var Findid=document.getElementById(SelectVal).value.replace(/\[(.*)\]/,'');

    document.getElementById('ajaxloading').style.display='block';
    var req = getXmlHttp()
    req.abort();
    req.onreadystatechange = function() {
        if (req.readyState == 4) {
            if(req.status == 200) {
                document.getElementById('ajaxloading').style.display='none';
                document.getElementById(SelectVal).innerHTML=req.responseText;
            }
        }
    }
    param='action=deletePoleAdm';
    param+='&forma=' + forma;
    param+='&plid=' + Findid;
    req.open('POST', ajaxurl, true);
    req.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    req.send(param);

}



function SF_outpMenuAdd(postfix){ //Отображаем нужное нам меню
    if (document.getElementById('SelectUserForms'+postfix).value!=''){
        switch (document.getElementById('SelectUserForms'+postfix).value){
            case 'SFdate': myCodeMirror['SFUserForm'+postfix].setValue(myCodeMirror['SFUserForm'+postfix].getValue()+'[SForm date]'); break;
            case 'SFuser': myCodeMirror['SFUserForm'+postfix].setValue(myCodeMirror['SFUserForm'+postfix].getValue()+'[SForm user]');break;
            case 'SFpost': myCodeMirror['SFUserForm'+postfix].setValue(myCodeMirror['SFUserForm'+postfix].getValue()+'[SForm post]');break;
            case 'SFphp': myCodeMirror['SFUserForm'+postfix].setValue(myCodeMirror['SFUserForm'+postfix].getValue()+'[SFormphp][/SFormphp]');break;
            case 'SFpubstat': myCodeMirror['SFUserForm'+postfix].setValue(myCodeMirror['SFUserForm'+postfix].getValue()+'[SForm pubstatus]');break;
            case 'SFpostid': myCodeMirror['SFUserForm'+postfix].setValue(myCodeMirror['SFUserForm'+postfix].getValue()+'[SForm postid]');break;

            default : myCodeMirror['SFUserForm'+postfix].setValue(myCodeMirror['SFUserForm'+postfix].getValue()+document.getElementById('SelectUserForms'+postfix).value.replace(/^\d/,''));break;
            //default: tinyMCE.get('SFUserForm'+postfix).setContent(tinyMCE.get('SFUserForm'+postfix).getContent() + document.getElementById('SelectUserForms'+postfix).value.replace(/^\d/,''));break;
        }


    }
}


/**
 * Выбираем значения списка
 * @param phpfile
 * @constructor
 */
function GetFields(ct){
    document.getElementById('ajaxloading').style.display='block';
    var req = getXmlHttp()
    req.abort();
    req.onreadystatechange = function() {
        if (req.readyState == 4) {
            if(req.status == 200) {
               if (ct==1){ document.getElementById('includeFormSelect').innerHTML=req.responseText;}
               if (ct==2){ document.getElementById('ValueSelect').value=req.responseText;}
               if (ct==3){ document.getElementById('ValueSelect').value=req.responseText;}
                document.getElementById('ajaxloading').style.display='none';
            }
        }
    }
    param='action=getselect';
    param+='&ct=' + ct;
    if (ct==1){param+="&field="+document.getElementById('contactSelect').value;}
    if (ct==2){param+="&field="+document.getElementById('NameSelect').value;}
    if (ct==3){param+="&field="+document.getElementById('subContact').value;}
    req.open('POST', ajaxurl, true);
    req.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    req.send(param);

}




/**
 * Записываем содержимое списка в БД
 * @param phpfile
 * @constructor
 */
function WriteFields(postfix){

    if (document.getElementById('NameSelect'+postfix).value==''){alert ('Следует задать имя!'); return false;}
    document.getElementById('ajaxloading').style.display='block';
    var req = getXmlHttp()
    req.onreadystatechange = function() {
        if (req.readyState == 4) {
            if(req.status == 200) {
                document.getElementById('helper'+postfix).innerHTML=req.responseText;
                document.getElementById('ajaxloading').style.display='none';
            }
        }
    }
    param='action=writeselect';
    if (document.getElementById('subContact'+postfix)){param+="&contact="+document.getElementById('subContact'+postfix).value;} else {param+="&contact=0";}
    param+="&values="+encodeURIComponent(document.getElementById('ValueSelect'+postfix).value);
    param+="&name="+document.getElementById('NameSelect'+postfix).value;

    req.open('POST', ajaxurl, true);
    req.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    req.send(param);

}



/**
 * Получаем поля
 * @param phpfile
 * @constructor
 */
function GetPole(forma, vstavka){
    document.getElementById('ajaxloading').style.display='block';
    var req = getXmlHttp()
    req.onreadystatechange = function() {
        if (req.readyState == 4) {
            if(req.status == 200) {
                document.getElementById('ajaxloading').style.display='none';
                document.getElementById(vstavka).innerHTML=req.responseText;

            }
        }
    }

    param='action=getPOLE';
    param+="&forma="+forma;
    req.open('POST', ajaxurl, true);
    req.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    req.send(param);
}


/**
 *Вставляем код из имеющихся полей
  */
function PasteCodeInd(otkuda,kuda){
    var pastekuda=document.getElementById(otkuda).value
    pastekuda=pastekuda.replace(/^\d+/gm,'');
    myCodeMirror[kuda].setValue(myCodeMirror[kuda].getValue()+pastekuda)

}



function ShowAdmHint(otkuda,kuda){
    document.getElementById('ajaxloading').style.display='block';
    var req = getXmlHttp()
    req.onreadystatechange = function() {
        if (req.readyState == 4) {
            if(req.status == 200) {
                document.getElementById('ajaxloading').style.display='none';
                document.getElementById(kuda).innerHTML=req.responseText.substr(0,req.responseText.length-1);
            }
        }
    }
    param='action=ShowAdmHint';
    var codeid=otkuda.value.match(/^\d+/g);
    param+="&values="+codeid[0];
    req.open('POST', ajaxurl, true);
    req.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    req.send(param);

}



/**
 * Записываем поле в БД
 * @param phpfile
 * @constructor
 */
function SavePole(forma, params, hint){
    var req = getXmlHttp()
    req.onreadystatechange = function() {
        if (req.readyState == 4) {
            if(req.status == 200) {
                document.getElementById('ajaxloading').style.display='none';
            }
        }
    }

    var matches = params.match('(?:name\:")(.*?)(?=")');
    var types=params.match('(?:type\:")(.*?)(?=")');

    param='action=writePOLE';
    param+="&values="+encodeURIComponent(params);
    param+="&hint="+hint;
    param+="&forma=" + forma;
    param+="&name=" + matches[1];
    param+="&type="+types[1];
    req.open('POST', ajaxurl, true);
    req.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    req.send(param);
    document.getElementById('ajaxloading').style.display='block';
}





function SowHideUniCatForm(frmid, SelectorShow, forma){
    var frmDf = document.getElementById(frmid);
    if (frmDf.style.display==''){frmDf.style.display='none';}
    //if (frmDf.style.display=='none'){frmDf.style.display='block';}else{frmDf.style.display='none'}
    if (frmDf.style.display=='none'){jQuery(frmDf).slideDown(400);}else{jQuery(frmDf).slideUp(400); return true;}

    switch (frmid){
        case 'inputForm': showCodeMirror('SFAdminForm');
        case 'findForm': showCodeMirror('SFFindForm');
        case 'outputForm': showCodeMirror('SFUserForm');
        case 'podrForm': showCodeMirror('SFUserFormPodr');
    }


    if (SelectorShow==''){return true;}




    document.getElementById('ajaxloading').style.display='block';
    var req = getXmlHttp()
    req.onreadystatechange = function() {
        if (req.readyState == 4) {
            if(req.status == 200) {
                document.getElementById('ajaxloading').style.display='none';
                if (document.getElementById(SelectorShow)){document.getElementById(SelectorShow).innerHTML=req.responseText; }

            }
        }
    }

    param='action=getPOLE';
    param+='&dpzn=1';
    param+="&forma="+forma;
    req.open('POST', ajaxurl, true);
    req.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    req.send(param);
}


/*
Сохраняем формы
 */

function AdmSaveAllForms(UniCbutton, forma){
    UniCbutton.innerHTML='Сохраняемся...';
    document.getElementById('ajaxloading').style.display='block';
    var req = getXmlHttp()
    req.onreadystatechange = function() {
        if (req.readyState == 4) {
            if(req.status == 200) {
                document.getElementById('ajaxloading').style.display='none';
                UniCbutton.innerHTML='Сохранить все';
                alert

            }
        }
    }
    param='action=AdmSaveAllForms';
   /* param+='&formname=' + encodeURIComponent(document.getElementById('AdmMainNameForm').value);
    param+='&formmails=' + encodeURIComponent(document.getElementById('AdmMainMailsForm').value);
    param+='&formpubdays=' + encodeURIComponent(document.getElementById('AdmMainPubDaysForms').value);
    param+='&formmessform=' + encodeURIComponent(document.getElementById('AdmMainMessForm').value);
    param+='&forminputform=' + encodeURIComponent(tinyMCE.get('SFAdminForm').getContent().replace(/\&quot;/g,'"'));
    param+='&formfindform=' + encodeURIComponent(tinyMCE.get('SFFindForm').getContent().replace(/\&quot;/g,'"'));
    param+='&formpostsform=' + encodeURIComponent(tinyMCE.get('SFUserForm').getContent().replace(/\&quot;/g,'"'));
    param+='&formpodrobnoform=' + encodeURIComponent(tinyMCE.get('SFUserFormPodr').getContent().replace(/\&quot;/g,'"'));*/


   //Старая версия без tinyMCE

    if (myCodeMirror['SFAdminForm']){myCodeMirror['SFAdminForm'].save();}
    if (myCodeMirror['SFFindForm']){myCodeMirror['SFFindForm'].save();}
    if (myCodeMirror['SFUserForm']){myCodeMirror['SFUserForm'].save();}
    if (myCodeMirror['SFUserFormPodr']){myCodeMirror['SFUserFormPodr'].save();}

    param+='&formname=' + encodeURIComponent(document.getElementById('AdmMainNameForm').value);
    param+='&formmails=' + encodeURIComponent(document.getElementById('AdmMainMailsForm').value);
    param+='&formpubdays=' + encodeURIComponent(document.getElementById('AdmMainPubDaysForms').value);
    param+='&formmessform=' + encodeURIComponent(document.getElementById('AdmMainMessForm').value);
    param+='&forminputform=' + encodeURIComponent(document.getElementById('SFAdminForm').value);
    param+='&formfindform=' + encodeURIComponent(document.getElementById('SFFindForm').value);
    param+='&formpostsform=' + encodeURIComponent(document.getElementById('SFUserForm').value);
    param+='&formpodrobnoform=' + encodeURIComponent(document.getElementById('SFUserFormPodr').value);

    param+="&forma="+forma;
    req.open('POST', ajaxurl, true);
    req.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    req.send(param);
}



function getChilds(childname,parentname,mult){
    if (childname==0){return true;}
    var req = getXmlHttp();

    req.onreadystatechange = function() {
        if (req.readyState == 4) {
            if(req.status == 200) {

                fst=document.getElementsByName(childname);

                if (req.responseText!=''){fst[0].innerHTML=req.responseText;}
                fst[0].click();
            }
        }
    }
    param='action=getchildren';
    param+="&parent="+parentname;
    param+="&child="+childname;
    fst=document.getElementsByName(parentname);

    param+="&content="+fst[0].value;

    req.open('POST', ajaxurluser['url'], true);
    req.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    req.send(param);
}



/**
 * Ajax
 * @returns {*}
 */
function getXmlHttp(){
    var xmlhttp;
    try {
        xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
    } catch (e) {
        try {
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        } catch (E) {
            xmlhttp = false;
        }
    }
    if (!xmlhttp && typeof XMLHttpRequest!='undefined') {
        xmlhttp = new XMLHttpRequest();
    }
    return xmlhttp;
}

/**
 * разрешаем вводить только цифры
 * @param obj
 */
function onlyNumbers(obj){
    if (/^[0-9]*?$/.test(obj.value))
        obj.defaultValue = obj.value;
    else
        obj.value = obj.defaultValue;
    if (obj.value=='') {document.getElementById('AddDemonButton').style.display='none';} else {document.getElementById('AddDemonButton').style.display='block';}
}