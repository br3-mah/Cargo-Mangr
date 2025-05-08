@if(session('message'))
    <div class="modal fade" id="messageModal" tabindex="-1" aria-labelledby="messageModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="messageModalLabel">Notification</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {{ session('message') }}
                    <img width="100" src="https://img.freepik.com/premium-vector/vector-drawing-hand-with-mobile-phone-phone-contains-numbers-entering-pin-code-owner-data-confirmation_531064-125.jpg?w=360">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Done</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        window.onload = function() {
            $('#messageModal').modal('show');
        };
    </script>
@endif