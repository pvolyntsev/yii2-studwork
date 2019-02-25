# Studwork

## Requirements

PHP 7.0+
MySQL 5.5+
Composer

## Preinstall

### Nginx
```
sudo ln -sf app/nginx/conf/dev.conf /etc/nginx/sites-enabled/dev.conf
sudo service nginx restart
```

### MySQL

```
mysql -uroot <<< "CREATE DATABASE IF NOT EXISTS studwork DEFAULT CHARACTER SET utf8;"
mysql -uroot <<< "GRANT ALL PRIVILEGES ON studwork.* TO studwork@localhost IDENTIFIED BY '123456'"
mysql -uroot <<< "GRANT ALL PRIVILEGES ON studwork.* TO studwork@127.0.0.1 IDENTIFIED BY '123456'"
```

### Application

```
git clone https://github.com/pvolyntsev/yii2-studwork.git
cd yii2-studwork
composer install
```

---

## Примеры запросов

### все публичные
`curl -k "https://studwork.dev/article/index"`

### все публичные и мои
`curl -k -H "Authorization: Bearer 8591df20-8b33-43fa-85d2-2e918699f3c6" "https://studwork.dev/article/index"`

### чужая не опубликованная, не могу посмотреть
`curl -k "https://studwork.dev/article/view?id=5"`

### моя не опубликованная, могу посмотреть
`curl -k -H "Authorization: Bearer 8591df20-8b33-43fa-85d2-2e918699f3c6" "https://studwork.dev/article/view?id=5"`

### аноним, не могу удалить
`curl -k -X DELETE "https://studwork.dev/article/delete?id=1"`

### чужая, не могу удалить
`curl -k -X DELETE -H "Authorization: Bearer 8591df20-8b33-43fa-85d2-2e918699f3c6" "https://studwork.dev/article/delete?id=6"`

### старая, не могу удалить
`curl -k -X DELETE -H "Authorization: Bearer 8591df20-8b33-43fa-85d2-2e918699f3c6" "https://studwork.dev/article/delete?id=1"`

### моя, не старая, могу удалить
`curl -k -X DELETE -H "Authorization: Bearer 8591df20-8b33-43fa-85d2-2e918699f3c6" "https://studwork.dev/article/delete?id=2"`


### аноним, не могу создать
`curl -k -X POST -d "title=123&text=sample text&published_at=2019-03-01 00:11:22" "https://studwork.dev/article/create"`

### могу создать
`curl -k -X POST -H "Authorization: Bearer 8591df20-8b33-43fa-85d2-2e918699f3c6" -d "title=123&text=sample text&published_at=2019-03-01 00:11:22" "https://studwork.dev/article/create"`
