<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ClockController extends Controller
{
    /**
     * Get current clock question state
     */
    public function getCurrentState()
    {
        $question = Cache::get('clock_current_question');

        if ($question) {
            return response()->json([
                'has_question' => true,
                'data' => $question,
            ]);
        }

        return response()->json([
            'has_question' => false,
            'data' => null,
        ]);
    }

    /**
     * Set new clock question (for teacher)
     */
    public function setQuestion(Request $request)
    {
        $validated = $request->validate([
            'hour' => 'required|integer|min:0|max:11',
            'minute' => 'required|integer|min:0|max:59',
            'format' => 'required|in:12h,24h',
            'question_type' => 'required|string',
            'show_answer' => 'sometimes|boolean',
        ]);

        // Default show_answer to false if not provided
        $validated['show_answer'] = $validated['show_answer'] ?? false;

        Cache::put('clock_current_question', $validated, now()->addHours(2));

        return response()->json([
            'success' => true,
            'data' => $validated,
        ]);
    }

    /**
     * Update/set clock question (alias for setQuestion)
     */
    public function updateQuestion(Request $request)
    {
        return $this->setQuestion($request);
    }

    /**
     * Generate random time
     */
    public function randomTime(Request $request)
    {
        $hour = rand(0, 11);
        $minute = rand(0, 59);

        return response()->json([
            'success' => true,
            'data' => [
                'hour' => $hour,
                'minute' => $minute,
            ],
        ]);
    }

    /**
     * Show answer for current question
     */
    public function showAnswer()
    {
        $question = Cache::get('clock_current_question');

        if ($question) {
            $question['show_answer'] = true;
            Cache::put('clock_current_question', $question, now()->addHours(2));

            return response()->json([
                'success' => true,
                'data' => $question,
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'No question to show answer',
        ], 404);
    }

    /**
     * Clear current question
     */
    public function clearQuestion()
    {
        Cache::forget('clock_current_question');

        return response()->json([
            'success' => true,
            'message' => 'Question cleared',
        ]);
    }

    /**
     * Get current question type (for students to check what teacher is doing)
     */
    public function getCurrentType()
    {
        $question = Cache::get('clock_current_question');

        if ($question && isset($question['question_type'])) {
            return response()->json([
                'has_question' => true,
                'question_type' => $question['question_type'],
            ]);
        }

        return response()->json([
            'has_question' => false,
            'question_type' => null,
        ]);
    }
}
