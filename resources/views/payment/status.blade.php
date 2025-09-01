<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Payment Status') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="text-center mb-8">
                        <!-- Status Icon -->
                        <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full mb-6
                            @if($payment->status === 'success') bg-green-100 dark:bg-green-900
                            @elseif($payment->status === 'pending') bg-yellow-100 dark:bg-yellow-900
                            @elseif($payment->status === 'failed') bg-red-100 dark:bg-red-900
                            @else bg-gray-100 dark:bg-gray-700
                            @endif">
                            @if($payment->status === 'success')
                                <svg class="h-8 w-8 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            @elseif($payment->status === 'pending')
                                <svg class="h-8 w-8 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            @elseif($payment->status === 'failed')
                                <svg class="h-8 w-8 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            @else
                                <svg class="h-8 w-8 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            @endif
                        </div>
                        
                        <h1 class="text-3xl font-bold mb-4
                            @if($payment->status === 'success') text-green-600 dark:text-green-400
                            @elseif($payment->status === 'pending') text-yellow-600 dark:text-yellow-400
                            @elseif($payment->status === 'failed') text-red-600 dark:text-red-400
                            @else text-gray-600 dark:text-gray-400
                            @endif">
                            @if($payment->status === 'success')
                                Payment Successful!
                            @elseif($payment->status === 'pending')
                                Payment Pending
                            @elseif($payment->status === 'failed')
                                Payment Failed
                            @else
                                Payment Status: {{ ucfirst($payment->status) }}
                            @endif
                        </h1>
                        
                        <p class="text-gray-600 dark:text-gray-400 mb-8">
                            @if($payment->status === 'success')
                                Thank you for your purchase. Your payment has been processed successfully.
                            @elseif($payment->status === 'pending')
                                Your payment is being processed. Please wait for confirmation or complete the payment if required.
                            @elseif($payment->status === 'failed')
                                We're sorry, but your payment could not be processed. Please try again or contact support.
                            @else
                                Here are the details of your payment transaction.
                            @endif
                        </p>
                    </div>

                    <!-- Payment Details -->
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6 mb-6">
                        <h3 class="text-lg font-semibold mb-4">Payment Details</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <span class="text-sm text-gray-600 dark:text-gray-400">Transaction ID:</span>
                                <p class="font-semibold font-mono">{{ $payment->transaction_id }}</p>
                            </div>
                            <div>
                                <span class="text-sm text-gray-600 dark:text-gray-400">Status:</span>
                                <p class="font-semibold">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        @if($payment->status === 'success') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                                        @elseif($payment->status === 'pending') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200
                                        @elseif($payment->status === 'failed') bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200
                                        @else bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200
                                        @endif">
                                        {{ ucfirst($payment->status) }}
                                    </span>
                                </p>
                            </div>
                            <div>
                                <span class="text-sm text-gray-600 dark:text-gray-400">Amount:</span>
                                <p class="font-semibold text-lg">Rp {{ number_format($payment->gross_amount, 0, ',', '.') }}</p>
                            </div>
                            <div>
                                <span class="text-sm text-gray-600 dark:text-gray-400">Payment Method:</span>
                                <p class="font-semibold">{{ $payment->payment_type ?? 'Duitku' }}</p>
                            </div>
                            @if($payment->va_number)
                            <div>
                                <span class="text-sm text-gray-600 dark:text-gray-400">VA Number:</span>
                                <p class="font-semibold font-mono text-lg">{{ $payment->va_number }}</p>
                            </div>
                            @endif
                            @if($payment->bank)
                            <div>
                                <span class="text-sm text-gray-600 dark:text-gray-400">Bank:</span>
                                <p class="font-semibold">{{ strtoupper($payment->bank) }}</p>
                            </div>
                            @endif
                            @if($payment->payment_code)
                            <div>
                                <span class="text-sm text-gray-600 dark:text-gray-400">Payment Code:</span>
                                <p class="font-semibold font-mono">{{ $payment->payment_code }}</p>
                            </div>
                            @endif
                            <div>
                                <span class="text-sm text-gray-600 dark:text-gray-400">Created:</span>
                                <p class="font-semibold">{{ $payment->created_at->format('d M Y, H:i') }}</p>
                            </div>
                            @if($payment->updated_at != $payment->created_at)
                            <div>
                                <span class="text-sm text-gray-600 dark:text-gray-400">Last Updated:</span>
                                <p class="font-semibold">{{ $payment->updated_at->format('d M Y, H:i') }}</p>
                            </div>
                            @endif
                            @if($payment->message)
                            <div class="md:col-span-2">
                                <span class="text-sm text-gray-600 dark:text-gray-400">Message:</span>
                                <p class="font-semibold
                                    @if($payment->status === 'failed') text-red-600 dark:text-red-400
                                    @else text-gray-900 dark:text-gray-100
                                    @endif">
                                    {{ $payment->message }}
                                </p>
                            </div>
                            @endif
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

                    <!-- Payment Instructions (for pending payments) -->
                    @if($payment->status === 'pending' && ($payment->va_number || $payment->payment_code))
                    <div class="bg-blue-50 dark:bg-blue-900 rounded-lg p-6 mb-6">
                        <h3 class="text-lg font-semibold mb-4 text-blue-800 dark:text-blue-200">Payment Instructions</h3>
                        <div class="text-blue-700 dark:text-blue-300">
                            @if($payment->va_number)
                                <p class="mb-2">Please complete your payment using the Virtual Account number above.</p>
                                <p class="mb-2">You can pay through:</p>
                                <ul class="list-disc list-inside ml-4 space-y-1">
                                    <li>ATM {{ strtoupper($payment->bank ?? '') }}</li>
                                    <li>Internet Banking {{ strtoupper($payment->bank ?? '') }}</li>
                                    <li>Mobile Banking {{ strtoupper($payment->bank ?? '') }}</li>
                                </ul>
                            @elseif($payment->payment_code)
                                <p class="mb-2">Please complete your payment using the payment code above.</p>
                                <p>Visit the nearest payment point or use the mobile app to complete your payment.</p>
                            @endif
                        </div>
                    </div>
                    @endif

                    <!-- Actions -->
                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        @if($payment->status === 'pending')
                            <button onclick="location.reload()" class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-200">
                                <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                </svg>
                                Refresh Status
                            </button>
                        @endif
                        
                        @if($payment->status === 'failed' && $payment->template)
                            <a href="{{ route('payment.checkout', $payment->template->id) }}" class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-200">
                                <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                </svg>
                                Try Again
                            </a>
                        @endif
                        
                        <a href="{{ route('dashboard') }}" class="inline-flex items-center justify-center px-6 py-3 border border-gray-300 dark:border-gray-600 text-base font-medium rounded-md text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-200">
                            <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                            </svg>
                            Back to Dashboard
                        </a>
                        
                        @if($payment->status === 'success')
                            <button onclick="window.print()" class="inline-flex items-center justify-center px-6 py-3 border border-gray-300 dark:border-gray-600 text-base font-medium rounded-md text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-200">
                                <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                                </svg>
                                Print Receipt
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>