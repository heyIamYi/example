/*
+--------------------------------------------------------
| 项目: 流年基类库--JS脚本库
| 版本: 0.1
| 作者: Liu21st < Liu21st2002@msn.com >
| 文件:
| 功能:
+--------------------------------------------------------
| 版权声明: Copyright◎ 2004-2005 世纪流年 版权所有
| WebURL:   http://blog.liu21st.com
| EMail:    liu21st@gmail.com
+--------------------------------------------------------
*/

/*使用说明
+--------------------------------------------------------
  <form name="form1" onsubmit="return CheckForm(this)">
    <input type="text" name="id" check="^\S+$" warning="id不能为空,且不能含有空格">
    <input type="submit">
  </form>

该方法主要就是设置各个验证项的正则表达式
基本技巧
判断位数 ^.{4,20}
+--------------------------------------------------------
*/

/*
使用范例

<script language="JavaScript" src="Check.js"></script>

<form name="form1" onsubmit="return CheckForm(this)">
test:<input type="text" name="test">不验证<br>
账号:<input type="text" check="^\S+$" warning="账号不能为空,且不能含有空格" name="id">不能为空<br>
密码:<input type="password" check="\S{6,}" warning="密码六位以上" name="id">六位以上<br>
电话:<input type="text" check="^\d+$" warning="电话号码含有非法字符" name="number" value=""><br>
相片上传:<input type="file" check="(.*)(\.jpg|\.bmp)$" warning="相片应该为JPG,BMP格式的" name="pic" value="1"><br>
出生日期:<input type="text" check="^\d{4}\-\d{1,2}-\d{1,2}$" warning="日期格式2004-08-10"  name="dt" value="">日期格式2004-08-10<br>
省份:
<select name="sel" check="^0$" warning="请选择所在省份">
<option value="">请选择
<option value="1">福建省
<option value="2">湖北省
</select>
<br>
选择你喜欢的运动:<br>
游泳<input type="checkbox" name="c" check="^0{2,}$" warning="请选择2项或以上">
篮球<input type="checkbox" name="c">
足球<input type="checkbox" name="c">
排球<input type="checkbox" name="c">
<br>
你的学历:
大学<input type="radio" name="r" check="^0$" warning="请选择一项学历">
中学<input type="radio" name="r">
小学<input type="radio" name="r">
<br>
个人介绍:
<textarea name="txts" check="^[\s|\S]{20,}$" warning="个人介绍不能为空,且不少于20字"></textarea>20个字以上
<input type="submit">
</form>

*/

function $G(id){
    return document.getElementById(id);
}

