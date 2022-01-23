<?php

namespace App\Http\Controllers;

use App\Models\Plans;
use App\Models\Subscriptions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubscriptionsController extends Controller
{
    public function index()
    {
        $subscriptions = Subscriptions::where('user_id', Auth::id())->paginate(10);

        return view('pages.subscriptions.index', compact('subscriptions'));

        // return Subscriptions::where('id', 2)->first()->plan;
        // return Subscriptions::where('id', 3)->first()->plan;
        // return Plans::find(8);
    }

    public function show($id)
    {
        $subscription = Subscriptions::find($id)->first();

        return $subscription;
    }

    public function store(Request $request, $id)
    {
        $request->validate([
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ]);

        return $request->all();
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'start_date' => $request->start_date,
            'end_date' => $request->end_date
        ]);

        return $request->all();
    }

    public function destroy($id)
    {

    }

    public function stopSubscription($id)
    {

    }
}
