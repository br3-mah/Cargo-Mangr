
{{-- Inject styles --}}
@section('styles')
    <style>
        .timeline .timeline-content {
            width: auto;
        }
        .timeline-label{
            margin-right: 6px;
            padding-right: 6px;
            border-right: solid 3px #eff2f5;
        }
        .timeline-label:before{
            width: unset;
        }
        .btn-loading {
            position: relative;
            pointer-events: none;
            opacity: 0.8;
        }
        .btn-loading .spinner-border {
            position: absolute;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
        }
        .btn-loading span {
            visibility: hidden;
        }
    </style>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function copyToClipboard(element) {
            var $temp = $("<input>");
            $("body").append($temp);
            $temp.val($(element).text()).select();
            document.execCommand("copy");
            $temp.remove();
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: "{{ __('cargo::view.payment_link_copied') }}",
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });
        }
            
        let selectedShipmentId = null;
        const originalTotal = parseFloat({{ $totalAmount }});
        const discountTypeEl = document.getElementById('discountType');
        const discountValueEl = document.getElementById('discountValue');
        const finalTotalEl = document.getElementById('finalTotal');

        function openMarkPaidModal(shipmentId) {
            selectedShipmentId = shipmentId;
            document.getElementById('discountType').value = '';
            document.getElementById('discountValue').value = 0;
            finalTotalEl.textContent = originalTotal.toFixed(2);
            $('#markPaidModal').modal('show');
        }

        function computeFinalTotal() {
            const type = discountTypeEl.value;
            const discountVal = parseFloat(discountValueEl.value) || 0;
            let finalTotal = originalTotal;

            if (type === 'fixed') {
                finalTotal = originalTotal - discountVal;
            } else if (type === 'percent') {
                finalTotal = originalTotal - (originalTotal * (discountVal / 100));
            }

            if (finalTotal < 0) finalTotal = 0;

            finalTotalEl.textContent = finalTotal.toFixed(2);
        }

        discountTypeEl.addEventListener('change', computeFinalTotal);
        discountValueEl.addEventListener('input', computeFinalTotal);

        document.getElementById('confirmMarkPaidBtn').addEventListener('click', function () {
            const btn = this;
            btn.classList.add('btn-loading');
            btn.innerHTML = '<div class="spinner-border spinner-border-sm text-white" role="status"></div>';

            const url = `{{ route('api.mark-as-paid') }}`;

            const discountType = discountTypeEl.value;
            const discountValue = parseFloat(discountValueEl.value) || 0;
            const finalTotal = parseFloat(finalTotalEl.textContent);

            fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                body: JSON.stringify({
                    shipment_id: selectedShipmentId,
                    discount_type: discountType,
                    discount_value: discountValue,
                    final_total: finalTotal,
                }),
            })
            .then(response => response.json())
            .then(data => {
                $('#markPaidModal').modal('hide');
                if (data.transaction) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: data.message,
                        showConfirmButton: false,
                        timer: 1500
                    }).then(() => {
                        window.location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: data.message
                    }).then(() => {
                        window.location.reload();
                    });
                }
            })
            .catch(error => {
                console.error(error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Failed to mark as paid.'
                });
            })
            .finally(() => {
                btn.classList.remove('btn-loading');
                btn.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-circle-fill me-2" viewBox="0 0 16 16"><path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0m-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/></svg><span>Confirm Payment</span>';
            });
        });

        // Function to open refund modal
        function openRefundModal(shipmentId) {
            selectedShipmentId = shipmentId;
            $('#refundModal').modal('show');
        }

        // Handle refund confirmation
        document.getElementById('confirmRefundBtn').addEventListener('click', function () {
            const btn = this;
            btn.classList.add('btn-loading');
            btn.innerHTML = '<div class="spinner-border spinner-border-sm text-white" role="status"></div>';

            const url = `{{ route('api.refund-payment') }}`;
            const refundReason = document.getElementById('refundReason').value;

            if (!refundReason.trim()) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Warning!',
                    text: 'Please provide a reason for the refund.'
                });
                btn.classList.remove('btn-loading');
                btn.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-counterclockwise me-2" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M8 3a5 5 0 1 1-4.546 2.914.5.5 0 0 0-.908-.417A6 6 0 1 0 8 2v1z"/><path d="M8 4.466V.534a.25.25 0 0 0-.41-.192L5.23 2.308a.25.25 0 0 0 0 .384l2.36 1.966A.25.25 0 0 0 8 4.466z"/></svg><span>Confirm Refund</span>';
                return;
            }

            fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                body: JSON.stringify({
                    shipment_id: selectedShipmentId,
                    reason: refundReason
                }),
            })
            .then(response => response.json())
            .then(data => {
                $('#refundModal').modal('hide');
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: data.message,
                        showConfirmButton: false,
                        timer: 1500
                    }).then(() => {
                        window.location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: data.message
                    });
                }
            })
            .catch(error => {
                console.error(error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Failed to process refund.'
                });
            })
            .finally(() => {
                btn.classList.remove('btn-loading');
                btn.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-counterclockwise me-2" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M8 3a5 5 0 1 1-4.546 2.914.5.5 0 0 0-.908-.417A6 6 0 1 0 8 2v1z"/><path d="M8 4.466V.534a.25.25 0 0 0-.41-.192L5.23 2.308a.25.25 0 0 0 0 .384l2.36 1.966A.25.25 0 0 0 8 4.466z"/></svg><span>Confirm Refund</span>';
            });
        });
    </script>
@endsection
