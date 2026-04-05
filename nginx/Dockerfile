FROM nginx:alpine

WORKDIR /var/www

# Laravel code copy
COPY ../ /var/www

# nginx config
COPY default.conf /etc/nginx/conf.d/default.conf