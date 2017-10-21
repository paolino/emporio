docker run --name emporio -d -e "PUID=`id -u $USER`" -e "PGID=`id -g $USER`" -v $(pwd):/var/www/html -p 8080:80 richarvey/nginx-php-fpm
