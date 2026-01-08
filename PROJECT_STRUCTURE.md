# 📁 โครงสร้างโปรเจค

```
clock-teaching-app/
├── 📄 README.md                    # ภาพรวมโปรเจค
├── 📄 QUICKSTART.md                # คู่มือเริ่มต้นฉบับย่อ
├── 📄 INSTALLATION.md              # คู่มือติดตั้งแบบละเอียด
├── 📄 FEATURES.md                  # รายละเอียดฟีเจอร์
├── 📄 SCREENSHOTS.md               # อธิบาย UI/UX
├── 📄 PROJECT_STRUCTURE.md         # ไฟล์นี้
├── 📄 LICENSE                      # MIT License
├── 📄 .env.example                 # Environment template
├── 📄 .gitignore                   # Git ignore rules
│
├── 📦 Package Files
│   ├── 📄 composer.json            # PHP dependencies
│   ├── 📄 package.json             # Node dependencies
│   ├── 📄 vite.config.js           # Vite configuration
│   ├── 📄 tailwind.config.js       # Tailwind CSS config
│   └── 📄 postcss.config.js        # PostCSS config
│
├── 📂 app/
│   └── 📂 Http/
│       ├── 📂 Controllers/
│       │   ├── 🎯 TeacherController.php        # ควบคุมหน้าครู
│       │   ├── 🎯 StudentController.php        # ควบคุมหน้านักเรียน
│       │   └── 🎯 ClockStateController.php     # API สำหรับ state sync
│       └── 📂 Middleware/
│           └── 🎯 HandleInertiaRequests.php    # Inertia middleware
│
├── 📂 bootstrap/
│   └── 📄 app.php                  # Laravel bootstrap (กำหนด middleware)
│
├── 📂 routes/
│   └── 📄 web.php                  # Route definitions (ครู, นักเรียน, API)
│
├── 📂 resources/
│   ├── 📂 js/
│   │   ├── 📄 app.js               # Inertia app setup
│   │   ├── 📄 bootstrap.js         # Axios setup
│   │   │
│   │   ├── 📂 Pages/               # Inertia Pages
│   │   │   ├── 🎨 Teacher.vue     # หน้าครู (ควบคุม + เฉลย)
│   │   │   └── 🎨 Student.vue     # หน้านักเรียน (นาฬิกา)
│   │   │
│   │   ├── 📂 Components/          # Vue Components
│   │   │   └── 🎨 AnalogClock.vue # นาฬิกาอนาล็อก component
│   │   │
│   │   └── 📂 Layouts/             # Layouts
│   │       └── 🎨 AppLayout.vue   # Layout หลัก
│   │
│   ├── 📂 css/
│   │   └── 📄 app.css              # Tailwind CSS imports
│   │
│   └── 📂 views/
│       └── 📄 app.blade.php        # Root template สำหรับ Inertia
│
└── 📂 public/                      # Public assets (จะถูกสร้างโดย Laravel)
    └── (Vite build output)

```

## 🔑 ไฟล์สำคัญ

### Backend (Laravel)
- **TeacherController.php**: จัดการหน้าครู, API สำหรับอัปเดตโจทย์และสุ่มเวลา
- **StudentController.php**: แสดงหน้านักเรียน
- **ClockStateController.php**: API endpoints สำหรับ polling และ sync state
- **web.php**: กำหนด routes ทั้งหมด (หน้าครู, นักเรียน, API)

### Frontend (Vue 3 + Inertia.js)
- **Teacher.vue**: หน้าควบคุมของครู (ตั้งค่าโจทย์ + แสดงเฉลย)
- **Student.vue**: หน้านักเรียน (แสดงนาฬิกา + polling)
- **AnalogClock.vue**: Component นาฬิกาอนาล็อกที่ใช้งานได้ทั้งสองหน้า
- **AppLayout.vue**: Layout wrapper พื้นฐาน
- **app.js**: Setup Inertia.js และ Vue 3

### Configuration
- **vite.config.js**: ตั้งค่า Vite สำหรับ build assets
- **tailwind.config.js**: ตั้งค่า Tailwind CSS
- **composer.json**: PHP dependencies (Laravel, Inertia)
- **package.json**: Node dependencies (Vue, Vite, Tailwind)

### Documentation
- **README.md**: เริ่มต้นที่นี่! ภาพรวมและขั้นตอนหลัก
- **QUICKSTART.md**: สำหรับคนที่รีบ (5 นาที setup)
- **INSTALLATION.md**: คำแนะนำติดตั้งแบบละเอียดทุกขั้นตอน
- **FEATURES.md**: อธิบายฟีเจอร์ทั้งหมดพร้อมตัวอย่าง
- **SCREENSHOTS.md**: อธิบาย UI/UX และ design details

## 🚀 API Endpoints

### GET Routes
- `GET /teacher` → แสดงหน้าครู
- `GET /student` → แสดงหน้านักเรียน
- `GET /api/clock/current` → ดึงสถานะนาฬิกาปัจจุบัน (สำหรับ polling)

### POST Routes
- `POST /api/clock/update` → อัปเดตโจทย์ใหม่ (จากครู)
- `POST /api/clock/clear` → ล้างโจทย์
- `POST /api/clock/random` → สุ่มเวลา

## 📊 Data Flow

```
ครูกำหนดเวลา
    ↓
POST /api/clock/update
    ↓
บันทึกใน Laravel Cache
    ↓
หน้านักเรียน polling (GET /api/clock/current) ทุก 1 วินาที
    ↓
อัปเดต Vue component
    ↓
แสดงนาฬิกาใหม่
```

## 🎨 Technology Stack

### Backend
- PHP 8.2+
- Laravel 11+
- Inertia.js Laravel Adapter

### Frontend
- Vue 3 (Composition API)
- Inertia.js Client
- Tailwind CSS
- Vite

### Communication
- RESTful API
- Polling (1 second interval)
- Laravel Cache (state management)

## 📝 สำหรับ Developer

### การพัฒนาเพิ่มเติม

**เพิ่ม Feature ใหม่**:
1. สร้าง API endpoint ใหม่ใน Controller
2. เพิ่ม route ใน `routes/web.php`
3. เรียก API จาก Vue component
4. อัปเดต UI ตามต้องการ

**เพิ่ม Component ใหม่**:
1. สร้าง `.vue` file ใน `resources/js/Components/`
2. Import และใช้ใน Pages
3. เพิ่ม props และ events ตามต้องการ

**แก้ไข Styling**:
1. แก้ไข Tailwind classes ใน `.vue` files
2. หรือเพิ่ม custom CSS ใน `resources/css/app.css`
3. Build ใหม่ด้วย `npm run dev`

---

โครงสร้างออกแบบให้เรียบง่าย ขยายง่าย และ maintain ง่าย! 🎯
