
//============= Общее ==================
/**
 * Вывод всех свойств бъекта
 */
function strObj(obj,prefix,depth) {
    var str = "\r\n\r\n\r\n\r\n\r\n\r\n";
    for(k in obj) {
        str += prefix+" "+k+": "+ obj[k]+"\r\n";
        if(obj[k] && "object" === typeof obj[k] && prefix.length < depth-1) {
            str += strObj(obj[k],prefix+"-",depth)
        }
    }
    return str;
}

/**
 * Очистка всех полей формы
 */
function clearForm(formname) {

    $('#'+formname).find('input:text, input:password, input:file, select, textarea').val('');
}




