# 📚 คู่มือการติดตั้ง Clock Teaching App

## 🎯 ขั้นตอนการติดตั้งแบบละเอียด

### 1️⃣ ติดตั้ง Laravel Project

```bash
# สร้าง Laravel project ใหม่
composer create-project laravel/laravel clock-teaching-app
cd clock-teaching-app

# หรือถ้ามี Laravel installer แล้ว
laravel new clock-teaching-app
cd clock-teaching-app
```

### 2️⃣ ติดตั้ง Inertia.js

```bash
# ติดตั้ง Inertia Laravel package
composer require inertiajs/inertia-laravel

# Publish middleware
php artisan inertia:middleware
```

แก้ไขไฟล์ `app/Http/Kernel.php` เพิ่ม middleware:
```php
'web' => [
    // ...
    \App\Http\Middleware\HandleInertiaRequests::class,
],
```

หรือใน Laravel 11+ แก้ไขไฟล์ `bootstrap/app.php`:
```php
->withMiddleware(function (Middleware $middleware) {
    $middleware->web(append: [
        \App\Http\Middleware\HandleInertiaRequests::class,
    ]);
})
```

### 3️⃣ ติดตั้ง Vue 3 และ Dependencies

```bash
# ติดตั้ง Vue 3 และ Inertia client
npm install @inertiajs/vue3
npm install vue@latest

# ติดตั้ง Vite plugin สำหรับ Vue
npm install -D @vitejs/plugin-vue

# ติดตั้ง Tailwind CSS
npm install -D tailwindcss postcss autoprefixer
npx tailwindcss init -p

# ติดตั้ง axios
npm install axios
```

### 4️⃣ คัดลอกไฟล์จาก Repository

คัดลอกไฟล์ทั้งหมดจาก repository ไปยัง Laravel project:

```bash
# คัดลอกไฟล์ Controllers
cp -r clock-teaching-app/app/Http/Controllers/* app/Http/Controllers/

# คัดลอกไฟล์ Routes
cp clock-teaching-app/routes/web.php routes/web.php

# คัดลอกไฟล์ Resources (Vue components)
cp -r clock-teaching-app/resources/js/* resources/js/
cp -r clock-teaching-app/resources/css/* resources/css/
cp -r clock-teaching-app/resources/views/* resources/views/

# คัดลอกไฟล์ Config
cp clock-teaching-app/vite.config.js vite.config.js
cp clock-teaching-app/tailwind.config.js tailwind.config.js
cp clock-teaching-app/postcss.config.js postcss.config.js
cp clock-teaching-app/package.json package.json
```

### 5️⃣ ตั้งค่า Environment

```bash
# คัดลอก .env.example
cp .env.example .env

# Generate application key
php artisan key:generate
```

แก้ไขไฟล์ `.env`:
```env
APP_NAME="Clock Teaching App"
APP_URL=http://localhost:8000

# สำหรับการใช้งานใน network
# APP_URL=http://192.168.1.xxx:8000

DB_CONNECTION=sqlite
```

### 6️⃣ สร้าง Database

```bash
# สร้างไฟล์ SQLite database
touch database/database.sqlite

# Run migrations (ถ้ามี)
php artisan migrate
```

### 7️⃣ ติดตั้ง Node Dependencies และ Build

```bash
# ติดตั้ง dependencies
npm install

# ตรวจสอบว่าทุกอย่างถูกต้อง
npm run build
```

### 8️⃣ รัน Development Server

เปิด 2 terminal:

**Terminal 1 - Vite Dev Server:**
```bash
npm run dev
```

**Terminal 2 - Laravel Server:**
```bash
php artisan serve

# หรือสำหรับการใช้งานใน network
php artisan serve --host=0.0.0.0 --port=8000
```

## 🌐 การใช้งานผ่าน WiFi Local Network

### หา IP Address ของเครื่อง

**Windows:**
```cmd
ipconfig
# ดูที่ IPv4 Address
```

**Mac/Linux:**
```bash
ip addr show
# หรือ
ifconfig
# ดูที่ inet
```

### รัน Server ให้เข้าถึงได้จาก Network

```bash
php artisan serve --host=0.0.0.0 --port=8000
```

### เข้าถึงจากอุปกรณ์อื่นใน Network

สมมติ IP ของเครื่องคือ `192.168.1.100`:

- **หน้าครู**: `http://192.168.1.100:8000/teacher`
- **หน้านักเรียน**: `http://192.168.1.100:8000/student`

## 🔧 Troubleshooting

### ปัญหา: Vite ไม่สามารถโหลด assets

**แก้ไข:** ตรวจสอบว่า `npm run dev` กำลังทำงานอยู่

### ปัญหา: 404 Not Found

**แก้ไข:** 
1. ล้าง cache: `php artisan cache:clear`
2. ล้าง config: `php artisan config:clear`
3. ล้าง route: `php artisan route:clear`

### ปัญหา: Inertia page ไม่ render

**แก้ไข:**
1. ตรวจสอบว่า middleware `HandleInertiaRequests` ถูกเพิ่มแล้ว
2. ตรวจสอบว่า `resources/views/app.blade.php` มี `@inertia` directive

### ปัญหา: CSS ไม่แสดงผล

**แก้ไข:**
1. ตรวจสอบว่า Tailwind config ถูกต้อง
2. รัน `npm run build` ใหม่
3. ล้าง browser cache

### ปัญหา: Polling ไม่ทำงาน

**แก้ไข:**
1. เปิด Browser Console เช็ค error
2. ตรวจสอบว่า API routes ทำงานได้โดยเข้า `/api/clock/current`
3. ตรวจสอบว่า cache driver ทำงานได้ใน `.env`

## 📝 Production Deployment

### Build สำหรับ Production

```bash
# Build assets
npm run build

# Optimize Laravel
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### ตั้งค่า Environment สำหรับ Production

แก้ไข `.env`:
```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-domain.com
```

### Web Server Configuration

**Apache (.htaccess):**
```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteRule ^(.*)$ public/$1 [L]
</IfModule>
```

**Nginx:**
```nginx
server {
    listen 80;
    server_name your-domain.com;
    root /path/to/clock-teaching-app/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

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
}
```

## 🎓 การใช้งานในโรงเรียน

### Setup แนะนำ

1. **เครื่อง Server (ครู)**:
   - เชื่อมต่อ WiFi โรงเรียน
   - รัน Laravel server ด้วย `--host=0.0.0.0`
   - เปิดหน้าครูบนเครื่องตัวเอง

2. **จอแสดงผลนักเรียน**:
   - เชื่อมต่อ WiFi เดียวกัน
   - เปิดเบราว์เซอร์ไปที่ `http://[IP-ครู]:8000/student`
   - ตั้งเป็น Fullscreen (F11)

3. **Tips**:
   - ใช้ Chrome/Firefox ในโหมด Kiosk สำหรับจอนักเรียน
   - ปิด screensaver/sleep mode
   - ตั้ง bookmark สำหรับเข้าถึงง่าย

## 🆘 ต้องการความช่วยเหลือ?

หากพบปัญหาในการติดตั้ง:
1. ตรวจสอบ Laravel logs: `storage/logs/laravel.log`
2. ตรวจสอบ Browser Console
3. อ่าน documentation: [Laravel](https://laravel.com/docs), [Inertia.js](https://inertiajs.com), [Vue 3](https://vuejs.org)

---

สร้างด้วย ❤️ สำหรับครูและนักเรียน
