<?php

namespace App\Http\Controllers;

use App\Models\Billings;
use App\Models\Invoices;
use App\Models\Subscriptions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BillingController extends Controller
{

    public function index()
    {
        $subscriptions = Subscriptions::where('status', 'inactive')->paginate(10);

        return view('pages.subscriptions.index', compact('subscriptions'));
    }

    public function create($id)
    {
        $subscription = Subscriptions::find($id);

        return view('pages.billings.create', compact('subscription'));
    }

    public function process($id, Request $request)
    {
        $request->validate([
            'number' => 'required',
            'total' => 'required'
        ]);

        $subscription = Subscriptions::find($id);

        if ($subscription->update(['status' => 'active'])) {
            $subscription->billing->invoice()->create([
                'number' => $request->number,
                'total' => str_replace('.', '', $request->total)
            ]);
        }

        // return $request->all();
        return redirect()->route('subscriptions.index')->with('message', 'Layanan '. $subscription->plan->name .'Telah dibayar');
    }

    public function history()
    {
        $invoices = Subscriptions::where([
            ['user_id', '=',  Auth::id()],
            ['status', '=', 'active'],
        ])->get();

        return view('pages.user.history.index', compact('invoices'));
        // return $invoices;
    }
}
