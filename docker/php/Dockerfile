ARG PHP_VERSION

# Imagem base
FROM alpine as base

# Construção das dependências
FROM php:${PHP_VERSION}-alpine as build-deps

ENV BUILD_DEPS="autoconf build-base gcc"

RUN set -ex && \
	apk add --update $BUILD_DEPS

FROM build-deps AS xdebug

ARG XDEBUG_VERSION

RUN set -ex; \
	apk add --update linux-headers; \
	# Install Xdebug extension
	[[ -z "${XDEBUG_VERSION}" || "${XDEBUG_VERSION}" == "latest" ]] && XDEBUG_VERSION='' || XDEBUG_VERSION="-${XDEBUG_VERSION}"; \
	pecl install xdebug${XDEBUG_VERSION}; \
	docker-php-ext-enable xdebug;

# Configura Xdebug
RUN { \
	echo 'xdebug.idekey = ${PHP_XDEBUG_IDEKEY}'; \
	echo 'xdebug.profiler_output_name = cachegrind.out.%R-%u'; \
	echo 'xdebug.mode = ${PHP_XDEBUG_MODE}'; \
	echo 'xdebug.start_with_request = yes'; \
	echo 'xdebug.client_host = host.docker.internal'; \
	echo 'xdebug.trace_format = 1'; \
	echo 'xdebug.trace_output_name = trace.out.%R-%u'; \
	echo 'xdebug.log = /tmp/xdebug.log'; \
	echo 'xdebug.output_dir = /data/xdebug'; \
	echo 'xdebug.max_nesting_level = ${PHP_XDEBUG_MAX_NESTING_LEVEL}'; \
} > /usr/local/etc/php/conf.d/xdebug.ini

# https://community.home-assistant.io/t/usr-lib-mariadb-plugin-caching-sha2-password-so-cannot-be-found/439973
FROM build-deps as mariadb-connector

RUN set -ex && \
	apk add --update mariadb-connector-c

# Imagem para o WP-CLI
FROM wordpress:cli-php${PHP_VERSION} as cli

# Corrige falha no uso do comando de ajuda do WP-CLI
ENV PAGER more

# Correção para connectar banco MySQL com MariaDB client
COPY --from=mariadb-connector /usr/lib/mariadb/plugin /usr/lib/mariadb/plugin

# Copia Xdebug
COPY --from=xdebug /usr/local/lib/php/ /usr/local/lib/php/
COPY --from=xdebug /usr/local/etc/php/conf.d/ /usr/local/etc/php/conf.d/

WORKDIR /app

# Imagem para o WordPress com PHP-FPM
FROM wordpress:php${PHP_VERSION}-fpm-alpine AS fpm

# Copia Xdebug
COPY --from=xdebug /usr/local/etc/php/ /usr/local/etc/php/
COPY --from=xdebug /usr/local/lib/php/ /usr/local/lib/php/
COPY --from=xdebug /usr/local/etc/php/conf.d/ /usr/local/etc/php/conf.d/
COPY docker-entrypoint.sh /usr/local/bin/

WORKDIR /app
