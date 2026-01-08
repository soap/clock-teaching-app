# ⚡ Quick Start Guide

เริ่มต้นใช้งาน Clock Teaching App ภายใน 5 นาที!

## 🚀 สำหรับผู้ที่มี Laravel ติดตั้งแล้ว

### 1. Clone หรือคัดลอกโปรเจค
```bash
cd clock-teaching-app
```

### 2. ติดตั้ง Dependencies
```bash
# Backend
composer install

# Frontend
npm install
```

### 3. Setup Environment
```bash
cp .env.example .env
php artisan key:generate
touch database/database.sqlite
php artisan migrate
```

### 4. รันโปรเจค
```bash
# Terminal 1
npm run dev

# Terminal 2
php artisan serve
```

### 5. เปิดเบราว์เซอร์
- ครู: http://localhost:8000/teacher
- นักเรียน: http://localhost:8000/student

---

## 🏫 สำหรับผู้ที่ยังไม่มี Laravel

### ติดตั้ง Prerequisites
```bash
# ติดตั้ง PHP 8.2+
# ติดตั้ง Composer
# ติดตั้ง Node.js 18+
```

### สร้างโปรเจค Laravel ใหม่
```bash
composer create-project laravel/laravel my-clock-app
cd my-clock-app
```

### ติดตั้ง Inertia.js
```bash
composer require inertiajs/inertia-laravel
npm install @inertiajs/vue3 vue@latest
npm install -D @vitejs/plugin-vue
npm install -D tailwindcss postcss autoprefixer
npx tailwindcss init -p
```

### คัดลอกไฟล์จาก clock-teaching-app
```bash
# คัดลอกทุกไฟล์จาก repository ไปยัง my-clock-app
```

### รันโปรเจค
```bash
npm install
npm run dev
# Terminal ใหม่
php artisan serve
```

---

## 🌐 ใช้งานผ่าน WiFi Local

### หา IP Address
```bash
# Windows
ipconfig

# Mac/Linux
ifconfig
```

### รัน Server
```bash
php artisan serve --host=0.0.0.0
```

### เปิดจากอุปกรณ์อื่น
แทนที่ `192.168.1.100` ด้วย IP ที่หาได้:
- ครู: `http://192.168.1.100:8000/teacher`
- นักเรียน: `http://192.168.1.100:8000/student`

---

## 💡 Quick Tips

### การใช้งาน
1. เปิดหน้าครูบนคอมพิวเตอร์ของครู
2. เปิดหน้านักเรียนบนจอแสดงผล (Fullscreen: F11)
3. ครูกำหนดเวลาและกด "แสดงโจทย์"
4. หน้านักเรียนจะอัปเดตอัตโนมัติ (polling ทุก 1 วินาที)

### Troubleshooting
- ไม่เห็นอะไร? → ตรวจสอบว่า `npm run dev` ทำงานอยู่
- 404 Error? → ลอง `php artisan route:clear`
- CSS ไม่โหลด? → ลอง clear browser cache

---

## 📚 เอกสารเพิ่มเติม

- **README.md**: ภาพรวมและคำแนะนำทั่วไป
- **INSTALLATION.md**: คำแนะนำติดตั้งแบบละเอียด
- **FEATURES.md**: รายละเอียดฟีเจอร์ทั้งหมด
- **SCREENSHOTS.md**: อธิบาย UI และ Component

---

เริ่มต้นได้เลย! 🎉
