#!/bin/sh
set -e

echo "🚀 Laravel container starting..."

if [ "$APP_ROLE" = "app" ]; then
    # Create .env if it does not exist
    if [ ! -f .env ]; then
        cp .env.example .env
    fi

    # Wait for MySQL to be ready
    echo "⏳ Waiting for MySQL..."
    until php -r "
    try {
        new PDO(
            'mysql:host=' . getenv('DB_HOST') . ';dbname=' . getenv('DB_DATABASE'),
            getenv('DB_USERNAME'),
            getenv('DB_PASSWORD')
        );
    } catch (Exception \$e) {
        exit(1);
    }
    "; do
      sleep 2
    done

    echo "✅ MySQL is ready"

    # Run Laravel setup commands
    php artisan key:generate
    php artisan storage:link

    php artisan migrate --force

    echo "🔍 Checking seed status..."

    COUNT=$(php artisan tinker --execute="echo \\Spatie\\Permission\\Models\\Permission::count();")

    echo "🔢 Permission count: $COUNT"

    if [ "$COUNT" -eq 0 ]; then
        echo "🌱 First run detected → running seeders"
        php artisan db:seed --force
    else
        echo "✔️ Already seeded"
    fi
fi

# Execute the container's main process (CMD)
exec "$@"
