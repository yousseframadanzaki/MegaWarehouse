<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Invoice;
use Illuminate\Http\Request;

class InvoicePolicy
{

    public function view_invoice(User $user): bool
    {
        if(!$user->role->permissions->contains('slug','view_invoices')){
            return false;
        }

        return true;
    }

}
