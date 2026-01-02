# Laravel Production Deployment Checklist

## Pre-Deployment
- [ ] Update `.env` file with production settings
- [ ] Set `APP_ENV=production` and `APP_DEBUG=false`
- [ ] Generate secure `APP_KEY`: `php artisan key:generate`
- [ ] Configure database connection
- [ ] Set up SSL certificates
- [ ] Configure mail settings
- [ ] Set up backup storage (S3, etc.)

## Server Configuration
- [ ] Install Nginx configuration: `sudo cp nginx.conf /etc/nginx/sites-available/your-domain`
- [ ] Enable site: `sudo ln -s /etc/nginx/sites-available/your-domain /etc/nginx/sites-enabled/`
- [ ] Test Nginx config: `sudo nginx -t`
- [ ] Install PHP-FPM config: `sudo cp php-fpm-laravel.conf /etc/php/8.3/fpm/pool.d/`
- [ ] Set up queue worker service: `sudo cp laravel-worker.service /etc/systemd/system/`
- [ ] Enable services: `sudo systemctl enable laravel-worker php8.3-fpm nginx`

## File Permissions
- [ ] Set ownership: `sudo chown -R www-data:www-data /var/www/html/laravelAdminLte3`
- [ ] Set storage permissions: `sudo chmod -R 755 storage bootstrap/cache`
- [ ] Create log directory: `sudo mkdir -p /var/log/php && sudo chown www-data:www-data /var/log/php`

## Database & Migrations
- [ ] Create production database
- [ ] Run migrations: `php artisan migrate --force`
- [ ] Seed data if needed: `php artisan db:seed --class=ProductionSeeder`
- [ ] Generate Passport keys: `php artisan passport:install`

## Security
- [ ] Set up firewall (UFW): `sudo ufw enable`
- [ ] Configure fail2ban for SSH protection
- [ ] Set up SSL with Let's Encrypt or commercial certificate
- [ ] Review and update security headers in Nginx config
- [ ] Enable two-factor authentication for admin users
- [ ] Set up regular security updates

## Performance Optimization
- [ ] Run deployment script: `./deploy.sh`
- [ ] Configure Redis for caching (optional)
- [ ] Set up CDN for static assets
- [ ] Configure opcache for PHP
- [ ] Set up monitoring (New Relic, DataDog, etc.)

## Monitoring & Logging
- [ ] Set up log rotation
- [ ] Configure error monitoring (Sentry, Bugsnag)
- [ ] Set up application monitoring
- [ ] Configure uptime monitoring
- [ ] Set up backup verification

## Cron Jobs
- [ ] Add cron jobs: `crontab -e` and paste contents from `cron-jobs.txt`
- [ ] Verify scheduler is running: `php artisan schedule:list`

## Queue Workers
- [ ] Start queue workers: `sudo systemctl start laravel-worker`
- [ ] Monitor queue: `php artisan queue:monitor`
- [ ] Set up queue failure notifications

## Testing in Production
- [ ] Test application functionality
- [ ] Verify SSL certificate
- [ ] Check error logs
- [ ] Test advertisement display
- [ ] Verify image uploads
- [ ] Test user registration/login
- [ ] Check API endpoints
- [ ] Verify email sending

## Backup & Disaster Recovery
- [ ] Set up automated database backups
- [ ] Configure file storage backups
- [ ] Test backup restoration process
- [ ] Document recovery procedures

## Documentation
- [ ] Update deployment documentation
- [ ] Create troubleshooting guide
- [ ] Document server specifications
- [ ] Create maintenance procedures

## Post-Deployment
- [ ] Monitor application performance
- [ ] Check error logs regularly
- [ ] Update dependencies regularly
- [ ] Review security logs
- [ ] Monitor resource usage

## Emergency Contacts
- [ ] Set up alerts for critical errors
- [ ] Configure notification channels
- [ ] Document escalation procedures

---

## Quick Commands

### Start Services
```bash
sudo systemctl start nginx php8.3-fpm laravel-worker
sudo systemctl enable nginx php8.3-fpm laravel-worker
```

### Check Status
```bash
sudo systemctl status nginx php8.3-fpm laravel-worker
sudo tail -f /var/log/nginx/laravel_error.log
php artisan queue:monitor
```

### Update Application
```bash
git pull origin main
./deploy.sh
sudo systemctl restart laravel-worker
```

### Emergency Rollback
```bash
# Restore previous version
git checkout previous-stable-tag
./deploy.sh
sudo systemctl restart laravel-worker nginx
```