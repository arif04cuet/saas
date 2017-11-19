/**
 * Created with JetBrains PhpStorm.
 * User: Masud
 * Date: 4/5/14
 * Time: 3:40 AM
 * To change this template use File | Settings | File Templates.
 */
function clearFldVal(fld){
    $(fld).val('');
    $(fld).text('');
}

function goBack()
{
    window.history.back()
}
