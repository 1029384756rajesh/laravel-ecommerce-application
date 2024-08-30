<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ShippingZone;
use Illuminate\Http\Request;
use CountryState;

class ShippingController extends Controller
{
    public function zones()
    {
        return ShippingZone::with('locations')->get();
    }

    public function zone(ShippingZone $zone)
    {
        return $zone->with('locations', 'methods')->first();
    }

    public function delete(ShippingZone $zone)
    {
        return $zone->delete();
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:30|unique:shipping_zones,name',
            'locations_ids' => 'required|array',
            'locations_ids.*' => 'required|integer|exists:locations,id',
            'methods' => 'required|array',
            'methods.*' => 'required|array',
            'methods.*.name' => 'required|string|max:50',
            'methods.*.amount' => 'required|integer|min:0',
            'methods.*.min_days' => 'nullable|integer|min:0',
            'methods.*.max_days' => 'nullable|integer|min:0',
            'methods.*.condition' => 'nullable|string',
            'methods.*.min_value' => 'nullable|integer|min:0',
            'methods.*.max_value' => 'nullable|integer|min:0',
        ]);

        $zone = ShippingZone::create([
            'name' => $request->name
        ]);

        foreach ($request->location_ids as $location_id) 
        {
            $zone->locations()->create([
                'location_id' => $location_id
            ]);
        }

        foreach ($request->methods as $method) 
        {
            $zone->methods()->create([
                'name' => $method['name'],
                'amount' => $method['amount'],
                'min_days' => $method['min_days'] ?? null,
                'max_days' => $method['max_days'] ?? null,
                'condition' => $method['condition'] ?? null,
                'min_value' => $method['min_value'] ?? null,
                'max_value' => $method['max_value'] ?? null,
            ]);
        }

        return [
            'success' => true,
            'id' => $zone->id
        ];
    }

    public function update(Request $request, ShippingZone $zone)
    {
        $request->validate([
            'name' => 'required|string|max:50|unique:shipping_zones,name',
            'locations_ids' => 'required|array',
            'locations_ids.*' => 'required|integer|exists:locations,id',
            'methods' => 'required|array',
            'methods.*' => 'required|array',
            'methods.*.name' => 'required|string|max:50',
            'methods.*.amount' => 'required|integer|min:0',
            'methods.*.min_days' => 'nullable|integer|min:0',
            'methods.*.max_days' => 'nullable|integer|min:0',
            'methods.*.condition' => 'nullable|string',
            'methods.*.min_value' => 'nullable|integer|min:0',
            'methods.*.max_value' => 'nullable|integer|min:0',
        ]);

        $zone->name = $request->name;

        $zone->save();

        $locations = $zone->locations()->get();

        foreach ($locations as $location) 
        {
            $deleted = true;

            foreach($request->location_ids as $location_id)
            {
                if($location->location_id == $location_id)
                {
                    $deleted = false;
                }
            }

            if($deleted)
            {
                $location->delete();
            }
        }

        foreach ($request->location_ids as $location_id) 
        {
            $created = true;

            foreach($locations as $location)
            {
                if($location->location_id == $location_id)
                {
                    $created = false;
                }
            }

            if($created)
            {
                $zone->locations()->create([
                    'location_id' => $location_id
                ]);
            }
        }

        $savedMethods = $zone->methods()->get();

        foreach ($savedMethods as $savedMethod) 
        {
            $deleted = true;
            
            foreach ($request->methods as $method) 
            {
                if($method->id == $savedMethod->id)
                {
                    $deleted = false;

                    $savedMethod->update([
                        'name' => $method['name'],
                        'amount' => $method['amount'],
                        'min_days' => $method['min_days'] ?? null,
                        'max_days' => $method['max_days'] ?? null,
                        'condition' => $method['condition'] ?? null,
                        'min_value' => $method['min_value'] ?? null,
                        'max_value' => $method['max_value'] ?? null,
                    ]);
                }
            }

            if($deleted)
            {
                $savedMethod->delete();
            }
        }

        foreach ($request->methods as $method) 
        {
            if($method->id == null)
            {
                $zone->methods()->create([
                    'name' => $method['name'],
                    'amount' => $method['amount'],
                    'min_days' => $method['min_days'] ?? null,
                    'max_days' => $method['max_days'] ?? null,
                    'condition' => $method['condition'] ?? null,
                    'min_value' => $method['min_value'] ?? null,
                    'max_value' => $method['max_value'] ?? null,
                ]);
            }
        }

        return [
            'success' => true,
            'id' => $zone->id
        ];
    }
}
