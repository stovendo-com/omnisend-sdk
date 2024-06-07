FROM php:8.3-fpm-alpine
ENV COMPOSER_HOME=/.composer
ENV COMPOSER_ALLOW_SUPERUSER=1

WORKDIR /app

COPY --from=mlocati/php-extension-installer --link /usr/bin/install-php-extensions /usr/local/bin/
COPY --from=composer/composer:2-bin --link /composer /usr/bin/composer

RUN apk add --no-cache \
		acl \
		fcgi \
		file \
		gettext \
		git \
	;

RUN set -eux; \
    install-php-extensions \
    	intl \
    	xsl \
    	zip \
    	apcu \
		opcache \
        pdo_pgsql \
        xdebug \
    ;

RUN mkdir -p /.composer/cache
RUN chmod -R 777 $COMPOSER_HOME
RUN mkdir -p "/opt/phpstorm-coverage" && \
    chmod a+rw "/opt/phpstorm-coverage"