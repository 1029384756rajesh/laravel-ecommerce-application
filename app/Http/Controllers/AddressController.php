<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Address;

class AddressController extends Controller
{
    public function index(Request $request)
    {
        $addresses = $request->user()->addresses()->orderBy('created_at', 'desc')->get();

        return response()->json($addresses);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'mobile' => 'required',
            'address_line_1' => 'required',
            'address_line_2' => 'required',
            'city' => 'required',
            'pincode' => 'required',
        ]);

        $request->user()->addresses()->create($validated);

        return response()->json(['success', 'Address added successfully']);
    }
    
    public function update(Request $request, Address $address)
    {
        $validated = $request->validate([
            'name' => 'required',
            'mobile' => 'required',
            'address_line_1' => 'required',
            'address_line_2' => 'required',
            'city' => 'required',
            'pincode' => 'required',
        ]);

        $address->name = $request->name; 

        $address->mobile = $request->mobile;  

        $address->address_line_1 = $request->address_line_1;

        $address->address_line_2 = $request->address_line_2;

        $address->city = $request->city;

        $address->pincode = $request->pincode;

        $address->save();

        return response()->json(['success', 'Address updated successfully']);
    }

    public function delete(Request $request, Address $address)
    {
        $address->delete();

        return response()->json(['success', 'Address deleted successfully']);
    }
}
