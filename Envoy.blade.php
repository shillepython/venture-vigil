@servers(['vigil' => 'u236394466@46.17.175.200 -p 65002'])


@task('deploy', ['on' => 'vigil'])
cd /home/u236394466/domains/venture-vigil.pro
set -e
echo "Deploying..."
git pull origin main
php artisan down
php composer.phar install --no-dev --optimize-autoloader
php artisan migrate --force
php artisan config:cache
php artisan event:cache
php artisan route:cache
php artisan view:cache
php artisan up
echo "Done!"
@endtask
