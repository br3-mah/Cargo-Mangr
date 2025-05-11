<?php

namespace App\Http\Controllers;

use App\Exports\ShipmentExport;
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
use Maatwebsite\Excel\Facades\Excel;

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

    // public function import(Request $request)
    // {
    //     try {
    //         $file = $request->file('excel_file');
    //         $spreadsheet = IOFactory::load($file->getPathname());
    //         $worksheet = $spreadsheet->getActiveSheet();
    //         $rows = $worksheet->toArray();

    //         // Dynamically locate Mawb No.
    //         $mawbNum = null;
    //         foreach ($rows as $row) {
    //             if (isset($row[2]) && trim($row[2]) === 'Mawb No.:') {
    //                 $mawbNum = $row[3] ?? null;
    //                 break;
    //             }
    //         }

    //         if (!$mawbNum) {
    //             throw new \Exception("Mawb No. not found in the Excel file.");
    //         }

    //         // Job No. is still expected at row 3, column 9
    //         $jobNum = $rows[3][9] ?? null;
    //         if (!$jobNum) {
    //             throw new \Exception("Job No. not found in the Excel file.");
    //         }

    //         $consignmentCode = $jobNum;

    //         $consignment = Consignment::firstOrCreate(
    //             [
    //                 'job_num' => $jobNum,
    //                 'mawb_num' => $mawbNum,
    //                 'consignment_code' => $consignmentCode,
    //             ],
    //             [
    //                 'name' => 'NWC',
    //                 'desc' => 'Consignment shipments',
    //                 'consignee' => 'Nwc',
    //             ]
    //         );

    //         // dd($consignment);
    //         // Process shipments (from row 7 onwards)
    //         for ($i = 7; $i < count($rows); $i++) {
    //             $data = $rows[$i];

    //             if (!empty($data[2])) {
    //                 $userName = $data[3] ?? 'customer' . rand(100000, 999999);
    //                 $userEmail = strtolower(str_replace(' ', '', $userName)) . '@mail.com';
    //                 $clientCode = rand(100000, 999999);
    //                 $clientAddress = $data[8];

    //                 $user = User::where('email', $userEmail)->first();


    //                 if (!$user) {
    //                     $user = new User();
    //                     $user->email = $userEmail;
    //                     $user->name = $userName;
    //                     $user->password = bcrypt('password123');
    //                     $user->role = 4;
    //                     $user->verified = 1;
    //                     $user->save();
    //                 }

    //                 $client = Client::where('user_id', $user->id)->first();
    //                 if (!$client) {
    //                     $client = new Client();
    //                     $client->user_id = $user->id;
    //                     $client->code = $clientCode;
    //                     $client->name = $userName;
    //                     $client->email = $userEmail;
    //                     $client->address = preg_replace('/[0-9\+\s]+/', '', $clientAddress);
    //                     $client->save();
    //                 }
    //                 // dd($user);
    //                 // dd($client);


    //                 $sh = Shipment::create([
    //                     'consignment_id' => $consignment->id,
    //                     'code' => $data[2],
    //                     'client_id' => $client->id,
    //                     'branch_id' => 1,
    //                     'type' => 1,
    //                     'status_id' => 1,
    //                     'client_status' => 1,
    //                     'from_country_id' => 1,
    //                     'from_state_id' => 1,
    //                     'to_country_id' => 1,
    //                     'to_state_id' => 1,
    //                     'shipping_date' => Carbon::now(),
    //                     'total_weight' => (float)$data[7] ?? 0,
    //                     'client_address' => preg_replace('/[0-9\+\s]+/', '', $clientAddress),
    //                     'client_phone' => preg_replace('/\D+/', '', $clientAddress),
    //                 ]);

    //                 $package = [
    //                     'package_id' => 1,
    //                     'shipment_id' => $sh->id,
    //                     'qty' => $data[6] ?? (int)$data[4],
    //                     'weight' => $data[7],
    //                     'length' => 1,
    //                     'width' => 1,
    //                     'height' => 1,
    //                 ];

    //                 $package_shipment = new PackageShipment();
    //                 $package_shipment->fill($package);
    //                 $package_shipment->shipment_id = $sh->id;
    //                 $package_shipment->save();

    //             }
    //         }

    //         DB::commit();
    //         return redirect()->back()->with('success', 'Excel data imported successfully!');
    //     } catch (\Exception $e) {

    //         dd($e->getMessage());
    //         DB::rollback();
    //         return redirect()->back()->with('error', 'Error importing file: ' . $e->getMessage());
    //     }
    // }

    public function import(Request $request)
    {
        // DB::beginTransaction();
        try {
            $file = $request->file('excel_file');
            $spreadsheet = IOFactory::load($file->getPathname());
            $worksheet = $spreadsheet->getActiveSheet();
            $rows = $worksheet->toArray();

            $consigneeRow = null;
            $mawbRow = null;
            $headerRow = null;

            // Step 1: Find the row containing both "Consignee" and "Job No"
            foreach ($rows as $rowIndex => $row) {
                $rowText = implode(' ', array_map('trim', $row));
                if (stripos($rowText, 'consignee') !== false && stripos($rowText, 'job no') !== false) {
                    $consigneeRow = $rowIndex;
                    break;
                }
            }

            if (is_null($consigneeRow)) {
                throw new \Exception("Row with both 'Consignee' and 'Job No' not found.");
            }


            // Step 2: Find Mawb No in the next few rows
            $mawbKeywords = ['Mawb No', 'Mawb No.', 'Mawb No :', 'Mawb No.:'];
            $mawbNum = null;

            for ($i = $consigneeRow + 1; $i <= $consigneeRow + 5 && $i < count($rows); $i++) {
                foreach ($rows[$i] as $k => $cell) {
                    if (!$cell) continue;
                    foreach ($mawbKeywords as $keyword) {
                        if (stripos($cell, $keyword) !== false) {
                            $mawbNum = $rows[$i][$k + 1] ?? null;
                            break 3;
                        }
                    }
                }
            }

            // if (!$mawbNum) {
            //     throw new \Exception("Mawb No. not found below 'Consignee' row.");
            // }

            // Step 3: Find Job No from same row as Consignee
            $jobNum = null;
            $jobKeywords = ['Job No', 'Job No.', 'Job No :', 'Job No.:'];

            foreach ($rows[$consigneeRow] as $k => $cell) {
                $cleanedCell = preg_replace('/\s+/', ' ', trim($cell)); // Normalize all whitespace to single space

                foreach ($jobKeywords as $keyword) {
                    if (stripos($cleanedCell, $keyword) !== false) {
                        // Check next non-empty cell for actual Job No value
                        for ($j = $k + 1; $j < count($rows[$consigneeRow]); $j++) {
                            $nextCell = trim($rows[$consigneeRow][$j]);
                            if (!empty($nextCell)) {
                                $jobNum = $nextCell;
                                break 2; // Break out of both loops
                            }
                        }
                    }
                }
            }


            if (!$jobNum) {
                throw new \Exception("Job No. not found in the same row as 'Consignee'.");
            }

            $consignmentCode = $jobNum;

            $consignment = Consignment::orWhere('mawb_num', $mawbNum)
                ->orWhere('consignment_code', $consignmentCode)
                ->first();
                
            if (empty($consignment)) {
                // Create a new record if it doesn't exist
                $consignment = Consignment::create([
                    'job_num' => $jobNum,
                    'mawb_num' => $mawbNum,
                    'consignment_code' => $consignmentCode,
                    'name' => 'NWC',
                    'desc' => 'Consignment shipments',
                    'consignee' => 'Nwc',
                ]);
            }

            // Step 4: Find the row with "Hawb No"
            foreach ($rows as $i => $row) {
                foreach ($row as $cell) {
                    if (stripos($cell, 'hawb no') !== false) {
                        $headerRow = $i;
                        break 2;
                    }
                }
            }

            // dd($headerRow);
            if (is_null($headerRow)) {
                throw new \Exception("Header row containing 'Hawb No' not found.");
            }

            // Step 5: Loop through data starting after headerRow
            $res = $this->loopCreateShipment($headerRow, $rows, $consignment);

            if (!$res) {
                $this->loopCreateShipmentII($headerRow, $rows, $consignment);
            } else {

            }
            DB::commit();
            return redirect()->back()->with('success', 'Excel data imported successfully!');
        } catch (\Exception $e) {
            dd($e);
            DB::rollback();

            // $this->loopCreateShipmentII($headerRow, $rows, $consignment);
            return redirect()->back()->with('error', 'Error importing file: ' . $e->getMessage());
        }
    }

    public function loopCreateShipment($headerRow, $rows, $consignment)
    {

        try {
            for ($i = $headerRow + 1; $i < count($rows) - 1; $i++) {
                $rowText = implode(' ', array_map('trim', $rows[$i]));
                if (stripos($rowText, 'total') !== false) {
                    break;
                }

                $data = $rows[$i];

                if (!empty($data[2])) {
                    $userName = $data[1] ?? 'customer' . rand(100000, 999999);
                    $userEmail = strtolower(str_replace(' ', '', $userName)) . '@mail.com';
                    $clientCode = rand(100000, 999999);
                    $clientPhone = preg_replace('/\D+/', '', (strlen($data[5] ?? '') > 5 ? $data[5] : ($data[6] ?? '')));


                    // Avoid duplicate User by email
                    $user = User::firstOrCreate(
                        ['email' => $userEmail],
                        [
                            'name' => $userName,
                            'password' => bcrypt('password123'),
                            'role' => 4,
                            'verified' => 1
                        ]
                    );

                    // Avoid duplicate Client by user_id (or use another unique key if better)
                    $client = Client::firstOrCreate(
                        ['user_id' => $user->id],
                        [
                            'code' => $clientCode,
                            'name' => $userName,
                            'email' => $userEmail,
                            'address' => preg_replace('/[0-9\+\s]+/', '', $clientPhone)
                        ]
                    );

                    // Avoid duplicate Shipment by code + consignment
                    $existingShipment = Shipment::where('code', $data[0])
                        ->where('consignment_id', $consignment->id)
                        ->first();

                    // dd($clientPhone);
                    if (!$existingShipment) {
                        $shipment = Shipment::create([
                            'consignment_id' => $consignment->id,
                            'code' => $data[0], // Hawb No
                            'client_id' => $client->id,
                            'branch_id' => 1,
                            'type' => 1,
                            'status_id' => 1,
                            'client_status' => 1,
                            'from_country_id' => 1,
                            'from_state_id' => 1,
                            'to_country_id' => 1,
                            'to_state_id' => 1,

                            'shipping_cost' => (float)str_replace(',', '', preg_replace('/[^0-9.,]/', '', $data[8])),
                            'return_cost' => 0,
                            'amount_to_be_collected' => (float)preg_replace('/\D+/', '', ($data[8])),

                            'shipping_date' => Carbon::now(),
                            'total_weight' => (float)($data[4] ?? 0),
                            'client_address' => $userName.''.$clientPhone,
                            'client_phone' => $clientPhone
                        ]);

                        PackageShipment::create([
                            'package_id' => 1,
                            'description' => $data[2].' '.$data[3],
                            'shipment_id' => $shipment->id,
                            'qty' => is_string($data[3]) ? ($data[4] ?? 1) : 1,
                            'weight' => (strpos($data[5], '.') || is_numeric($data[5]) !== false) ? $data[5] : ($data[4] ?? 0),
                            'length' => 1,
                            'width' => 1,
                            'height' => 1,
                        ]);
                    }
                }
            }
            return true;
        } catch (\Throwable $th) {
            // dd($th);
            return false;
        }
    }

    public function loopCreateShipmentII($headerRow, $rows, $consignment){
        // dd($rows);
        for ($i = 7 + 1; $i < count($rows) - 1; $i++) {
            $data = $rows[$i];
            if (!empty($data[2])) {
                // Extract user and client-related information
                $userName = $data[3] ?? 'customer' . rand(100000, 999999); // Assuming Mark column represents user/client name
                $userEmail = strtolower(str_replace(' ', '', $userName)) . '@mail.com'; // Generate a placeholder email
                $clientCode = rand(100000, 999999); // Random client code
                $clientContact = $data[8]; // Assuming consignee_info column represents address
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
                    $client->save();
                }

                // Create Shipment
                $shipment = Shipment::create([
                    'consignment_id' => $consignment->id,
                    'code' => $data[2],
                    'client_id' => $client->id,
                    'branch_id' => 1,
                    'type' => 1,
                    'status_id' => 1,
                    'client_status' => 1,
                    ...(!empty($data[10]) ? [
                        'shipping_cost' => (float)str_replace(',', '', preg_replace('/[^0-9.,]/', '', $data[10])),
                        'return_cost' => 0,
                        'amount_to_be_collected' => (float)preg_replace('/\D+/', '', $data[10]),
                    ] : []),
                    'from_country_id' => 1,
                    'from_state_id' => 1,
                    'to_country_id' => 1,
                    'to_state_id' => 1,
                    'shipping_date' => Carbon::now(),
                    'total_weight' => (float)($data[6] ?? 0),
                    'client_phone' => preg_replace('/\D+/', '', $clientContact),
                ]);


                $package['description'] = $data[4].'. Parcel items including: ('.preg_replace('/[0-9\+\s]+/', '', $data[5]) .')';
                $package['qty'] = $data[6];
                $package['weight'] = $data[7];
                $package['length'] = 1;
                $package['width'] = 1;
                $package['height'] = 1;
                $total_weight = $package['weight'];

                $package_shipment = new PackageShipment();
                $package_shipment->fill($package);
                $package_shipment->shipment_id = $shipment->id;
                DB::commit();
            }
        }
    }


    public function importBKP(Request $request)
    {

        try {
            $request->validate([
                'excel_file' => 'required|mimes:xlsx,xls'
            ]);

            $file = $request->file('excel_file');
            $spreadsheet = IOFactory::load($file->getPathname());
            $worksheet = $spreadsheet->getActiveSheet();
            $rows = $worksheet->toArray();

            // DB::beginTransaction();
            $jobNum = $rows[3][9];
            // Job No.
            $mawbNum = $rows[4][3]; // Mawb No.
            dd($rows);
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
            for ($i = 7; $i < count($rows); $i++) {
                $data = $rows[$i];
                if (!empty($data[2])) {
                    // Extract user and client-related information
                    $userName = $data[3] ?? 'customer' . rand(100000, 999999); // Assuming Mark column represents user/client name
                    $userEmail = strtolower(str_replace(' ', '', $userName)) . '@mail.com'; // Generate a placeholder email
                    $clientCode = rand(100000, 999999); // Random client code
                    $clientAddress = $data[8]; // Assuming consignee_info column represents address
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
                        'code' => $data[2],
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
                        'total_weight' => (float)$data[7] ?? 0,
                        'client_address' => preg_replace('/[0-9\+\s]+/', '', $clientAddress),
                        'client_phone' => preg_replace('/\D+/', '', $clientAddress),
                        // 'salesman' => $data[7],
                        // 'remark' => $data[8],
                    ]);

                    $package['qty'] = $data[6] ?? (int)$data[4];
                    $package['weight'] = $data[7];
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
            dd($e);
            // DB::rollback();
            return redirect()->back()->with('error', 'Error importing file: ' . $e->getMessage());
        }
    }

    public function export(Request $request)
    {
        $request->validate([
            'from_date' => 'required|date',
            'to_date' => 'required|date|after_or_equal:from_date',
        ]);
        return Excel::download(
            new ShipmentExport($request->from_date, $request->to_date),
            'shipments_export_' . now()->format('Ymd_His') . '.xlsx'
        );
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
        $consignment = $cons::where('id',$id)->with([
            'shipments.client',
            'shipments.consignment' // optional, only if needed
        ])->first();
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
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'source' => 'required|string',
                'destination' => 'required|string',
                'status' => 'required|string',
                'consignment_code' => 'nullable|string',
                'consignee' => 'nullable|string',
                'mawb_num' => 'nullable|string',
                'eta' => 'nullable|date',
                'cargo_date' => 'nullable|date',
                'job_num' => 'nullable|string|nullable',
                'cargo_type' => 'nullable|string',
                'eta_dar' => 'nullable|date',
                'eta_lun' => 'nullable|date',
            ]);
            $consignment->update($validated);
            return redirect()->back()->with('success', 'Consignment updated successfully.');
        } catch (\Throwable $th) {
            report($th);
            return redirect()->back()->withErrors(['error' => 'Failed to update consignment.']);
        }
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

            if (!$c) {
                return redirect()->back()->with('error', 'Consignment not found.');
            }

            // Delete all shipments with this consignment_id
            $shipments = Shipment::where('consignment_id', $c->id)->get();

            foreach ($shipments as $shipment) {
                // Delete related PackageShipment records
                PackageShipment::where('shipment_id', $shipment->id)->delete();

                // Delete the shipment itself
                $shipment->delete();
            }

            // Delete the consignment
            $c->delete();

            $consignments = Consignment::get();

            return redirect()->route('consignment.index', compact('consignments'))
                ->with('success', 'Consignment and related data deleted successfully.');
        } catch (\Throwable $th) {
            dd($th);
        }
    }
    public function bulkDelete(Request $request)
    {
        try {
            Consignment::whereIn('id', $request->ids)->delete();
            return response()->json(['status' => 'success']);
        } catch (\Throwable $th) {
            return response()->json(['status' => 'failed','msg' => $th->getMessage()]);
        }
    }
    
}