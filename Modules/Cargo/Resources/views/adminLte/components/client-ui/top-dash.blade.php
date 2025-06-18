    @php
        $client_id = Modules\Cargo\Entities\Client::where('user_id',auth()->user()->id)->pluck('id')->first();
        $all_client_shipments = Modules\Cargo\Entities\Shipment::where('client_id', $client_id)->count();
        $in_progress_client_shipments = Modules\Cargo\Entities\Shipment::where('client_id', $client_id)
            ->whereHas('consignment', function($query) {
                $query->where('status', 'in_transit');
            })
            ->count();
        $delivered_client_shipments = Modules\Cargo\Entities\Shipment::where('client_id', $client_id)
            ->whereHas('consignment', function($query) {
                $query->where('status', 'delivered');
            })
            ->count();

        $transactions = Modules\Cargo\Entities\Transaction::where('client_id', $client_id)->orderBy('created_at','desc')->sum('value');
        $DEBIT_transactions = Modules\Cargo\Entities\Transaction::where('client_id', $client_id)->where('value', 'like', '%-%')->orderBy('created_at','desc')->sum('value');
        $CREDIT_transactions = Modules\Cargo\Entities\Transaction::where('client_id', $client_id)->where('value', 'not like', '%-%')->orderBy('created_at','desc')->sum('value');

        // DEBIT  -
        // CREDIT  +
    @endphp

    {{-- <div class="col-lg-12">
        <!--begin::Stats Widget 30 Customer Wallet-->
        <div class="card card-custom bgi-no-repeat card-stretch gutter-b">
            <!--begin::Body-->
            <div class="card-body">
                <a href="{{ route('transactions.index') }}" class="mb-0 font-weight-bold text-light-75 text-hover-primary font-size-h5">{{ __('cargo::view.your_wallet') }}
                    <div class="font-weight-bold text-success mt-2">{{format_price($CREDIT_transactions)}}</div>
                    <div class="font-weight-bold text-danger mt-3">{{format_price($DEBIT_transactions)}}</div>
                    <div style="width: 15%;height: 1px;background-color: #3f4254;margin-top: 9px;"></div>
                    <div class="mb-3 font-weight-bold text-success mt-4">{{format_price($transactions)}}</div>
                </a>
                <p class="m-0 text-dark-75 font-weight-bolder font-size-h5">{{ __('cargo::view.client_wallet_dashboard') }}.</p>

            </div>
            <!--end::Body-->
        </div>
        <!--end::Stats Widget 30-->
    </div> --}}

    <div class="col-lg-12">
      <!-- Tailwind CSS CDN -->
      <script src="https://cdn.tailwindcss.com"></script>
      <!-- Font Awesome -->
      <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

      <div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 p-6">
        <!-- Welcome Section -->
        <div class="relative mb-8">
          <div class="absolute inset-0 bg-yellow-400 opacity-10 rounded-3xl transform -rotate-1"></div>
          <div class="relative bg-white rounded-3xl p-8 shadow-xl">
            <div class="flex items-center justify-between">
              <div>
                <h1 class="text-3xl font-bold text-gray-800 mb-2">Welcome back, {{ auth()->user()->name }}!</h1>
                <p class="text-gray-600">Here's what's happening with your shipments today.</p>
              </div>
              <div class="hidden md:block">
                <div class="w-32 h-32 bg-yellow-100 rounded-full flex items-center justify-center transform hover:scale-105 transition-transform duration-300">
                  {{-- <i class="fas fa-shipping-fast text-4xl text-yellow-500"></i> --}}
                  <img src="data:image/jpeg;base64,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">
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Quick Actions Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
          <a href="{{ url('shipments/tracking') }}" class="group">
            <div class="bg-white rounded-2xl p-6 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
              <div class="flex items-center space-x-4">
                <div class="bg-yellow-100 p-3 rounded-xl">
                  <i class="fas fa-truck-fast text-2xl text-yellow-500"></i>
                </div>
                <div>
                  <h3 class="text-lg font-semibold text-gray-800">Track Shipment</h3>
                  <p class="text-gray-600 text-sm">Monitor your shipments in real-time</p>
                </div>
              </div>
            </div>
          </a>

          <a href="#" class="group">
            <div class="bg-white rounded-2xl p-6 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
              <div class="flex items-center space-x-4">
                <div class="bg-yellow-100 p-3 rounded-xl">
                  <i class="fas fa-calendar text-2xl text-yellow-500"></i>
                </div>
                <div>
                  <h3 class="text-lg font-semibold text-gray-800">Schedule</h3>
                  <p class="text-gray-600 text-sm">Plan your future shipments</p>
                </div>
              </div>
            </div>
          </a>

          <a href="{{ route('support') }}" class="group">
            <div class="bg-white rounded-2xl p-6 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
              <div class="flex items-center space-x-4">
                <div class="bg-yellow-100 p-3 rounded-xl">
                  <i class="fas fa-headset text-2xl text-yellow-500"></i>
                </div>
                <div>
                  <h3 class="text-lg font-semibold text-gray-800">Support</h3>
                  <p class="text-gray-600 text-sm">Get help when you need it</p>
                </div>
              </div>
            </div>
          </a>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
          <!-- All Shipments Card -->
          <div class="bg-white rounded-2xl p-6 shadow-lg relative overflow-hidden group">
            <div class="absolute top-0 right-0 w-32 h-32 bg-yellow-100 rounded-full transform translate-x-16 -translate-y-16 opacity-50 group-hover:opacity-75 transition-opacity duration-300"></div>
            <div class="relative z-10">
              <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-800">All Shipments</h3>
                <div class="bg-yellow-100 p-3 rounded-xl">
                  <i class="fas fa-boxes text-xl text-yellow-500"></i>
                </div>
              </div>
              <p class="text-3xl font-bold text-gray-900 mb-2">{{ $all_client_shipments }}</p>
              <p class="text-sm text-gray-600">Total shipments in your account</p>
            </div>
          </div>

          <!-- In Progress Card -->
          <div class="bg-white rounded-2xl p-6 shadow-lg relative overflow-hidden group">
            <div class="absolute top-0 right-0 w-32 h-32 bg-yellow-100 rounded-full transform translate-x-16 -translate-y-16 opacity-50 group-hover:opacity-75 transition-opacity duration-300"></div>
            <div class="relative z-10">
              <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-800">In Progress</h3>
                <div class="bg-yellow-100 p-3 rounded-xl">
                  <i class="fas fa-shipping-fast text-xl text-yellow-500"></i>
                </div>
              </div>
              <p class="text-3xl font-bold text-gray-900 mb-2">{{ $in_progress_client_shipments }}</p>
              <p class="text-sm text-gray-600">Active shipments</p>
            </div>
          </div>

          <!-- Canceled Card -->
          <div class="bg-white rounded-2xl p-6 shadow-lg relative overflow-hidden group">
            <div class="absolute top-0 right-0 w-32 h-32 bg-yellow-100 rounded-full transform translate-x-16 -translate-y-16 opacity-50 group-hover:opacity-75 transition-opacity duration-300"></div>
            <div class="relative z-10">
              <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-800">Canceled</h3>
                <div class="bg-yellow-100 p-3 rounded-xl">
                  <i class="fas fa-truck-loading text-xl text-yellow-500"></i>
                </div>
              </div>
              <p class="text-3xl font-bold text-gray-900 mb-2">0</p>
              <p class="text-sm text-gray-600">Canceled shipments</p>
            </div>
          </div>
        </div>

        <!-- 3D Decorative Elements -->
        {{-- <div class="fixed bottom-0 right-0 w-96 h-96 pointer-events-none">
          <div class="absolute bottom-0 right-0 w-64 h-64 bg-yellow-200 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob"></div>
          <div class="absolute bottom-0 right-0 w-64 h-64 bg-yellow-300 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob animation-delay-2000"></div>
          <div class="absolute bottom-0 right-0 w-64 h-64 bg-yellow-400 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob animation-delay-4000"></div>
        </div> --}}
      </div>

      <style>
        @keyframes blob {
          0% { transform: translate(0px, 0px) scale(1); }
          33% { transform: translate(30px, -50px) scale(1.1); }
          66% { transform: translate(-20px, 20px) scale(0.9); }
          100% { transform: translate(0px, 0px) scale(1); }
        }
        .animate-blob {
          animation: blob 7s infinite;
        }
        .animation-delay-2000 {
          animation-delay: 2s;
        }
        .animation-delay-4000 {
          animation-delay: 4s;
        }
      </style>
    </div>
    <!-- ./col -->
