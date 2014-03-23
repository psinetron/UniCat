/**
 * Вставляем выбранную подсказку в поле
 * @param ndpole
 * @param frm
 * @constructor
 */


jQuery(document).ready(function($) {

    $('input[name="datepublic"]').datepicker(
        {
        maxDate: "+60d",
        minDate: "0d",
        dateFormat: "dd.mm.yy",
        constraintInput:true
        }
    );
});


function AddPodsk(ndpole, frm){
    txtar=document.getElementsByName(ndpole);
    var txt=frm.innerHTML;
    txt=txt.replace(new RegExp('<span>|</span>','g'),'')
    txtar[0].value=txt;
}

/**
 * Выводим всплывающую подсказку
 * @param field
 * @param retid
 * @constructor
 */

function ShowPodsk(field, retid, ndpole){
var Divret=document.getElementById(retid);
    Divret.innerHTML='<img src="'+ajaxurluser['loadingimage']+'" border="0">';
    Divret.style.display='block';
    var req = getXmlHttp()
    req.onreadystatechange = function() {
        if (req.readyState == 4) {
            if(req.status == 200) {
                Divret.innerHTML=req.responseText;
                if (Divret.innerHTML!=''){Divret.style.display='block';} else {Divret.style.display='none';}
            }
        }
    }
    var ndpls=document.getElementsByName(ndpole);
    param='action=showhiddenpodsk';
    param+="&field="+field;
    param+="&ndpole="+ndpole;
    param+="&ndvalue="+encodeURIComponent(ndpls[0].value);
    req.open('POST', ajaxurluser['url'], true);
    req.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    if(ndpls[0].value!=''){req.send(param);} else {Divret.style.display='none';}
}

/**
 * Прячем всплывающую подсказку
 * @param podskId
 */
function hidePodsk(podskId){
    setTimeout(function (){document.getElementById(podskId).style.display='none';}, 300);
}


/**
 * Записываем содержимое списка в БД
 * @param phpfile
 * @constructor
 */
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
    if (mult=='multi'){fst=document.getElementsByName(parentname+ '[]'); } else {fst=document.getElementsByName(parentname);}

    param+="&content="+fst[0].value;

    req.open('POST', ajaxurluser['url'], true);
    req.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    req.send(param);
}

/**
 * Проверка на обязательные поля
 * @returns {boolean}
 * @constructor
 */

function FSAllCorrect(forma){
    var fields=document.getElementsByClassName('FSneeedlePL');
    var truba=false;
    for (var i=0;i<fields.length;i++){
        if (fields[i].value==''){
        newInp = document.createElement('div');
            newInp.onclick=function (){
                this.parentNode.removeChild(this);
            }
            newInp.onmouseover=function (){
                this.parentNode.removeChild(this);
            }

        newInp.className='SFnotfilled';
        newInp.innerHTML='обязательно для заполнения';
        truba=true;
        //forma.appendChild(newInp);
            fields[i].parentNode.insertBefore(newInp,fields[i]);



        }

    }
    if (truba){
        newInp = document.createElement('div');
        newInp.onclick=function (){
            this.parentNode.removeChild(this);
        }
        newInp.onmouseover=function (){
            this.parentNode.removeChild(this);
        }

        newInp.className='SFnotfilled';
        newInp.innerHTML='Заполнены не все обязательные поля';
        forma.appendChild(newInp);
        return false;
    }   else {return true;}
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


function onlyNumbers(obj){
    if (/^[0-9]*?$/.test(obj.value))
        obj.defaultValue = obj.value;
    else
        obj.value = obj.defaultValue;
    if (obj.value=='') {document.getElementById('AddDemonButton').style.display='none';} else {document.getElementById('AddDemonButton').style.display='block';}
}