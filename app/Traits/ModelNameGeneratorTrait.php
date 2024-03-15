<?php
namespace App\Traits;

use Illuminate\Support\Str;

trait ModelNameGeneratorTrait
{
    protected function generateModelName($tablename)
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
