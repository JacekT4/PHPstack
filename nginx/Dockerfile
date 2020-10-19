FROM nginx:1.19.2-alpine

RUN rm /etc/nginx/conf.d/*
COPY nginx/front-dev.conf /etc/nginx/conf.d/default.conf
ADD nginx/public /var/www/html/public

EXPOSE 80
