#!/bin/bash

# Laravel Production Deployment Script
# Run this script to deploy the application to production

echo "🚀 Starting Laravel Production Deployment..."

# Backup current deployment (if exists)
echo "📦 Creating backup..."
if [ -d "backup" ]; then
    rm -rf backup
fi
mkdir -p backup
cp -r storage/app backup/ 2>/dev/null || true
cp -r storage/logs backup/ 2>/dev/null || true

# Install production dependencies
echo "📚 Installing production dependencies..."
composer install --optimize-autoloader --no-dev --no-interaction

# Build frontend assets
echo "🎨 Building frontend assets..."
npm ci --production
npm run build

# Clear all caches
echo "🧹 Clearing caches..."
php artisan optimize:clear

# Cache configurations for production
echo "⚡ Optimizing for production..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Run migrations
echo "🗃️ Running database migrations..."
php artisan migrate --force

# Set proper permissions
echo "🔐 Setting file permissions..."
chmod -R 755 storage/
chmod -R 755 bootstrap/cache/
chown -R www-data:www-data storage/
chown -R www-data:www-data bootstrap/cache/

# Generate passport keys (if needed)
if [ ! -f "storage/oauth-private.key" ]; then
    echo "🔑 Generating Passport keys..."
    php artisan passport:keys
fi

# Queue processing setup
echo "⚙️ Setting up queue workers..."
php artisan queue:restart

# Create symbolic link for storage
echo "🔗 Creating storage link..."
php artisan storage:link

echo "✅ Deployment completed successfully!"
echo "📋 Post-deployment checklist:"
echo "   - Update .env file with production settings"
echo "   - Configure web server (Nginx/Apache)"
echo "   - Set up SSL certificate"
echo "   - Configure queue workers in production"
echo "   - Set up cron jobs for scheduled tasks"
echo "   - Monitor logs and performance"

# Verify deployment
echo "🔍 Running deployment verification..."
php artisan about

echo "🎉 Laravel application is ready for production!"