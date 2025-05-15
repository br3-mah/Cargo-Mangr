<div class="content" style="margin-left: 20%; width:80%">
@if(session('success'))
    <div class="alert alert-sm alert-success alert-dismissible fade show shadow-sm border-left-success text-white" role="alert">
        <strong>Success!</strong> {{ session('success') }}
        <button type="button" class="close text-white" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif
</div>


<div class="modal fade" id="currencyModal" tabindex="-1" role="dialog" aria-labelledby="currencyModalLabel" aria-hidden="true">
    <div style="z-index: 9999" class="modal-dialog modal-lg" role="document">
        <div class="modal-content shadow-lg border-0">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="currencyModalLabel">
                    <i class="fas fa-exchange-alt mr-2"></i>Update Currency Exchange Rates
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="currencyRatesForm" action="{{ route('currency.update_rates') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row">
                       <div class="col-md-4">
                            <div class="form-group">
                                <label for="fromCurrency" class="small font-weight-bold text-primary mb-1">From Currency</label>
                                <input type="text" class="form-control" id="fromCurrency" name="from_currency" placeholder="e.g. ZMW" value="ZMW" style="font-size: 0.85rem; height: calc(1.5em + 0.75rem);">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="toCurrency" class="small font-weight-bold text-primary mb-1">To Currency</label>
                                <input type="text" class="form-control" id="toCurrency" name="to_currency" placeholder="e.g. USD" value="USD" style="font-size: 0.85rem; height: calc(1.5em + 0.75rem);">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="exchangeRate" class="small font-weight-bold text-primary mb-1">Exchange Rate</label>
                                <input type="number" class="form-control form-control-sm" value="{{ current_x_rate() }}" id="exchangeRate" name="exchange_rate" placeholder="e.g. 27.4" step="0.0001" min="0" style="height: calc(1.5em + 0.55rem);">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button id="deleteItemBtn" type="button" class="btn btn-outline-danger btn-sm">
                        <i class="fas fa-times mr-1"></i>Reset
                    </button>
                    <button type="button" class="btn btn-outline-secondary btn-sm" data-dismiss="modal">
                        <i class="fas fa-times mr-1"></i>Close
                    </button>
                    <button type="submit" class="btn btn-primary btn-sm" data-show-loader="true">
                        <i class="fas fa-save mr-1"></i>Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.getElementById('deleteItemBtn').addEventListener('click', function () {
        const deleteUrl = "{{ route('currency-reset') }}";

        fetch(deleteUrl, {
            method: 'POST',
        })
        .then(response => response.json())
        .then(data => {
            window.location.reload();
        })
        .catch(error => {
            console.error('Error:', error);
        });
    });
</script>
