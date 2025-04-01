<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Consignment;
use Illuminate\Http\Request;

class ConsignmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // dd('here');
        $consignments = Consignment::with('shipments')->get();
        $adminTheme = env('ADMIN_THEME', 'adminLte');
        return view('cargo::'.$adminTheme.'.pages.consignments.index', compact('consignments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $adminTheme = env('ADMIN_THEME', 'adminLte');
        // dd('here');
        return view('cargo::'.$adminTheme.'.pages.consignments.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreConsignmentRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'consignment_code' => 'required|unique:consignments',
            'name' => 'required|string|max:255',
            'source' => 'required|string',
            'destination' => 'required|string',
            'status' => 'required|in:pending,in_transit,delivered,canceled',
        ]);
        Consignment::create($request->all());
        return redirect()->route('consignment.index')->with('success', 'Consignment created successfully.');
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Consignment  $consignment
     * @return \Illuminate\Http\Response
     */
    public function show(Consignment $cons, $id)
    {
        $adminTheme = env('ADMIN_THEME', 'adminLte');
        $consignment = $cons::with('shipments')->where('id',$id)->first();
        // dd($consignment->shipments);
        return view('cargo::'.$adminTheme.'.pages.consignments.show', compact('consignment'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Consignment  $consignment
     * @return \Illuminate\Http\Response
     */
    public function edit(Consignment $cons, $id)
    {
        $adminTheme = env('ADMIN_THEME', 'adminLte');
        $consignment = $cons::where('id',$id)->first();
        return view('cargo::'.$adminTheme.'.pages.consignments.edit', compact('consignment'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateConsignmentRequest  $request
     * @param  \App\Models\Consignment  $consignment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Consignment $consignment){
        $request->validate([
            'name' => 'required|string|max:255',
            'source' => 'required|string',
            'destination' => 'required|string',
            'status' => 'required|in:pending,in_transit,delivered,canceled',
        ]);

        $consignment->update($request->all());
        $adminTheme = env('ADMIN_THEME', 'adminLte');
        // dd('here');
        return view('cargo::'.$adminTheme.'.pages.consignments.index')->with('success', 'Consignment updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Consignment  $consignment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Consignment $consignment)
    {
        $consignment->delete();
        $adminTheme = env('ADMIN_THEME', 'adminLte');
        // dd('here');
        return view('cargo::'.$adminTheme.'.pages.consignments.index')->with('success', 'Consignment deleted successfully.');
    }
}