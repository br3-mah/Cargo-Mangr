@php
        $client_id = Modules\Cargo\Entities\Client::where('user_id',auth()->user()->id)->pluck('id')->first();
        $all_client_shipments          = Modules\Cargo\Entities\Shipment::where('client_id', $client_id )->count();
        $saved_client_shipments        = Modules\Cargo\Entities\Shipment::where('client_id', $client_id )->where('status_id', Modules\Cargo\Entities\Shipment::SAVED_STATUS)->count();
        $in_progress_client_shipments  = Modules\Cargo\Entities\Shipment::where('client_id', $client_id )->where('client_status', Modules\Cargo\Entities\Shipment::CLIENT_STATUS_IN_PROCESSING)->count();
        $delivered_client_shipments    = Modules\Cargo\Entities\Shipment::where('client_id', $client_id )->where('client_status', Modules\Cargo\Entities\Shipment::CLIENT_STATUS_DELIVERED)->count();

        $transactions                  = Modules\Cargo\Entities\Transaction::where('client_id', $client_id )->orderBy('created_at','desc')->sum('value');
        $DEBIT_transactions            = Modules\Cargo\Entities\Transaction::where('client_id', $client_id )->where('value', 'like', '%-%')->orderBy('created_at','desc')->sum('value');
        $CREDIT_transactions           = Modules\Cargo\Entities\Transaction::where('client_id', $client_id )->where('value', 'not like', '%-%')->orderBy('created_at','desc')->sum('value');

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
      <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
      <style>
        :root {
          --primary-color: #2563eb;
          --secondary-color: #fbbf24;
          --light-color: #f8fafc;
          --dark-color: #1e293b;
          --success-color: #10b981;
          --warning-color: #f59e0b;
          --danger-color: #ef4444;
          --card-radius: 16px;
        }

        .dashboard-container {
          max-width: 100%;
          margin: 0 auto;
          padding: 0 2rem;
        }

        .dashboard-header {
          display: flex;
          justify-content: space-between;
          align-items: center;
          padding: 1.5rem 0;
          margin-bottom: 1.5rem;
        }

        .dashboard-title {
          font-size: 1.8rem;
          font-weight: 700;
          background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
          -webkit-background-clip: text;
          -webkit-text-fill-color: transparent;
          letter-spacing: -0.5px;
        }

        .quick-actions {
          display: flex;
          gap: 12px;
          margin-bottom: 2rem;
        }

        .action-button {
          display: flex;
          align-items: center;
          gap: 8px;
          padding: 10px 16px;
          border-radius: 12px;
          font-weight: 600;
          font-size: 0.9rem;
          cursor: pointer;
          transition: all 0.3s ease;
          border: none;
        }

        .primary-btn {
          background-color: var(--primary-color);
          color: white;
          box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2);
        }

        .primary-btn:hover {
          background-color: #1d4ed8;
          transform: translateY(-2px);
          box-shadow: 0 6px 16px rgba(37, 99, 235, 0.3);
        }

        .secondary-btn {
          background-color: var(--secondary-color);
          color: #1e293b;
          box-shadow: 0 4px 12px rgba(251, 191, 36, 0.2);
        }

        .secondary-btn:hover {
          background-color: #f59e0b;
          transform: translateY(-2px);
          box-shadow: 0 6px 16px rgba(251, 191, 36, 0.3);
        }

        .row {
          display: flex;
          flex-wrap: wrap;
          margin: 0 -12px;
        }

        .col-lg-3 {
          width: 25%;
          padding: 0 12px;
        }

        .card-stats {
          position: relative;
          border-radius: var(--card-radius);
          overflow: hidden;
          border: none;
          margin-bottom: 1.5rem;
          height: 80%;
          transition: transform 0.3s ease, box-shadow 0.3s ease;
          backdrop-filter: blur(10px);
          background-color: rgba(255, 255, 255, 0.7);
          box-shadow: 0 10px 25px -5px rgba(0,0,0,0.05);
        }

        .card-stats::before {
          content: "";
          position: absolute;
          top: 0;
          left: 0;
          right: 0;
          height: 4px;
        }

        .card-primary::before {
          background: var(--primary-color);
        }

        .card-success::before {
          background: var(--success-color);
        }

        .card-warning::before {
          background: var(--warning-color);
        }

        .card-danger::before {
          background: var(--danger-color);
        }

        .card-stats:hover {
          transform: translateY(-5px);
          box-shadow: 0 20px 35px -10px rgba(0,0,0,0.08);
        }

        .card-body {
          padding: 1.5rem;
          position: relative;
          z-index: 1;
        }

        .stat-icon {
          display: flex;
          align-items: center;
          justify-content: center;
          width: 50px;
          height: 50px;
          border-radius: 12px;
          position: absolute;
          top: 1.5rem;
          right: 1.5rem;
          font-size: 1.5rem;
          color: white;
        }

        .card-primary .stat-icon {
          background-color: var(--primary-color);
          box-shadow: 0 8px 16px -4px rgba(37, 99, 235, 0.3);
        }

        .card-success .stat-icon {
          background-color: var(--success-color);
          box-shadow: 0 8px 16px -4px rgba(16, 185, 129, 0.3);
        }

        .card-warning .stat-icon {
          background-color: var(--warning-color);
          box-shadow: 0 8px 16px -4px rgba(245, 158, 11, 0.3);
        }

        .card-danger .stat-icon {
          background-color: var(--danger-color);
          box-shadow: 0 8px 16px -4px rgba(239, 68, 68, 0.3);
        }

        .stat-value {
          font-size: 2.5rem;
          font-weight: 700;
          margin-bottom: 0.75rem;
          background: linear-gradient(45deg, var(--dark-color), #4b5563);
          -webkit-background-clip: text;
          -webkit-text-fill-color: transparent;
          letter-spacing: -1px;
        }

        .stat-label {
          text-transform: uppercase;
          font-size: 0.85rem;
          letter-spacing: 1.2px;
          color: #6b7280;
          font-weight: 600;
          margin-bottom: 1.5rem;
        }

        .card-footer {
          background-color: rgba(255, 255, 255, 0.5);
          border-top: 1px solid rgba(0,0,0,0.04);
          padding: 0;
        }

        .stat-link {
          display: block;
          padding: 0.75rem 1.5rem;
          color: #6b7280;
          text-decoration: none;
          font-size: 0.85rem;
          font-weight: 600;
          transition: all 0.3s ease;
        }

        .card-primary .stat-link:hover {
          background-color: var(--primary-color);
          color: white;
        }

        .card-success .stat-link:hover {
          background-color: var(--success-color);
          color: white;
        }

        .card-warning .stat-link:hover {
          background-color: var(--warning-color);
          color: white;
        }

        .card-danger .stat-link:hover {
          background-color: var(--danger-color);
          color: white;
        }

        .stat-link i {
          margin-left: 0.5rem;
          transition: transform 0.3s ease;
        }

        .stat-link:hover i {
          transform: translateX(5px);
        }

        @media (max-width: 1200px) {
          .col-lg-3 {
            width: 50%;
          }
        }

        @media (max-width: 768px) {
          .col-lg-3 {
            width: 100%;
          }

          .dashboard-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 16px;
          }

          .quick-actions {
            width: 100%;
            overflow-x: auto;
            padding-bottom: 12px;
          }
        }

        /* Glassmorphism Effects */
        .glass-panel {
          background: rgba(255, 255, 255, 0.25);
          backdrop-filter: blur(10px);
          border-radius: 24px;
          border: 1px solid rgba(255, 255, 255, 0.18);
          box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.07);
          padding: 2rem;
          margin-bottom: 2rem;
        }

        .blobs {
          position: fixed;
          width: 100%;
          height: 100%;
          overflow: hidden;
          top: 0;
          left: 0;
          z-index: -1;
        }

        .blob {
          position: absolute;
          border-radius: 50%;
          filter: blur(40px);
          opacity: 0.4;
        }

        .blob-1 {
          top: -100px;
          left: -100px;
          width: 400px;
          height: 400px;
          background: rgba(37, 99, 235, 0.3);
        }

        .blob-2 {
          bottom: -150px;
          right: -100px;
          width: 500px;
          height: 500px;
          background: rgba(251, 191, 36, 0.3);
        }

        .shortcut-grid {
          display: grid;
          grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
          gap: 16px;
          margin-bottom: 2rem;
        }

        .shortcut-card {
          display: flex;
          flex-direction: column;
          align-items: center;
          justify-content: center;
          background: rgba(255, 255, 255, 0.5);
          backdrop-filter: blur(8px);
          padding: 1.5rem 1rem;
          border-radius: 16px;
          text-align: center;
          cursor: pointer;
          transition: all 0.3s ease;
          box-shadow: 0 4px 12px rgba(0, 0, 0, 0.03);
          border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .shortcut-card:hover {
          transform: translateY(-5px);
          box-shadow: 0 12px 20px rgba(0, 0, 0, 0.05);
        }

        .shortcut-icon {
          font-size: 1.8rem;
          color: var(--primary-color);
          margin-bottom: 0.75rem;
          width: 50px;
          height: 50px;
          display: flex;
          align-items: center;
          justify-content: center;
          background: rgba(255, 255, 255, 0.8);
          border-radius: 12px;
          margin-bottom: 1rem;
        }

        .yellow-icon {
        color: var(--secondary-color);
        }

        .danger-icon {
        color: var(--danger-color);
        }   
        .success-icon {
        color: var(--success-color);
        }   

        .shortcut-title {
          font-size: 0.95rem;
          font-weight: 600;
          color: var(--dark-color);
        }
      </style>

      <div class="blobs">
        <div class="blob blob-1"></div>
        <div class="blob blob-2"></div>
      </div>

      <div class="dashboard-container">
        <header class="dashboard-header">
          <h1 class="dashboard-title">Welcome, {{ auth()->user()->name }}</h1>

          <div class="quick-actions">
            <a href="{{ aurl('shipments/shipments/create') }}" class="action-button primary-btn">
              <i class="fas fa-plus"></i> New Shipment
            </a>
            {{-- <button class="action-button secondary-btn">
              <i class="fas fa-file-export"></i> Export Report
            </button> --}}
            {{-- <button class="action-button secondary-btn">
              <i class="fas fa-file-export"></i> Export Report
            </button> --}}
          </div>
        </header>

        <div class="glass-panel">
          <h2 style="margin-bottom: 1.5rem; font-size: 1.2rem; color: #334155;">Quick Access</h2>
          <div class="shortcut-grid">
            <a target="_blank" href="{{ url('shipments/tracking') }}" class="shortcut-card">
              <div class="shortcut-icon">
                <i class="fas fa-truck-fast"></i>
              </div>
              <div class="shortcut-title">Track Shipment</div>
            </a>
            {{-- <div class="shortcut-card">
              <div class="shortcut-icon yellow-icon">
                <i class="fas fa-user-group"></i>
              </div>
              <div class="shortcut-title">Clients</div>
            </div> --}}
            <a href="{{ aurl('transactions/transactions') }}" class="shortcut-card">
              <div class="shortcut-icon">
                <i class="fas fa-wallet"></i>
              </div>
              <div class="shortcut-title">Payments</div>
            </a>
            <div class="shortcut-card">
              <div class="shortcut-icon yellow-icon">
                <i class="fas fa-chart-line"></i>
              </div>
              <div class="shortcut-title">Analytics</div>
            </div>
            <div class="shortcut-card">
                <div class="shortcut-icon">
                  <i class="fas fa-calendar"></i>
                </div>
                <div class="shortcut-title">Schedule</div>
              </div>
              <div class="shortcut-card">
                <div class="shortcut-icon">
                  <i class="fas fa-headset danger-icon"></i>
                </div>
                <div class="shortcut-title">Support</div>
              </div>
          </div>
        </div>

        <div class="row">
          <div class="col-lg-3 col-md-6 mb-4">
            <div class="card-stats card-primary">
              <div class="card-body">
                <div class="stat-icon">
                  <i class="fas fa-boxes"></i>
                </div>
                <div class="stat-value">{{ $all_client_shipments }}</div>
                <div class="stat-label">All Shipments</div>
              </div>
            </div>
          </div>

          <div class="col-lg-3 col-md-6 mb-4">
            <div class="card-stats card-success">
              <div class="card-body">
                <div class="stat-icon">
                  <i class="fas fa-save"></i>
                </div>
                <div class="stat-value">{{ $saved_client_shipments }}</div>
                <div class="stat-label">Saved Shipments</div>
              </div>
            </div>
          </div>

          <div class="col-lg-3 col-md-6 mb-4">
            <div class="card-stats card-warning">
              <div class="card-body">
                <div class="stat-icon">
                  <i class="fas fa-shipping-fast"></i>
                </div>
                <div class="stat-value">{{ $in_progress_client_shipments }}</div>
                <div class="stat-label">In Progress Shipment</div>
              </div>
            </div>
          </div>

          <div class="col-lg-3 col-md-6 mb-4">
            <div class="card-stats card-danger">
              <div class="card-body">
                <div class="stat-icon">
                  <i class="fas fa-truck-loading"></i>
                </div>
                <div class="stat-value">0</div>
                <div class="stat-label">Canceled Shipment</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- ./col -->
