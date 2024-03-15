###

指令相關說明: (指令固定放在 app/Console/Commands)

1. 產生所有後台 controller, model, view (如有使用 map 關鍵字則不會產生相關 view 檔案)

```
php artisan init:setup
```

2. 產生所有 Model

```
php artisan model:gen-all
```

3. 產生 service (字首需要大寫)

```
php artisan make:service ClassName
```

4. 產生所有 Repository (日後可能停用, 此站目前還有使用)

```
php artisan repo:gen-all
```

###

目前網站開發流程

1. 建立 sql 資料表(使用 migration 則跳過此步驟)
2. 透過上面指令依序產生 Controller, Model, View, Repository(目前仍使用)
3. 使用指令 `php artisan init:setup`
4. 寫 Route
5. 簡單後臺基本完成

###

製作相關 Repository,
Models
Controllers

Services 放前後端的邏輯整合
Repositroy 取得資料庫資料

--

# 其他說明

### 資料庫名稱:

```
winkale
```

### 建立完以後, 如果不是複製檔案請先安裝環境

-   如果有 bash 執行, 沒有請略過這步

```
bash buildENV.sh
```

### 接著執行下面指令安裝相關資料

-   安裝的資料可以在 database/seeds/ 裡面找到

```
php artisan init:setup
```

--

### 基本安裝

-   沒有安裝 bash 可參考以下指令依照步驟安裝
```
cp .env.example .env
composer install
php artisan key:generate
php artisan storage:link
cp database/seeds/menuExample.json database/seeds/menus.json
php artisan serve
```

-   記得修改.env 裡面的資料庫設定
-   如果沒有.env 檔案, 請自行建立
-   記得檢查 databases/seeders/menus.json 是否存在, 如果不存在請自行建立
# example
