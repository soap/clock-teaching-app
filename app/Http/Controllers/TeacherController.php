<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class TeacherController extends Controller
{
    /**
     * แสดงหน้าครู
     */
    public function index()
    {
        return Inertia::render('Teacher');
    }

    /**
     * อัปเดตโจทย์ใหม่
     */
    public function updateQuestion(Request $request)
    {
        $validated = $request->validate([
            'hour' => 'required|integer|min:0|max:23',
            'minute' => 'required|integer|min:0|max:59',
            'format' => 'required|in:12h,24h',
        ]);

        // เก็บข้อมูลใน cache (expire หลัง 1 ชั่วโมง)
        cache()->put('clock_current_state', [
            'hour' => $validated['hour'],
            'minute' => $validated['minute'],
            'format' => $validated['format'],
            'updated_at' => now()->toISOString(),
        ], 3600);

        return response()->json([
            'success' => true,
            'data' => cache('clock_current_state')
        ]);
    }

    /**
     * ล้างโจทย์
     */
    public function clearQuestion()
    {
        cache()->forget('clock_current_state');

        return response()->json([
            'success' => true,
            'message' => 'Question cleared'
        ]);
    }

    /**
     * สุ่มเวลา
     */
    public function randomTime(Request $request)
    {
        $format = $request->input('format', '12h');
        
        $maxHour = $format === '12h' ? 11 : 23;
        $hour = rand(0, $maxHour);
        $minute = rand(0, 59);

        return response()->json([
            'success' => true,
            'data' => [
                'hour' => $hour,
                'minute' => $minute,
            ]
        ]);
    }
}