//预定义验证格式
var RegNames = new Array();
RegNames    =   ['Chinese','Require','Email','Password','Phone','Mobile','Url','Currency','Date','Number','Zip','Username','TwId'];
var RegArray = {
    Require : /.+/,
    Email : /^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/,
    // Password : /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*\W).{8,}$/,
    Password : /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$/,
    // Phone : /^((\(\d{2,3}\))|(\d{3}\-))?(\(0\d{2,3}\)|0\d{2,3}-)?[1-9]\d{6,7}(\-\d{1,4})?$/,
    // Mobile : /^((\(\d{2,3}\))|(\d{3}\-))?13\d{9}$/,
    // Phone : /^(\d{2,3}-\d{3,4}-\d{3,4})+(#\d+)?$/,
    // Mobile : /^\d{4}-\d{3}-\d{3}$/,
    Phone : /^(\d{2,3}-((\d{3,4}-\d{3,4})|(\d{7,8})))+(#\d+)?$/,
    Mobile : /^\d{4}-((\d{3}-\d{3})|(\d{6}))$/,
    Url : /^http:\/\/[A-Za-z0-9]+\.[A-Za-z0-9]+[\/=\?%\-&_~`@[\]\':+!]*([^<>\"\"])*$/,
    Currency : /^(([1-9]\d{0,9})|0)(\.\d{1,2})?$/,
    Zip : /^[1-9]\d{5}$/,
    QQ : /^[1-9]\d{4,8}$/,
    Date : /^\d{4}(-|\/)\d{1,2}(-|\/)\d{1,2}$/,
    Number : /^\d+$/,
    Integer : /^[-\+]?\d+$/,
    Double : /^[-\+]?\d+(\.\d+)?$/,
    English : /^[A-Za-z]+$/,
    Chinese :  /^[\u0391-\uFFE5]+$/,
    Username : /^[A-Za-z0-9]\w{2,}$/,
    UnSafe : /^(([A-Z]*|[a-z]*|\d*|[-_\~!@#\$%\^&\*\.\(\)\[\]\{\}<>\?\\\/\'\"]*)|.{0,5})$|\s/,
    TwId : /^[A-Za-z]\d{9}$/ //2018.1.31加入
}

//主函数
function CheckForm(oForm,target)
{
    var els = (oForm.elements) ? oForm.elements : $(oForm).find('*');
    //遍历所有表元素
    for(var i=0;i<els.length;i++)
    {
        //是否需要验证
        var Check = els[i].getAttribute('check');
        if(Check)
        {
            Check = trim(Check);
            //取得验证的正则字符串
            var sReg = Filter(Check);
            //取得表单的值,用通用取值函数
            var sVal = GetValue(els[i]);
            //字符串->正则表达式,不区分大小写
            // var reg = new RegExp(sReg,"i");
            var reg = new RegExp(sReg);
            var Warning = els[i].getAttribute('warning');
            if(!reg.test(sVal))
            {
                //验证不通过,弹出提示warning
                //els[i].styles.border = '1pt solid orange';
                ShowError(els[i],Warning,target);
                return false;
            }
            if (Check=="TwId" && !TwIdcheck(sVal)) {ShowError(els[i],Warning,target);return false;}
        }
    }
    return true;
}

function ShowError(obj,Warning,target)
{
    if (target==undefined) {
        alert(Warning);
    } else {
        $('#'+target).removeClass('none').show();
        $('#'+target).empty().html('<div style="font-weight:bold;color:red"><img src="'+PUBLIC+'/Images/error.gif" />'+Warning+'</div>');
        this.intval = window.setTimeout(function (){
            //var myFx = new Fx.Style(target, 'opacity',{duration:1000}).custom(1,0);
            $('#'+target).empty().hide();
            },3000);
    }

    //该表单元素取得焦点,用通用返回函数
    GoBack(obj);
}

function CheckEl(els,target)
{
    var sVal = GetValue(els);
    if(!sVal)return false;
        //是否需要验证
        var Check = els.getAttribute('check');
        if(Check)
        {
            //取得验证的正则字符串
            var sReg = Filter(trim(Check));
            //取得表单的值,用通用取值函数
            //字符串->正则表达式,不区分大小写
            var reg = new RegExp(sReg,"i");
            if(!reg.test(sVal))
            {
                //验证不通过,弹出提示warning
                //els.styles.border = '1pt solid orange';
                var Warning = els.getAttribute('warning');
                if (target==undefined)
                {
                    alert(Warning);
                }else {
                    $('#'+target).removeClass('none').show();
                    $('#'+target).empty().html('<div style="font-weight:bold;color:red"><img src="'+PUBLIC+'/images/error.gif" />'+Warning+'</div>');
                }

                //该表单元素取得焦点,用通用返回函数
                GoBack(els);
                return false;
            }else{
                if (target!=undefined){
                    $('#'+target).empty();
                }
            }
        }
    return true;
}

function CheckPwd(source,target,Warning)
{
    // var sVal = GetValue($G(source));
    // var tVal = GetValue($G(target));
    var sVal = GetValue(source);
    var tVal = GetValue(target);
    if(!sVal||!tVal)return false;

    if(sVal!=tVal)
    {
        //验证不通过,弹出提示warning
        //els.styles.border = '1pt solid orange';
            alert(Warning);
        //该表单元素取得焦点,用通用返回函数
        GoBack(source);
        return false;
    }else{
        if (notice!=undefined){
            $('#'+notice).empty();
        }
    }
    return true;
}

function trim(s)
{
    return s.replace( /^\s*/, "" ).replace( /\s*$/, "" );
}

//过滤和转换正则表达式
//支持预定义正则和表达式两种
//预定义正则参考RegNames数组
function Filter(str)
{
    if (RegNames.toString().indexOf(str)!=-1)
    {
        return RegArray[str].toString().replace( /^\/*/, "" ).replace( /\/*$/, "" );
    }
    return str;
}

//通用取值函数分三类进行取值
//文本输入框,直接取值el.value
//单多选,遍历所有选项取得被选中的个数返回结果"00"表示选中两个
//单多下拉菜单,遍历所有选项取得被选中的个数返回结果"0"表示选中一个
function GetValue(el)
{
    //取得表单元素的类型
    var sType = el.type;
    switch(sType)
    {
        case "tel":
        case "email":
        case "date":
        case "time":
        case "text":
        case "number":
        case "hidden":
        case "password":
        case "file":
        case "textarea":  return trim(el.value);
        case "checkbox":
        case "radio": return GetValueChoose(el);
        case "select-one":
        case "select-multiple": return GetValueSel(el);
    }
}

//取得radio,checkbox的选中数,用"0"来表示选中的个数,我们写正则的时候就可以通过0{1,}来表示选中个数
function GetValueChoose(el)
{
    var sValue = "";
    //取得第一个元素的name,搜索这个元素组
    var tmpels = document.getElementsByName(el.name);
    for(var i=0;i<tmpels.length;i++)
    {
        if(tmpels[i].checked)
        {
            sValue += "0";
        }
    }
    return sValue;
}
//取得select的选中数,用"0"来表示选中的个数,我们写正则的时候就可以通过0{1,}来表示选中个数
function GetValueSel(el)
{
    var sValue = "";
    for(var i=0;i<el.options.length;i++)
    {
        //单选下拉框提示选项设置为value=""
        if(el.options[i].selected && el.options[i].value!="")
        {
            sValue += "0";
        }
    }
    return sValue;
}
//通用返回函数,验证没通过返回的效果.分三类进行取值
//文本输入框,光标定位在文本输入框的末尾
//单多选,第一选项取得焦点
//单多下拉菜单,取得焦点
function GoBack(el)
{
    //取得表单元素的类型
    var sType = el.type;
    switch(sType)
    {
        case "tel":
        case "email":
        case "date":
        case "time":
        case "text":
        case "number":
        case "hidden":
        case "password":
        case "file":
        case "textarea":
            el.focus();
            if(document.createRange){
                var rng =  document.createRange();
                rng.collapse(false);
            }else{
                var rng =  el.createTextRange();
                rng.collapse(false);
                rng.select();
            }
        case "checkbox":
        case "radio":
            var els = document.getElementsByName(el.name);
            els[0].focus();
        case "select-one":
        case "select-multiple":
            el.focus();
    }
}

//2018.1.31加入
function TwIdcheck(idStr) {
    var tab = 'ABCDEFGHJKLMNPQRSTUVXYWZIO',
        A1 = [1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 3, 3, 3, 3, 3, 3],
        A2 = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 0, 1, 2, 3, 4, 5],
        Mx = [9, 8, 7, 6, 5, 4, 3, 2, 1, 1];
    if (idStr.length != 10) return;
    var i = tab.indexOf(idStr.toUpperCase().charAt(0));
    if (i == -1) return;
    var sum = A1[i] + A2[i] * 9;
    for (i = 1; i < 10; i++) {
        var v = parseInt(idStr.charAt(i));
        if (isNaN(v)) return;
        sum = sum + v * Mx[i];
    }
    if (sum % 10 != 0) return;
    return true;
};

//2019.7.5加入,檢查副檔名
function CheckFileExt(obj,reg='/gif|jpg|jpeg|bmp|png/',alt='只允許上傳圖片類型檔案!!!') {
  var str="";
  var ext="";
  var cut=0;
  if(obj.value == "" || obj.value == " ") {
    alert("請按「瀏覽」選擇欲上傳的檔案");
    obj.focus();
    return false;
  }
  else {
    str = obj.value.substring(obj.value.lastIndexOf("\\",obj.value.length)+1,obj.value.length);
    str = str.toLowerCase();

    for (var i = 0; i < str.length; i++) {
      ch = str.substring(i, i + 1)
      if (ch == ".") {
        cut++;
      }
    }
    if(cut>1) {
      alert("檔名中請勿含有「.」!!!");
      obj.focus();
      obj.select();
      return false;
    }
    else if (cut==1) {
      ext=str.substring(str.lastIndexOf(".",str.length)+1,str.length);
      if (ext.match(reg)) {
        return true;
      }
      else {
        alert(alt);
        obj.focus();
        obj.select();
        return false;
      }
    }
    else {
      alert(alt);
      obj.focus();
      obj.select();
      return false;
    }
  }
}
