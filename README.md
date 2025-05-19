# PiGLy

## 環境構築
Dockerビルド
1. git clone git@github.com:hosako-mikako/Pigly.git
2. cd Pigly
3. Docker Desktopを立ち上げる
4. docker compose up -d --build

## Laravel環境構築
1. docker compose exec php bash
2. composer install
3. cp .env.example .env
4. .envに以下の環境変数を追加
```bash
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=laravel_db
DB_USERNAME=laravel_user
DB_PASSWORD=laravel_pass
```
6. アプリケーションキーの作成
```bash
php artisan key:generate
```
6. マイグレーションの実行
```bash
php artisan migrate
```
7. シーディングの実行
```bash
php artisan db:seed
```
8. シンボリックリンクの作成
```bash
php artisan storage:link
```

## 使用技術
```bash
フレームワーク: Laravel 8.83.8
PHP: 7.4.9
環境: Docker-compose, Ubuntu
データベース: MySQL
認証: Laravel Fortify
フロントエンド: Bootstrap Icons, JavaScript, CSS
```

## テーブル設計
https://docs.google.com/spreadsheets/d/12eEnjc1Ow_REYeV9ZV3gBhJvbEdTPuwzZJqXlWmjauU/edit?usp=sharing

## ER図
https://drive.google.com/file/d/1HAG6KpTYfCncjte4Nn6CuQz2aL2ZTeP7/view?usp=sharing

## URL
開発環境：http://localhost/
phpMyAdmin:：http://localhost:8080/



