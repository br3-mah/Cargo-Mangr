<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
<div class="w-full bg-white px-3 shadow-sm rounded-lg overflow-hidden">
  <div class="bg-gradient-to-r text-dark py-4 flex justify-between items-center">
    {{-- <h2 class="text-lg font-bold text-primary tracking-tight">Consignment Tracking System</h2> --}}
    <div class="flex space-x-2">
      @can('delete-consignments')
        <button id="bulk-delete-btn"
            class="btnclicky btn-sm d-flex item-center justify-content-center bg-red-500 text-white rounded hover:bg-red-600 transition disabled:opacity-50"
            disabled>
            <span> <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
            <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
            <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
            </svg></span>
        </button>
      @endcan
    </div>
  </div>

  <!-- Table Container -->
  <div class="overflow-x-auto">
    <table class="w-full table-auto">
      <thead>
        <tr class="bg-gray-100 text-gray-700 uppercase text-xs border-b border-gray-200">
            <th class="px-6 py-3">
                <input type="checkbox" class="bulk-checkbox" id="select-all">
            </th>
            <th class="px-6 py-3 font-semibold tracking-wider text-left">CODE</th>
        <th class="px-6 py-3 font-semibold tracking-wider text-left">SHIPMENT PARCELS</th>
            <th class="px-6 py-3 font-semibold tracking-wider text-left">CONSIGNEE</th>
            <th class="px-6 py-3 font-semibold tracking-wider text-left">SOURCE</th>
            <th class="px-6 py-3 font-semibold tracking-wider text-left">DESTINATION</th>
            <th class="px-6 py-3 font-semibold tracking-wider text-left">UPDATED</th>
            <th class="px-6 py-3 font-semibold tracking-wider text-left">STATUS</th>
            <th class="px-6 py-3 font-semibold tracking-wider text-center">ACTIONS</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-gray-200">
        @forelse($consignments as $consignment)
        <tr class="hover:bg-gray-50 transition-colors duration-150">
            <td class="px-6 py-4 text-sm">
                <input type="checkbox" class="row-checkbox" value="{{ $consignment->id }}">
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                {{ $consignment->consignment_code ?? 'Unspecified' }}
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                {{ $consignment->shipment_count ?? 'Unspecified' }}
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                {{ $consignment->name }}
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                {{ $consignment->source ?? 'China' }}
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                {{ $consignment->destination ?? 'Zambia' }}
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                {{ $consignment->updated_at->toFormattedDateString() }}
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
                @if($consignment->status == 'delivered')
                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                    DELIVERED
                </span>
                @elseif($consignment->status == 'in_transit')
                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                    IN TRANSIT
                </span>
                @else
                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                    {{-- {{ strtoupper($consignment->status) }} --}}
                    {{ strtoupper($consignment->current_status) }}
                </span>
                @endif
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-center">
                <div class="flex justify-center space-x-2">

                @can('edit-consignments')
                <a href="{{ route('consignment.edit', $consignment->id) }}"
                    class="p-1.5 bg-yellow-500 text-white rounded-md shadow-sm hover:bg-yellow-600 transition duration-150 ease-in-out focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                </a>
                @endcan

                @can('delete-consignments')
                <form action="{{ route('consignment.destroy', $consignment->id) }}" method="POST" class="inline-block">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('Are you sure?')"
                            class="btnclicky p-1.5 bg-red-500 text-white rounded-md shadow-sm hover:bg-red-600 transition duration-150 ease-in-out focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                    </button>
                </form>
                @endcan

                @can('view-consignments')
                <a href="{{ route('consignment.show', $consignment->id) }}"
                    class="p-1.5 bg-gray-200 text-gray-700 rounded-md shadow-sm hover:bg-gray-300 transition duration-150 ease-in-out focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                </a>
                @endcan

                @can('update-consignment-tracker')
                <button type="button" class="btn btn-sm btn-warning update-tracker-btn" 
                    data-toggle="modal" 
                    data-target="#updateTrackerModal"
                    data-id="{{ $consignment->id }}"
                    data-checkpoint="{{ $consignment->checkpoint }}"
                    data-cargo_type="{{ $consignment->cargo_type }}"
                    data-consignee_name="{{ $consignment->consignee_name }}"
                    data-consignment_code="{{ $consignment->consignment_code }}"
                    data-source="{{ $consignment->source }}"
                    data-destination="{{ $consignment->destination }}"
                    data-status="{{ $consignment->status }}"
                    data-updated_at="{{ $consignment->updated_at }}">
                    <i class="fas fa-shipping-fast"></i> Update Tracker
                </button>
                @endcan
                </div>
            </td>
        </tr>
        @empty
        @endforelse

      </tbody>
    </table>
  </div>

</div>
<script>
    $(document).ready(function () {
      const table = $('table').DataTable();

      // Select All Checkbox
      $('#select-all').on('click', function () {
        const checked = this.checked;
        $('.row-checkbox').each(function () {
          this.checked = checked;
        });
        toggleBulkDelete();
      });

      // Enable/Disable bulk delete
      $(document).on('change', '.row-checkbox', function () {
        toggleBulkDelete();
      });

      function toggleBulkDelete() {
        const selected = $('.row-checkbox:checked').length;
        $('#bulk-delete-btn').prop('disabled', selected === 0);
      }

      // Bulk Delete Logic
      $('#bulk-delete-btn').on('click', function () {
        const ids = $('.row-checkbox:checked').map(function () {
          return this.value;
        }).get();

        if (confirm(`Delete ${ids.length} selected consignments?`)) {
          $.ajax({
            url: "{{ route('consignment.bulkDelete') }}", // Create this route in Laravel
            method: 'POST',
            data: {
              _token: "{{ csrf_token() }}",
              ids: ids
            },
            success: function (response) {
              location.reload(); // Reload the page
            },
            error: function (err) {
              alert('An error occurred while deleting.');
            }
          });
        }
      });
    });


  document.addEventListener('DOMContentLoaded', function () {
    const checkboxes = document.querySelectorAll('.bulk-checkbox:not(#select-all)');
    const selectAll = document.getElementById('select-all');
    const bulkDeleteBtn = document.getElementById('bulk-delete-btn');

    function updateButtonState() {
      const anyChecked = Array.from(checkboxes).some(checkbox => checkbox.checked);
      bulkDeleteBtn.disabled = !anyChecked;
    }

    checkboxes.forEach(checkbox => {
      checkbox.addEventListener('change', updateButtonState);
    });

    // Optional: Handle "Select All" toggle
    if (selectAll) {
      selectAll.addEventListener('change', function () {
        checkboxes.forEach(cb => cb.checked = selectAll.checked);
        updateButtonState();
      });
    }
  });
</script>
