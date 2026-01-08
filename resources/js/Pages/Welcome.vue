<script setup>
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    laravelVersion: String,
    phpVersion: String,
});
</script>

<template>
    <Head title="Welcome" />

    <div class="min-h-screen bg-gradient-to-br from-indigo-600 via-purple-600 to-pink-500 flex items-center justify-center p-4 relative overflow-hidden">
        <!-- Animated background circles -->
        <div class="absolute top-0 left-0 w-96 h-96 bg-white/10 rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute bottom-0 right-0 w-96 h-96 bg-white/10 rounded-full blur-3xl animate-pulse delay-1000"></div>

        <div class="relative z-10 max-w-4xl w-full">
            <!-- Main Card -->
            <div class="bg-white/95 backdrop-blur-lg rounded-3xl shadow-2xl p-12 text-center transform hover:scale-105 transition-transform duration-300">
                <!-- Icon/Logo -->
                <div class="mb-8 flex justify-center">
                    <div class="bg-gradient-to-br from-indigo-500 to-purple-600 p-6 rounded-full shadow-lg">
                        <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>

                <!-- Title -->
                <h1 class="text-5xl md:text-6xl font-bold bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 bg-clip-text text-transparent mb-4">
                    Clock Teaching App
                </h1>

                <p class="text-xl text-gray-600 mb-8">
                    🕐 เรียนรู้การบอกเวลาแบบสนุกสนาน
                </p>

                <!-- Version Info -->
                <div v-if="laravelVersion" class="flex items-center justify-center gap-4 mb-10 text-sm text-gray-500">
                    <span class="px-3 py-1 bg-gray-100 rounded-full">Laravel {{ laravelVersion }}</span>
                    <span class="px-3 py-1 bg-gray-100 rounded-full">PHP {{ phpVersion }}</span>
                </div>

                <!-- Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 justify-center items-center max-w-md mx-auto">
                    <Link
                        v-if="canLogin"
                        :href="route('login')"
                        class="w-full sm:w-auto px-8 py-4 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-bold rounded-xl shadow-lg transform hover:-translate-y-1 transition-all duration-200 flex items-center justify-center gap-2"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                        </svg>
                        เข้าสู่ระบบ
                    </Link>

                    <Link
                        v-if="canRegister"
                        :href="route('register')"
                        class="w-full sm:w-auto px-8 py-4 bg-white border-2 border-purple-600 text-purple-600 hover:bg-purple-50 font-bold rounded-xl shadow-lg transform hover:-translate-y-1 transition-all duration-200 flex items-center justify-center gap-2"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                        </svg>
                        ลงทะเบียน
                    </Link>
                </div>

                <!-- Quick Access -->
                <div class="mt-12 pt-8 border-t border-gray-200">
                    <p class="text-gray-600 mb-4 font-medium">เริ่มเรียนรู้เลย</p>
                    <div class="flex flex-wrap justify-center gap-3">
                        <Link
                            :href="route('student')"
                            class="px-6 py-2 bg-gradient-to-r from-blue-500 to-cyan-500 hover:from-blue-600 hover:to-cyan-600 text-white font-semibold rounded-lg shadow transform hover:scale-105 transition-all duration-200"
                        >
                            👨‍🎓 โหมดนักเรียน
                        </Link>
                        <Link
                            href="/teacher"
                            class="px-6 py-2 bg-gradient-to-r from-green-500 to-emerald-500 hover:from-green-600 hover:to-emerald-600 text-white font-semibold rounded-lg shadow transform hover:scale-105 transition-all duration-200"
                        >
                            👨‍🏫 โหมดครู
                        </Link>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
