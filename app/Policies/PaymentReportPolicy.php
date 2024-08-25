<?php

namespace App\Policies;

use App\Models\User;
use App\Models\PaymentReport;

class PaymentReportPolicy
{

    public function view(User $user): bool
    {
        if(!$user->role->permissions->contains('slug','view_payment_reports')){
            return false;
        }

        return true;
    }

    public function add(User $user): bool
    {
        if(!$user->role->permissions->contains('slug','add_payment_report')){
            return false;
        }

        return true;
    }
}
