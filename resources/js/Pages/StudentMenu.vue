<template>
    <AppLayout>
        <div class="min-h-screen flex items-center justify-center p-8 bg-gradient-to-br from-blue-50 to-indigo-100">
            <div class="w-full max-w-4xl">
                <!-- Title -->
                <div class="text-center mb-12">
                    <h1 class="text-6xl font-bold text-gray-800 mb-4">
                        📚 เลือกประเภทโจทย์
                    </h1>
                    <p class="text-xl text-gray-600">
                        เลือกโจทย์ที่ต้องการฝึกฝน
                    </p>
                </div>

                <!-- Current Teacher Question Alert -->
                <div v-if="teacherQuestion" class="mb-8 bg-yellow-50 border-2 border-yellow-400 rounded-2xl p-6 text-center animate-pulse">
                    <div class="text-4xl mb-2">👨‍🏫</div>
                    <p class="text-xl font-bold text-yellow-800 mb-2">
                        ครูกำลังเปิดโจทย์!
                    </p>
                    <p class="text-lg text-yellow-700">
                        {{ getQuestionTypeName(teacherQuestion) }}
                    </p>
                    <a
                        :href="getQuestionTypeRoute(teacherQuestion)"
                        class="inline-block mt-4 px-8 py-3 bg-yellow-400 hover:bg-yellow-500 text-gray-900 font-bold rounded-lg transition-all shadow-lg"
                    >
                        เข้าร่วมเลย →
                    </a>
                </div>

                <!-- Question Types Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Tell a Time -->
                    <a
                        href="/student/tell-a-time"
                        class="block group"
                    >
                        <div class="bg-white rounded-3xl shadow-xl p-8 hover:shadow-2xl transition-all duration-300 transform group-hover:scale-105 border-4 border-transparent hover:border-blue-400">
                            <div class="text-6xl mb-4 text-center">🕐</div>
                            <h3 class="text-2xl font-bold text-gray-800 mb-3 text-center">
                                บอกเวลา
                            </h3>
                            <p class="text-gray-600 text-center">
                                อ่านเวลาจากนาฬิกา Analog
                            </p>
                            <div class="mt-4 flex justify-center">
                                <span class="inline-block px-4 py-2 bg-blue-100 text-blue-600 rounded-full text-sm font-semibold">
                                    พร้อมใช้งาน
                                </span>
                            </div>
                        </div>
                    </a>

                    <!-- Clock Fast/Slow - Coming Soon -->
                    <div class="block group opacity-60 cursor-not-allowed">
                        <div class="bg-white rounded-3xl shadow-xl p-8 border-4 border-gray-200">
                            <div class="text-6xl mb-4 text-center filter grayscale">⏰</div>
                            <h3 class="text-2xl font-bold text-gray-800 mb-3 text-center">
                                นาฬิกาช้า/เร็ว
                            </h3>
                            <p class="text-gray-600 text-center">
                                คำนวณเวลาที่นาฬิกาช้าหรือเร็ว
                            </p>
                            <div class="mt-4 flex justify-center">
                                <span class="inline-block px-4 py-2 bg-gray-200 text-gray-600 rounded-full text-sm font-semibold">
                                    เร็วๆ นี้
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- More question types can be added here -->
                </div>

                <!-- Back to Welcome -->
                <div class="mt-8 text-center">
                    <a
                        href="/"
                        class="inline-flex items-center gap-2 px-6 py-3 text-gray-600 hover:text-gray-800 font-medium transition-all"
                    >
                        ← กลับหน้าหลัก
                    </a>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue';
import AppLayout from '../Layouts/AppLayout.vue';
import axios from 'axios';

const teacherQuestion = ref(null);
let pollingInterval = null;

// Check current teacher question
async function checkTeacherQuestion() {
    try {
        const response = await axios.get('/api/clock/current-type');
        if (response.data.has_question) {
            teacherQuestion.value = response.data.question_type;
        } else {
            teacherQuestion.value = null;
        }
    } catch (error) {
        console.error('Error checking teacher question:', error);
    }
}

function getQuestionTypeName(type) {
    const names = {
        'tell-a-time': '📖 บอกเวลา',
        'clock-fast-slow': '⏰ นาฬิกาช้า/เร็ว',
    };
    return names[type] || type;
}

function getQuestionTypeRoute(type) {
    return `/student/${type}`;
}

onMounted(() => {
    checkTeacherQuestion();
    // Poll every 2 seconds
    pollingInterval = setInterval(checkTeacherQuestion, 2000);
});

onUnmounted(() => {
    if (pollingInterval) {
        clearInterval(pollingInterval);
    }
});
</script>
