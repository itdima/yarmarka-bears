/**
 * Created by Дима on 21.12.2015.
 */
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