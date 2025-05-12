<!-- Tailwind CSS CDN -->
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

<div class="w-full bg-white px-3 shadow-xl rounded-lg overflow-hidden">
  <!-- Header -->
  <div class="bg-gradient-to-r text-dark py-4 flex justify-between items-center">
    <h2 class="text-lg font-bold text-primary tracking-tight">Consignment Tracking System</h2>
    <!-- Bulk Delete Button -->
    <div class="flex space-x-2">
        <button id="bulk-delete-btn"
            class="btnclicky px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600 transition disabled:opacity-50"
            disabled>
            Bulk Delete
        </button>
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
            <th class="px-6 py-3 font-semibold tracking-wider text-left">SHIPMENTS</th>
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
                {{ $consignment->mawb_num ?? 'Unspecified' }}
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
                    {{ strtoupper($consignment->status) }}
                </span>
                @endif
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-center">
                <div class="flex justify-center space-x-2">
                <a href="{{ route('consignment.edit', $consignment->id) }}"
                    class="p-1.5 bg-yellow-500 text-white rounded-md shadow-sm hover:bg-yellow-600 transition duration-150 ease-in-out focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                </a>

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

                <a href="{{ route('consignment.show', $consignment->id) }}"
                    class="p-1.5 bg-gray-200 text-gray-700 rounded-md shadow-sm hover:bg-gray-300 transition duration-150 ease-in-out focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                </a>

                <button type="button"
                        data-id="{{ $consignment->id }}"
                        data-checkpoint="{{ $consignment->checkpoint }}"
                        data-toggle="modal"
                        data-target="#updateTrackerModal"
                        class="p-1.5 bg-blue-500 text-white rounded-md shadow-sm hover:bg-blue-600 transition duration-150 ease-in-out focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 update-tracker-btn">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                </button>
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
