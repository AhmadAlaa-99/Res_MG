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
                                                    placeholder="Enter a username.." name="user_name" required="">
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
                                                    id="validationCustom02" placeholder="Your valid email.." required="">
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
                                                    placeholder="963-9376-07234" name="user_phone" required="">
                                                @error('user_phone')
                                                    <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror
                                                <div class="invalid-feedback">
                                                    Please enter a user_phone no.
                                                </div>
                                            </div>
                                        </div>
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
                                    </div>
                                    <div class="col-xl-6">
                                        <div class="mb-3 row">
                                            <label class="col-lg-4 col-form-label" for="validationCustom06">Resturant Name
                                                <span class="text-danger">*</span>
                                            </label>
                                            <div class="col-lg-6">
                                                <input type="text" name="resturant_name" class="form-control"
                                                    id="validationCustom06" placeholder="resturant_name" required>
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
                                                    placeholder="963-9376-07234" name="resturant_phone" required="">
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
                                                <input type="text" name="description"class="form-control"
                                                    id="validationCustom07" placeholder="description" required="">
                                                @error('description')
                                                    <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror
                                                <div class="invalid-feedback">
                                                    Please enter a description.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
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
                                        </div>
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
                                            <span class="input-group-text">Upload</span>
                                            <div class="form-file">
                                                <input type="file" name="images[]" accept="image/*"
                                                    class="form-file-input form-control" multiple>
                                            </div>
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
@endsection
@section('js')
@endsection
