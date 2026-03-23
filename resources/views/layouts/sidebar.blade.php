<div class="sidebar">
    <ul class="nav flex-column">
        @can('view dashboard')
        <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
        @endcan

        @canany(['view products','create products'])
        <li>
            Products
            <ul>
                @can('create products')
                <li><a href="{{ route('products.create') }}">Add Product</a></li>
                @endcan
                @can('view products')
                <li><a href="{{ route('products.index') }}">View Products</a></li>
                @endcan
            </ul>
        </li>
        @endcanany

        @canany(['create sales','view sales'])
        <li>
            Sales
            <ul>
                @can('create sales')
                <li><a href="{{ route('sales.create') }}">Record Sale</a></li>
                @endcan
                @can('view sales')
                <li><a href="{{ route('sales.index') }}">View Sales</a></li>
                @endcan
            </ul>
        </li>
        @endcanany

        @can('view analytics')
        <li><a href="{{ route('analytics.index') }}">Analytics</a></li>
        @endcan

        @can('manage users')
        <li><a href="{{ route('users.index') }}">Manage Users</a></li>
        @endcan
    </ul>
</div>