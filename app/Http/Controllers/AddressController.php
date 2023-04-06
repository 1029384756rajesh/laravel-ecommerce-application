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

    public function show(Request $request, Address $address)
    {
        return response()->json($address);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'mobile' => 'required',
            'addressLine1' => 'required',
            'addressLine2' => 'required',
            'city' => 'required',
            'pincode' => 'required',
        ]);

        $address = $request->user()->addresses()->create([
            'name' => $request->name,
            'mobile' => $request->mobile,
            'address_line_1' => $request->addressLine1,
            'address_line_2' => $request->addressLine2,
            'city' => $request->city,
            'pincode' => $request->pincode
        ]);

        return response()->json($address, 201);
    }
    
    public function update(Request $request, Address $address)
    {
        $validated = $request->validate([
            'name' => 'required',
            'mobile' => 'required',
            'addressLine1' => 'required',
            'addressLine2' => 'required',
            'city' => 'required',
            'pincode' => 'required',
        ]);

        $address->name = $request->name; 

        $address->mobile = $request->mobile;  

        $address->address_line_1 = $request->addressLine1;

        $address->address_line_2 = $request->addressLine2;

        $address->city = $request->city;

        $address->pincode = $request->pincode;

        $address->save();

        return response()->json($address);
    }

    public function delete(Request $request, Address $address)
    {
        $address->delete();

        return response()->json(['success', 'Address deleted successfully']);
    }
}
