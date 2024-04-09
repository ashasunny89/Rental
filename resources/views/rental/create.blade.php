<!-- resources/views/suites/create.blade.php -->


@extends('layouts.app', ['title' => __('User Profile')])

@section('content')

@include('users.partials.header', [
    'title' => __(''),
    'description' => __(''),
    'class' => 'col-lg-12'
])   
<div class="container-fluid mt--7">
<div class="row">
<div class="col-xl-12 mb-5 mb-xl-6">
    <div class="card shadow">
        <div class="card-header border-0">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="mb-0">Add Rent Details</h3>
                    
                </div>
                <a class="btn bg-gradient-white  mx-3" href="{{route('suit_pieces.create')}}">
                    <i class="material-icons text-sm"></i>&nbsp;&nbsp;Add New Item
                </a>
            </div>
        </div>
       
        <div class="table-responsive">
            <!-- Projects table -->
          
            @if(Session::has('success'))
            <div class="alert alert-success" role="alert">
                {{Session::get('success')}}
            </div>
            @endif
            <div class="container">
               
               <!-- Rental creation form -->
            <form action="{{ route('rental.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="customer_name">Customer Name:</label>
                    <input type="text" name="customer_name" id="customer_name" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="customer_address">Customer Address:</label>
                    <textarea name="customer_address" id="customer_address" class="form-control" required></textarea>
                </div>
                <div class="form-group">
                    <label for="phone1">Phone 1:</label>
                    <input type="text" name="phone1" id="phone1" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="phone2">Phone 2:</label>
                    <input type="text" name="phone2" id="phone2" class="form-control">
                </div>
                <div class="form-group">
                    <label for="rental_date">Rental Date:</label>
                    <input type="date" name="rental_date" id="rental_date" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="return_date">Return Date:</label>
                    <input type="date" name="return_date" id="return_date" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="advanced_amount">Advance Amount:</label>
                    <input type="number" name="advanced_amount" id="advanced_amount" class="form-control" required>
                </div>
                <div class="form-group">
                                <div id="suit-piece-rows">
                                    <!-- Initial row for selecting suit piece and price -->
                                    <div class="form-row suit-piece-row">
                                        <div class="col">
                                            <div class="form-group">
                                            <select name="suit_pieces[]" id="suit_pieces" class="form-control"  required>
                                                    @foreach ($suitPieces as $suitPiece)
                                                        <option value="{{ $suitPiece->id }}">{{ $suitPiece->name.' '.$suitPiece->size }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                                                                </div>
                                        <div class="col">
                                            <input type="number" name="price[]" class="form-control price" placeholder="Price" required><br>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button type="button" class="btn btn-primary" id="add-suit-piece">Add More</button>
                            <div class="form-group">
                                <label for="total_rent">Total Rent:</label>
                                <input type="text" name="total_rent" id="total_rent" class="form-control" readonly>
                            </div>
                            <div class="form-group">
                                <label for="total_amount">Total Amount:</label>
                                <input type="text" name="total_amount" id="total_amount" class="form-control" readonly>
                            </div>
                            <div class="form-group">
                                <label for="discount">Discount:</label>
                                <input type="number" name="discount" id="discount" class="form-control">
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('layouts.footers.auth')

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script><script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>



<script>
    $(document).ready(function() {
        // Event listener for "Add More" button
        $('#add-suit-piece').click(function() {
            // Clone the last suit piece row
            var newRow = $('#suit-piece-rows .suit-piece-row:last').clone();

            // Clear the input values in the new row
            newRow.find('input').val('');

            // Append the new row to the container
            $('#suit-piece-rows').append(newRow);
        });
        $('#suit-piece-rows').on('change', '.price, #discount', function() {
            var totalAmount = 0;
            $('.price').each(function() {
                totalAmount += parseFloat($(this).val()) || 0;
            });
            
            $('#total_rent').val(totalAmount.toFixed(2));
            var advancedAmount = parseFloat($('#advanced_amount').val()) || 0;
            var discount =  parseFloat($('#discount').val()) || 0;
            var discountedAmount = totalAmount - discount  + advancedAmount;
          
            $('#total_amount').val(discountedAmount.toFixed(2));
        });
        
        $('#advanced_amount').on('change', function() {
            var totalAmount =  $('#total_rent').val() || 0;
            var advancedAmount = parseFloat($('#advanced_amount').val()) || 0;
            var discount =  parseFloat($('#discount').val()) || 0;
            var discountedAmount = totalAmount - discount  + advancedAmount;
          
            $('#total_amount').val(discountedAmount.toFixed(2));
        });

        $('#discount').on('change', function() {
            var totalAmount =  $('#total_rent').val() || 0;
            var discount =  parseFloat($('#discount').val()) || 0;
            var advancedAmount = parseFloat($('#advanced_amount').val()) || 0;
            var discountedAmount = totalAmount - discount  + advancedAmount;
        
            $('#total_amount').val(discountedAmount.toFixed(2));
        });
    });
</script>

@endsection