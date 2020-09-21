# PHPstack

```
server{
    listen 80;
    server_name ~.*;

    root /var/www/html/public;

    location ~ /\.  {
        try_files /dev/null @error;
    }

    location ~ \.php {
        try_files /dev/null @error;
    }

    location ~ ^/(.*)\.(jpg|png|css|js|pdf|ico|woff|woff2)$  {
        rewrite ^/(.*)$ /assets/$1 break;
    }

    location / {
        try_files $uri @application;
    }

    location @application {
        include fastcgi_params;
        fastcgi_param SCRIPT_FILENAME $document_root/app.php;
        fastcgi_pass php:9000;
    }

    location @error {
        deny all;
    }
```
