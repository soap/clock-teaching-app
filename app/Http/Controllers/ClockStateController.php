<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ClockStateController extends Controller
{
    /**
     * ดึงสถานะปัจจุบันของนาฬิกา (สำหรับ polling)
     */
    public function current()
    {
        $state = cache('clock_current_state');

        return response()->json([
            'success' => true,
            'data' => $state,
            'has_question' => !is_null($state),
        ]);
    }

    /**
     * อัปเดตสถานะนาฬิกา (เรียกจากครู)
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'hour' => 'required|integer|min:0|max:23',
            'minute' => 'required|integer|min:0|max:59',
            'format' => 'required|in:12h,24h',
        ]);

        $state = [
            'hour' => $validated['hour'],
            'minute' => $validated['minute'],
            'format' => $validated['format'],
            'updated_at' => now()->toISOString(),
        ];

        cache()->put('clock_current_state', $state, 3600);

        return response()->json([
            'success' => true,
            'data' => $state
        ]);
    }

    /**
     * ล้างสถานะนาฬิกา
     */
    public function clear()
    {
        cache()->forget('clock_current_state');

        return response()->json([
            'success' => true,
            'message' => 'Clock state cleared'
        ]);
    }
}
