@extends('layouts.common_layout')

@section('content')
<div class="container my-5">
    <h1 class="mb-4 text-3xl font-bold text-gray-800">Transactions</h1>

    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <table class="w-full table-auto">
            <thead class="bg-gray-200 text-gray-700 uppercase text-sm leading-normal">
                <tr>
                    <th class="py-3 px-6 text-left">S.No</th>
                    <th class="py-3 px-6 text-left">Transaction ID</th>
                    <th class="py-3 px-6 text-left">Order ID</th>
                    <th class="py-3 px-6 text-left">User</th>
                    <th class="py-3 px-6 text-left">Amount</th>
                    <th class="py-3 px-6 text-left">Payment Method</th>
                    <th class="py-3 px-6 text-left">Status</th>
                    <th class="py-3 px-6 text-center">Action</th>
                </tr>
            </thead>
            <tbody class="text-gray-600 text-sm font-light">
                @foreach($payments as $payment)
                <tr class="border-b border-gray-200 hover:bg-gray-100">
                    <td class="py-3 px-6 text-left whitespace-nowrap">
                        {{ $loop->iteration + ($payments->currentPage() - 1) * $payments->perPage() }}
                    </td>
                    <td class="py-3 px-6 text-left">
                        {{ $payment->razorpay_payment_id }}
                    </td>
                    <td class="py-3 px-6 text-left">
                        {{ $payment->order_id }}
                    </td>
                    <td class="py-3 px-6 text-left">
                        {{ $payment->user->name }}
                    </td>
                    <td class="py-3 px-6 text-left">
                        ₹{{ number_format($payment->amount, 2) }}
                    </td>
                    <td class="py-3 px-6 text-left">
                        {{ ucfirst($payment->payment_method) }}
                    </td>
                    <td class="py-3 px-6 text-left">
                        <span class="px-2 py-1 font-semibold leading-tight rounded-full 
                            {{ $payment->status === 'completed' ? 'text-green-700 bg-green-100' : 'text-red-700 bg-red-100' }}">
                            {{ ucfirst($payment->status) }}
                        </span>
                    </td>
                    <td class="py-3 px-6 text-center">
                        <a href="{{ route('transactions.show', $payment->id) }}" 
                           class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            View
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Pagination Links -->
    <div class="mt-6">
        {{ $payments->links() }}
    </div>
</div>
@endsection

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
@endpush
