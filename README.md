# 🕐 Clock Teaching App

แอปพลิเคชันสอนการอ่านนาฬิกาสำหรับครูและนักเรียน พัฒนาด้วย Laravel + Inertia.js + Vue 3

## ✨ Features

- ✅ หน้าครู: กำหนดเวลา (เจาะจง/สุ่ม) พร้อมแสดงคำตอบที่ถูกต้อง
- ✅ หน้านักเรียน: แสดงนาฬิกาแบบ real-time (sync ด้วย polling)
- ✅ นาฬิกาอนาล็อก + ดิจิตอล
- ✅ รองรับทั้งระบบ 12H (AM/PM) และ 24H
- ✅ ใช้งานผ่าน WiFi local ในโรงเรียน

## 🚀 การติดตั้ง

### 1. ติดตั้ง Laravel Project ใหม่

```bash
composer create-project laravel/laravel clock-teaching-app
cd clock-teaching-app
```

### 2. ติดตั้ง Inertia.js และ Dependencies

```bash
composer require inertiajs/inertia-laravel
npm install @inertiajs/vue3
npm install -D @vitejs/plugin-vue
npm install -D tailwindcss postcss autoprefixer
npx tailwindcss init -p
```

### 3. คัดลอกไฟล์จาก Repository นี้

คัดลอกไฟล์ทั้งหมดจากโฟลเดอร์นี้ไปยัง Laravel project ของคุณ:

```bash
# Controller
app/Http/Controllers/TeacherController.php
app/Http/Controllers/StudentController.php
app/Http/Controllers/ClockStateController.php

# Routes
routes/web.php

# Vue Components & Pages
resources/js/app.js
resources/js/Pages/Teacher.vue
resources/js/Pages/Student.vue
resources/js/Components/AnalogClock.vue

# Layouts
resources/js/Layouts/AppLayout.vue

# Views
resources/views/app.blade.php

# Config
vite.config.js
tailwind.config.js
```

### 4. ตั้งค่า Environment

```bash
cp .env.example .env
php artisan key:generate
```

แก้ไข `.env`:
```
APP_NAME="Clock Teaching App"
APP_URL=http://localhost:8000
# หรือใช้ IP ของเครื่องใน network เช่น
# APP_URL=http://192.168.1.100:8000
```

### 5. สร้าง Table และ Cache

```bash
php artisan migrate
php artisan cache:clear
```

### 6. Build Frontend และรัน Server

```bash
npm install
npm run dev

# Terminal ใหม่
php artisan serve --host=0.0.0.0
```

## 📱 การใช้งาน

### สำหรับครู
1. เปิดเบราว์เซอร์ไปที่: `http://localhost:8000/teacher`
2. เลือกระบบเวลา (12H หรือ 24H)
3. กำหนดเวลา:
   - **กำหนดเอง**: เลือกชั่วโมงและนาที
   - **สุ่ม**: กดปุ่มสุ่มเวลา
4. กด **"แสดงโจทย์"** เพื่อส่งไปยังหน้าจอนักเรียน
5. ดูคำตอบที่ถูกต้องด้านล่าง
6. กด **"ล้างหน้าจอ"** เพื่อเคลียร์โจทย์

### สำหรับนักเรียน (แสดงบนจอใหญ่)
1. เปิดเบราว์เซอร์ไปที่: `http://localhost:8000/student`
2. หน้าจอจะ sync กับครูโดยอัตโนมัติ (polling ทุก 1 วินาที)
3. นักเรียนช่วยกันตอบเวลาที่เห็นบนนาฬิกา

### การใช้งานผ่าน WiFi Local
เมื่อต้องการให้เครื่องอื่นๆ ในเครือข่ายเข้าถึง:

```bash
# หา IP ของเครื่อง
ip addr show  # Linux/Mac
ipconfig      # Windows

# รัน server ด้วย IP นั้น
php artisan serve --host=0.0.0.0 --port=8000
```

จากนั้นเครื่องอื่นสามารถเข้าถึงผ่าน:
- ครู: `http://192.168.1.xxx:8000/teacher`
- นักเรียน: `http://192.168.1.xxx:8000/student`

## 🔧 Technical Details

### Architecture
- **Backend**: Laravel 11+ (API endpoints)
- **Frontend**: Vue 3 + Inertia.js (SPA)
- **Styling**: Tailwind CSS
- **Real-time**: Polling (1 second interval)
- **State Management**: Laravel Cache

### API Endpoints
- `GET /api/clock/current` - ดึงสถานะปัจจุบัน
- `POST /api/clock/update` - อัปเดตโจทย์ใหม่
- `POST /api/clock/clear` - ล้างโจทย์

### File Structure
```
├── app/Http/Controllers/
│   ├── TeacherController.php     # ควบคุมหน้าครู
│   ├── StudentController.php     # ควบคุมหน้านักเรียน
│   └── ClockStateController.php  # API สำหรับ sync state
├── resources/js/
│   ├── Pages/
│   │   ├── Teacher.vue           # หน้าครู (ควบคุม + คำตอบ)
│   │   └── Student.vue           # หน้านักเรียน (นาฬิกา)
│   ├── Components/
│   │   └── AnalogClock.vue       # นาฬิกาอนาล็อก
│   └── Layouts/
│       └── AppLayout.vue         # Layout หลัก
└── routes/web.php                # Routes
```

## 📝 License

Open-source สำหรับใช้ในการศึกษา

---
Made with ❤️ for Teachers and Students
