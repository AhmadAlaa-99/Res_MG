@extends('layouts.master')
@section('css')
@endsection
@section('title')
Restrants Management - Resturant Edit
@stop
@section('content')
    <div class="container-fluid">
        <div class="row page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Edit</a></li>
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
                            <form method="post"  action="{{ route('resturants.update',$Resturant->id) }}" autocomplete="off" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-xl-6">
                                        <div class="mb-3 row">
                                            <label class="col-lg-4 col-form-label" for="validationCustom01">Username
                                                <span class="text-danger">*</span>
                                            </label>
                                            <div class="col-lg-6">
                                                <input type="text" class="form-control" id="validationCustom01"
                                                    placeholder="Enter a username.." value="{{$Resturant->staff->name}}"name="user_name" required="">
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
                                                <input type="text" class="form-control" value="{{$Resturant->staff->email}}"name="email" id="validationCustom02"
                                                    placeholder="Your valid email.." required="">
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
                                                <input type="password" name="password" class="form-control" id="validationCustom03"
                                                    placeholder="Choose a safe one.." required="">
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
                                                    placeholder="963-9376-07234"value="{{$Resturant->staff->phone}}" name="user_phone" required="">
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
                    
                                                    <button type="submit" name="action" value="Save" class="btn btn-primary">Save</button>
                                                </div>
                                            </div>
    
                                            <div class="mb-6 row sub">
                                                <div class="col-lg-8 ms-auto">
                                                    <button type="cancel" name="action" value="Cancel" class="btn btn-danger">Cancel</button>
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
                                                <input type="text" name="Resturant_name" class="form-control"
                                                    id="validationCustom06" value="{{$Resturant->name}}"placeholder="Resturant_name" required>
                                                <div class="invalid-feedback">
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
                                                    placeholder="963-9376-07234"
                                                     value="{{$Resturant->phone_number}}" name="Resturant_phone" required="">
                                                <div class="invalid-feedback">
                                                    Please enter a Resturant_phone no.
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
                                                    <option value="{{$cuisin->id}}" {{$cuisin->id == $Resturant->cuisine_id ? 'selected' : ""}}>{{ $cuisin->name }}</option>

                                                        <option value="{{ $cuisin->id }}">{{ $cuisin->name }}</option>
                                                    @endforeach


                                                </select>
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
                                                <input type="text" name="description" value="{{$Resturant->description}}" class="form-control"
                                                    id="validationCustom07" placeholder="description" required="">
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
                                                <input type="text" value="{{$Resturant->location}}" class="form-control"name="location"
                                                    id="validationCustom09" placeholder="location" required="">
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
                                                    id="validationCustom09" value="{{$Resturant->Activation_start}}" placeholder="Activation_start"
                                                    required="">
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
                                                    id="validationCustom09" 
                                                    value="{{$Resturant->Activation_end}}"
                                                    placeholder="Activation_end" required="">
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
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
@section('js')
@endsection
