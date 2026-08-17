#!/bin/sh
set -e

# Salin data awal ke volume saat pertama kali dijalankan (data dari image /seed)
# Database disimpan di dalam /var/www/html/storage agar satu volume mencakup keduanya.
if [ ! -s /var/www/html/storage/database/database.sqlite ]; then
    mkdir -p /var/www/html/storage/database
    cp /seed/database.sqlite /var/www/html/storage/database/database.sqlite
fi

if [ ! -e /var/www/html/storage/app/public/.seeded ]; then
    mkdir -p /var/www/html/storage/app/public
    cp -rn /seed/public/. /var/www/html/storage/app/public/
    touch /var/www/html/storage/app/public/.seeded
fi

# Pastikan public/storage mengarah ke folder upload
php artisan storage:link || true

exec apache2-foreground