#!/bin/sh
set -e

# Railway dapat mengaktifkan lebih dari satu MPM Apache; pastikan hanya prefork.
a2dismod mpm_worker 2>/dev/null || true
a2dismod mpm_event 2>/dev/null || true
a2dismod mpm_itk 2>/dev/null || true
a2enmod mpm_prefork >/dev/null 2>&1 || true

# Apache harus mendengarkan port yang Railway berikan via $PORT.
PORT="${PORT:-80}"
sed -i "s/Listen 80/Listen ${PORT}/g" /etc/apache2/ports.conf
sed -i "s/VirtualHost \*:80/VirtualHost \*:${PORT}/g" /etc/apache2/sites-available/000-default.conf
sed -i "/^<VirtualHost/,/^<\/VirtualHost>/{s/:\*:80/*:${PORT}/g}" /etc/apache2/conf-available/*.conf 2>/dev/null || true

# Salin data awal ke volume saat pertama kali dijalankan (data dari image /seed)
# Database disimpan di dalam /var/www/html/storage agar satu volume mencakup keduanya.
if [ ! -s /var/www/html/storage/database/database.sqlite ]; then
    mkdir -p /var/www/html/storage/database
    cp /seed/database.sqlite /var/www/html/storage/database/database.sqlite
fi
chown -R www-data:www-data /var/www/html/storage/database
chmod 664 /var/www/html/storage/database/database.sqlite

if [ ! -e /var/www/html/storage/app/public/.seeded ]; then
    mkdir -p /var/www/html/storage/app/public
    cp -rn /seed/public/. /var/www/html/storage/app/public/
    touch /var/www/html/storage/app/public/.seeded
fi
chown -R www-data:www-data /var/www/html/storage/app/public

# Pastikan public/storage mengarah ke folder upload
php artisan storage:link || true

exec apache2-foreground