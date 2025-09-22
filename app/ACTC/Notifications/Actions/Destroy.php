<?php

declare(strict_types=1);

namespace ACTC\Notifications\Actions;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Destroy
{
    public function __invoke(Request $request, string $notification): JsonResponse
    {
        DB::table('notifications')->where('id', $notification)->delete();

        return response()->json(['success' => true]);
    }
}
