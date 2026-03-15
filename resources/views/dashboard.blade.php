<x-app-layout>

<div class="max-w-7xl mx-auto py-8">

<h1 class="text-2xl font-bold mb-6">
Dashboard
</h1>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">

{{-- PRODUCTS --}}
@can('view products')
<div class="bg-white shadow p-6 rounded">
<h2 class="font-semibold text-lg mb-2">
Inventory
</h2>

<p class="text-gray-600 mb-4">
View and manage product stock.
</p>

<a href="/products"
class="text-blue-500 hover:underline">
Go to Products
</a>
</div>
@endcan


{{-- SALES --}}
@can('create sales')
<div class="bg-white shadow p-6 rounded">
<h2 class="font-semibold text-lg mb-2">
Sales
</h2>

<p class="text-gray-600 mb-4">
Record and view sales transactions.
</p>

<a href="/sales"
class="text-green-500 hover:underline">
Go to Sales
</a>
</div>
@endcan


{{-- PURCHASES --}}
@can('create purchases')
<div class="bg-white shadow p-6 rounded">
<h2 class="font-semibold text-lg mb-2">
Purchases
</h2>

<p class="text-gray-600 mb-4">
Add inventory purchases.
</p>

<a href="/purchases"
class="text-indigo-500 hover:underline">
Go to Purchases
</a>
</div>
@endcan


{{-- ANALYTICS --}}
@can('view analytics')
<div class="bg-white shadow p-6 rounded">
<h2 class="font-semibold text-lg mb-2">
Analytics
</h2>

<p class="text-gray-600 mb-4">
View sales reports and trends.
</p>

<a href="/analytics"
class="text-yellow-600 hover:underline">
View Analytics
</a>
</div>
@endcan


{{-- PROFIT --}}
@can('view profit reports')
<div class="bg-white shadow p-6 rounded">
<h2 class="font-semibold text-lg mb-2">
Profit Reports
</h2>

<p class="text-gray-600 mb-4">
Check shop profit performance.
</p>

<a href="/profit"
class="text-purple-600 hover:underline">
View Profit
</a>
</div>
@endcan


{{-- USER MANAGEMENT --}}
@can('manage users')
<div class="bg-white shadow p-6 rounded">
<h2 class="font-semibold text-lg mb-2">User Management</h2>
<p class="text-gray-600 mb-4">Create and manage users and roles.</p>
<a href="/users" class="text-red-600 hover:underline">Manage Users</a>
</div>
@endcan


</div>

</div>

</x-app-layout>