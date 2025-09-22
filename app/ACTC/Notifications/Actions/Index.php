<?php

declare(strict_types=1);

namespace ACTC\Notifications\Actions;

use ACTC\Notifications\Resources\NotificationResource;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Inertia\Inertia;

class Index
{
    public function __invoke(Request $request)
    {
        $notifications = $request->user()->notifications()->paginate(20);

        $config = [
            'notifications' => Inertia::merge(NotificationResource::collection($notifications->items())->resolve()),
            'pagination' => Arr::only($notifications->toArray(), ['current_page', 'last_page']),
        ];

        return Inertia::render('Notifications/Index', $config);
    }
}
