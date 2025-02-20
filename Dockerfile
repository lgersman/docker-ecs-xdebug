# Use the latest Debian image
FROM debian:12-slim

# Install necessary packages
RUN <<EOF
  apt-get update && apt-get install -y curl php php-cli php-xdebug php-xml php-zip php-curl git unzip wget
  apt-get clean

  # Install Composer
  curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
EOF

# configure xdebug (find ini file in image : is $(find / -path '*/cli/*' -name '*xdebug.ini'))
COPY <<FILE /etc/php/8.2/cli/conf.d/20-xdebug.ini
zend_extension=xdebug.so
xdebug.mode=debug
xdebug.start_with_request=yes
xdebug.discover_client_host=true
xdebug.client_host=host.docker.internal
xdebug.client_port=9005
xdebug.log_level=0
FILE


ENV ECS_VERSION="12.5.8"

COPY --chmod=755 <<FILE /usr/bin/entrypoint.sh
#!/usr/bin/env bash

if [[ ! -f /var/www/html/composer.json ]]; then
  cat <<EOF > /var/www/html/composer.json
{
  "version" : "0.0.1",
  "require": {},
  "config": {
    "platform": {
        "php": "8.2"
    }
  }
}
EOF
fi

if [[ ! -d /var/www/html/vendor ]]; then
  composer config allow-plugins.dealerdirect/phpcodesniffer-composer-installer true
  composer require --dev symplify/easy-coding-standard:12.5.8 --with-dependencies
  composer require --dev wp-coding-standards/wpcs:3.1.0

  # tell phpcs dependency of easy-coding-standard where to find the used standards
  ./vendor/symplify/easy-coding-standard/vendor/squizlabs/php_codesniffer/bin/phpcs --config-set installed_paths '../../../../../phpcsstandards/phpcsextra,../../../../../phpcsstandards/phpcsutils,../../../../../wp-coding-standards/wpcs'
fi

exec  \$@
FILE

# create user/group to run ecs as non-root
RUN groupadd --gid 1000 php && useradd --uid 1000 --gid php --shell /bin/sh --create-home php
USER php

# Set the working directory
WORKDIR /var/www/html

VOLUME [ "/var/www/html" ]

# Set the entrypoint
ENTRYPOINT ["/usr/bin/entrypoint.sh"]

CMD [ "/bin/bash" ]
