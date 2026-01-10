# समाचार हाउस - Production Deployment Guide

## 🚀 Production Deployment Steps

### 1. Server Requirements
```bash
- PHP 8.2+
- MySQL 8.0+
- Node.js 18+
- Nginx/Apache
- SSL Certificate
```

### 2. File Upload
```bash
# Upload all files to server
# Exclude: .env, node_modules, storage/logs/*
```

### 3. Environment Setup
```bash
# Copy and configure .env
cp .env.example .env

# Generate application key
php artisan key:generate

# Configure database settings in .env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_username
DB_PASSWORD=your_password

# Set production environment
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com
```

### 4. Database Setup
```bash
# Run migrations
php artisan migrate

# Seed data (if needed)
php artisan db:seed
```

### 5. File Permissions
```bash
chmod -R 775 storage
chmod -R 775 bootstrap/cache
chown -R www-data:www-data storage
chown -R www-data:www-data bootstrap/cache
```

### 6. Storage Setup
```bash
# Create storage link
php artisan storage:link

# Create video directories
mkdir -p storage/app/public/videos
mkdir -p storage/app/public/video-thumbnails
chmod 775 storage/app/public/videos
chmod 775 storage/app/public/video-thumbnails
```

### 7. Build Assets
```bash
# Install dependencies
npm install

# Build for production
npm run build
```

### 8. Optimize for Production
```bash
# Cache configurations
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Optimize autoloader
composer install --optimize-autoloader --no-dev
```

### 9. Web Server Configuration

#### Nginx Configuration
```nginx
server {
    listen 80;
    listen [::]:80;
    server_name yourdomain.com www.yourdomain.com;
    return 301 https://$server_name$request_uri;
}

server {
    listen 443 ssl http2;
    listen [::]:443 ssl http2;
    server_name yourdomain.com www.yourdomain.com;
    root /path/to/your/app/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    # Handle video files
    location ~* \.(mp4|webm|ogg|avi|mov)$ {
        expires 1y;
        add_header Cache-Control "public, immutable";
    }

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }

    # SSL Configuration
    ssl_certificate /path/to/ssl/certificate.crt;
    ssl_certificate_key /path/to/ssl/private.key;
    ssl_protocols TLSv1.2 TLSv1.3;
    ssl_ciphers ECDHE-RSA-AES256-GCM-SHA512:DHE-RSA-AES256-GCM-SHA512;
}
```

### 10. Security Setup
```bash
# Set secure file permissions
find /path/to/your/app -type f -exec chmod 644 {} \;
find /path/to/your/app -type d -exec chmod 755 {} \;
chmod -R 775 storage bootstrap/cache

# Hide sensitive files
echo "User-agent: *" > public/robots.txt
echo "Disallow: /admin" >> public/robots.txt
```

### 11. Monitoring & Maintenance
```bash
# Set up log rotation
# Configure backup schedule
# Monitor disk space for video uploads
# Set up SSL certificate auto-renewal
```

## 📱 Features Included

### ✅ Frontend Features
- **Responsive Design**: Mobile/Desktop optimized
- **Bilingual Support**: Hindi/English switching
- **Video News**: Full video player with controls
- **Professional Layout**: Editorial newspaper design
- **SEO Optimized**: Meta tags and structured data

### ✅ Admin Panel Features
- **Content Management**: Articles, Headlines, Categories
- **Video Upload**: Video files with thumbnails
- **User Management**: Roles and permissions
- **Media Gallery**: Image and video management

### ✅ Technical Features
- **Laravel 11**: Latest framework
- **React/TypeScript**: Modern frontend
- **Inertia.js**: SPA experience
- **Video Support**: MP4, WebM formats
- **Image Optimization**: Automatic resizing
- **Cache Optimization**: Production ready

## 🔧 Maintenance Commands

```bash
# Clear caches
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Rebuild caches
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Update dependencies
composer update
npm update && npm run build
```

## 📞 Support Information
- **Website**: समाचार हाउस
- **Contact**: parimalharsh7@gmail.com
- **Phone**: +91 9828977775
- **Address**: Choudhariyo ki gali bahety chowk bikaner rajasthan

---
*This deployment guide ensures your news website runs smoothly in production with all video features working correctly.*