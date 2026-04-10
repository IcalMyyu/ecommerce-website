<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
{
    public function index()
    {
        $addresses = Auth::user()->addresses()->orderBy('is_default', 'desc')->get();
        return view('ubah-alamat', compact('addresses'));
    }

    public function create()
    {
        return view('add-address');
    }

    public function store(Request $request)
    {
        $request->validate([
            'recipient_name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'full_address' => 'required|string',
        ]);

        $user = Auth::user();

        // If this is the first address, make it default automatically
        $isDefault = $user->addresses()->count() === 0;

        $user->addresses()->create([
            'recipient_name' => $request->recipient_name,
            'phone_number' => $request->phone_number,
            'full_address' => $request->full_address,
            'is_default' => $isDefault,
        ]);

        return redirect()->route('address.index')->with('success', 'Alamat berhasil ditambahkan!');
    }

    public function setDefault($id)
    {
        $user = Auth::user();
        $address = $user->addresses()->findOrFail($id);

        // Remove default from all other addresses
        $user->addresses()->update(['is_default' => false]);

        // Set this as default
        $address->update(['is_default' => true]);

        return redirect()->route('address.index');
    }

    public function destroy($id)
    {
        $user = Auth::user();
        $address = $user->addresses()->findOrFail($id);

        $wasDefault = $address->is_default;
        $address->delete();

        // If we deleted the default address, set another one as default
        if ($wasDefault && $user->addresses()->count() > 0) {
            $user->addresses()->first()->update(['is_default' => true]);
        }

        return redirect()->route('address.index')->with('success', 'Alamat berhasil dihapus!');
    }
}
