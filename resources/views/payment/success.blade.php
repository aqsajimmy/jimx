<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Payment Success') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="text-center">
                        <!-- Success Icon -->
                        <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-green-100 dark:bg-green-900 mb-6">
                            <svg class="h-8 w-8 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        
                        <h1 class="text-3xl font-bold text-green-600 dark:text-green-400 mb-4">
                            Payment Successful!
                        </h1>
                        
                        <p class="text-gray-600 dark:text-gray-400 mb-8">
                            Thank you for your purchase. Your payment has been processed successfully.
                        </p>
                    </div>

                    <!-- Payment Details -->
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6 mb-6">
                        <h3 class="text-lg font-semibold mb-4">Payment Details</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <span class="text-sm text-gray-600 dark:text-gray-400">Transaction ID:</span>
                                <p class="font-semibold">{{ $payment->transaction_id }}</p>
                            </div>
                            <div>
                                <span class="text-sm text-gray-600 dark:text-gray-400">Status:</span>
                                <p class="font-semibold">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                        {{ ucfirst($payment->status) }}
                                    </span>
                                </p>
                            </div>
                            <div>
                                <span class="text-sm text-gray-600 dark:text-gray-400">Amount:</span>
                                <p class="font-semibold">Rp {{ number_format($payment->gross_amount, 0, ',', '.') }}</p>
                            </div>
                            <div>
                                <span class="text-sm text-gray-600 dark:text-gray-400">Payment Method:</span>
                                <p class="font-semibold">{{ $payment->payment_type ?? 'Duitku' }}</p>
                            </div>
                            @if($payment->va_number)
                            <div>
                                <span class="text-sm text-gray-600 dark:text-gray-400">VA Number:</span>
                                <p class="font-semibold font-mono">{{ $payment->va_number }}</p>
                            </div>
                            @endif
                            @if($payment->bank)
                            <div>
                                <span class="text-sm text-gray-600 dark:text-gray-400">Bank:</span>
                                <p class="font-semibold">{{ strtoupper($payment->bank) }}</p>
                            </div>
                            @endif
                            <div>
                                <span class="text-sm text-gray-600 dark:text-gray-400">Date:</span>
                                <p class="font-semibold">{{ $payment->created_at->format('d M Y, H:i') }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Product Information -->
                    @if($payment->template)
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6 mb-6">
                        <h3 class="text-lg font-semibold mb-4">Product Information</h3>
                        <div class="flex items-center space-x-4">
                            <img src="{{ $payment->template->image }}" alt="{{ $payment->template->name }}" class="w-16 h-16 object-cover rounded-lg">
                            <div>
                                <h4 class="font-semibold">{{ $payment->template->name }}</h4>
                                <p class="text-sm text-gray-600 dark:text-gray-400">{{ $payment->template->description }}</p>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Actions -->
                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <a href="{{ route('dashboard') }}" class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-200">
                            <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                            </svg>
                            Back to Dashboard
                        </a>
                        
                        <button onclick="window.print()" class="inline-flex items-center justify-center px-6 py-3 border border-gray-300 dark:border-gray-600 text-base font-medium rounded-md text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-200">
                            <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                            </svg>
                            Print Receipt
                        </button>
                    </div>

                    <!-- Additional Information -->
                    <div class="mt-8 p-4 bg-blue-50 dark:bg-blue-900 rounded-lg">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-blue-800 dark:text-blue-200">
                                    What's Next?
                                </h3>
                                <div class="mt-2 text-sm text-blue-700 dark:text-blue-300">
                                    <p>Your purchase has been confirmed. You will receive an email confirmation shortly with your receipt and any additional information about your purchase.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>