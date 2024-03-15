<?php
$config = include '../config/config.php';
ini_set('display_errors','off');
if(!defined('ROOT_PATH')){
    define('ROOT_PATH',dirname(dirname(dirname(dirname(__FILE__)))).DIRECTORY_SEPARATOR);
}
try{
    $file=$_FILES['upload']['name'];
    $type=(int)$_GET['type'];
    $extension='.'.strtolower(pathinfo($file, PATHINFO_EXTENSION));
    // 檢查可上傳格式
    $uploadConfig = array();
    if (!$config['ext_blacklist']) {
        $uploadConfig['accept_file_types'] = '/\.(' . implode('|', $config['ext']) . ')$/i';
        if ($config['files_without_extension']) {
            $uploadConfig['accept_file_types'] = '/((\.(' . implode('|', $config['ext']) . ')$)|(^[^.]+$))$/i';
        }
    } else {
        $uploadConfig['accept_file_types'] = '/\.(?!' . implode('|', $config['ext_blacklist']) . '$)/i';
        if ($config['files_without_extension']) {
            $uploadConfig['accept_file_types'] = '/((\.(?!' . implode('|', $config['ext_blacklist']) . '$))|(^[^.]+$))/i';
        }
    }
    if (!preg_match($uploadConfig['accept_file_types'], $extension)) $error='Filetype not allowed ('.$extension.')';
    if ($error) throw new Exception($error);

    if($type == 1){ //圖
        $typeFilder = 'files/';
    } else if($type == 2){ //文件
        $typeFilder = 'files/';
    } else {
        throw new Exception('參數錯誤');
    }

    $filderPath = ROOT_PATH.'upload'.DIRECTORY_SEPARATOR.$typeFilder;
    if(!file_exists($filderPath)){
        mkdir($filderPath, 0777, true);
    }

    $filetmp=$_FILES['upload']['tmp_name'];
    $debug = move_uploaded_file($filetmp,ROOT_PATH.'upload'.DIRECTORY_SEPARATOR.$typeFilder.$file);
    $function_number=$_GET['CKEditorFuncNum'];
    $url='/upload/'.$typeFilder.$file;
    $message='';
    echo json_encode([
        "uploaded" =>  1,
        "fileName"=> $file,
        "url" => $url
    ]);
} catch (Exception $e){
    echo json_encode([
        "uploaded" =>  0,
        "error" => [
            "message" => $e->getMessage()
        ]
    ]);
}
?>