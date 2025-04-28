<div class="col-lg-3 col-6">
    <!-- small box -->
    <div class="small-box bg-info">
        <div class="inner">
            <h3>{{$all_client_shipments}}</h3>
            <p>{{ __('cargo::view.all_Shipments') }}</p>
        </div>
        <div class="icon">
            <i class="fas fa-box-open"></i>
        </div>
        <a href="{{ route('shipments.index', ['client_id' => $client_id ]) }}" class="small-box-footer">{{ __('cargo::view.more_info') }} <i class="fas fa-arrow-circle-right"></i></a>
    </div>
</div>
<!-- ./col -->

<div class="col-lg-3 col-6">
    <!-- small box -->
    <div class="small-box bg-success">
        <div class="inner">
            <h3>{{$saved_client_shipments}}</h3>
            <p>{{ __('cargo::view.saved_shipments') }}</p>
        </div>
        <div class="icon">
            <i class="fas fa-box-open"></i>
        </div>
        <a href="{{ route('shipments.index', ['status'=>[ Modules\Cargo\Entities\Shipment::SAVED_STATUS]  , 'client_id' => $client_id ]) }}" class="small-box-footer">{{ __('cargo::view.more_info') }} <i class="fas fa-arrow-circle-right"></i></a>
    </div>
</div>
<!-- ./col -->

<div class="col-lg-3 col-6">
    <!-- small box -->
    <div class="small-box bg-warning">
        <div class="inner">
            <h3>{{$in_progress_client_shipments}}</h3>
            <p>{{ __('cargo::view.in_progress_shipments') }}</p>
        </div>
        <div class="icon">
            <i class="fas fa-box-open"></i>
        </div>
        <a href="{{ route('shipments.index', ['client_status'=>[ Modules\Cargo\Entities\Shipment::CLIENT_STATUS_IN_PROCESSING] , 'client_id' => $client_id ]) }}" class="small-box-footer">{{ __('cargo::view.more_info') }} <i class="fas fa-arrow-circle-right"></i></a>
    </div>
</div>

<div class="col-lg-3 col-6">
    <!-- small box -->
    <div class="small-box bg-danger">
        <div class="inner">
            <h3>{{$delivered_client_shipments}}</h3>
            <p>{{ __('cargo::view.delivered_shipments') }}</p>
        </div>
        <div class="icon">
            <i class="fas fa-box-open"></i>
        </div>
        <a href="{{ route('shipments.index', ['client_status'=>[ Modules\Cargo\Entities\Shipment::CLIENT_STATUS_DELIVERED] , 'client_id' => $client_id ]) }}" class="small-box-footer">{{ __('cargo::view.more_info') }} <i class="fas fa-arrow-circle-right"></i></a>
    </div>
</div>
