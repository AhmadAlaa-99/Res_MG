@extends('layouts.master')
@section('css')
@endsection
@section('title')
    Restrants Management - Resturant Add
@stop
@section('content')
    <div class="container-fluid">
        <div class="row page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Add</a></li>
                <li class="breadcrumb-item"><a href="javascript:void(0)">Resturants</a></li>
            </ol>
        </div>
        <!-- row -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Resturant Add</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-validation">
                            <form method="post" action="{{ route('resturants.store') }}" autocomplete="off"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-xl-6">
                                        <div class="mb-3 row">
                                            <label class="col-lg-4 col-form-label" for="validationCustom01">Username
                                                <span class="text-danger">*</span>
                                            </label>
                                            <div class="col-lg-6">
                                                <input type="text" class="form-control" id="validationCustom01"
                                                    placeholder="Enter a username.." value="testname"name="user_name"
                                                    required="">
                                                @error('user_name')
                                                    <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror
                                                <div class="invalid-feedback">
                                                    Please enter a username.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label class="col-lg-4 col-form-label" for="validationCustom02">Email <span
                                                    class="text-danger">*</span>
                                            </label>
                                            <div class="col-lg-6">
                                                <input type="text" class="form-control" name="email"
                                                    id="validationCustom02" value="testname@gmail.com"
                                                    placeholder="Your valid email.." required="">
                                                @error('email')
                                                    <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror
                                                <div class="invalid-feedback">
                                                    Please enter a Email.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label class="col-lg-4 col-form-label" for="validationCustom03">Password
                                                <span class="text-danger">*</span>
                                            </label>
                                            <div class="col-lg-6">
                                                <input type="password" name="password" class="form-control"
                                                    id="validationCustom03" placeholder="Choose a safe one.."
                                                    required="">
                                                @error('password')
                                                    <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror
                                                <div class="invalid-feedback">
                                                    Please enter a password.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label class="col-lg-4 col-form-label" for="validationCustom08">Phone (SY)
                                                <span class="text-danger">*</span>
                                            </label>
                                            <div class="col-lg-6">
                                                <input type="text" class="form-control" id="validationCustom08"
                                                    placeholder="963-9376-07234" value="0976768877"name="user_phone"
                                                    required="">
                                                @error('user_phone')
                                                    <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror
                                                <div class="invalid-feedback">
                                                    Please enter a user_phone no.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label class="col-lg-4 col-form-label" for="validationCustom08">State
                                                <span class="text-danger">*</span>
                                            </label>
                                            <div class="col-lg-6">

                                                <select class="default-select wide form-control" name="state"
                                                    id="validationCustom05">
                                                    <option data-display="Select">Please select</option>
                                                    <option selected value="Damascus">Damascus</option>
                                                    <option value="Homs">Homs</option>
                                                    <option value="Lattakia">Lattakia</option>
                                                    <option value="Aleppo">Aleppo</option>
                                                    <option value="Tartus">Tartus</option>
                                                    <option value="As-suwayda">As-suwayda</option>
                                                </select>

                                                @error('state')
                                                    <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror
                                                <div class="invalid-feedback">
                                                    Please enter a state.
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mb-3 row">
                                            <label class="col-lg-4 col-form-label" for="validationCustom08">Location (TEXT)
                                                <span class="text-danger">*</span>
                                            </label>
                                            <div class="col-lg-6">
                                                <input type="text" class="form-control" id="validationCustom08"
                                                    placeholder="location details" value="testlocation" name="location"
                                                    required="">
                                                @error('location')
                                                    <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror
                                                <div class="invalid-feedback">
                                                    Please enter a location.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label class="col-lg-4 col-form-label" for="validationCustom08">Latitude
                                                <span class="text-danger">*</span>
                                            </label>
                                            <div class="col-lg-6">
                                                <input type="text" class="form-control" id="latitude"
                                                    placeholder="latitude" value="0.0"name="latitude" required="">
                                                @error('latitude')
                                                    <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror
                                                <div class="invalid-feedback">
                                                    Please enter a latitude.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label class="col-lg-4 col-form-label" for="validationCustom08">Longitude
                                                <span class="text-danger">*</span>
                                            </label>
                                            <div class="col-lg-6">
                                                <input type="text" name="longitude" id="longitude"
                                                    class="form-control" value="0.0" placeholder="longitude"
                                                    required="">
                                                @error('longitude')
                                                    <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror

                                                <div class="invalid-feedback">
                                                    Please enter a longitude.
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="col-xl-6">
                                        <div class="mb-3 row">
                                            <label class="col-lg-4 col-form-label" for="validationCustom06">Resturant Name
                                                <span class="text-danger">*</span>
                                            </label>
                                            <div class="col-lg-6">
                                                <input type="text" name="resturant_name" class="form-control"
                                                    id="validationCustom06"
                                                    value="test_resname"placeholder="resturant_name" required>
                                                <div class="invalid-feedback">
                                                    @error('resturant_name')
                                                        <div class="alert alert-danger">{{ $message }}</div>
                                                    @enderror
                                                    Please enter a name.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label class="col-lg-4 col-form-label" for="validationCustom08">Phone (SY)
                                                <span class="text-danger">*</span>
                                            </label>
                                            <div class="col-lg-6">
                                                <input type="text" class="form-control" id="validationCustom08"
                                                    placeholder="963-9376-07234" value="0999999999"
                                                    name="resturant_phone" required="">
                                                @error('resturant_phone')
                                                    <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror
                                                <div class="invalid-feedback">
                                                    Please enter a resturant_phone no.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label class="col-lg-4 col-form-label" for="validationCustom05"> Cuisine
                                                <span class="text-danger">*</span>
                                            </label>
                                            <div class="col-lg-6">
                                                <select class="default-select wide form-control" name="cuisine_id"
                                                    id="validationCustom05">
                                                    <option data-display="Select">Please select</option>
                                                    @foreach ($cuisins as $cuisin)
                                                        <option value="{{ $cuisin->id }}">{{ $cuisin->name }}</option>
                                                    @endforeach
                                                </select>
                                                @error('cuisine_id')
                                                    <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror
                                                <div class="invalid-feedback">
                                                    Please select a one.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label class="col-lg-4 col-form-label" for="validationCustom07">Description
                                                <span class="text-danger">*</span>
                                            </label>
                                            <div class="col-lg-6">
                                                <input type="text" value="desc"
                                                    name="description"class="form-control" id="validationCustom07"
                                                    placeholder="description" required="">
                                                @error('description')
                                                    <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror
                                                <div class="invalid-feedback">
                                                    Please enter a description.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label class="col-lg-4 col-form-label" for="validationCustom07">Deposite
                                                <span class="text-danger">*</span>
                                            </label>
                                            <div class="col-lg-6">
                                                <input type="number" value="15" name="deposite"class="form-control"
                                                    id="validationCustom07" placeholder="deposite" required="">
                                                @error('deposite')
                                                    <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror
                                                <div class="invalid-feedback">
                                                    Please enter a deposite.
                                                </div>
                                            </div>
                                        </div>
                                        <!-- <div class="mb-3 row">
                                                                            <label class="col-lg-4 col-form-label" for="validationCustom09">location <span
                                                                                    class="text-danger">*</span>
                                                                            </label>
                                                                            <div class="col-lg-6">
                                                                                <input type="text" class="form-control"name="location"
                                                                                    id="validationCustom09" placeholder="location" required="">
                                                                                @error('location')
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror
                                                                                <div class="invalid-feedback">
                                                                                    Please enter a location.
                                                                                </div>
                                                                            </div>
                                                                        </div> -->
                                        <div class="mb-3 row">
                                            <label class="col-lg-4 col-form-label"
                                                for="validationCustom09">Activation_start <span
                                                    class="text-danger">*</span>
                                            </label>
                                            <div class="col-lg-6">
                                                <input type="date" class="form-control"name="Activation_start"
                                                    id="validationCustom09" placeholder="Activation_start"
                                                    required="">
                                                @error('Activation_start')
                                                    <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror
                                                <div class="invalid-feedback">
                                                    Please enter a Activation_start.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label class="col-lg-4 col-form-label" for="validationCustom09">Activation_end
                                                <span class="text-danger">*</span>
                                            </label>
                                            <div class="col-lg-6">
                                                <input type="date" class="form-control"name="Activation_end"
                                                    id="validationCustom09" placeholder="Activation_end" required="">
                                                @error('Activation_end')
                                                    <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror
                                                <div class="invalid-feedback">
                                                    Please enter a Activation_end.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="input-group mb-3">
                                            <label class="col-lg-4 col-form-label"
                                                for="validationCustom09">Images(Craousal)
                                                <span class="text-danger">*</span>
                                            </label>
                                            <div class="col-lg-6">
                                                <input type="file" name="images[]" accept="images/*"
                                                    class="form-file-input form-control" multiple>
                                                @error('images')
                                                    <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror
                                                <div class="invalid-feedback">
                                                    Please enter a images.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="input-group mb-3">
                                            <label class="col-lg-4 col-form-label" for="validationCustom09">Image(Logo)
                                                <span class="text-danger">*</span>
                                            </label>
                                            <div class="col-lg-6">
                                                <input type="file" name="logo" accept="images/*"
                                                    class="form-file-input form-control">
                                                @error('logo')
                                                    <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror
                                                <div class="invalid-feedback">
                                                    Please enter a logo.
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-sm-6 col-12">
                                        <div id="map" style="height: 400px;     margin-bottom: 15px;"></div>
                                    </div>

                                </div>
                                <div class="col-xl-12">
                                    <div class="icons">
                                        @foreach ($icons as $icon)
                                            <div class="icon">
                                                <img src="{{ asset($icon->image) }}" alt="{{ $icon->name }}">
                                                <p>{{ $icon->name }}</p>
                                            




                                                <input type="checkbox" name="services[]"
                                                    value="{{ $icon->id }}">
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                
<style>
    .icons {
        display: flex;
        flex-wrap: wrap;
    }
    .icon {
        margin: 10px;
        text-align: center;
    }
</style>
                                <div class="col-xl-12">
                                    <style>
                                        .sub {
                                            display: inline-block;
                                        }
                                    </style>
                                    <div class="mb-6 row sub " style="color: black">
                                        <div class="col-lg-8 ms-auto">
                                            <button type="submit" name="action" value="more_add"
                                                class="btn btn-primary">submit And add more</button>
                                        </div>
                                    </div>
                                    <div class="mb-6 row sub">
                                        <div class="col-lg-8 ms-auto">
                                            <button type="submit" name="action" value="add_and_cancel"
                                                class="btn btn-danger">submit And Cancel</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>
    </div>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var map = L.map('map').setView([33.5138, 36.2765], 10);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">
                OpenStreetMap < /a> contributors'
            }).addTo(map);

            map.on('click', function(e) {
                document.getElementById('latitude').value = e.latlng.lat;
                document.getElementById('longitude').value = e.latlng.lng;
            });
        });
    </script>

@endsection
@section('js')
@endsection
