<?php

declare(strict_types=1);

namespace ACTC\Users\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PaymentMethodResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $expiry = $this->card->exp_month;
        if ($this->card->exp_month < 10) {
            $expiry = '0'.$expiry;
        }
        $expiry .= '/'.$this->card->exp_year;

        return [
            'id' => $this->id,
            'brand' => ucwords($this->card->brand),
            'card' => str_pad((string) $this->card->last4, 8, '*', STR_PAD_LEFT),
            'expiry' => $expiry,
            'default' => false,
        ];
    }
}
