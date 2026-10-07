<?php

namespace App\Http\Controllers;

use App\Services\EmailGeneratorService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class EmailController extends Controller
{
    public function __construct(private EmailGeneratorService $emailGeneratorService)
    {

    }

    public function generate(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'purpose' => 'required|string|max:500',
            'recipient_name' => 'required|string|max:100',
            'tone' => 'required|string|max:50',
        ]);

        try {
            $result = $this->emailGeneratorService->generateEmail(
                $validated['purpose'],
                $validated['recipient_name'],
                $validated['tone']
            );
        } catch (\RuntimeException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
        

        return response()->json([
            'success' => true,
            'message' => 'Email generated successfully.',
            'data' => $result,
        ]);
    }
}
