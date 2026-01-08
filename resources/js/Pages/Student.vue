<template>
    <AppLayout>
        <div class="min-h-screen flex items-center justify-center p-8">
            <div v-if="currentQuestion" class="w-full max-w-6xl">
                <!-- Title -->
                <div class="text-center mb-8">
                    <h1 class="text-5xl font-bold text-gray-800 mb-4">
                        🕐 อ่านเวลาจากนาฬิกา
                    </h1>
                    <div class="inline-block px-6 py-3 bg-blue-600 text-white rounded-full text-2xl font-semibold">
                        {{ currentQuestion.format === '12h' ? 'ระบบ 12 ชั่วโมง (AM/PM)' : 'ระบบ 24 ชั่วโมง' }}
                    </div>
                </div>

                <!-- Clock Display -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-start">
                    <!-- Analog Clock -->
                    <div class="bg-white rounded-3xl shadow-2xl p-12 flex justify-center items-center">
                        <AnalogClock
                            :hour="currentQuestion.hour"
                            :minute="currentQuestion.minute"
                            :size="400"
                            hand-color="#2563eb"
                        />
                    </div>

                    <!-- Right Side: Helper Info (before answer) or Digital Clock (after answer) -->
                    <div class="space-y-6">
                        <!-- Show Answer - Digital Clocks -->
                        <div v-if="currentQuestion.show_answer" class="space-y-3">
                            <!-- เฉลยกลางวัน -->
                            <div class="bg-gradient-to-br from-orange-500 to-yellow-500 rounded-2xl shadow-2xl p-4 text-center">
                                <div class="text-white mb-2">
                                    <p class="text-xl font-semibold">☀️ กลางวัน (AM)</p>
                                </div>

                                <div class="bg-black/30 rounded-xl py-6 px-4 backdrop-blur-sm space-y-2">
                                    <!-- 12H -->
                                    <div v-if="currentQuestion.format === '12h'" class="text-6xl font-bold text-white font-mono tracking-wider">
                                        {{ formatTime12H(currentQuestion.hour, currentQuestion.minute) }} <span class="text-yellow-300">AM</span>
                                    </div>

                                    <!-- 24H -->
                                    <div v-else class="text-6xl font-bold text-white font-mono tracking-wider">
                                        {{ formatTime24H(currentQuestion.hour % 12, currentQuestion.minute) }}
                                    </div>
                                </div>
                            </div>

                            <!-- เฉลยกลางคืน -->
                            <div class="bg-gradient-to-br from-indigo-600 to-blue-600 rounded-2xl shadow-2xl p-4 text-center">
                                <div class="text-white mb-2">
                                    <p class="text-xl font-semibold">🌙 กลางคืน (PM)</p>
                                </div>

                                <div class="bg-black/30 rounded-xl py-6 px-4 backdrop-blur-sm space-y-2">
                                    <!-- 12H -->
                                    <div v-if="currentQuestion.format === '12h'" class="text-6xl font-bold text-white font-mono tracking-wider">
                                        {{ formatTime12H(currentQuestion.hour, currentQuestion.minute) }} <span class="text-blue-300">PM</span>
                                    </div>

                                    <!-- 24H -->
                                    <div v-else class="text-6xl font-bold text-white font-mono tracking-wider">
                                        {{ formatTime24H((currentQuestion.hour % 12) + 12, currentQuestion.minute) }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Before Answer - Helper Info -->
                        <div v-else class="bg-white rounded-2xl shadow-xl p-8">
                            <h3 class="text-2xl font-bold text-gray-800 mb-4 text-center">
                                📝 คำใบ้
                            </h3>
                            <div class="space-y-3 text-lg">
                                <div class="flex items-start gap-3">
                                    <span class="text-2xl">🕐</span>
                                    <p class="text-gray-700">
                                        <strong>เข็มสั้น</strong> = ชั่วโมง (0-11)
                                    </p>
                                </div>
                                <div class="flex items-start gap-3">
                                    <span class="text-2xl">🕐</span>
                                    <p class="text-gray-700">
                                        <strong>เข็มยาว</strong> = นาที (0-59)
                                    </p>
                                </div>
                                <div class="flex items-start gap-3">
                                    <span class="text-2xl">☀️</span>
                                    <p class="text-gray-700">
                                        <strong>AM</strong> = กลางวัน (00:00-11:59)
                                    </p>
                                </div>
                                <div class="flex items-start gap-3">
                                    <span class="text-2xl">🌙</span>
                                    <p class="text-gray-700">
                                        <strong>PM</strong> = กลางคืน (12:00-23:59)
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- No Question State -->
            <div v-else class="text-center">
                <div class="bg-white rounded-3xl shadow-2xl p-16">
                    <div class="text-8xl mb-6">⏳</div>
                    <h2 class="text-4xl font-bold text-gray-800 mb-4">
                        รอครูกำหนดโจทย์...
                    </h2>
                    <p class="text-xl text-gray-600">
                        หน้าจอจะแสดงนาฬิกาเมื่อครูเริ่มต้นโจทย์
                    </p>

                    <!-- Loading Animation -->
                    <div class="flex justify-center gap-2 mt-8">
                        <div class="w-4 h-4 bg-blue-600 rounded-full animate-bounce" style="animation-delay: 0ms"></div>
                        <div class="w-4 h-4 bg-blue-600 rounded-full animate-bounce" style="animation-delay: 150ms"></div>
                        <div class="w-4 h-4 bg-blue-600 rounded-full animate-bounce" style="animation-delay: 300ms"></div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue';
import AppLayout from '../Layouts/AppLayout.vue';
import AnalogClock from '../Components/AnalogClock.vue';
import axios from 'axios';

const currentQuestion = ref(null);
let pollingInterval = null;

// Polling function
async function pollCurrentState() {
    try {
        const response = await axios.get('/api/clock/current');

        if (response.data.has_question) {
            currentQuestion.value = response.data.data;
        } else {
            currentQuestion.value = null;
        }
    } catch (error) {
        console.error('Error polling state:', error);
    }
}

// Format time functions
function formatTime12H(h, m) {
    // แปลง 0-11 -> 12,1,2,...,11 สำหรับแสดงผลระบบ 12 ชม.
    const hour12 = h === 0 ? 12 : h;
    return `${hour12}:${m.toString().padStart(2, '0')}`;
}

function formatTime24H(h, m) {
    return `${h.toString().padStart(2, '0')}:${m.toString().padStart(2, '0')}`;
}

function getPeriod(h) {
    return h >= 0 && h < 12 ? 'AM' : 'PM';
}

function getPeriodColor(h) {
    return h >= 0 && h < 12
        ? 'text-blue-300'
        : 'text-yellow-300';
}

function getPeriod24H(h) {
    if (h >= 6 && h < 18) {
        return 'กลางวัน';
    } else {
        return 'กลางคืน';
    }
}

function getPeriodColor24H(h) {
    return h >= 6 && h < 18
        ? 'text-yellow-300'
        : 'text-blue-300';
}

// Lifecycle
onMounted(() => {
    // โหลดทันที
    pollCurrentState();

    // Polling ทุก 1 วินาที
    pollingInterval = setInterval(pollCurrentState, 1000);
});

onUnmounted(() => {
    if (pollingInterval) {
        clearInterval(pollingInterval);
    }
});
</script>
