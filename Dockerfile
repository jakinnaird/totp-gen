FROM php:8.2-cli

RUN apt-get update && apt-get install -y \
		libfreetype-dev \
		libjpeg62-turbo-dev \
		libpng-dev \
	&& docker-php-ext-configure gd --with-freetype --with-jpeg \
	&& docker-php-ext-install -j$(nproc) gd

COPY . /usr/src/app
WORKDIR /usr/src/app

EXPOSE 8080

CMD ["php", "-S", "0.0.0.0:8080", "./index.php" ]
