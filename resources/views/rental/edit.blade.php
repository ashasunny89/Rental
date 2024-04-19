<!-- resources/views/suites/create.blade.php -->


@extends('layouts.app', ['title' => __('User Profile')])

@section('content')

@include('users.partials.header', [
    'title' => __(''),
    'description' => __(''),
    'class' => 'col-lg-12'
])   <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
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
                                <form action="{{ route('rental.update',$rental->id ) }}" method="POST" id="rentalForm">
                                    @csrf
                                    @method('PUT')
                                    <div class="form-group">
                                        <label for="customer_name">Customer Name:</label>
                                        <input type="text" name="customer_name" id="customer_name" value={{$rental->customer_name}}  class="form-control" required>
                                        @error('customer_name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="customer_address">Customer Address:</label>
                                        <textarea name="customer_address" id="customer_address"  class="form-control" required>{{$rental->customer_address}}</textarea>
                                        @error('customer_address')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="phone1">Phone 1:</label>
                                        <input type="text" name="phone1" id="phone1" value={{$rental->phone1}}  class="form-control" required>
                                        @error('phone1')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="phone2">Phone 2:</label>
                                        <input type="text" name="phone2" id="phone2" value={{$rental->phone2}}  class="form-control">
                                        @error('phone2')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-row ">
                                        <div class="col">
                                            <div class="form-group">
                                                <label for="rental_date">Rental Date:</label>
                                                <input type="date" name="rental_date" id="rental_date" value={{$rental->rental_date}}  class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-group">
                                                <label for="return_date">Return Date:</label>
                                                <input type="date" name="return_date" id="return_date" value={{$rental->return_date}}  class="form-control" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="advanced_amount">Advance Amount:</label>
                                        <input type="number" name="advanced_amount" id="advanced_amount" value={{$rental->advanced_amount}}   class="form-control" required>
                                        @error('advanced_amount')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col">
                                   

                                    <div id="suit_piece_fields">    
                                    @foreach ($selectedSuitPieces as $selectedSuitPiece)
    <div class="form-row suit-piece-row">
        <div class="col">
            <div class="form-group">
                <select name="suit_pieces[]" class="form-control suit_piece" required>
                    @foreach ($suitPieces as $suitPiece)
                        <option value="{{ $suitPiece->id }}" 
                        {{ $selectedSuitPiece->id === $suitPiece->id ? 'selected' : '' }}
                            data-price="{{ $suitPiece->price }}">
                            {{ $suitPiece->name . ' ' . $suitPiece->size }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col">
            <input type="number" name="price[]" class="form-control price" value="{{ $selectedSuitPiece->pivot->price }}" placeholder="Price" required>
        </div>
        <div class="col">
            <button type="button" class="btn btn-danger remove-field">Remove</button>
        </div>
    </div>
@endforeach
                  
                                    </div>
                                    <div class="col">
                                        <button type="button" class="btn btn-primary add-more">Add Items</button>
                                    </div>
                                    <div class="form-group">
                                            <label for="total_rent">Total Rent:</label>
                                            <input type="text" name="total_rent" value={{$rental->total_rent}} id="total_rent" class="form-control" readonly>
                                            @error('total_rent')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                    </div>
                                    <div class="form-group">
                                            <label for="total_amount">Total Amount:</label>
                                            <input type="text" name="total_amount" value={{$rental->total_amount}} id="total_amount" class="form-control" readonly>
                                            @error('total_amount')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                    </div>
                                    <div class="form-group">
                                            <label for="discount">Discount:</label>
                                            <input type="number" name="discount"  id="discount" value={{$rental->discount}} class="form-control">
                                            @error('discount')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                    </div>
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('layouts.footers.auth')

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

<script>
    document.getElementById('rentalForm').addEventListener('submit', function(event) {
        var phone1 = document.getElementById('phone1').value;
        var phone2 = document.getElementById('phone2').value;
        var rentalDate = new Date(document.getElementById('rental_date').value);
        var currentDate = new Date();
        
        if (phone1 === phone2) {
            alert('Phone 1 and Phone 2 cannot have the same value.');
            event.preventDefault();
            return
        }

        // Extract the date part of the rental date and current date
        var rentalDateOnly = new Date(rentalDate.getFullYear(), rentalDate.getMonth(), rentalDate.getDate());
        var currentDateOnly = new Date(currentDate.getFullYear(), currentDate.getMonth(), currentDate.getDate());

        if (rentalDateOnly < currentDateOnly) {
            alert('Rental Date cannot be a past date.');
            event.preventDefault();
            return
        }
        // Check if suit pieces are selected
        var suitPieceDropdowns = document.querySelectorAll('.suit_piece');
        if (suitPieceDropdowns.length === 0) {
            alert('Please add at least one suit piece.');
            event.preventDefault(); 
            return; // Stop further processing
        }
    });
</script>


<script>
    $(document).ready(function() {
        var firstOptionPrice = $('#suit_pieces option:first').data('price');
        $('#price').val(firstOptionPrice);

        
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

        $('#suit_pieces_0').change(function() {
            var selectedOption = $(this).find(':selected');
            var price = selectedOption.data('price');
         
            $(this).closest('.suit-piece-row').find('.price').val(price);
            
        });
    

        var suitPieceCount = 1;  // Keep track of the number of suit piece/price fields

            // Function to create a new suit piece/price field
            function createSuitPieceField() {
               
                var newField = `
                <div class="form-row suit-piece-row">
                    <div class="col">
                        <div class="form-group">
                            <select name="suit_pieces[]" id="suit_pieces_${suitPieceCount}" class="form-control suit_piece" required>
                                @foreach ($suitPieces as $suitPiece)
                                    <option value="{{ $suitPiece->id }}" data-price="{{ $suitPiece->price }}">{{ $suitPiece->name . ' ' . $suitPiece->size }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col">
                        
                            <input type="number" id="price_${suitPieceCount}" name="price[]" class="form-control price" placeholder="Price" required>
                    
                    </div>
                    <div class="col">
                        <button type="button" class="btn btn-danger remove-field">Remove</button>
                    </div>
                </div>
                `;

                suitPieceCount++;  // Increment the count for the next field
                return newField;
            }

            // Handle "Add More" button click
            $(".add-more").click(function() {
                var newField = createSuitPieceField();
                $("#suit_piece_fields").append(newField);

                // Update price on suit piece selection for the newly added field
                $(".suit_piece").last().change(function() {
                    var selectedPrice = $(this).find(":selected").data("price");
                    var correspondingPriceField = $(this).closest(".col").next().find(".price");
                    correspondingPriceField.val(selectedPrice);
                    $(this).find(":selected").data("price");
                    calculateTotalAmount();
                });
            });

            // Handle "Remove" button click (optional)
            $(document).on("click", ".remove-field", function() {
                $(this).closest(".col").parent().remove();
                calculateTotalAmount();
            });
            $(document).on("click", ".remove-suit-piece", function() {
                $(this).parent().remove(); // Remove the suit piece from the list
                calculateTotalAmount();
            });


            // Delegate change event for dynamically added fields
            $('#suit_piece_fields').on('change', '.price, #discount', function() {
                
                    calculateTotalAmount();
                });


            // Function to calculate total amount
            function calculateTotalAmount() {
                var totalAmount = 0;
                $('.price').each(function() {
                    totalAmount += parseFloat($(this).val()) || 0;
                });

                var advancedAmount = parseFloat($('#advanced_amount').val()) || 0;
                var discount = parseFloat($('#discount').val()) || 0;
                var discountedAmount = totalAmount - discount + advancedAmount;

                $('#total_rent').val(totalAmount.toFixed(2));
                $('#total_amount').val(discountedAmount.toFixed(2));
            }
            // calculateTotalAmount();



            $('#suit_piece_fields').on('change', '.suit_piece', function() {
               
                var suitPieceId = $(this).val();
                var rentalDate = $('#rental_date').val();
                var returnDate = $('#return_date').val();

                // Make an AJAX request to check booking availability
                $.ajax({
                    url: "{{ route('checkAvailability') }}",
                    type: "POST",
                    data: {
                        suit_piece_id: suitPieceId,
                        rental_date: rentalDate,
                        return_date: returnDate,
                        _token: $('#token').val()
                    },
                    success: function(response) {
                        console.log(response.data);
                        if (response.data.available === false) {
                            // Construct message with booked dates
                            var message = "The selected suit piece is not available for the specified dates. Booked on:\n";
                            response.data.rental_dates.forEach(function(date) {
                                message += date.rental_date + ' to ' + date.return_date + '\n';
                            });
                            alert(message);
                        } else {
                            // Show message for availability
                            // alert('The selected suit piece is available for the specified dates.');
                        }
                    },
                    error: function(xhr, status, error) {
                        alert(`Error: ${error}, Status: ${status}, XHR: ${xhr.responseText}`);
                        // Handle AJAX errors
                        console.error(error);
                    }
                });
            });
    });


   
</script>

@endsection