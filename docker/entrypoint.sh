#!/bin/sh
set -e

# Salin data awal ke volume saat pertama kali dijalankan (data dari image /seed)
if [ ! -s /var/www/html/database/database.sqlite ]; then
    cp /seed/database.sqlite /var/www/html/database/database.sqlite
fi

if [ ! -e /var/www/html/storage/app/public/.seeded ]; then
    mkdir -p /var/www/html/storage/app/public
    cp -rn /seed/public/. /var/www/html/storage/app/public/
    touch /var/www/html/storage/app/public/.seeded
fi

# Pastikan public/storage mengarah ke folder upload
php artisan storage:link || true

exec apache2-foreground