<?php

declare(strict_types=1);

namespace ACTC\Users\Actions\Card;

use ACTC\Users\Resources\PaymentMethodResource;
use Inertia\Inertia;
use Inertia\Response;

class CardIndex
{
    public function __invoke(): Response
    {
        $user = auth()->user();

        $config = [
            'cards' => Inertia::defer(function () use ($user) {
                $paymentMethods = $user->paymentMethods();
                $defaultPaymentMethod = $user->defaultPaymentMethod();

                $methods = PaymentMethodResource::collection($paymentMethods)->resolve();
                foreach ($methods as $index => $method) {
                    if ($method['id'] == $defaultPaymentMethod->id) {
                        $methods[$index]['default'] = true;
                    }
                }

                usort($methods, function ($a, $b) {
                    return ($b['default'] ?? false) <=> ($a['default'] ?? false);
                });

                return $methods;
            }, 'cards'),
        ];

        return Inertia::render('Profile/Card/Index', $config);
    }
}
