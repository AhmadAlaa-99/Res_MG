@extends('layouts.master')
@section('css')
    <style>
        .badge-rounded {
            border-radius: 20px;
            padding: 10px 23px;
            margin: 3px;
            /* size: 32px; */
        }
    </style>
@endsection
@section('title')
    Restrants Management - Reservation Details
@stop
@section('content')
    <div class="container-fluid">
        <div class="row page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Reservations</a></li>
                <li class="breadcrumb-item"><a href="javascript:void(0)">Details</a></li>
            </ol>
        </div>
        <div class="row">
            <div class="col-lg-12">

                <div class="card mt-3">
                    <div class="card-header">
                        <span class="badge badge-pill badge-secondary">Details </span>

                        <span class="badge light badge-secondary">
                            <strong>
                                Time : {{ $reservation->reservation_time ?? '-' }}
                            </strong>
                        </span>
                        <a id="statusBadge_{{ $reservation->id }}" href="javascript:void(0)"  class="float-end badge badge-rounded badge-outline-danger">
                            <strong>Status:</strong> {{ $reservation->status ?? '-' }}</a>


                    </div>
                    <div class="card-body">
                        <div class="row mb-5">
                            <div class="mt-4 col-xl-3 col-lg-3 col-md-6 col-sm-12">
                                <h6>User:</h6>


                                <div>
                                    <a href="javascript:void(0)" class="badge badge-rounded badge-danger">
                                        <strong>
                                            Name: {{ $reservation->user->name ?? '-' }}

                                        </strong>
                                    </a>

                                </div>

                                <div>
                                    <a href="javascript:void(0)" class="badge badge-rounded badge-danger">
                                        <strong>
                                            Email: {{ $reservation->user->email ?? '-' }}
                                        </strong>
                                    </a>
                                </div>


                                <div>
                                    <a href="javascript:void(0)" class="badge badge-rounded badge-danger">
                                        <strong>
                                            Phone: {{ $reservation->user->phone ?? '-' }}
                                        </strong>
                                    </a>


                                </div>

                                <div>
                                    <a href="javascript:void(0)" class="badge badge-rounded badge-danger">
                                        <strong>special
                                            requests: {{ $reservation->speacial_request ?? '-' }}
                                        </strong></a>


                                </div>

                                <div>
                                    <a href="javascript:void(0)" class="badge badge-rounded badge-danger">
                                        <strong> party size:
                                            {{ $reservation->party_size ?? '-' }}

                                        </strong></a>

                                </div>



                            </div>
                            <div class="mt-4 col-xl-3 col-lg-3 col-md-6 col-sm-12">
                                <h6>Table:</h6>



                                <div>
                                    <a href="javascript:void(0)" class="badge badge-rounded badge-danger">
                                        <strong>
                                            number : {{ $reservation->table->number ?? '-' }}
                                        </strong>
                                    </a>

                                </div>
                                <div>
                                    <a href="javascript:void(0)" class="badge badge-rounded badge-danger">
                                        <strong>
                                            seating config : {{ $reservation->table->seating_configuration ?? '-' }}
                                        </strong>
                                    </a>

                                </div>
                                <div>
                                    <a href="javascript:void(0)" class="badge badge-rounded badge-danger">
                                        <strong>
                                            capacity : {{ $reservation->table->capacity ?? '-' }}
                                        </strong>
                                    </a>

                                </div>

                            </div>
                            <div class="mt-4 col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                <div class="col-xl-12 col-xxl-12">
                                    <div class="row">
                                        <div class="col-xl-12 col-xxl-12 col-lg-5 col-sm-6">
                                            <div class="card bg-blue action-card">
                                                <div class="card-body text-white">
                                                    <img src="images/pattern/circle.png" class="mb-4" alt="">
                                                    {{-- <h2 class="text-white fs-36">$824,571.93</h2>
                                                    <p class="fs-16">Wallet Balance</p> --}}
                                                
                                                    <div class="ic-card">
                                                        @if ($reservation->status == 'next' || $reservation->status == 'scheduled')
                                                        <a id="startButton_{{ $reservation->id }}"
                                                            onclick="startReservation({{ $reservation->id }})">
                                                            <i class="bg-danger">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="currentColor" 
                                                                class="bi bi-play" viewBox="0 0 16 16">
                                                                    <path d="M10.804 8 5 4.633v6.734L10.804 8zm.792-.696a.802.802 0 0 1 0 1.392l-6.363 3.692C4.713 12.69 4 12.345 4 11.692V4.308c0-.653.713-.998 1.233-.696l6.363 3.692z"/>
                                                                  </svg>
                                                            </i>
                                                            <span>Start</span>
                                                        </a>
                                                        @endif
                                                     
                                                        
                                                        @if ($reservation->status == 'current')
                                                        <a id="endButton_{{ $reservation->id }}"
                                                            onclick="endReservation({{ $reservation->id }})">
                                                            <i class="bg-success">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="currentColor" 
                                                                class="bi bi-x-octagon" viewBox="0 0 16 16">
                                                                    <path d="M4.54.146A.5.5 0 0 1 4.893 0h6.214a.5.5 0 0 1 .353.146l4.394 4.394a.5.5 0 0 1 .146.353v6.214a.5.5 0 0 1-.146.353l-4.394 4.394a.5.5 0 0 1-.353.146H4.893a.5.5 0 0 1-.353-.146L.146 11.46A.5.5 0 0 1 0 11.107V4.893a.5.5 0 0 1 .146-.353L4.54.146zM5.1 1 1 5.1v5.8L5.1 15h5.8l4.1-4.1V5.1L10.9 1H5.1z"/>
                                                                    <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
                                                                  </svg>
                                                            </i>
                                                            <span>End</span>
                                                        </a>
                                                          @endif
                                                          <a id="endButton_{{ $reservation->id }}" style="display: none"
                                                            onclick="endReservation({{ $reservation->id }})">
                                                            <i class="bg-success">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="currentColor" 
                                                                class="bi bi-x-octagon" viewBox="0 0 16 16">
                                                                    <path d="M4.54.146A.5.5 0 0 1 4.893 0h6.214a.5.5 0 0 1 .353.146l4.394 4.394a.5.5 0 0 1 .146.353v6.214a.5.5 0 0 1-.146.353l-4.394 4.394a.5.5 0 0 1-.353.146H4.893a.5.5 0 0 1-.353-.146L.146 11.46A.5.5 0 0 1 0 11.107V4.893a.5.5 0 0 1 .146-.353L4.54.146zM5.1 1 1 5.1v5.8L5.1 15h5.8l4.1-4.1V5.1L10.9 1H5.1z"/>
                                                                    <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
                                                                  </svg>
                                                            </i>
                                                            <span>End</span>
                                                        </a>
                                                      


                                                      
                                                    
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    
                                    </div>
                                </div>

                            </div>
                        </div>
                 


                    </div>

                </div>
            </div>
        </div>
    </div>
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
     function startReservation(id) {
    $.ajax({
        url: "{{ route('reservations_start_ajax', ':id') }}".replace(':id', id),
        method: 'GET',
        success: function(response) {
            $('#startButton_'+id).hide();

            $('#reservationStatus_'+id).text('current');
            $('#endButton_' + id).show(); // إظهار زر الانتهاء بعد تحديث الحالة
            $('#statusBadge_' + id).text('Status: current');
            document.getElementById("endButton_" + reservationId).style.display = "";
        
        },
        error: function(error) {
            alert('An error occurred');
            console.log(error);
        }
    });
}
</script>
<script>
function endReservation(id) {
    $.ajax({
        url: "{{ route('reservations_end_ajax', ':id') }}".replace(':id', id),
        method: 'GET',
        success: function(response) {
            $('#endButton_' + id).hide();
            $('#reservationStatus_'+id).text('finite');
            $('#statusBadge_' + id).text('Status: finite'); // تحديث نص الحالة إلى "finite" 
        },
        error: function(error) {
            alert('An error occurred');
            console.log(error);
        }
    });
}
    </script>
@endsection
@section('js')
@endsection
