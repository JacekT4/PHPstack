# PHPstack


```
version: "3.5"

  nginx:
    image: nginx:1.16.1-alpine
    restart: on-failure
    depends_on:
      - php

  php:
    build:
      context: .
      dockerfile: docker/php/Dockerfile
    restart: on-failure
```

