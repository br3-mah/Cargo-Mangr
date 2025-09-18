<?php

namespace App\Http\Controllers;

use App\Models\TrackingStage;
use Illuminate\Http\Request;

class TrackingStageController extends Controller
{
public function index()
{
    $airStages = TrackingStage::where('cargo_type', 'air')
        ->orderByDesc('order')
        ->get();

    $seaStages = TrackingStage::where('cargo_type', 'sea')
        ->orderByDesc('order')
        ->get();

    $lastStage = TrackingStage::orderByDesc('order')->first();

    return view('cargo::adminLte.pages.tracking-stages.index', compact('airStages', 'seaStages', 'lastStage'));
}


    public function create()
    {
        $lastStage = TrackingStage::orderByDesc('order')->first();
        return view('cargo::adminLte.pages.tracking-stages.create', compact('lastStage'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'cargo_type' => 'required|in:air,sea',
            'status' => 'required',
            'order' => 'required|integer|unique:tracking_stages,order',
            'is_active' => 'boolean'
        ]);

        TrackingStage::create($validated);

        return redirect()->route('tracking-stages.index')
            ->with('success', 'Tracking stage created successfully.');
    }

    public function edit(TrackingStage $trackingStage)
    {
        return view('cargo::adminLte.pages.tracking-stages.edit', compact('trackingStage'));
    }

    public function update(Request $request, TrackingStage $trackingStage)
    {

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'cargo_type' => 'required|in:air,sea',
            'status' => 'required',
            'order' => 'required|integer|unique:tracking_stages,order,' . $trackingStage->id,
            'is_active' => 'boolean'
        ]);

        $trackingStage->update($validated);

        return redirect()->route('tracking-stages.index')
            ->with('success', 'Tracking stage updated successfully.');
    }

    public function destroy(TrackingStage $trackingStage)
    {
        $trackingStage->delete();

        return redirect()->route('tracking-stages.index')
            ->with('success', 'Tracking stage deleted successfully.');
    }

    // API endpoint for fetching stages by cargo type
    public function apiIndex(Request $request)
    {
        $cargoType = $request->input('cargo_type', 'air');
        $stages = TrackingStage::where('cargo_type', $cargoType)
            ->where('is_active', true)
            ->orderBy('order')
            ->get(['id', 'name', 'description', 'order']);

        return response()->json($stages);
    }
}
