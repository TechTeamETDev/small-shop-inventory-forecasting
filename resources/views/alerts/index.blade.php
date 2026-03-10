@extends('layouts.app')

@section('content')
<div class="container mt-5">

    <h2 class="text-primary mb-4">Low Stock Products</h2>

    <!-- Navigation buttons -->
    <div class="mb-3">
        <a href="{{ route('alerts.create') }}" class="btn btn-success me-2">Add Low Stock Alert</a>
        <a href="{{ route('products.index') }}" class="btn btn-secondary">Back to Products</a>
    </div>

    <!-- If no low stock products -->
    @if($alerts->isEmpty())
        <div class="alert alert-success">
            All products are in stock.
        </div>
    @else
        <table class="table table-bordered align-middle">
            <thead class="table-light">
                <tr>
                    <th>Product</th>
                    <th>Current Stock</th>
                    <th>Alert Quantity</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($alerts as $alert)
                    <tr>
                        <td>{{ $alert->product->name }}</td>
                        <td>{{ $alert->product->quantity }}</td>
                        <td>{{ $alert->alert_quantity }}</td>
                        <td class="text-danger fw-bold">
                            ⚠️ Low Stock
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

</div>
@endsection