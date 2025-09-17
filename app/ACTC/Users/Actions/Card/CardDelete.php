<?php

declare(strict_types=1);

namespace ACTC\Users\Actions\Card;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CardDelete
{
    public function __invoke(Request $request, string $id): JsonResponse
    {
        try {
            auth()->user()->deletePaymentMethod($id);

            return response()->json([
                'success' => true,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }
}
