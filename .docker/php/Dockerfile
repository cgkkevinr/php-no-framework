FROM php:7.3-fpm
FROM composer

COPY --from=composer /usr/bin/composer /usr/bin/composer

CMD ["php-fpm"]
CMD ["php", "-S", "localhost:8000"]

EXPOSE 8000
EXPOSE 9000