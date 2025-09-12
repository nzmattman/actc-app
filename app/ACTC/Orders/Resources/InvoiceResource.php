<?php

declare(strict_types=1);

namespace ACTC\Orders\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InvoiceResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'date' => $this->date()->toFormattedDateString(),
            'total' => $this->total(),
            'download' => route('invoices.download', $this->id),
        ];
    }
}
