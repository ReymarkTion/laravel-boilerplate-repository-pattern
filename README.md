# Shiftech Marine Admin API

### Clone repository
```
git clone https://github.com/ReymarkTion/laravel-boilerplate-repository-pattern.git
```

### Setup environment
```
cp .env.example .env
cp .env.testing.example .env.testing
touch database\database.sqlite
```


### create database
```
mysql -u root -p
create database repository_pattern_boilerplate
```

### setup environment
```
composer install
php artisan cache:clear && php artisan config:clear
php artisan migrate --seed && php artisan passport:install
```

### run tests
```
php artisan test
```