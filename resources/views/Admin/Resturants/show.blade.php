@extends('layouts.master')
@section('css')
@endsection
@section('title')
    Restrants Management - Resturant Details
@stop
@section('content')
    <div class="container-fluid">


        <div class="row page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Details</a></li>
                <li class="breadcrumb-item"><a href="javascript:void(0)">Resturants</a></li>
            </ol>
        </div>
        <!-- row -->
        <div class="row">


            <div class="col-lg-12">
                <div class="profile card card-body px-3 pt-3 pb-0">
                    <div class="profile-head">
                        <div class="col-xl-12">
                            <div class="card">
                                <div class="card-body p-4">
                                    <h4 class="card-intro-title mb-4">Resturant Details</h4>
                                    <div class="bootstrap-carousel">
                                        <div id="carouselExampleIndicators2" class="carousel slide" data-bs-ride="carousel">
                                            <div class="carousel-indicators">
                                                @php $counter = 0; @endphp
                                                @foreach ($Resturant->images as $image)
                                                    <button type="button" data-bs-target="#carouselExampleIndicators"
                                                        data-bs-slide-to="{{ $counter }}"
                                                        class="{{ $counter === 0 ? 'active' : '' }}"
                                                        aria-label="Slide {{ $counter + 1 }}"></button>
                                                    @php $counter++; @endphp
                                                @endforeach
                                            </div>
                                            <div class="carousel-inner">
                                                @php $counter = 0; @endphp
                                                @foreach ($Resturant->images as $image)
                                                    <div class="carousel-item {{ $counter === 0 ? 'active' : '' }}">
                                                        <img class="d-block w-100"
                                                            src="{{ asset('attachments/resturants/' . $Resturant->name . '/' . $image->filename) }}"
                                                            alt="Slide {{ $counter + 1 }}">
                                                    </div>
                                                    @php $counter++; @endphp
                                                @endforeach
                                            </div>
                                            <button class="carousel-control-prev" type="button"
                                                data-bs-target="#carouselExampleIndicators2" data-bs-slide="prev">
                                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                <span class="visually-hidden">Previous</span>
                                            </button>
                                            <button class="carousel-control-next" type="button"
                                                data-bs-target="#carouselExampleIndicators2" data-bs-slide="next">
                                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                <span class="visually-hidden">Next</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="profile-info">
                            <div class="media pt-3 pb-3">
                                @foreach ($Resturant->images as $image)
                                    @if ($image->type === 'logo')
                                        <img src="{{ asset('attachments/resturants/' . $Resturant->name . '/' . $image->filename) }}"
                                            alt="image" class="me-3 rounded" width="75">
                                    @endif
                                @endforeach

                                <div class="media-body">
                                    <h5 class="m-b-5">
                                        <a href="post-details.html" class="text-black">{{ $Resturant->staff->name }}</a>
                                    </h5>
                                    <p class="mb-0">
                                        {{ $Resturant->staff->email }}
                                    </p>
                                </div>
                            </div>
                            <div class="profile-details">
                                <div class="profile-name px-3 pt-2">
                                    <h4 class="text-primary mb-0"></h4>
                                    <p></p>
                                </div>
                                <div class="profile-email px-2 pt-2">
                                    <h4 class="text-muted mb-0"></h4>
                                    <p></p>
                                </div>
                                <div class="dropdown ms-auto">
                                    <div class="mt-4">
                                        @can('Crud Resturants')
                                        <a href="{{ route('resturants.edit', $Resturant->id) }}"
                                            class="btn btn-primary mb-1 me-1">Edit</a>
                                            @endcan
                                        <a href="{{ route('resturant_reservations', $Resturant->id) }}"
                                            class="btn btn-primary mb-1">Reservations Details</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">

            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <div class="profile-tab">
                            <div class="custom-tab-1">
                                <ul class="nav nav-tabs">
                                    <li class="nav-item"><a href="#resturant" data-bs-toggle="tab"
                                            class="nav-link active show">Resturant</a>
                                    </li>
                                    <li class="nav-item"><a href="#location" data-bs-toggle="tab"
                                            class="nav-link">Location</a>
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    <div id="resturant" class="tab-pane fade active show">
                                        <div class="profile-about-me">
                                            <div class="pt-4 border-bottom-1 pb-3">
                                                <h4 class="text-primary">About Me</h4>
                                                <p class="mb-2">{{ $Resturant->description }}</p>
                                            </div>
                                        </div>
                                        <div class="profile-about-me">
                                            <div class="pt-4 border-bottom-1 pb-3">
                                                <h4 class="text-primary">{{ $Resturant->cuisine->name }}</h4>
                                                <p class="mb-2">{{ $Resturant->cuisine->desc }} </p>
                                            </div>
                                        </div>


                                        <div class="profile-skills mb-5">
                                            <h4 class="text-primary mb-2">Menu</h4>
                                            @forelse($Resturant->menu as $men)
                                                <a href="javascript:void(0);" class="btn btn-primary light btn-xs mb-1">
                                                    {{ $men->name }} : {{ $men->price }}
                                                </a>
                                            @empty
                                            @endforelse

                                        </div>
                                        <div class="profile-personal-info">
                                            <h4 class="text-primary mb-4">Contact Information</h4>
                                            <div class="row mb-2">
                                                <div class="col-sm-3 col-5">
                                                    <h5 class="f-w-500">Name <span class="pull-end">:</span>
                                                    </h5>
                                                </div>
                                                <div class="col-sm-9 col-7"><span>{{ $Resturant->name }}</span>
                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col-sm-3 col-5">
                                                    <h5 class="f-w-500">location <span class="pull-end">:</span>
                                                    </h5>
                                                </div>
                                                <div class="col-sm-9 col-7"><span>{{ $Resturant->location->state }}</span>
                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col-sm-3 col-5">
                                                    <h5 class="f-w-500">Activation_start <span class="pull-end">:</span>
                                                    </h5>
                                                </div>
                                                <div class="col-sm-9 col-7">
                                                    <span>{{ $Resturant->Activation_start }}</span>
                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col-sm-3 col-5">
                                                    <h5 class="f-w-500">Activation_end <span class="pull-end">:</span>
                                                    </h5>
                                                </div>
                                                <div class="col-sm-9 col-7"><span>{{ $Resturant->Activation_end }}</span>
                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col-sm-3 col-5">
                                                    <h5 class="f-w-500">phone_number <span class="pull-end">:</span></h5>
                                                </div>
                                                <div class="col-sm-9 col-7"><span>{{ $Resturant->phone_number }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="location" class="tab-pane fade  ">
                                        <div class="profile-personal-info">
                                            <div class="pt-4 border-bottom-1 pb-3">
                                                <h4 class="text-primary">Location</h4>

                                            </div>




                                            <div class="row mb-2">
                                                <div class="col-sm-3 col-5">
                                                    <h5 class="f-w-500">State <span class="pull-end">:</span>
                                                    </h5>
                                                </div>
                                                <div class="col-sm-9 col-7"><span>{{ $Resturant->location->state }}</span>
                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col-sm-3 col-5">
                                                    <h5 class="f-w-500">Text(details)<span class="pull-end">:</span>
                                                    </h5>
                                                </div>
                                                <div class="col-sm-9 col-7"><span>{{ $Resturant->location->text }}</span>
                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col-sm-3 col-5">
                                                    <h5 class="f-w-500">Latitude <span class="pull-end">:</span>
                                                    </h5>
                                                </div>
                                                <div class="col-sm-9 col-7">
                                                    <span>{{ $Resturant->location->latitude }}</span>
                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col-sm-3 col-5">
                                                    <h5 class="f-w-500">Longitude<span class="pull-end">:</span>
                                                    </h5>
                                                </div>
                                                <div class="col-sm-9 col-7">
                                                    <span>{{ $Resturant->location->longitude }}</span>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="card-body">
                                            <div id="map" style="height: 450px;"></div>
                                        </div>




                                    </div>

                                </div>
                            </div>
                            <!-- Modal -->
                            <div class="modal fade" id="replyModal">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Post Reply</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form>
                                                <textarea class="form-control" rows="4">Message</textarea>
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-danger light"
                                                data-bs-dismiss="modal">btn-close</button>
                                            <button type="button" class="btn btn-primary">Reply</button>
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


    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet-providers"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var map = L.map('map').setView([{{ $Resturant->location->latitude }},
                {{ $Resturant->location->longitude }}
            ], 10);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);
            // استخدام مزود القمر الصناعي
            L.tileLayer.provider('Esri.WorldImagery').addTo(map);

            L.marker([{{ $Resturant->location->latitude }}, {{ $Resturant->location->longitude }}]).addTo(map);
        });
    </script>
@endsection
@section('js')
@endsection
