set -e

echo "Deploying application ..."

# Enter maintenance mode
(php artisan down --message 'The app is being (quickly!) update. Please try again in a minute')
    # Update codebase
    git pull origin master
# Exit maintenance mode
php artisan update

echo "Applicaton deployed!"