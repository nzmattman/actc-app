<?php

declare(strict_types=1);

namespace ACTC\Discounts\Actions;

use ACTC\Discounts\Discount;
use ACTC\Discounts\DiscountUser;
use ACTC\Discounts\Http\Requests\CheckDiscountRequest;

class CheckDiscount
{
    public function __invoke(CheckDiscountRequest $request)
    {
        $code = $request->validated('code');

        $discount = Discount::whereRaw('LOWER(code) = ?', [strtolower($code)])
            ->active()
            ->first()
        ;

        if (! $discount) {
            return response()->json([
                'success' => false,
                'message' => 'You have entered an invalid discount code.',
            ]);
        }

        if (auth()->check()) {
            $used = DiscountUser::whereDiscountId($discount->id)->whereUserId(auth()->id())->exists();
            if ($used) {
                return response()->json([
                    'success' => false,
                    'message' => 'You have entered an invalid discount code.',
                ]);
            }
        }

        if ($discount->expires_at < now()) {
            return response()->json([
                'success' => false,
                'message' => 'This discount code has expired.',
            ]);
        }

        $type = $this->getType($discount->type);

        $message = '';
        if ('weeks' === $type) {
            $message = 'Your free '.$discount->weeks.' week'.($discount->weeks > 2 ? 's' : '').' has been applied.';
        }

        $value = $this->getValue($discount);

        return response()->json([
            'success' => true,
            'type' => $type,
            'value' => $value,
            'message' => $message,
            'id' => $discount->uuid,
        ]);
    }

    private function getType(int $type): ?string
    {
        return match ($type) {
            1 => 'weeks',
            2 => 'price',
            3 => 'percent',
            default => null,
        };
    }

    private function getValue(Discount $item): ?float
    {
        return match ($item->type) {
            1 => $item->weeks,
            2 => $item->value / 100,
            3 => $item->percent / 100,
            default => null,
        };
    }
}
