@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-10">
    <h1 class="text-3xl font-bold mb-6">Yearly Sales Report</h1>
    
    @if($yearlySales->isEmpty())
        <p class="text-gray-300">No sales data available for this year.</p>
    @else
        <table class="min-w-full bg-white rounded-lg shadow-md">
            <thead>
                <tr class="bg-gray-800 text-white">
                    <th class="py-2 px-4">Order ID</th>
                    <th class="py-2 px-4">Customer Name</th>
                    <th class="py-2 px-4">Total Amount</th>
                    <th class="py-2 px-4">Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach($yearlySales as $sale)
                    <tr class="border-b">
                        <td class="py-2 px-4">{{ $sale->id }}</td>
                        <td class="py-2 px-4">{{ $sale->customer_name }}</td>
                        <td class="py-2 px-4">Rp{{ number_format($sale->total_amount, 2) }}</td>
                        <td class="py-2 px-4">{{ $sale->created_at->format('Y-m-d H:i') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection