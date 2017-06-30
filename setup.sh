#!/bin/sh

# Install packages
apt-get -q update                      \
&& apt-get --force-yes -y -qq upgrade  \
&& apt-get install -y -q               \
     supervisor                        \
     aria2                             \
     nginx                             \
     php5-cli php5-fpm                 \
     mediainfo unzip unrar             \
     libav-tools                       \
&& apt-get clean


# web and aria2 configuration
adduser aria --disabled-password --gecos ''     \
&& mkdir -p /home/aria/downloads/public         \
&& chown -R aria:aria /home/aria/

cp -rf ./overlay/home/aria/. /home/aria/
cp -f ./overlay/etc/supervisor/conf.d/aria2.conf /etc/supervisor/conf.d/

cp -rf ./overlay/var/www/. /var/www/
ln -s /home/aria/downloads /var/www/

unlink /etc/nginx/sites-enabled/default
cp -f ./overlay/etc/nginx/sites-available/aria2 /etc/nginx/sites-available/
ln -s /etc/nginx/sites-available/aria2 /etc/nginx/sites-enabled/

chown -R www-data:www-data /var/www/

ln -s /home/aria/downloads /root/downloads

# php-fpm configuration
cp -f ./overlay/etc/php5/fpm/conf.d/50-scaleway.ini /etc/php5/fpm/conf.d/50-scaleway.ini
