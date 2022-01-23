<?php

namespace App\Http\Controllers;

use App\Models\Billings;
use App\Models\Invoices;
use App\Models\Plans;
use App\Models\Subscriptions;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Auth;

class PlansController extends Controller
{
    public function index()
    {
        $plans = Plans::paginate(12);
        // $user = User::find(Auth::id());

        return view('pages.plans.index', compact(
            'plans',
            // 'user'
        ));
    }

    public function show($id)
    {
        $plan = Plans::find($id);

        if (!empty($plan)) {
            return view('pages.plans.show', compact('plan'));
        } else {
            return abort(404);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required',
            'name' => 'required',
            'description' => 'required',
            'price' => 'required'
        ]);

        Plans::create([
            'type' => $request->type,
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'tax' => 0.1
        ]);

        return redirect()->route('plans.index')->with('success', 'Layanan Telah dibuat');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'type' => 'required',
            'name' => 'required',
            'description' => 'required',
            'price' => 'required'
        ]);

        $plan = Plans::find($id);
        $plan->update([
            'name' => $request->name,
            'type' => $request->type,
            'description' => $request->description,
            'price' => $request->price,
        ]);

        return redirect()->route('plans.index')->with('success', 'Layanan telah berhasil diubah');
    }

    public function destroy($id)
    {
        $plan = Plans::find($id);
        $plan->delete();

        return redirect()->route('plans.index')->with('success', 'Layanan telah berhasil dihapus');
    }

    public function subscribe(Request $request, $id)
    {
        $plan = Plans::find($id);
        $collection = $this->subs($plan);

        $subscription = Subscriptions::create([
            'user_id' => Auth::id(),
            'plan_id' => $collection->get('plan_id'),
            'start_date' => $collection->get('start_date'),
            'end_date' => $collection->get('end_date'),
            'status' => $collection->get('status'),
        ]);

        $billing = $subscription->billing()->create([
            'period' => Carbon::now()->addDays(1)->format('F'),
            'due_time' => $collection->get('end_date'),
        ]);

        return redirect()->route('subscriptions.index')->with('success', 'Anda telah berlangganan dengan layanan ('.$plan->name.')');
    }

    protected function subs(Plans $plan)
    {
        // Plans
        $id = $plan->id;

        // Period
        $startDate = Carbon::now();

        if ($plan->type === 'daily') {
            $endDate = Carbon::now()->addDays(1);
        } elseif ($plan->type === 'weekly') {
            $endDate = Carbon::now()->addDays(7);
        } else {
            $endDate = Carbon::now()->addDays(30);
        }

        // status
        $status = 'inactive';

        $collection = collect([
            'plan_id' => $id,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'status' => $status
        ]);

        return $collection;
        // return $startDate;
    }
}
