RUN apt-get update \
    && apt-get install -y libpng-dev \
                          libjpeg-dev \
                          libfreetype6-dev \
                          zip \
                          unzip \
                          git \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd \
    && docker-php-ext-install pdo pdo_mysql \
    && docker-php-ext-install zip
