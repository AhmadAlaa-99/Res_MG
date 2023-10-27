@extends('layouts.master')
@section('css')
@endsection
@section('title')
    Restrants Management - Customers
@stop
@section('content')
    <div class="container-fluid">

        <div class="row page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Shop</a></li>
                <li class="breadcrumb-item"><a href="javascript:void(0)">Customers</a></li>
            </ol>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-sm mb-0 table-striped">
                                <thead>
                                    <tr>
                                        <th class=" pe-3">
                                            <div class="form-check custom-checkbox mx-2">        
                                                <label for="checkAll">ID</label>
                                            </div>
                                        </th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                         <th>State</th>
                                        {{-- <th>
                                        </th> --}}
                                    </tr>
                                </thead>
                                <tbody id="customers">
                                    @php
                                        $i = 0;
                                    @endphp
                                    @foreach ($users as $user)
                                        @php
                                            $i++;
                                        @endphp
                                        <tr class="btn-reveal-trigger">
                                            <td class="py-2">
                                                <div class="form-check custom-checkbox mx-2">
                                          
                                                    <label class="form-check-label"
                                                        for="checkbox12">#{{ $i }}</label>
                                                </div>
                                            </td>
                                            <td class="py-3">
                                                <a href="#">
                                                    <div class="media d-flex align-items-center">
                                                        <div class="avatar avatar-xl me-2">
                                                            <img class="rounded-circle img-fluid" src="images/avatar/1.png"
                                                                alt="" width="30">
                                                        </div>
                                                        <div class="media-body">
                                                            <h5 class="mb-0 fs--1">{{ $user->firstname }}</h5>
                                                        </div>
                                                    </div>
                                                </a>
                                            </td>
                                            <td class="py-2"><a href="mailto:antony@example.com">{{ $user->email }}</a>
                                            </td>
                                            <td class="py-2"> <a href="tel:9013243127">{{ $user->phone }}</a></td>

                                            {{-- <td class="py-2 text-end">
										<div class="dropdown"><button class="btn btn-primary tp-btn-light sharp" type="button" data-bs-toggle="dropdown"><span class="fs--1"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="18px" height="18px" viewbox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"></rect><circle fill="#000000" cx="5" cy="12" r="2"></circle><circle fill="#000000" cx="12" cy="12" r="2"></circle><circle fill="#000000" cx="19" cy="12" r="2"></circle></g></svg></span></button>
											<div class="dropdown-menu dropdown-menu-end border py-0">
												<div class="py-2"><a class="dropdown-item" href="#!">Edit</a><a class="dropdown-item text-danger" href="#!">Delete</a></div>
											</div>
										</div>
									</td> --}}
                                    <td><span class="badge badge-danger light">{{$user->State}}</span>
                                                </td>
                                        </tr>
										@endforeach
										


                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
@endsection
