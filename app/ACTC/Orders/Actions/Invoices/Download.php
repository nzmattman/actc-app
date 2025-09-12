<?php

namespace ACTC\Orders\Actions\Invoices;

use Illuminate\Http\Request;

class Download
{
    public function __invoke(Request $request, string $invoiceId)
    {
        return $request->user()->downloadInvoice($invoiceId);
    }
}
