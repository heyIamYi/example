<?php
namespace App\Traits;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


trait BaseControllerTraits
{
    /**
     * 名稱例外處理
     * 例如IconFooter與Icon為同一個Model，但是路徑不同，所以需要例外處理
     */
    protected function exceptionRepo($repoName):String
    {
        // 例外清單 例外名稱 => 實際使用的名稱
        $exceptionArray = [
            'IconFooter' => 'Icon',
        ];

        // 如果提供的 $repoName 存在於例外清單中，則返回對應的值
        if (isset($exceptionArray[$repoName])) {
            return $exceptionArray[$repoName];
        }

        // 如果不存在，則直接返回 $repoName
        return $repoName;
    }

    /**
     * 將路徑轉為Model名稱
     */
    protected function generateModelName($tablename):String
    {
        // 替換 - 與 _ 為空格，這樣我們可以利用 ucwords 將每個單詞的首字母轉換為大寫
        $formattedTableName = str_replace(['-', '_'], ' ', $tablename);

        // 將所有單詞的首字母轉換為大寫
        $studlyCase = ucwords($formattedTableName);

        // 去掉空格
        $modelName = str_replace(' ', '', $studlyCase);

        // 做單數轉換
        $singularModelName = Str::singular($modelName);

        return $singularModelName;
    }
}
