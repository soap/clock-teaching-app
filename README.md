# 🕐 Clock Teaching App

แอปพลิเคชันสอนการอ่านนาฬิกาสำหรับครูและนักเรียน พัฒนาด้วย Laravel + Inertia.js + Vue 3

## ✨ Features

- ✅ **ระบบเมนู**: เลือกประเภทโจทย์ที่ต้องการสอน
- ✅ **การบอกเวลา**: สอนการอ่านเวลาจากนาฬิกา Analog
- ✅ **Real-time Sync**: นักเรียนเห็นว่าครูกำลังสอนโจทย์ประเภทไหน (polling ทุก 2 วินาที)
- ✅ **รองรับ 2 ระบบ**: 12 ชั่วโมง (AM/PM) และ 24 ชั่วโมง
- ✅ **นาฬิกา Analog + Digital**: แสดงผลทั้งแบบเข็มและตัวเลข
- ✅ **ใช้งานผ่าน WiFi Local**: เหมาะสำหรับใช้ในห้องเรียน
- 🚧 **นาฬิกาช้า/เร็ว**: กำลังพัฒนา

## 🚀 การติดตั้ง

### ข้อกำหนดเบื้องต้น
- PHP 8.2+
- Composer
- Node.js 18+ และ npm/pnpm
- Git

### 1. Clone Repository

```bash
git clone https://github.com/soap/clock-teaching-app.git
cd clock-teaching-app
```

### 2. ติดตั้ง Dependencies

```bash
# Backend dependencies
composer install

# Frontend dependencies
npm install
# หรือใช้ pnpm
pnpm install
```

### 3. ตั้งค่า Environment

```bash
# คัดลอกไฟล์ environment
cp .env.example .env

# สร้าง application key
php artisan key:generate
```

แก้ไข `.env` (ถ้าจำเป็น):
```env
APP_NAME="Clock Teaching App"
APP_URL=http://localhost:8000
# หรือใช้ IP ของเครื่องใน network เช่น
# APP_URL=http://192.168.1.100:8000

# Cache driver (ใช้ file cache)
CACHE_DRIVER=file
```

### 4. เตรียมฐานข้อมูลและ Cache

```bash
# รัน migrations (ถ้ามี)
php artisan migrate

# ล้าง cache
php artisan cache:clear
php artisan config:clear
```

### 5. รัน Application

```bash
# Terminal 1: รัน Vite dev server
npm run dev
# หรือ
pnpm dev

# Terminal 2: รัน Laravel server
php artisan serve --host=0.0.0.0
```

✅ เปิดเบราว์เซอร์ไปที่: `http://localhost:8000`

## 📱 การใช้งาน

### สำหรับครู

#### 🔐 การเข้าสู่ระบบ (สำคัญ!)

**หน้าครูต้องมีการ Login เพื่อความปลอดภัย**

1. สร้างบัญชีครู (ครั้งแรก):
   - ไปที่ `http://localhost:8000/register`
   - กรอกข้อมูล: ชื่อ, อีเมล, รหัสผ่าน
   - ลงทะเบียน

2. เข้าสู่ระบบ:
   - ไปที่ `http://localhost:8000/login`
   - หรือคลิก "เข้าสู่ระบบ" จากหน้าหลัก
   - ใส่อีเมลและรหัสผ่านที่ลงทะเบียนไว้

3. หลัง Login แล้วจะเข้าถึงหน้าครูได้ที่:
   - เมนู: `http://localhost:8000/teacher`
   - Dashboard: `http://localhost:8000/dashboard`

💡 **ทำไมต้อง Login?**
- ป้องกันไม่ให้นักเรียนหรือบุคคลอื่นเข้ามาแก้ไขโจทย์
- เหมาะสำหรับ deploy บน internet
- สามารถควบคุมได้ว่าใครมีสิทธิ์เป็นครู

#### 1. หน้าเมนูครู (`/teacher`)
เมื่อ login แล้ว เข้าไปที่: `http://localhost:8000/teacher`
- เลือกประเภทโจทย์ที่ต้องการสอน
- ปัจจุบันมี: **บอกเวลา** (เปิดใช้งาน), **นาฬิกาช้า/เร็ว** (เร็วๆ นี้)

#### 2. หน้าควบคุม "บอกเวลา" (`/teacher/tell-a-time`)
1. เลือกระบบเวลา:
   - **12 ชั่วโมง (AM/PM)**: แสดงคำตอบทั้งช่วงเช้า (AM) และบ่าย (PM)
   - **24 ชั่วโมง**: แสดงคำตอบทั้งช่วงเช้าและบ่าย
2. กำหนดเวลา:
   - **กำหนดเอง**: ปรับเข็มนาฬิกาเพื่อเลือกเวลาที่ต้องการ
   - **สุ่ม**: กดปุ่ม "🎲 สุ่มเวลา" เพื่อสุ่มเวลาแบบอัตโนมัติ
