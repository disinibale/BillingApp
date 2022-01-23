<?php

namespace App\Http\Controllers;

use App\Models\Subscriptions;
use App\Models\User;
use Illuminate\Http\Request;

class ReportsController extends Controller
{
    public function customers()
    {
        $customers = User::role('user')->paginate(10);

        return view('pages.admin.customers.index', compact('customers'));
    }

    public function billings()
    {
        $invoices = Subscriptions::where('status', 'active')->paginate(10);

        return view('pages.user.history.index', compact('invoices'));
    }
}
