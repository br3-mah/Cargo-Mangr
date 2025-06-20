<?php

namespace Modules\Cargo\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Cargo\Entities\Aircraft;

class AircraftController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $aircrafts = Aircraft::all();
        $airConsignments = \App\Models\Consignment::where('cargo_type', 'air')->get();
        $stats = [
            'total' => $airConsignments->count(),
            'delivered' => $airConsignments->where('status', 'delivered')->count(),
            'in_transit' => $airConsignments->where('status', 'in_transit')->count(),
        ];
        return view('cargo::adminLte.pages.aircraft.index', compact('aircrafts', 'stats', 'airConsignments'));
    }

    public function create() { /* ... */ }
    public function store(Request $request) { /* ... */ }
    public function show($id) { /* ... */ }
    public function edit($id) { /* ... */ }
    public function update(Request $request, $id) { /* ... */ }
    public function destroy($id) { /* ... */ }

    public function airConsignments()
    {
        $consignments = \App\Models\Consignment::with('shipments')->where('cargo_type', 'air')->orderBy('created_at', 'desc')->get();
        $stats = [
            'total' => $consignments->count(),
            'delivered' => $consignments->where('status', 'delivered')->count(),
            'in_transit' => $consignments->where('status', 'in_transit')->count(),
        ];
        return view('cargo::adminLte.pages.consignments.air', compact('consignments', 'stats'));
    }

    public function seaConsignments()
    {
        $consignments = \App\Models\Consignment::with('shipments')->where('cargo_type', 'sea')->orderBy('created_at', 'desc')->get();
        $stats = [
            'total' => $consignments->count(),
            'delivered' => $consignments->where('status', 'delivered')->count(),
            'in_transit' => $consignments->where('status', 'in_transit')->count(),
        ];
        return view('cargo::adminLte.pages.consignments.sea', compact('consignments', 'stats'));
    }
} 