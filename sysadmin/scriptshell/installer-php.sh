#!/bin/bash
. `dirname $0`/env.sh

#
sudo apt-get -y install php5 php5-cli php5-curl php5-dev php5-gd php5-geoip php5-imagick php5-imap php5-intl php5-ldap php5-mcrypt php5-mysql php5-pgsql php5-sqlite php5-suhosin php5-tidy php5-xmlrpc php5-xsl libapache2-svn php-pear
sudo apt-get install php-pear php5-imagick php5-xdebug php5-ming php5-ps php5-pspell php5-recode php5-snmp php5-tidy php5-xmlrpc php5-xsl php5-cli php5-idn php5-openssl php-soap
sudo apt-get install libapache2-mod-php5 php5-mysqlnd php5-mongo php5-memcache
sudo apt-get install  php5-memcached gearman
sudo pecl install timezonedb
sudo aptitude clean

# Timezone par défaut :
sudo sed -i -e 's/^;date.timezone =$/date.timezone = Europe\/Paris/' /etc/php5/apache2/php.ini
sudo sed -i -e 's/^;date.timezone =$/date.timezone = Europe\/Paris/' /etc/php5/cli/php.ini

# Quelques paramètres de conf qui ne me conviennent pas, pour une machine de développement / test
sudo sed -i -e 's/^short_open_tag = On$/short_open_tag = Off/' /etc/php5/apache2/php.ini
sudo sed -i -e 's/^;realpath_cache_size = 16k$/realpath_cache_size = 16k/' /etc/php5/apache2/php.ini
sudo sed -i -e 's/^;realpath_cache_ttl = 120$/realpath_cache_ttl = 120/' /etc/php5/apache2/php.ini
sudo sed -i -e 's/^max_execution_time = 30$/max_execution_time = 60/' /etc/php5/apache2/php.ini
sudo sed -i -e 's/^error_reporting = E_ALL & ~E_DEPRECATED$/error_reporting = E_ALL \& E_STRICT/' /etc/php5/apache2/php.ini
sudo sed -i -e 's/^display_errors = Off$/display_errors = On/' /etc/php5/apache2/php.ini
sudo sed -i -e 's/^track_errors = Off$/track_errors = On/' /etc/php5/apache2/php.ini
sudo sed -i -e 's/^html_errors = Off$/html_errors = On/' /etc/php5/apache2/php.ini
sudo sed -i -e 's/^upload_max_filesize = 2M$/upload_max_filesize = 5M/' /etc/php5/apache2/php.ini
sudo sed -i -e 's/^session.gc_maxlifetime = 1440$/session.gc_maxlifetime = 14400/' /etc/php5/apache2/php.ini


# Même chose, dans la conf CLI
sudo sed -i -e 's/^short_open_tag = On$/short_open_tag = Off/' /etc/php5/cli/php.ini
sudo sed -i -e 's/^;realpath_cache_size = 16k$/realpath_cache_size = 16k/' /etc/php5/cli/php.ini
sudo sed -i -e 's/^;realpath_cache_ttl = 120$/realpath_cache_ttl = 120/' /etc/php5/cli/php.ini
sudo sed -i -e 's/^max_execution_time = 30$/max_execution_time = 60/' /etc/php5/cli/php.ini
sudo sed -i -e 's/^error_reporting = E_ALL & ~E_DEPRECATED$/error_reporting = E_ALL \& E_STRICT/' /etc/php5/cli/php.ini
sudo sed -i -e 's/^display_errors = Off$/display_errors = On/' /etc/php5/cli/php.ini
sudo sed -i -e 's/^track_errors = Off$/track_errors = On/' /etc/php5/cli/php.ini
sudo sed -i -e 's/^html_errors = Off$/html_errors = On/' /etc/php5/cli/php.ini
sudo sed -i -e 's/^upload_max_filesize = 2M$/upload_max_filesize = 5M/' /etc/php5/cli/php.ini
sudo sed -i -e 's/^session.gc_maxlifetime = 1440$/session.gc_maxlifetime = 14400/' /etc/php5/cli/php.ini


# Installation de quelques extension via PECL
# => Téléchargement de la dernière version des sources + compilation
# Objectif : être sûr d'avoir une version à jour, pour des extensions qui sont mises à jour potentiellement 
#            plus souvent sur pecl que dans les repositories de la distribution
# (Et pour ces extensions, on veut une version récente / à jour, ne serait-ce que pour les corrections de bugs éventuels)

sudo pecl install xdebug

sudo sh -c "cat > /etc/php5/conf.d/xdebug.ini" <<EOF
zend_extension=/usr/lib/php5/20090626/xdebug.so
xdebug.default_enable = 1
xdebug.overload_var_dump = 1
xdebug.collect_includes = 1
xdebug.collect_params = 2
xdebug.collect_vars = 1
xdebug.show_exception_trace = 0
xdebug.show_mem_delta = 1
xdebug.max_nesting_level = 256
xdebug.var_display_max_children = 256
xdebug.var_display_max_data = 2048
xdebug.var_display_max_depth = 8
xdebug.auto_trace = 0
xdebug.profiler_enable = 0
xdebug.profiler_enable_trigger = 1
xdebug.profiler_append = 0
xdebug.profiler_output_dir = /tmp
xdebug.profiler_output_name = cachegrind.out.%t
EOF


sudo sh -c 'printf "\n" |pecl install apc'

sudo sh -c "cat > /etc/php5/conf.d/apc.ini" <<EOF
extension=apc.so
apc.enabled = 1
apc.ttl = 3600
apc.file_update_protection = 2
apc.stat = 1
apc.shm_size = 128
apc.shm_segments = 1
apc.user_entries_hint = 9000
apc.num_files_hint = 1024
apc.include_once_override = 1
apc.write_lock = 1
apc.localcache = 1
apc.localcache.size = 128
EOF