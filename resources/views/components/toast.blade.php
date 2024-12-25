@if(session('success') || $errors->any())
    <div style="position: fixed; bottom: 20px; right: 20px; z-index: 1055;">
        @if(session('success'))
            <div class="toast align-items-center text-bg-success border-0" role="alert" aria-live="assertive"
                 aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        {{ session('success') }}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                            aria-label="Close"></button>
                </div>
            </div>
        @endif

        @if($errors->any())
            <div class="toast align-items-center text-bg-danger border-0" role="alert" aria-live="assertive"
                 aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        @foreach ($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                            aria-label="Close"></button>
                </div>
            </div>
        @endif
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const toastElements = document.querySelectorAll('.toast');
            toastElements.forEach(function (toastElement) {
                const toast = new bootstrap.Toast(toastElement);
                toast.show();
            });
        });
    </script>
@endif
