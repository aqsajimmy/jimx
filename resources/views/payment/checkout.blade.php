<x-app-layout>
    <x-slot name="pageTitle">
        Checkout - {{ $template->name }}
    </x-slot>
    
    <x-slot name="header">
        <h2 class="h4 text-dark">
            {{ __('Checkout') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="container">
            <div class="card shadow-lg border-0">
                <div class="card-body p-4">
                    <div class="row g-4">
                        <!-- Product Information -->
                        <div class="col-lg-6">
                            <div class="card bg-light border-0 h-100">
                                <div class="card-body p-4">
                                    <h3 class="h5 fw-bold mb-4 text-dark">Product Details</h3>
                                    <div class="mb-4">
                                        <div class="position-relative overflow-hidden rounded-3 shadow">
                                            <img src="{{ $template->image }}" alt="{{ $template->name }}" class="img-fluid rounded-3" style="height: 250px; width: 100%; object-fit: cover;">
                                        </div>
                                    </div>
                                    <div class="mb-4">
                                        <h4 class="h4 fw-bold text-dark mb-2">{{ $template->name }}</h4>
                                        <p class="text-muted mb-0">{{ $template->description }}</p>
                                    </div>
                                    <div class="card border-0 bg-white">
                                        <div class="card-body p-3">
                                            <div class="d-flex justify-content-between align-items-center py-2">
                                                <span class="text-muted fw-medium">Original Price:</span>
                                                <span class="fw-semibold text-dark">Rp {{ number_format($template->price, 0, ',', '.') }}</span>
                                            </div>
                                            @if($template->discount > 0)
                                            <div class="d-flex justify-content-between align-items-center py-2">
                                                <span class="text-muted fw-medium">Discount ({{ $template->discount }}%):</span>
                                                <span class="text-danger fw-semibold">-Rp {{ number_format($template->price * $template->discount / 100, 0, ',', '.') }}</span>
                                            </div>
                                            @endif
                                            <hr class="my-3">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span class="h5 fw-bold text-dark mb-0">Total:</span>
                                                <span class="h4 fw-bold text-success mb-0">Rp {{ number_format($template->price - ($template->price * ($template->discount ?? 0) / 100), 0, ',', '.') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Checkout Form -->
                        <div class="col-lg-6">
                            <div class="card border-0 h-100">
                                <div class="card-body p-4">
                                    <h3 class="h5 fw-bold mb-4 text-dark">Billing Information</h3>
                                    <form id="checkout-form">
                                        @csrf
                                        <input type="hidden" name="template_id" value="{{ $template->id }}">
                                        
                                        <div class="row g-3 mb-3">
                                            <div class="col-md-6">
                                                <label for="first_name" class="form-label fw-medium">{{ __('First Name') }}</label>
                                                <input type="text" class="form-control" id="first_name" name="first_name" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="last_name" class="form-label fw-medium">{{ __('Last Name') }}</label>
                                                <input type="text" class="form-control" id="last_name" name="last_name" required>
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label for="customer_name" class="form-label fw-medium">{{ __('Full Name (for VA)') }}</label>
                                            <input type="text" class="form-control" id="customer_name" name="customer_name" required>
                                        </div>

                                        <div class="mb-3">
                                            <label for="email" class="form-label fw-medium">{{ __('Email') }}</label>
                                            <input type="email" class="form-control" id="email" name="email" value="{{ auth()->user()->email }}" required>
                                        </div>

                                        <div class="mb-3">
                                            <label for="phone" class="form-label fw-medium">{{ __('Phone Number') }}</label>
                                            <input type="tel" class="form-control" id="phone" name="phone" placeholder="08123456789" required>
                                        </div>

                                        <div class="mb-3">
                                            <label for="address" class="form-label fw-medium">{{ __('Address (Optional)') }}</label>
                                            <textarea class="form-control" id="address" name="address" rows="3"></textarea>
                                        </div>

                                        <div class="row g-3 mb-4">
                                            <div class="col-md-6">
                                                <label for="city" class="form-label fw-medium">{{ __('City (Optional)') }}</label>
                                                <input type="text" class="form-control" id="city" name="city">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="postal_code" class="form-label fw-medium">{{ __('Postal Code (Optional)') }}</label>
                                                <input type="text" class="form-control" id="postal_code" name="postal_code">
                                            </div>
                                        </div>

                                        <div class="d-grid">
                                            <button type="submit" id="pay-button" class="btn btn-primary btn-lg fw-bold py-3">
                                                <span id="button-text">Pay Now - Rp {{ number_format($template->price - ($template->price * ($template->discount ?? 0) / 100), 0, ',', '.') }}</span>
                                                <span id="loading-text" class="d-none">
                                                    <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                                                    Processing...
                                                </span>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Duitku Pop Integration -->
    <script src="https://app-sandbox.duitku.com/lib/js/duitku.js"></script>
    <script>
        document.getElementById('checkout-form').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const payButton = document.getElementById('pay-button');
            const buttonText = document.getElementById('button-text');
            const loadingText = document.getElementById('loading-text');
            
            // Show loading state
            payButton.disabled = true;
            buttonText.classList.add('d-none');
            loadingText.classList.remove('d-none');
            
            try {
                const formData = new FormData(this);
                
                const response = await fetch('{{ route("payment.create-invoice") }}', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                });
                
                const result = await response.json();
                
                if (result.success) {
                    // Initialize Duitku Pop
                    checkout.process(result.duitku_reference, {
                        defaultLanguage: "id", // id | en
                        successEvent: function(result) {
                            console.log('Payment success:', result);
                            window.location.href = `/payment/${result.merchantOrderId}/success`;
                        },
                        pendingEvent: function(result) {
                            console.log('Payment pending:', result);
                            alert('Payment is being processed. Please wait for confirmation.');
                        },
                        errorEvent: function(result) {
                            console.log('Payment error:', result);
                            alert('Payment failed: ' + result.statusMessage);
                        },
                        closeEvent: function(result) {
                            console.log('Payment popup closed:', result);
                            // Reset button state
                            payButton.disabled = false;
                            buttonText.classList.remove('d-none');
                            loadingText.classList.add('d-none');
                        }
                    });
                } else {
                    alert('Error: ' + result.message);
                    // Reset button state
                    payButton.disabled = false;
                    buttonText.classList.remove('d-none');
                    loadingText.classList.add('d-none');
                }
            } catch (error) {
                console.error('Error:', error);
                alert('An error occurred. Please try again.');
                // Reset button state
                payButton.disabled = false;
                buttonText.classList.remove('d-none');
                loadingText.classList.add('d-none');
            }
        });
        
        // Auto-fill customer name from first and last name
        document.getElementById('first_name').addEventListener('input', updateCustomerName);
        document.getElementById('last_name').addEventListener('input', updateCustomerName);
        
        function updateCustomerName() {
            const firstName = document.getElementById('first_name').value;
            const lastName = document.getElementById('last_name').value;
            document.getElementById('customer_name').value = (firstName + ' ' + lastName).trim();
        }
    </script>
</x-app-layout>