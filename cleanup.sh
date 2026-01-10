#!/bin/bash

# Laravel Cleanup Script
# Run this script to remove unused files and optimize application size

echo "🧹 Starting Laravel cleanup process..."

# Clear Laravel caches
echo "Clearing Laravel caches..."
php artisan optimize:clear

# Remove log files
echo "Removing log files..."
find . -name "*.log" -type f -delete
find storage/logs/ -name "*.log" -type f -delete 2>/dev/null || true

# Remove system files
echo "Removing system files..."
find . -name ".DS_Store" -delete
find . -name "Thumbs.db" -delete
find . -name "*.tmp" -delete
find . -name "*.bak" -delete
find . -name "*~" -delete

# Clear framework cache
echo "Clearing framework cache..."
rm -rf storage/framework/cache/data/*
rm -rf storage/framework/sessions/*
rm -rf storage/framework/views/*
rm -rf storage/debugbar 2>/dev/null || true

# Remove node modules cache
echo "Cleaning node modules..."
rm -rf node_modules/.cache 2>/dev/null || true

# Remove development files
echo "Removing development files..."
rm -f public/hot
find . -name "*.test" -delete
find . -name "*.spec.js" -delete
find . -name "*.spec.ts" -delete

# Clean vendor files (if not in production)
if [ "$1" != "--production" ]; then
    echo "Cleaning vendor development files..."
    rm -rf vendor/*/.github 2>/dev/null || true
    rm -rf vendor/*/tests 2>/dev/null || true
    rm -rf vendor/*/test 2>/dev/null || true
    rm -rf vendor/*/*/tests 2>/dev/null || true
    rm -rf vendor/*/*/test 2>/dev/null || true
    find vendor/ -name "*.md" -not -path "*/composer/*" -delete 2>/dev/null || true
    find vendor/ -name "*.yml" -delete 2>/dev/null || true
    find vendor/ -name "phpunit.xml*" -delete 2>/dev/null || true
fi

# Remove backup and temporary React files
echo "Cleaning React/JS backup files..."
find resources/js/ -name "*_OLD.*" -delete
find resources/js/ -name "*.backup" -delete

# Set proper permissions
echo "Setting proper permissions..."
chmod -R 755 storage/
chmod -R 755 bootstrap/cache/

# Final optimization
echo "Running final optimization..."
if [ "$1" == "--production" ]; then
    php artisan optimize
else
    php artisan config:clear
    php artisan view:clear
fi

echo "✅ Cleanup completed!"

# Show size after cleanup
echo "📊 Application size:"
du -sh .

echo "🎉 Laravel application cleaned successfully!"