3. กด **"🚀 แสดงโจทย์"** เพื่อส่งไปยังหน้าจอนักเรียน
4. กด **"👁️ แสดงคำตอบ"** เพื่อให้นักเรียนเห็นเฉลย
5. กด **"🗑️ ล้างหน้าจอ"** เพื่อเคลียร์โจทย์และกลับไปหน้าเมนู

### สำหรับนักเรียน

#### 1. หน้าเมนูนักเรียน (`/student`)
เปิดเบราว์เซอร์ไปที่: `http://localhost:8000/student`
- **ไม่ต้อง login** - เปิดใช้งานได้เลย
- เลือกประเภทโจทย์ที่ต้องการฝึก
- **แจ้งเตือนพิเศษ**: เมื่อครูเปิดโจทย์ จะแสดงกล่องสีเหลืองแจ้งให้เข้าร่วมทันที

#### 2. หน้าฝึกโจทย์ "บอกเวลา" (`/student/tell-a-time`)
- **ไม่ต้อง login** - เหมาะสำหรับฉายบนจอ Projector
- หน้าจอจะ sync กับครูโดยอัตโนมัติ (polling ทุก 1 วินาที)
- แสดงนาฬิกา Analog พร้อมคำใบ้การอ่านเวลา
- เมื่อครูกด "แสดงคำตอบ" จะแสดงเฉลยบนหน้าจอ
- รองรับทั้งโหมด 12H (แสดง AM/PM) และ 24H

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
- **หน้าหลัก**: `http://192.168.1.xxx:8000`
- **เมนูครู**: `http://192.168.1.xxx:8000/teacher`
- **เมนูนักเรียน**: `http://192.168.1.xxx:8000/student`
- **บอกเวลา (ครู)**: `http://192.168.1.xxx:8000/teacher/tell-a-time`
- **บอกเวลา (นักเรียน)**: `http://192.168.1.xxx:8000/student/tell-a-time`

💡 **คำแนะนำ**: แนะนำให้ฉายหน้าจอนักเรียนบน Projector เพื่อให้ทุกคนเห็นนาฬิกาชัดเจน

## 🔧 Technical Details

### Architecture
- **Backend**: Laravel 12+ (API endpoints)
- **Frontend**: Vue 3.3+ + Inertia.js 2.0+ (SPA)
- **Styling**: Tailwind CSS
- **Real-time**: Polling (1-2 second interval)
- **State Management**: Laravel Cache
- **Question Types**: Extensible architecture สำหรับเพิ่มประเภทโจทย์

### API Endpoints
- `GET /api/clock/current` - ดึงสถานะโจทย์ปัจจุบัน
- `GET /api/clock/current-type` - ดึงประเภทโจทย์ที่ครูเปิดอยู่ (สำหรับ real-time detection)
- `POST /api/clock/set` - สร้างโจทย์ใหม่ (ต้องระบุ `question_type`)
- `POST /api/clock/update` - อัปเดตรูปแบบเวลา (12H/24H)
- `POST /api/clock/random` - สุ่มเวลา
- `POST /api/clock/show-answer` - แสดง/ซ่อนคำตอบ
- `POST /api/clock/clear` - ล้างโจทย์

### Route Structure
```
/                           # หน้าหลัก (Welcome)
├── /student                # เมนูนักเรียน (StudentMenu.vue)
│   ├── /student/tell-a-time         # โจทย์บอกเวลา (Student.vue)
│   └── /student/clock-fast-slow     # โจทย์นาฬิกาช้า/เร็ว (เร็วๆ นี้)
└── /teacher                # เมนูครู (TeacherMenu.vue)
    ├── /teacher/tell-a-time         # ควบคุมบอกเวลา (Teacher.vue)
    └── /teacher/clock-fast-slow     # ควบคุมนาฬิกาช้า/เร็ว (เร็วๆ นี้)
```

