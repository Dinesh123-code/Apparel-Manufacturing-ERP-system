# 🚀 Public Deployment Guide — Pro ERP Production Suite

This guide explains how to deploy your **Pro ERP Apparel Manufacturing System** for multi-user public production access.

---

## 📋 Pre-Deployment Checklist

1. **Database**: MySQL 8.0 instance (Local MySQL, AWS RDS, Railway, DigitalOcean, or Aiven MySQL).
2. **PHP Runtime**: PHP 8.2 or 8.3 with extensions (`pdo_mysql`, `mbstring`, `bcmath`, `xml`, `curl`, `gd`).
3. **Web Server**: Nginx or Apache with URL rewriting enabled pointing to `/public`.
4. **SSL Certificate**: HTTPS enabled via Let's Encrypt (Certbot).

---

## 🌟 Option A: Deployment via Railway (Easiest Cloud Setup)

[Railway.app](https://railway.app) provides zero-config deployment for Laravel + MySQL.

### Step 1: Create a Railway Project
1. Go to **Railway.app** and click **New Project**.
2. Select **Provision MySQL** database.
3. Select **Deploy from GitHub repo** and pick your `bundle-erp` repository.

### Step 2: Set Environment Variables
In your Railway Service Settings -> Variables, add:

```env
APP_NAME="Pro ERP"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-app-name.up.railway.app

DB_CONNECTION=mysql
DB_HOST=${MYSQLHOST}
DB_PORT=${MYSQLPORT}
DB_DATABASE=${MYSQLDATABASE}
DB_USERNAME=${MYSQLUSER}
DB_PASSWORD=${MYSQLPASSWORD}

SESSION_DRIVER=database
CACHE_STORE=database
QUEUE_CONNECTION=sync
```

### Step 3: Run Database Migrations
Run via Railway CLI or Web Terminal:
```bash
php artisan migrate --force --seed
```

---

## 🌐 Option B: Deployment on Ubuntu VPS (DigitalOcean / AWS / Linode)

### Step 1: Install Nginx, PHP 8.2 & MySQL
```bash
sudo apt update && sudo apt install -y nginx mysql-server php8.2-fpm php8.2-mysql php8.2-cli php8.2-common php8.2-xml php8.2-mbstring php8.2-curl php8.2-zip unzip git
```

### Step 2: Clone Codebase & Install Dependencies
```bash
cd /var/www
sudo git clone https://github.com/your-username/bundle-erp.git pro-erp
cd pro-erp
sudo composer install --no-dev --optimize-autoloader
```

### Step 3: Configure Permissions & `.env`
```bash
sudo cp .env.example .env
sudo php artisan key:generate
sudo chown -R www-data:www-data storage bootstrap/cache
sudo chmod -R 775 storage bootstrap/cache
```

Update `.env` with production MySQL details and `APP_URL=https://yourdomain.com`.

### Step 4: Run Production Build & Migration
```bash
php artisan migrate --force --seed
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### Step 5: Configure Nginx Site
Create `/etc/nginx/sites-available/pro-erp`:
```nginx
server {
    listen 80;
    server_name yourdomain.com;
    root /var/www/pro-erp/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.ht {
        deny all;
    }
}
```

Enable site & SSL:
```bash
sudo ln -s /etc/nginx/sites-available/pro-erp /etc/nginx/sites-enabled/
sudo nginx -t && sudo systemctl reload nginx
sudo certbot --nginx -d yourdomain.com
```

---

## 🔒 Security Best Practices for Production

- Set `APP_DEBUG=false` in production `.env`.
- Ensure `database/dump.sql` is not committed to public repositories.
- Use HTTPS enforced routes (`URL::forceScheme('https')`).
- Change default admin password (`admin@bundle-erp.com` / `password`) immediately after first login.
