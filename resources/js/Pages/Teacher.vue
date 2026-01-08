<template>
    <AppLayout>
        <div class="container mx-auto px-4 py-8">
            <!-- Header -->
            <div class="text-center mb-8">
                <h1 class="text-4xl font-bold text-gray-800 mb-2">
                    🎓 หน้าควบคุมของครู
                </h1>
                <p class="text-gray-600">กำหนดเวลาเพื่อแสดงบนหน้าจอนักเรียน</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 max-w-6xl mx-auto">
                <!-- Control Panel -->
                <div class="bg-white rounded-2xl shadow-xl p-8">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6">⚙️ ตั้งค่าโจทย์</h2>

                    <!-- Format Selection -->
                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-gray-700 mb-3">
                            รูปแบบเวลา
                        </label>
                        <div class="flex gap-4">
                            <button
                                @click="updateFormat('12h')"
                                :class="[
                                    'flex-1 py-3 px-4 rounded-lg font-medium transition-all',
                                    format === '12h'
                                        ? 'bg-blue-600 text-white shadow-lg'
                                        : 'bg-gray-100 text-gray-700 hover:bg-gray-200'
                                ]"
                            >
                                12 ชั่วโมง (AM/PM)
                            </button>
                            <button
                                @click="updateFormat('24h')"
                                :class="[
                                    'flex-1 py-3 px-4 rounded-lg font-medium transition-all',
                                    format === '24h'
                                        ? 'bg-blue-600 text-white shadow-lg'
                                        : 'bg-gray-100 text-gray-700 hover:bg-gray-200'
                                ]"
                            >
                                24 ชั่วโมง
                            </button>
                        </div>
                    </div>

                    <!-- Clock Hand Position Input -->
                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-gray-700 mb-3">
                            กำหนดตำแหน่งเข็มนาฬิกา
                        </label>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs text-gray-600 mb-2">เข็มสั้น (ชั่วโมง)</label>
                                <input
                                    v-model.number="hour"
                                    type="number"
                                    min="0"
                                    max="11"
                                    class="w-full px-4 py-3 text-xl font-bold text-center border-2 border-gray-300 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition-all"
                                />
                                <p class="text-xs text-gray-500 mt-1 text-center">
                                    0-11 (0=12, 1=1, ..., 11=11)
                                </p>
                            </div>
                            <div>
                                <label class="block text-xs text-gray-600 mb-2">เข็มยาว (นาที)</label>
                                <input
                                    v-model.number="minute"
                                    type="number"
                                    min="0"
                                    max="59"
                                    class="w-full px-4 py-3 text-xl font-bold text-center border-2 border-gray-300 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition-all"
                                />
                                <p class="text-xs text-gray-500 mt-1 text-center">0-59</p>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="space-y-3">
                        <button
                            @click="randomTime"
                            class="w-full py-3 px-6 bg-purple-600 hover:bg-purple-700 text-white font-semibold rounded-lg transition-all shadow-md hover:shadow-lg"
                        >
                            🎲 สุ่มตำแหน่งเข็ม
                        </button>
                        <button
                            @click="showQuestion"
                            :disabled="isSubmitting"
                            class="w-full py-3 px-6 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg transition-all shadow-md hover:shadow-lg disabled:bg-gray-400 disabled:cursor-not-allowed"
                        >
                            {{ isSubmitting ? '⏳ กำลังส่ง...' : '✅ แสดงโจทย์' }}
                        </button>
                        <button
                            @click="showAnswerToStudents"
                            :disabled="!currentQuestion || currentQuestion.show_answer"
                            class="w-full py-3 px-6 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition-all shadow-md hover:shadow-lg disabled:bg-gray-400 disabled:cursor-not-allowed"
                        >
                            {{ currentQuestion?.show_answer ? '✓ แสดงเฉลยแล้ว' : '👁️ แสดงเฉลย' }}
                        </button>
                        <button
                            @click="clearQuestion"
                            class="w-full py-3 px-6 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg transition-all shadow-md hover:shadow-lg"
                        >
                            🗑️ ล้างหน้าจอ
                        </button>
                    </div>

                    <!-- Status Message -->
                    <div
                        v-if="statusMessage"
                        :class="[
                            'mt-4 p-4 rounded-lg text-center font-medium',
                            statusType === 'success' ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800'
                        ]"
                    >
                        {{ statusMessage }}
                    </div>
                </div>

                <!-- Answer Preview -->
                <div class="bg-white rounded-2xl shadow-xl p-8">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6">✅ เฉลย</h2>

                    <div v-if="currentQuestion" class="space-y-6">
                        <!-- Analog Clock Preview -->
                        <div class="flex justify-center">
                            <AnalogClock
                                :hour="currentQuestion.hour"
                                :minute="currentQuestion.minute"
                                :size="250"
                                hand-color="#059669"
                            />
                        </div>

                        <!-- Digital Answer -->
                        <div class="space-y-3">
                            <h3 class="text-sm font-semibold text-gray-600 mb-3 text-center">
                                คำตอบที่ถูกต้องตามที่เลือก ({{ currentQuestion.format === '12h' ? '12H' : '24H' }})
                            </h3>

                            <!-- 12H Format -->
                            <div v-if="currentQuestion.format === '12h'" class="bg-gradient-to-r from-green-50 to-emerald-50 rounded-xl p-4">
                                <div class="text-center space-y-2">
                                    <div class="text-3xl font-bold text-green-700">
                                        {{ formatTime12H(currentQuestion.hour, currentQuestion.minute) }} AM
                                    </div>
                                    <div class="text-sm text-gray-600">หรือ</div>
                                    <div class="text-3xl font-bold text-green-700">
                                        {{ formatTime12H(currentQuestion.hour, currentQuestion.minute) }} PM
                                    </div>
                                </div>
                            </div>

                            <!-- 24H Format -->
                            <div v-else class="bg-gradient-to-r from-green-50 to-emerald-50 rounded-xl p-4">
                                <div class="text-center space-y-2">
                                    <div class="text-3xl font-bold text-green-700">
                                        {{ formatTime24H(currentQuestion.hour % 12, currentQuestion.minute) }}
                                    </div>
                                    <div class="text-sm text-gray-600">หรือ</div>
                                    <div class="text-3xl font-bold text-green-700">
                                        {{ formatTime24H((currentQuestion.hour % 12) + 12, currentQuestion.minute) }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Detailed Answer -->
                        <div class="bg-gray-50 rounded-xl p-4 text-sm space-y-2">
                            <div class="flex justify-between">
                                <span class="text-gray-600">ชั่วโมง:</span>
                                <span class="font-semibold">{{ currentQuestion.hour }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">นาที:</span>
                                <span class="font-semibold">{{ currentQuestion.minute }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">รูปแบบ:</span>
                                <span class="font-semibold">{{ currentQuestion.format === '12h' ? '12 ชั่วโมง' : '24 ชั่วโมง' }}</span>
                            </div>
                        </div>
                    </div>

                    <div v-else class="text-center text-gray-400 py-12">
                        <p class="text-lg">ยังไม่มีโจทย์</p>
                        <p class="text-sm mt-2">กำหนดเวลาและกด "แสดงโจทย์" เพื่อเริ่มต้น</p>
                    </div>
                </div>
            </div>

            <!-- Student View Link -->
            <div class="text-center mt-8 p-6 bg-white rounded-2xl shadow-lg max-w-2xl mx-auto">
                <h3 class="text-lg font-semibold text-gray-800 mb-3">
                    📺 ลิงก์สำหรับหน้าจอนักเรียน
                </h3>
                <div class="bg-gray-100 rounded-lg p-4 font-mono text-sm break-all">
                    {{ studentUrl }}
                </div>
                <p class="text-xs text-gray-600 mt-3">
                    เปิดลิงก์นี้บนจอแสดงผลสำหรับนักเรียน
                </p>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import AnalogClock from '@/Components/AnalogClock.vue';
import axios from 'axios';

const format = ref('12h');
const hour = ref(9);
const minute = ref(0);
const currentQuestion = ref(null);
const isSubmitting = ref(false);
const statusMessage = ref('');
const statusType = ref('success');

const studentUrl = computed(() => {
    return window.location.origin + '/student';
});

// อัพเดท format และส่งไป backend ถ้ามีโจทย์อยู่แล้ว
async function updateFormat(newFormat) {
    format.value = newFormat;

    // ถ้ามีโจทย์อยู่แล้ว ให้อัพเดท format ใน backend ทันที
    if (currentQuestion.value) {
        try {
            const response = await axios.post('/api/clock/update', {
                hour: currentQuestion.value.hour,
                minute: currentQuestion.value.minute,
                format: newFormat,
                question_type: 'tell-a-time',
            });

            if (response.data.success) {
                currentQuestion.value = response.data.data;
                showStatus('✅ เปลี่ยนรูปแบบแล้ว', 'success');
            }
        } catch (error) {
            console.error('Error updating format:', error);
            showStatus('❌ เกิดข้อผิดพลาด', 'error');
        }
    }
}

// สุ่มเวลา
async function randomTime() {
    try {
        const response = await axios.post('/api/clock/random');

        if (response.data.success) {
            hour.value = response.data.data.hour;
            minute.value = response.data.data.minute;
            showStatus('✅ สุ่มตำแหน่งเข็มแล้ว!', 'success');
        }
    } catch (error) {
        console.error('Error randomizing time:', error);
        showStatus('❌ เกิดข้อผิดพลาด', 'error');
    }
}

// แสดงโจทย์
async function showQuestion() {
    isSubmitting.value = true;

    try {
        const response = await axios.post('/api/clock/update', {
            hour: hour.value,
            minute: minute.value,
            format: format.value,
            question_type: 'tell-a-time'
        });

        if (response.data.success) {
            currentQuestion.value = response.data.data;
            showStatus('✅ แสดงโจทย์บนหน้าจอนักเรียนแล้ว!', 'success');
        }
    } catch (error) {
        console.error('Error showing question:', error);
        showStatus('❌ เกิดข้อผิดพลาด', 'error');
    } finally {
        isSubmitting.value = false;
    }
}

// แสดงเฉลยให้นักเรียน
async function showAnswerToStudents() {
    try {
        const response = await axios.post('/api/clock/show-answer');

        if (response.data.success) {
            currentQuestion.value = response.data.data;
            showStatus('👁️ แสดงเฉลยบนหน้าจอนักเรียนแล้ว!', 'success');
        }
    } catch (error) {
        console.error('Error showing answer:', error);
        showStatus('❌ เกิดข้อผิดพลาด', 'error');
    }
}

// ล้างโจทย์
async function clearQuestion() {
    try {
        const response = await axios.post('/api/clock/clear');

        if (response.data.success) {
            currentQuestion.value = null;
            showStatus('🗑️ ล้างหน้าจอแล้ว', 'success');
        }
    } catch (error) {
        console.error('Error clearing question:', error);
        showStatus('❌ เกิดข้อผิดพลาด', 'error');
    }
}

// แสดงสถานะ
function showStatus(message, type = 'success') {
    statusMessage.value = message;
    statusType.value = type;

    setTimeout(() => {
        statusMessage.value = '';
    }, 3000);
}

// Format time functions
function formatTime12H(h, m) {
    const hour12 = h === 0 ? 12 : h > 12 ? h - 12 : h;
    return `${hour12}:${m.toString().padStart(2, '0')}`;
}

function formatTime24H(h, m) {
    return `${h.toString().padStart(2, '0')}:${m.toString().padStart(2, '0')}`;
}

function getPeriodText(h) {
    if (h >= 0 && h < 12) {
        return 'ตอนกลางคืน (AM)';
    } else {
        return 'ตอนกลางวัน (PM)';
    }
}

function getPeriodText24H(h) {
    if (h >= 0 && h < 12) {
        return 'ตอนกลางคืน (00:00-11:59)';
    } else {
        return 'ตอนกลางวัน (12:00-23:59)';
    }
}

// โหลดสถานะปัจจุบัน
async function loadCurrentState() {
    try {
        const response = await axios.get('/api/clock/current');
        if (response.data.has_question) {
            currentQuestion.value = response.data.data;
        }
    } catch (error) {
        console.error('Error loading current state:', error);
    }
}

onMounted(() => {
    loadCurrentState();
});
</script>
