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
      <!-- Driver.js CSS -->
      <link rel="stylesheet" href="https://unpkg.com/driver.js/dist/driver.min.css">
      <!-- Driver.js JS -->
      <script src="https://unpkg.com/driver.js/dist/driver.min.js"></script>

      <div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 p-6">
        <!-- Welcome Section -->
        <div class="relative mb-8">
          <div class="absolute inset-0 bg-yellow-400 opacity-10 rounded-3xl transform -rotate-1"></div>
          <div class="relative bg-white rounded-3xl p-8 shadow-xl">
            <div class="flex items-center justify-between">
              <div>
                <h1 class="text-3xl font-bold text-gray-800 mb-2" id="welcome-title">Welcome back, {{ auth()->user()->name }}!</h1>
                <p class="text-gray-600">Here's what's happening with your shipments today.</p>
              </div>
              <div class="hidden md:block relative" style="height: 8rem;">
                <div class="absolute -top-8 -right-8 w-80 h-60  rounded-full flex items-center justify-center z-10">
                  {{-- <i class="fas fa-shipping-fast text-4xl text-yellow-500"></i> --}}
                  <img class="w-80 h-80 object-contain" src="https://cdn3d.iconscout.com/3d/premium/thumb/air-cargo-3d-icon-download-in-png-blend-fbx-gltf-file-formats--delivery-freight-airplane-shipment-and-logistic-pack-industry-icons-10476768.png?f=webp" alt="Air Cargo 3D Icon">
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

          <a href="#" class="group" id="schedule-trigger">
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
          <div class="bg-white rounded-2xl p-6 shadow-lg relative overflow-hidden group" id="all-shipments-card">
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

    <!-- Schedule Modal -->
    <div id="scheduleModal" class="fixed inset-0 z-[9999] flex items-center justify-center bg-white/40 backdrop-blur-sm hidden">
      <div class="bg-white rounded-3xl shadow-2xl w-full max-w-xl p-0 relative overflow-hidden">
        <!-- Illustration/Header -->
        <div class="bg-gradient-to-r from-yellow-400 to-yellow-200 flex flex-col items-center justify-center py-6 rounded-t-3xl">
          <h2 class="text-2xl font-extrabold text-gray-800 tracking-tight">Schedule a Shipment</h2>
          <p class="text-gray-700 text-sm mt-1">Let us help you get started with your shipment request</p>
          <button id="closeScheduleModal" class="absolute top-4 right-4 text-gray-400 hover:text-gray-700 text-3xl font-bold bg-white bg-opacity-60 rounded-full w-10 h-10 flex items-center justify-center shadow-md transition-all">&times;</button>
        </div>
        <form id="scheduleForm" class="p-8 pt-4 bg-white">
          <div id="questionnaireSteps"></div>
          <div class="flex justify-between mt-8">
            <button type="button" id="prevStep" class="px-5 py-2 bg-gray-100 text-gray-700 rounded-lg font-semibold shadow hover:bg-gray-200 transition-all" style="display:none;">Previous</button>
            <button type="button" id="nextStep" class="px-5 py-2 bg-yellow-500 text-white rounded-lg font-semibold shadow hover:bg-yellow-600 transition-all">Next</button>
            <button type="submit" id="submitSchedule" class="px-5 py-2 bg-green-500 text-white rounded-lg font-semibold shadow hover:bg-green-600 transition-all" style="display:none;">Submit</button>
          </div>
        </form>
      </div>
    </div>

    <script>
      // Modal logic
      const scheduleTrigger = document.getElementById('schedule-trigger');
      const scheduleModal = document.getElementById('scheduleModal');
      const closeScheduleModal = document.getElementById('closeScheduleModal');
      scheduleTrigger.addEventListener('click', function(e) {
        e.preventDefault();
        scheduleModal.classList.remove('hidden');
        startQuestionnaire();
      });
      closeScheduleModal.addEventListener('click', function() {
        scheduleModal.classList.add('hidden');
      });
      window.addEventListener('click', function(e) {
        if (e.target === scheduleModal) scheduleModal.classList.add('hidden');
      });

      // Questionnaire logic
      const steps = [
        {
          question: 'Are you a first time or old client?',
          name: 'client_type',
          type: 'radio',
          options: ['First time', 'Old client'],
          illustration: 'https://img.freepik.com/premium-vector/add-user-concept-illustration_86047-677.jpg'
        },
        {
          question: 'What are your full names?',
          name: 'full_names',
          type: 'text',
          illustration: 'https://img.freepik.com/premium-vector/visit-link-flat-illustration-call-action-concept-light-blue-yellow-color-isometric-minimal-style_146120-297.jpg'
        },
        {
          question: 'Which route do you wish to ship from?',
          name: 'route',
          type: 'radio',
          options: ['From China', 'From Dubai'],
          illustration: 'https://blog.shipsgo.com/wp-content/uploads/2023/10/5-Major-International-Shipping-Routes-01.png'
        },
        {
          question: 'What type of goods are being shipped?',
          name: 'goods_type',
          type: 'radio',
          options: ['General', 'Electric'],
          illustration: 'https://img.freepik.com/premium-vector/illustration-loading-goods-shipment-client_81522-2047.jpg'
        },
        {
          question: 'Do you have a supplier?',
          name: 'has_supplier',
          type: 'radio',
          options: ['Yes', 'No'],
          illustration: 'https://blog.modalku.co.id/wp-content/uploads/2021/01/Cara-Mencari-Supplier-Tangan-Pertama-untuk-Kualitas-Terbaik-Harga-Termurah.jpg'
        },
        // If No supplier, ask if need help
        {
          question: 'Do you need help finding a supplier?',
          name: 'need_supplier_help',
          type: 'radio',
          options: ['Yes', 'No'],
          conditional: {
            field: 'has_supplier',
            value: 'No'
          },
          illustration: 'https://cashflowinventory.com/blog/wp-content/uploads/2023/03/Supplier-Negotiation.jpg'
        },
        // Summary step
        {
          question: 'Summary of Your Request',
          name: 'summary',
          type: 'summary',
          illustration: 'https://cdn3d.iconscout.com/3d/premium/thumb/summary-6333246-5227296.png?f=webp'
        }
      ];

      // Example rates (replace with dynamic if needed)
      const ratesHtml = `
        <div class=\"mb-4\">
          <h4 class=\"font-semibold mb-2 text-lg text-yellow-700\">Shipping Rates</h4>
          <div class=\"flex items-center mb-2\"><img src=\"https://cdn3d.iconscout.com/3d/premium/thumb/airplane-6333247-5227297.png?f=webp\" class=\"w-8 h-8 mr-2\">Air Cargo: <span class=\"font-bold ml-2\">$5/kg</span></div>
          <div class=\"flex items-center\"><img src=\"https://cdn3d.iconscout.com/3d/premium/thumb/ship-6333248-5227298.png?f=webp\" class=\"w-8 h-8 mr-2\">Sea Cargo: <span class=\"font-bold ml-2\">$2/kg</span></div>
        </div>
      `;

      let currentStep = 0;
      let answers = {};

      const questionnaireSteps = document.getElementById('questionnaireSteps');
      const prevStepBtn = document.getElementById('prevStep');
      const nextStepBtn = document.getElementById('nextStep');
      const submitBtn = document.getElementById('submitSchedule');
      const scheduleForm = document.getElementById('scheduleForm');

      function renderStep() {
        // Handle conditional step
        let step = steps[currentStep];
        if (step.conditional) {
          if (answers[step.conditional.field] !== step.conditional.value) {
            // Skip this step
            currentStep++;
            renderStep();
            return;
          }
        }

        let html = '';
        // Illustration for each step
        if (step.illustration) {
          html += `<div class=\"flex justify-center mb-4\"><img src=\"${step.illustration}\" alt=\"Step Illustration\" class=\"w-20 h-20\"></div>`;
        }
        if (step.type === 'summary') {
          //summary not necessary
          if (answers['has_supplier'] === 'Yes') {
            html += ratesHtml;
          } else {
            html += `<div class=\"mb-4\"><span class=\"font-semibold text-yellow-700\">Shipping rates will be provided after supplier confirmation.</span></div>`;
          }
          html += '</div>';
        } else {
          html += `<div class=\"mb-4\"><label class=\"block font-semibold mb-2 text-lg text-gray-800\">${step.question}</label>`;
          if (step.type === 'radio') {
            step.options.forEach(opt => {
              const checked = answers[step.name] === opt ? 'checked' : '';
              html += `<label class=\"inline-flex items-center mr-4\"><input type=\"radio\" name=\"${step.name}\" value=\"${opt}\" ${checked} class=\"form-radio accent-yellow-500\"> <span class=\"ml-2\">${opt}</span></label>`;
            });
          } else if (step.type === 'text') {
            html += `<input type=\"text\" name=\"${step.name}\" value=\"${answers[step.name]||''}\" class=\"form-input border-2 border-yellow-200 rounded-lg px-3 py-2 w-full focus:border-yellow-500 focus:ring-2 focus:ring-yellow-100 transition-all\">`;
          }
          html += '</div>';
          // If "has_supplier" is Yes and this is the next step, show rates
          if (step.name === 'has_supplier' && answers['has_supplier'] === 'Yes') {
            html += ratesHtml;
          }
        }

        questionnaireSteps.innerHTML = html;

        // Show/hide navigation
        prevStepBtn.style.display = currentStep > 0 ? '' : 'none';
        nextStepBtn.style.display = currentStep < steps.length - 1 ? '' : 'none';
        submitBtn.style.display = currentStep === steps.length - 1 ? '' : 'none';
      }

      function startQuestionnaire() {
        currentStep = 0;
        answers = {};
        renderStep();
      }

      nextStepBtn.onclick = function() {
        // Save answer
        const step = steps[currentStep];
        if (step.type === 'radio') {
          const selected = scheduleForm.querySelector(`input[name='${step.name}']:checked`);
          if (!selected) return alert('Please select an option.');
          answers[step.name] = selected.value;
        } else if (step.type === 'text') {
          const input = scheduleForm.querySelector(`input[name='${step.name}']`);
          if (!input.value.trim()) return alert('Please fill in this field.');
          answers[step.name] = input.value.trim();
        }
        currentStep++;
        renderStep();
      };

      prevStepBtn.onclick = function() {
        if (currentStep > 0) currentStep--;
        renderStep();
      };

      scheduleForm.onsubmit = function(e) {
        e.preventDefault();
        // Save last answer (should be summary step)
        // No input to save, just submit
        alert('Your request has been submitted! (Backend/email logic not yet implemented)');
        scheduleModal.classList.add('hidden');
      };
    </script>
