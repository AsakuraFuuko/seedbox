#!/bin/sh

# Install packages
apt-get -q update                      \
&& apt-get --force-yes -y -qq upgrade  \
&& apt-get install -y -q               \
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
cp -f ./overlay/etc/init.d/aria2c /etc/init.d/

cp -rf ./overlay/var/www/. /var/www/
ln -s /home/aria/downloads /var/www/

unlink /etc/nginx/sites-enabled/default
cp -f ./overlay/etc/nginx/sites-available/aria2 /etc/nginx/sites-available/
ln -s /etc/nginx/sites-available/aria2 /etc/nginx/sites-enabled/

chown -R www-data:www-data /var/www/

ln -s /home/aria/downloads /root/downloads

# php-fpm configuration
cp -f ./overlay/etc/php5/fpm/conf.d/50-seedbox.ini /etc/php5/fpm/conf.d/50-seedbox.ini

update-rc.d aria2c defaults
update-rc.d php5-fpm defaults
update-rc.d nginx defaults

service aria2c restart
service php5-fpm restart
service nginx restart
