# Symfony5-CRUD-API-test

1.將專案git 下來目的資料夾
```
git clone https://github.com/CODEbyPoHsiang/Symfony5-CRUD-API-test
```
2.進入 資料夾
```
Symfony5-CRUD-API-test
```
.4.設定連接的資料庫及帳號密碼設定 ` .env ` 檔案

```php=
// 修改配置文件
DATABASE_URL=mysql://資料庫使用者名:資料庫密碼@127.0.0.1:3306/資料庫名
```

5.創建資料庫
```php=

// 執行建立資料庫指令
$ php bin/console doctrine:database:create
// 若返回結果如下，即為創建成功
Created database `symfony` for connection named default
```
9.建立資料表"腳本" (尚未寫入資料庫)
```php=
php bin/console make:migration
```
10.建立資料表 (寫到資料庫)

```php=
 bin/console doctrine:migrations:migrate  
```
