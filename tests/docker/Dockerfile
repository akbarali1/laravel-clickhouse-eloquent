FROM bitnami/laravel

RUN cd / && composer create-project laravel/laravel app
RUN composer require akbarali1/laravel-clickhouse-eloquent
WORKDIR "/app"
