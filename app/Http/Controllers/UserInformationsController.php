<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserInformations;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserInformationsController extends Controller
{

    public function index()
    {
        $customers = User::role('user')->paginate(10);

        return view('pages.admin.customers.index', compact('customers'));
    }

    public function adminShow($id)
    {
        $customer = User::find($id);

        if (!empty($customer)) {
            return view('pages.admin.customers.show', compact('customer'));
        } else {
            abort(404);
        }

        // return $customer->info;

    }

    public function show()
    {
        $user = User::where('id', Auth::id())->first();

        return view('pages.profile.show', compact('user'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'phone' => 'required|max:14',
            'address' => 'required',
            'zip_code' => 'required',
        ]);

        $info = UserInformations::create([
            'user_id' => Auth::id(),
            'phone' => $request->phone,
            'address' => $request->address,
            'zip_code' => $request->zip_code
        ]);

        // return $request->all();
        return redirect()->route('user.info.show')->with('success', 'Informasi anda telah disimpan');
    }

    public function update(Request $request)
    {
        $request->validate([
            'phone' => 'required|max:14',
            'address' => 'required',
            'zip_code' => 'required',
        ]);

        $info = UserInformations::where('user_id', Auth::id());
        $info->update([
            'phone' => $request->phone,
            'address' => $request->address,
            'zip_code' => $request->zip_code,
        ]);

        return redirect()->route('user.info.show')->with('success', 'Informasi anda telah disimpan');
    }

    public function destroy($id)
    {
        $info = UserInformations::findOrFail($id);

        return redirect()->route('user.info.show')->with('message', 'Informasi anda telah dihapus');
    }

}
