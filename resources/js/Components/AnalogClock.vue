<template>
    <div class="relative" :style="{ width: size + 'px', height: size + 'px' }">
        <!-- Clock Face -->
        <svg :width="size" :height="size" :viewBox="`0 0 ${size} ${size}`" class="transform -rotate-90">
            <!-- Outer Circle -->
            <circle
                :cx="center"
                :cy="center"
                :r="radius"
                fill="white"
                stroke="#1e293b"
                :stroke-width="strokeWidth"
            />
            
            <!-- Hour Markers -->
            <g v-for="hour in 12" :key="`hour-${hour}`">
                <line
                    :x1="getMarkerX(hour, radius - 15)"
                    :y1="getMarkerY(hour, radius - 15)"
                    :x2="getMarkerX(hour, radius - 30)"
                    :y2="getMarkerY(hour, radius - 30)"
                    stroke="#1e293b"
                    :stroke-width="strokeWidth"
                    stroke-linecap="round"
                />
            </g>

            <!-- Minute Markers (5-minute intervals) -->
            <g v-for="minute in 60" :key="`minute-${minute}`">
                <line
                    v-if="minute % 5 !== 0"
                    :x1="getMarkerX(minute / 5, radius - 10)"
                    :y1="getMarkerY(minute / 5, radius - 10)"
                    :x2="getMarkerX(minute / 5, radius - 20)"
                    :y2="getMarkerY(minute / 5, radius - 20)"
                    stroke="#64748b"
                    :stroke-width="strokeWidth / 2"
                    stroke-linecap="round"
                />
            </g>

            <!-- Hour Hand -->
            <line
                :x1="center"
                :y1="center"
                :x2="getHandX(hourAngle, hourHandLength)"
                :y2="getHandY(hourAngle, hourHandLength)"
                :stroke="handColor"
                :stroke-width="hourHandWidth"
                stroke-linecap="round"
                class="transition-all duration-300"
            />

            <!-- Minute Hand -->
            <line
                :x1="center"
                :y1="center"
                :x2="getHandX(minuteAngle, minuteHandLength)"
                :y2="getHandY(minuteAngle, minuteHandLength)"
                :stroke="handColor"
                :stroke-width="minuteHandWidth"
                stroke-linecap="round"
                class="transition-all duration-300"
            />

            <!-- Center Dot -->
            <circle
                :cx="center"
                :cy="center"
                :r="centerDotRadius"
                :fill="handColor"
            />
        </svg>

        <!-- Numbers -->
        <div class="absolute inset-0 pointer-events-none">
            <div
                v-for="hour in 12"
                :key="`number-${hour}`"
                class="absolute text-gray-700 font-bold transform -translate-x-1/2 -translate-y-1/2"
                :style="{
                    fontSize: numberSize + 'px',
                    left: getNumberX(hour) + 'px',
                    top: getNumberY(hour) + 'px',
                }"
            >
                {{ hour }}
            </div>
        </div>
    </div>
</template>

<script setup>
import { computed } from 'vue';

const props = defineProps({
    hour: {
        type: Number,
        required: true,
    },
    minute: {
        type: Number,
        required: true,
    },
    size: {
        type: Number,
        default: 300,
    },
    handColor: {
        type: String,
        default: '#1e293b',
    },
});

// Calculations
const center = computed(() => props.size / 2);
const radius = computed(() => props.size / 2 - 10);
const strokeWidth = computed(() => props.size / 100);
const hourHandLength = computed(() => radius.value * 0.5);
const minuteHandLength = computed(() => radius.value * 0.7);
const hourHandWidth = computed(() => props.size / 40);
const minuteHandWidth = computed(() => props.size / 60);
const centerDotRadius = computed(() => props.size / 40);
const numberSize = computed(() => props.size / 12);
const numberRadius = computed(() => radius.value * 0.75);

// Angles (in degrees)
const minuteAngle = computed(() => (props.minute / 60) * 360);
const hourAngle = computed(() => ((props.hour % 12) / 12) * 360 + (props.minute / 60) * 30);

// Helper functions for marker positions
function getMarkerX(position, r) {
    const angle = (position / 12) * 360;
    return center.value + r * Math.cos((angle * Math.PI) / 180);
}

function getMarkerY(position, r) {
    const angle = (position / 12) * 360;
    return center.value + r * Math.sin((angle * Math.PI) / 180);
}

// Helper functions for hand positions
function getHandX(angle, length) {
    return center.value + length * Math.cos((angle * Math.PI) / 180);
}

function getHandY(angle, length) {
    return center.value + length * Math.sin((angle * Math.PI) / 180);
}

// Helper functions for number positions
function getNumberX(hour) {
    const angle = ((hour / 12) * 360 - 90) * (Math.PI / 180);
    return center.value + numberRadius.value * Math.cos(angle);
}

function getNumberY(hour) {
    const angle = ((hour / 12) * 360 - 90) * (Math.PI / 180);
    return center.value + numberRadius.value * Math.sin(angle);
}
</script>
