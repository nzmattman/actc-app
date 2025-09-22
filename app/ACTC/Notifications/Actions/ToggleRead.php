<?php

declare(strict_types=1);

namespace ACTC\Notifications\Actions;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ToggleRead
{
    public function __invoke(Request $request, string $notification): JsonResponse
    {
        $item = DB::table('notifications')->where('id', $notification)->first();
        $now = null;
        if ($item && !$item->read_at) {
            $now = now();
        }

        DB::table('notifications')
            ->where('id', $notification)
            ->update(['read_at' => $now])
        ;

        return response()->json(['success' => true]);
    }
}
