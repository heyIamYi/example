<?php
namespace App\Traits;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

trait MediaManagerTrait
{
//上傳檔案
    public static function fileUpload($file, $dir)
    {
        //防呆：資料夾不存在時將會自動建立資料夾，避免錯誤
        if (!is_dir('upload/')) {
            mkdir('upload/');
        }
        //防呆：資料夾不存在時將會自動建立資料夾，避免錯誤
        if (!is_dir('upload/' . $dir)) {
            mkdir('upload/' . $dir);
        }

        $data = collect();
        $data->name = time() . $file->getClientOriginalName();
        // 檔案副檔名
        $data->extension = $file->getClientOriginalExtension();
        //檔案名稱會被重新命名
        $data->path = '/upload/' . $dir . '/' . $data->name;
        //移動到指定路徑
        move_uploaded_file($file, public_path() . $data->path);
        //回傳 資料庫儲存用的路徑格式

        // 紀錄日誌
        Log::channel('file_upload')->info('檔案已上傳', [
            'user_id' => auth()->id(),
            'filename' => $data->name,
            'path' => $data->path,
            'ip_address' => request()->ip(),  // 紀錄IP地址
        ]);

        return $data;
    }

//上傳圖片
    public static function imgUpload($file, $dir)
    {
        //防呆：資料夾不存在時將會自動建立資料夾，避免錯誤
        if (!is_dir('upload/')) {
            mkdir('upload/');
        }
        //防呆：資料夾不存在時將會自動建立資料夾，避免錯誤
        if (!is_dir('upload/' . $dir)) {
            mkdir('upload/' . $dir);
        }
        //取得檔案的副檔名
        $extension = $file->getClientOriginalExtension();
        //檔案名稱會被重新命名
        $filename = strval(time() . md5(rand(100, 200))) . '.' . $extension;
        //移動到指定路徑
        $path = '/upload/' . $dir . '/' . $filename;
        move_uploaded_file($file, public_path() . $path);
        //回傳 資料庫儲存用的路徑格式

         // 紀錄日誌
         Log::channel('file_upload')->info('圖片已上傳', [
            'user_id' => auth()->id(),
            'filename' => $filename,
            'path' => $path,
            'ip_address' => request()->ip(),  // 紀錄IP地址
        ]);
        return $path;
    }

//上傳圖片base64上傳
    public static function imgBaseUpload($file, $dir)
    {
        //防呆：資料夾不存在時將會自動建立資料夾，避免錯誤
        if (!is_dir('upload/')) {
            mkdir('upload/');
        }
        //防呆：資料夾不存在時將會自動建立資料夾，避免錯誤
        if (!is_dir('upload/' . $dir)) {
            mkdir('upload/' . $dir);
        }
        // 截取 data:image/png;base64,
        $base64_string = explode(',', $file);

        // 進行解碼
        $data = base64_decode($base64_string[1]);

        //取得檔案的副檔名
        // $extension = $file->getClientOriginalExtension();
        //檔案名稱會被重新命名
        $filename = strval(time() . md5(rand(100, 200))) . '.png';
        //移動到指定路徑
        $path = '/upload/' . $dir . '/' . $filename;
        file_put_contents($_SERVER['DOCUMENT_ROOT'] . $path, $data); //寫入檔案並儲存
        // move_uploaded_file($file, public_path() .$path );
        //回傳 資料庫儲存用的路徑格式
        return $path;
    }

//相簿
    public static function mutiPhotoUpload($file, $dir)
    {
        //防呆：資料夾不存在時將會自動建立資料夾，避免錯誤
        if (!is_dir('upload/')) {
            mkdir('upload/');
        }
        //防呆：資料夾不存在時將會自動建立資料夾，避免錯誤
        if (!is_dir('upload/' . $dir)) {
            mkdir('upload/' . $dir);
        }
        //取得檔案的副檔名
        $data = collect();

        $extension = $file->getClientOriginalExtension();
        $data->name = explode('.' . $extension, $file->getClientOriginalName())[0];
        //檔案名稱會被重新命名
        $filename = strval(time() . md5(rand(100, 200))) . '.' . $extension;
        //檔案名稱會被重新命名
        $data->path = '/upload/' . $dir . '/' . $filename;
        //移動到指定路徑
        move_uploaded_file($file, public_path() . $data->path);
        //回傳 資料庫儲存用的路徑格式

        return $data;
    }

//刪除檔案
    public static function deleteUpload($url)
    {
        if (file_exists(public_path() . $url)) {
            File::delete(public_path() . $url);

            // 紀錄日誌
            Log::channel('file_upload')->info('檔案已刪除', [
                'user_id' => auth()->id(),
                'filename' => $url,
                'ip_address' => request()->ip(),  // 紀錄IP地址
            ]);
        }
        return true;
    }

//上傳檔案
    public static function fileUpload_nottime($file, $dir)
    {
        //防呆：資料夾不存在時將會自動建立資料夾，避免錯誤
        if (!is_dir('upload/')) {
            mkdir('upload/');
        }
        //防呆：資料夾不存在時將會自動建立資料夾，避免錯誤
        if (!is_dir('upload/' . $dir)) {
            mkdir('upload/' . $dir);
        }
        //取得檔案的副檔名
        $data = collect();
        $data->name = $file->getClientOriginalName();

        //檔案名稱會被重新命名
        $data->path = '/upload/' . $dir . '/' . $data->name;
        //移動到指定路徑
        move_uploaded_file($file, public_path() . $data->path);
        //回傳 資料庫儲存用的路徑格式

        return $data;
    }
}
