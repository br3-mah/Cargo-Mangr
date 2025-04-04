<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Consignment;
use App\Models\User;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Modules\Cargo\Entities\Shipment;
use Modules\Cargo\Entities\PackageShipment;
use Modules\Cargo\Entities\Client;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

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
        return view('cargo::' . $adminTheme . '.pages.consignments.index', compact('consignments'));
    }

    public function import(Request $request)
    {
        try {
            $request->validate([
                'excel_file' => 'required|mimes:xlsx,xls'
            ]);

            $file = $request->file('excel_file');
            $spreadsheet = IOFactory::load($file->getPathname());
            $worksheet = $spreadsheet->getActiveSheet();
            $rows = $worksheet->toArray();

            DB::beginTransaction();
            $jobNum = $rows[0][7]; // Job No.
            $mawbNum = $rows[1][1]; // Mawb No.
            $consignmentCode = $jobNum; // First shipment consignment code

            // Check if consignment already exists
            $consignment = Consignment::firstOrCreate(
                [
                    'job_num' => $jobNum,
                    'mawb_num' => $mawbNum,
                    'consignment_code' => $consignmentCode,
                ],
                [
                    'name' => 'NWC',
                    'desc' => 'Consignment shipments',
                    'consignee' => 'Nwc',
                ]
            );

            // Process shipments (from row 3 onwards)
            for ($i = 4; $i < count($rows); $i++) {
                $data = $rows[$i];
                if (!empty($data[0])) {
                    // Extract user and client-related information
                    $userName = $data[1] ?? 'customer'.rand(100000, 999999); // Assuming Mark column represents user/client name
                    $userEmail = strtolower(str_replace(' ', '', $userName)) . '@mail.com'; // Generate a placeholder email
                    $clientCode = rand(100000, 999999); // Random client code
                    $clientAddress = $data[6]; // Assuming consignee_info column represents address
                    // Create or find User
                    $user = User::where('email', $userEmail)->first();
                    if (!$user) {
                        $user = new User();
                        $user->email = $userEmail;
                        $user->name = $userName;
                        $user->password = bcrypt('password123');
                        $user->role = 4;
                        $user->verified = 1;
                        $user->save();
                    }
                    $client = Client::where('user_id', $user->id)->first();
                    if (!$client) {
                        $client = new Client();
                        $client->user_id = $user->id;
                        $client->code = $clientCode;
                        $client->name = $userName;
                        $client->email = $userEmail;
                        $client->address = preg_replace('/[0-9\+\s]+/', '', $clientAddress);
                        $client->save();
                    }


                    // Create Shipment

                    $shipmt = Shipment::create([
                        'consignment_id' => $consignment->id,
                        'code' => $data[0],
                        'client_id' => $client->id,
                        'branch_id' => 1,
                        'type' => 1,
                        'status_id' => 1,
                        'client_status' => 1,

                        'from_country_id' => 1,
                        'from_state_id' => 1,
                        'to_country_id' => 1,
                        'to_state_id' => 1,

                        'shipping_date' => Carbon::now(),
                        // 'packing' => $data[4],
                        'total_weight' => $data[5] ?? 0,
                        'client_address' => preg_replace('/[0-9\+\s]+/', '', $clientAddress),
                        'client_phone' => preg_replace('/\D+/', '', $clientAddress),
                        // 'salesman' => $data[7],
                        // 'remark' => $data[8],
                    ]);

                    $package['qty'] = $data[3] ?? (int)$data[4];
                    $package['weight'] = $data[5];
                    $package['length'] = 1;
                    $package['width'] = 1;
                    $package['height'] = 1;
                    $total_weight = $package['weight'];

                    $package_shipment = new PackageShipment();
                    $package_shipment->fill($package);
                    $package_shipment->shipment_id = $shipmt->id;
                    DB::commit();
                }
            }

            return redirect()->back()->with('success', 'Excel data imported successfully!');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Error importing file: ' . $e->getMessage());
        }
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $adminTheme = env('ADMIN_THEME', 'adminLte');
        return view('cargo::' . $adminTheme . '.pages.consignments.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreConsignmentRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {

            $request->validate([
                'consignment_code' => 'required|unique:consignments',
                'name' => 'required|string|max:255',
                'source' => 'required|string',
                'destination' => 'required|string',
                'status' => 'required|in:pending,in_transit,delivered,canceled',
                'consignee' => 'nullable|string|max:255',
                'job_num' => 'nullable|string|max:255',
                'mawb_num' => 'nullable|string|max:255',
            ]);

            Consignment::create($request->all());
            return redirect()->route('consignment.index')->with('success', 'Consignment created successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while creating the consignment: ' . $e->getMessage());
        }
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
        $consignment = $cons::with('shipments.client')->where('id', $id)->first();
        return view('cargo::' . $adminTheme . '.pages.consignments.show', compact('consignment'));
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
        $consignment = $cons::where('id', $id)->first();
        return view('cargo::' . $adminTheme . '.pages.consignments.edit', compact('consignment'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateConsignmentRequest  $request
     * @param  \App\Models\Consignment  $consignment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Consignment $consignment)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'source' => 'required|string',
            'destination' => 'required|string',
            'status' => 'required|in:pending,in_transit,delivered,canceled',
        ]);

        $consignment->update($request->all());
        $adminTheme = env('ADMIN_THEME', 'adminLte');
        // dd('here');
        return view('cargo::' . $adminTheme . '.pages.consignments.index')->with('success', 'Consignment updated successfully.');
    }

    public function editTracker($id)
    {
        $consignment = Consignment::findOrFail($id);
        return response()->json($consignment);
    }

    public function updateTracker(Request $request, $id)
    {
        try {
            // Validate the request
            $request->validate([
                'consignment_id' => 'required|integer|exists:consignments,id',
                'status' => 'required|integer|min:1|max:6',
            ]);

            $consignment = Consignment::findOrFail($id);
            $consignment->checkpoint = $request->status;

            // Decode existing JSON or initialize an empty array
            $checkpointDates = json_decode($consignment->checkpoint_date, true) ?? [];

            // Append the new timestamp
            $checkpointDates[] = Carbon::now()->toDateTimeString();

            // Save the updated JSON data
            $consignment->checkpoint_date = json_encode($checkpointDates);

            // Update consignment status
            if ($request->status > 1) {
                $consignment->status = 'in_transit';
            }
            if ($request->status > 5) {
                $consignment->status = 'delivered';
            }

            $consignment->save();

            return redirect()->back()->with('success', 'Tracker updated successfully.');
        } catch (\Throwable $th) {

            return redirect()->back()->with('error', 'Failed to update shipment tracker.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Consignment  $consignment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Consignment $consignment, $id)
    {
        try {
            $c = $consignment->where('id', $id)->first();
            $c->delete();
            $adminTheme = env('ADMIN_THEME', 'adminLte');
            $consignments = Consignment::get();
            return redirect()->route('consignment.index', compact('consignments'))->with('success', 'Consignment deleted successfully.');
            // return view('cargo::' . $adminTheme . '.pages.consignments.index',)->with('success', 'Consignment deleted successfully.');
        } catch (\Throwable $th) {
            dd($th);
        }
    }
}