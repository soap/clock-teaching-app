# Multi-Question Type Implementation

## Overview
This document describes the implementation of a multi-question-type system that allows the app to support various types of clock learning exercises.

## Architecture

### Current Question Types
1. **tell-a-time** (บอกเวลา) - Active ✅
2. **clock-fast-slow** (นาฬิกาเร็ว/ช้า) - Planned 🚧

### URL Structure

#### Student Routes
- `/student` → StudentMenu.vue (Question type selection menu)
- `/student/tell-a-time` → Student.vue (Tell-a-time exercise)
- `/student/clock-fast-slow` → (Future implementation)

#### Teacher Routes
- `/teacher` → TeacherMenu.vue (Question type selection menu)
- `/teacher/tell-a-time` → Teacher.vue (Tell-a-time control panel)
- `/teacher/clock-fast-slow` → (Future implementation)

## Key Features

### 1. Question Type Detection
Students can see when the teacher has an active question and what type it is.

**API Endpoint:** `GET /api/clock/current-type`

**Response:**
```json
{
  "has_question": true,
  "question_type": "tell-a-time"
}
```

### 2. Real-Time Polling
StudentMenu.vue polls the API every 2 seconds to check if the teacher has opened a question.

When a question is detected:
- Yellow animated alert box appears
- Shows the question type name
- Provides "เข้าร่วมเลย →" button to join directly

### 3. Backend Changes

#### ClockController.php
- Added `question_type` validation in `setQuestion()` method
- Created `getCurrentType()` method to return current question state
- All set/update operations now store question_type in cache

**Cache Structure:**
```php
Cache::put('current_question', [
    'hours' => 3,
    'minutes' => 30,
    'format' => '12H',
    'question_type' => 'tell-a-time',  // NEW
    'show_answer' => false
], now()->addHours(2));
```

#### routes/api.php
Added route:
```php
Route::get('/current-type', [ClockController::class, 'getCurrentType']);
```

#### routes/web.php
Restructured routes:
```php
// Old structure
Route::get('/student', ...Student.vue);

// New structure
Route::get('/student', ...StudentMenu.vue);
Route::get('/student/tell-a-time', ...Student.vue);
Route::get('/teacher', ...TeacherMenu.vue);
Route::get('/teacher/tell-a-time', ...Teacher.vue);
```

## Component Details

### StudentMenu.vue
**Purpose:** Main menu for students to choose question types

**Features:**
- Grid layout with question type cards
- Polling mechanism (every 2 seconds) to detect teacher activity
- Animated yellow alert box when teacher has active question
- Visual distinction between active and disabled question types

**Polling Logic:**
```javascript
const checkTeacherQuestion = async () => {
    const response = await axios.get('/api/clock/current-type');
    teacherQuestion.value = response.data.has_question 
        ? response.data.question_type 
        : null;
};

onMounted(() => {
    checkTeacherQuestion();
    const interval = setInterval(checkTeacherQuestion, 2000);
    onUnmounted(() => clearInterval(interval));
});
```

### TeacherMenu.vue
**Purpose:** Main menu for teachers to choose question types

**Features:**
- Grid layout with question type cards
- Purple-themed UI to distinguish from student view
- Links to specific question control panels

### Teacher.vue
**Changes:**
- Added `question_type: 'tell-a-time'` to all API calls
- Modified `showQuestion()` and `updateFormat()` methods

**Example:**
```javascript
const showQuestion = async () => {
    await axios.post('/api/clock/set', {
        hours: parseInt(hours.value),
        minutes: parseInt(minutes.value),
        format: format.value,
        question_type: 'tell-a-time'  // NEW
    });
};
```

### Student.vue
**Changes:**
- None (remains the same, accessed via `/student/tell-a-time`)

## Testing Checklist

