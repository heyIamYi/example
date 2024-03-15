<?php
// 載入資料庫設定
include_once ('conf/db.conf.php');
// 載入資料庫類別
include_once ('include/class/mysql.class.php');
// 宣告資料庫物件
$webdb = new mysql ( $host );
if (version_compare(phpversion(), '5.4.0', '>'))
{
	include_once ('comm/session54.inc.php');
}
else
{
	include_once ('comm/session.inc.php');
}
$no = '';
if(array_key_exists('no', $_GET))
{
	$no = $_GET['no'];
}

//生成验证码图片



//定義亂數字元.

// $SafeCodeChar = "ABCDEFGHIJKLMNPQRSTUVWXYZ123456789";
$SafeCodeChar = "123456789";

$SafeCodeCharLength = strlen($SafeCodeChar);
//定義亂數字元數
$SafeCodeLength = 5;
$_SESSION['authnum'.$no]="";
$im = imagecreate(62,22); //制定图片背景大小
//驗證碼字串
$SafeCode = "";
//產生亂數
for($i=1;$i<=$SafeCodeLength;$i++){
	$SafeCode .= substr($SafeCodeChar,mt_rand(0,($SafeCodeCharLength -1)),1);
}
//文字顏色
$font=imagecolorallocate($im,0x0A,0x02,0x00);
//填入背景色
$back=imagecolorallocate($im,0xC3,0xC5,0xC2);

imagefill($im,0,0,$back); //采用区域填充法，设定（0,0）


//将四位整数验证码绘入图片
$_SESSION['authnum'.$no]=$SafeCode;
imagestring($im, 5, 10, 3, $SafeCode, $font);
// 用 col 颜色将字符串 s 画到 image 所代表的图像的 x，y 座标处（图像的左上角为 0, 0）。
//如果 font 是 1，2，3，4 或 5，则使用内置字体

for($i=0;$i<200;$i++)   //加入干扰象素
{
    $randcolor = ImageColorallocate($im,rand(0,255),rand(0,255),rand(0,255));
    imagesetpixel($im, rand()%70 , rand()%30 , $randcolor);
}
Header("Content-type: image/PNG");
ImagePNG($im);
ImageDestroy($im);
?>
