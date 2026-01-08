<template>
    <AppLayout>
        <div class="min-h-screen flex items-center justify-center p-8 bg-gradient-to-br from-purple-50 to-pink-100">
            <div class="w-full max-w-4xl">
                <!-- Title -->
                <div class="text-center mb-12">
                    <h1 class="text-6xl font-bold text-gray-800 mb-4">
                        👨‍🏫 เลือกประเภทโจทย์
                    </h1>
                    <p class="text-xl text-gray-600">
                        เลือกโจทย์ที่ต้องการสอน
                    </p>
                </div>

                <!-- Question Types Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Tell a Time -->
                    <a
                        href="/teacher/tell-a-time"
                        class="block group"
                    >
                        <div class="bg-white rounded-3xl shadow-xl p-8 hover:shadow-2xl transition-all duration-300 transform group-hover:scale-105 border-4 border-transparent hover:border-purple-400">
                            <div class="text-6xl mb-4 text-center">🕐</div>
                            <h3 class="text-2xl font-bold text-gray-800 mb-3 text-center">
                                บอกเวลา
                            </h3>
                            <p class="text-gray-600 text-center">
                                สอนการอ่านเวลาจากนาฬิกา Analog
                            </p>
                            <div class="mt-6 flex justify-center">
                                <span class="inline-flex items-center gap-2 px-6 py-3 bg-purple-600 text-white rounded-lg font-semibold group-hover:bg-purple-700 transition-all">
                                    เริ่มสอน →
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
                                สอนการคำนวณเวลาที่นาฬิกาช้าหรือเร็ว
                            </p>
                            <div class="mt-6 flex justify-center">
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
import AppLayout from '../Layouts/AppLayout.vue';
</script>