### Basic Navigation
- [ ] Visit `/` and click "นักเรียน" → Should go to `/student` (StudentMenu)
- [ ] Visit `/` and click "ครู" → Should go to `/teacher` (TeacherMenu)
- [ ] From StudentMenu, click "บอกเวลา" card → Should go to `/student/tell-a-time`
- [ ] From TeacherMenu, click "บอกเวลา" card → Should go to `/teacher/tell-a-time`

### Teacher Activity Detection
1. [ ] Open `/student` in one browser/tab
2. [ ] Open `/teacher` in another browser/tab
3. [ ] From teacher menu, click "บอกเวลา" to go to `/teacher/tell-a-time`
4. [ ] Teacher creates a new question
5. [ ] Student menu should show yellow alert box within 2 seconds
6. [ ] Alert should say "ครูเปิดโจทย์: บอกเวลา" with "เข้าร่วมเลย →" button
7. [ ] Click button → Should navigate to `/student/tell-a-time` with active question

### Question Type Persistence
- [ ] Teacher creates a tell-a-time question
- [ ] Refresh student page → Question type should still be detected
- [ ] Teacher clears question → Student menu alert should disappear within 2 seconds

### Multiple Question Types (Future)
When clock-fast-slow is implemented:
- [ ] Teacher creates clock-fast-slow question
- [ ] Student menu should detect "นาฬิกาเร็ว/ช้า"
- [ ] Clicking "เข้าร่วมเลย" should navigate to correct route

## Adding New Question Types

To add a new question type (e.g., "clock-fast-slow"):

### 1. Backend
No changes needed - already supports arbitrary question_type strings

### 2. Routes (routes/web.php)
```php
Route::get('/student/clock-fast-slow', ...ClockFastSlowStudent.vue);
Route::get('/teacher/clock-fast-slow', ...ClockFastSlowTeacher.vue);
```

### 3. Create Vue Components
- Create `ClockFastSlowStudent.vue` - Student view
- Create `ClockFastSlowTeacher.vue` - Teacher control panel

### 4. Update Menus
Add new question type card to:
- `StudentMenu.vue` - Add to `questionTypes` array
- `TeacherMenu.vue` - Add to `questionTypes` array

**Example:**
```javascript
const questionTypes = [
    {
        id: 'tell-a-time',
        name: 'บอกเวลา',
        icon: '🕐',
        route: '/student/tell-a-time',
        available: true
    },
    {
        id: 'clock-fast-slow',
        name: 'นาฬิกาเร็ว/ช้า',
        icon: '⏰',
        route: '/student/clock-fast-slow',
        available: true  // Set to false to disable
    }
];
```

### 5. Update Teacher Component
In the new teacher component, make sure to include `question_type` in API calls:
```javascript
await axios.post('/api/clock/set', {
    // ... other data
    question_type: 'clock-fast-slow'
});
```

## API Reference

### GET /api/clock/current-type
Returns current teacher question type

**Response:**
```json
{
  "has_question": true,
  "question_type": "tell-a-time"
}
```

**Response (No Question):**
```json
{
  "has_question": false,
  "question_type": null
}
```

### POST /api/clock/set
Creates new question (requires `question_type` field)

**Request:**
```json
{
  "hours": 3,
  "minutes": 30,
  "format": "12H",
  "question_type": "tell-a-time"
}
```

### PUT /api/clock/update
Updates question format (requires `question_type` field)

**Request:**
```json
{
  "format": "24H",
  "question_type": "tell-a-time"
}
```

## Benefits of This Architecture

1. **Scalability** - Easy to add new question types without modifying core logic
2. **Real-Time Awareness** - Students always know what teacher is doing
3. **Clear Navigation** - Separate URLs for each question type
4. **User Experience** - Direct links to join teacher's active question
5. **Future-Proof** - Structure supports unlimited question types

## Notes

- Polling interval is 2 seconds - adjust in StudentMenu.vue if needed
- Cache TTL is 2 hours for questions - adjust in ClockController if needed
- Question types are string-based, allowing flexible addition of new types
- No database changes required - all state stored in cache
