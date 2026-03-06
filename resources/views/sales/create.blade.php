<!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
.select2-container {
    width: 350px !important;
}

.select2-dropdown {
    margin: auto;
}

.select2-search__field {
    text-align: center;
}
.quantity-box label {
    font-weight: bold;
}
</style>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<h2>Log Sale</h2> 

@if(session('error'))
    <p style="color:red">{{ session('error') }}</p>
@endif

@if(session('success'))
    <p style="color:green">{{ session('success') }}</p>
@endif

@if ($errors->any())
    <div style="color:red">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('sales.store') }}" method="POST">
    @csrf
    <!-- Add this line -->
    <input type="hidden" name="source" value="{{ $source ?? '' }}">

   <label for="product_id">Products:</label>
<select name="product_id[]" id="product_id" multiple required>
    @foreach($products->sortBy('name') as $product)
        <option value="{{ $product->id }}" data-name="{{ $product->name }}">
            {{ $product->name }} (Stock: {{ $product->quantity }}, Price: {{ number_format($product->price, 2) }})
        </option>
    @endforeach
</select>

<div id="quantity-container"></div>

<br>
<button type="submit">Record Sale</button>

<script>
$(document).ready(function() {
    $('#product_id').select2({
        placeholder: "Search and select products...",
        width: '350px'
    });

    $('#product_id').on('change', function() {
        $('#quantity-container').html(''); // clear old inputs
        let selected = $(this).val();
        if(selected) {
            selected.forEach(function(id) {
                let option = $('#product_id option[value="'+id+'"]');
                let name = option.data('name');
                $('#quantity-container').append(`
                    <label>${name} Quantity:</label>
                    <input type="number" name="quantity_sold[${id}]" value="1" min="1" required>
                    <br><br>
                `);
            });
        }
    });
});
</script>