### File Structure
```
├── app/Http/Controllers/
│   └── ClockController.php         # API Controller หลัก
├── resources/js/
│   ├── Pages/
│   │   ├── Welcome.vue             # หน้าหลัก
│   │   ├── StudentMenu.vue         # เมนูนักเรียน (พร้อม teacher detection)
│   │   ├── TeacherMenu.vue         # เมนูครู
│   │   ├── Student.vue             # หน้านักเรียน - บอกเวลา
│   │   └── Teacher.vue             # หน้าครู - บอกเวลา
│   ├── Components/
│   │   └── AnalogClock.vue         # นาฬิกา Analog แบบ Interactive
│   └── Layouts/
│       └── AppLayout.vue           # Layout หลัก
└── routes/
    ├── web.php                      # Web routes
    └── api.php                      # API routes

### Cache Structure
```php
// current_question
[
    'hour' => 3,
    'minute' => 30,
    'format' => '12h',              // '12h' หรือ '24h'
    'question_type' => 'tell-a-time', // ประเภทโจทย์
    'show_answer' => false           // แสดงคำตอบหรือไม่
]
```

### คำอธิบายเพิ่มเติม

#### การทำงานของระบบ Real-Time Detection
- StudentMenu.vue polling API `/api/clock/current-type` ทุก 2 วินาที
- เมื่อครูเปิดโจทย์ นักเรียนจะเห็นแจ้งเตือนแบบ real-time
- แจ้งเตือนจะแสดงชื่อโจทย์และปุ่ม "เข้าร่วมเลย" เพื่อเข้าสู่หน้าโจทย์ทันที

#### การเพิ่มประเภทโจทย์ใหม่
ระบบออกแบบให้เพิ่มโจทย์ใหม่ได้ง่าย:
1. สร้าง Vue component ใหม่ (เช่น `ClockFastSlow.vue`)
2. เพิ่ม route ใน `routes/web.php`
3. เพิ่มข้อมูลโจทย์ใน `StudentMenu.vue` และ `TeacherMenu.vue`
4. ไม่ต้องแก้ Backend - API รองรับ `question_type` แบบ dynamic

📖 ดูรายละเอียดเพิ่มเติมใน [MULTI_QUESTION_IMPLEMENTATION.md](MULTI_QUESTION_IMPLEMENTATION.md)

#### การเพิ่มระบบแบบฝึกหัดที่ต้อง Login (Future Feature)

สำหรับการพัฒนาระบบแบบฝึกหัดส่วนตัวที่นักเรียนต้อง login:

**1. แยก Routes ชัดเจน:**
```php
// Public - ไม่ต้อง login (สำหรับห้องเรียน/ฉายจอ)
Route::get('/student', ...);              // เมนูดูโจทย์จากครู
Route::get('/student/tell-a-time', ...);  // ดูโจทย์บอกเวลา

// Private - ต้อง login (สำหรับฝึกหัดส่วนตัว)
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/practice', ...);                    // เมนูแบบฝึกหัด
    Route::get('/practice/tell-a-time', ...);        // ฝึกหัดบอกเวลา
    Route::post('/practice/submit-answer', ...);     // ส่งคำตอบ
    Route::get('/practice/history', ...);            // ประวัติการทำ
    Route::get('/practice/leaderboard', ...);        // กระดานคะแนน
});
```

**2. Database Schema:**
```php
// Migration: create_practice_sessions_table
Schema::create('practice_sessions', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained()->onDelete('cascade');
    $table->string('question_type'); // 'tell-a-time', 'clock-fast-slow'
    $table->json('question_data');   // เก็บโจทย์
    $table->json('student_answer');  // คำตอบของนักเรียน
    $table->boolean('is_correct');   // ถูก/ผิด
    $table->integer('time_taken');   // เวลาที่ใช้ (วินาที)
    $table->integer('score');        // คะแนน
    $table->timestamps();
});

// Migration: add_role_to_users_table
Schema::table('users', function (Blueprint $table) {
    $table->enum('role', ['teacher', 'student'])->default('student');
    $table->string('student_id')->nullable(); // รหัสนักเรียน
    $table->string('grade')->nullable();      // ชั้นเรียน
});
```

**3. Components:**
- `PracticeMenu.vue` - เมนูเลือกแบบฝึกหัด
- `PracticeTellATime.vue` - หน้าฝึกหัดบอกเวลา (มีระบบตรวจคำตอบ)
- `PracticeHistory.vue` - ประวัติการทำแบบฝึกหัด
- `Leaderboard.vue` - กระดานคะแนน

**4. ข้อดี:**
- นักเรียนแต่ละคนมี account ของตัวเอง
- ติดตามความก้าวหน้า เก็บคะแนน
- ครูดูสถิติของนักเรียนได้
- Gamification: badges, leaderboard, achievements

**5. การสมัครสมาชิก:**
- ครูสร้าง class code
- นักเรียนใช้ class code สมัคร
- ครูอนุมัติการเข้าร่วม

## 🎯 Roadmap

- ✅ ระบบบอกเวลา (Tell a Time) - โหมดห้องเรียน
- 🚧 นาฬิกาช้า/เร็ว (Clock Fast/Slow)
- 📋 การคำนวณระยะเวลา (Time Duration)
- 📋 การเปรียบเทียบเวลา (Time Comparison)
- 📋 **ระบบแบบฝึกหัดส่วนตัว** (Practice Mode with Login)
  - Student authentication & profiles
  - แบบฝึกหัดอัตโนมัติ
  - ระบบตรวจคำตอบ
  - ประวัติและสถิติ
  - กระดานคะแนน
- 📋 Dashboard สำหรับครูดูสถิติของนักเรียน

## 🐛 Known Issues

- ต้องมี Vite dev server (`npm run dev`) ทำงานตลอดเวลาในโหมด development
- ถ้าหน้าจอนักเรียนไม่อัปเดต ให้ลอง refresh (F5)

## 🤝 Contributing

ยินดีรับ Pull Request และ Issue ทุกรูปแบบ!

## 📝 License

Open-source สำหรับใช้ในการศึกษา

---

Made with ❤️ for Teachers and Students
