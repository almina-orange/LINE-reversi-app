web: vendor/bin/heroku-php-nginx -C nginx_app.conf
rewrite /imgs/(.*)/(.*)/(.*)$ /boardImageGenerator.php?stones=$1&size=$3 break;

index index.php;
