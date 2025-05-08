
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
    </style>
@endsection

@section('scripts')
    <script>
        function copyToClipboard(element) {
            var $temp = $("<input>");
            $("body").append($temp);
            $temp.val($(element).text()).select();
            document.execCommand("copy");
            $temp.remove();
            AIZ.plugins.notify('success', "{{ __('cargo::view.payment_link_copied') }}");
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
            const url = `/api/mark-as-paid`;

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
                alert('Marked as Paid successfully!');
                window.location.reload();
            })
            .catch(error => {
                console.error(error);
                alert('Failed to mark as paid.');
            });
        });
    </script>

@endsection
