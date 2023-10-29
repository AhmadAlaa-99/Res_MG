@extends('layouts.master')
@section('css')
@endsection
@section('title')
    Restrants Management - TABLES
@stop
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-9">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-header flex-wrap border-0 pb-0 align-items-end">
                                <div class="mb-3 me-3">
                                    <h5 class="fs-20 text-black font-w500">Main Balance</h5>
                                    <span class="text-num text-black fs-36 font-w500">$673,412.66</span>
                                </div>
                                <div class="me-3 mb-3">
                                    <p class="fs-14 mb-1">VALID THRU</p>
                                    <span class="text-black fs-16">08/21</span>
                                </div>
                                <div class="me-3 mb-3">
                                    <p class="fs-14 mb-1">CARD HOLDER</p>
                                    <span class="text-black fs-16">WilliamFacyson</span>
                                </div>
                                <span class="fs-20 text-black font-w500 me-3 mb-3">**** **** **** 1234</span>
                                <div class="dropdown mb-auto">
                                    <a href="javascript:void(0);" class="btn-link" data-bs-toggle="dropdown"
                                        aria-expanded="false">
                                        <svg width="24" height="24" viewbox="0 0 24 24" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M12 13C12.5523 13 13 12.5523 13 12C13 11.4477 12.5523 11 12 11C11.4477 11 11 11.4477 11 12C11 12.5523 11.4477 13 12 13Z"
                                                stroke="#575757" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round"></path>
                                            <path
                                                d="M12 6C12.5523 6 13 5.55228 13 5C13 4.44772 12.5523 4 12 4C11.4477 4 11 4.44772 11 5C11 5.55228 11.4477 6 12 6Z"
                                                stroke="#575757" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round"></path>
                                            <path
                                                d="M12 20C12.5523 20 13 19.5523 13 19C13 18.4477 12.5523 18 12 18C11.4477 18 11 18.4477 11 19C11 19.5523 11.4477 20 12 20Z"
                                                stroke="#575757" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round"></path>
                                        </svg>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" href="javascript:void(0);">Delete</a>
                                        <a class="dropdown-item" href="javascript:void(0);">Edit</a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="progress default-progress">
                                    <div class="progress-bar bg-gradient-5 progress-animated"
                                        style="width: 50%; height:20px;" role="progressbar">
                                        <span class="sr-only">50% Complete</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-header d-sm-flex d-block border-0 pb-0">
                                <div class="me-auto mb-sm-0 mb-4">
                                    <h4 class="fs-20 text-black">Tables List</h4>
                                    <span class="fs-12">Lorem ipsum dolor sit amet, consectetur</span>
                                </div>
                                {{-- <a href="{{route('tables.create')}}" class="btn btn-primary btn-rounded btn-md mx-3">+Add New Table</a> --}}
                                @can('Crud Tables')
                                    <a href="#" class="btn btn-primary btn-rounded btn-md mx-3" id="addNewTableLink">+Add
                                        New Table</a>


                                    <form action="{{ route('tables.create') }}" method="GET" id="addNewTableForm"
                                        style="display: none;">
                                        <input type="hidden" name="res_id" value="{{ $res_id }}">
                                        <button type="submit" class="btn btn-primary btn-rounded btn-md mx-3">+Add New
                                            Table</button>
                                    </form>
                                @endcan

                            </div>
                            @if (session()->has('error'))
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <strong>{{ session()->get('error') }}</strong>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">


                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <div class="card-body pb-0">
                                @php
                                    $i = 0;
                                @endphp
                                @foreach ($tables as $table)
                                    @php
                                        $i++;
                                    @endphp
                                    <div
                                        class="d-flex mb-3 border-bottom justify-content-between flex-wrap align-items-center">
                                        <div class="d-flex pb-3 align-items-center">
                                            <img src="{{ URL::asset('dashboard/images/card/1.jpg') }}" alt=""
                                                class="rounded me-3 card-list-img" width="130">
                                            <div class="me-3">
                                                <p class="fs-14 mb-1">Table Number</p>

                                                <span class="badge badge-danger">{{ $table->number }}</span>
                                            </div>
                                        </div>
                                        <div class="me-3 pb-3">
                                            <p class="fs-14 mb-1">Capacity</p>

                                            <span class="badge badge-warning">{{ $table->capacity }}</span>
                                        </div>
                                        <div class="me-3 pb-3">
                                            <p class="fs-14 mb-1">seating_configuration</p>
                                            <span class="badge badge-dark light">{{ $table->seating_configuration }}</span>

                                        </div>
                                        <a href="{{ route('today_tables', $table->id) }}"
                                            class="btn btn-primary d-sm-inline-block d-none">
                                            Reservations
                                        </a>
                                        @can('Crud Tables')
                                            <td>
                                                <div class="d-flex">
                                                    <a href="{{ route('tables.edit', $table->id) }}"
                                                        class="btn btn-primary shadow btn-xs sharp me-1"><i
                                                            class="fas fa-pencil-alt"></i></a>
                                                    <a class="btn btn-danger shadow btn-xs sharp" href="#"
                                                        onclick="event.preventDefault();
                                                 document.getElementById('destroy-form-{{ $table->id }}').submit();">
                                                        <i class="fa fa-trash"></i>

                                                    </a>
                                                    <form id="destroy-form-{{ $table->id }}"
                                                        action="{{ route('tables.destroy', $table->id) }}" method="POST"
                                                        style="display: none;">
                                                        @method('DELETE')
                                                        @csrf
                                                    </form>


                                                </div>
                                            </td>
                                        @endcan
                                    </div>
                                @endforeach
                                {{-- <div class="d-flex mb-3 border-bottom justify-content-between flex-wrap align-items-center">
                                <div class="d-flex pb-3 align-items-center">
                                    <img src="images/card/2.jpg" alt="" class="rounded me-3 card-list-img" width="130">
                                    <div class="me-3">
                                        <p class="fs-14 mb-1">Card Type</p>
                                        <span class="text-black font-w500">Secondary</span>
                                    </div>
                                </div>
                                <div class="me-3 pb-3">
                                    <p class="fs-14 mb-1">Bank</p>
                                    <span class="text-black font-w500">ABC Bank</span>
                                </div>
                                <div class="me-3 pb-3">
                                    <p class="fs-14 mb-1">Card Number</p>
                                    <span class="text-black font-w500">**** **** **** 2256</span>
                                </div>
                                <div class="me-3 pb-3">
                                    <p class="fs-14 mb-1">Namein Card</p>
                                    <span class="text-black font-w500">Franklin Jr.</span>
                                </div>
                                <a href="javascript:void(0);" class="fs-14 btn-link me-3 pb-3">See Number</a>
                                <div class="dropdown pb-3">
                                    <a href="javascript:void(0);" class="btn-link" data-bs-toggle="dropdown" aria-expanded="false">
                                        <svg width="24" height="24" viewbox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M12 13C12.5523 13 13 12.5523 13 12C13 11.4477 12.5523 11 12 11C11.4477 11 11 11.4477 11 12C11 12.5523 11.4477 13 12 13Z" stroke="#575757" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                            <path d="M12 6C12.5523 6 13 5.55228 13 5C13 4.44772 12.5523 4 12 4C11.4477 4 11 4.44772 11 5C11 5.55228 11.4477 6 12 6Z" stroke="#575757" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                            <path d="M12 20C12.5523 20 13 19.5523 13 19C13 18.4477 12.5523 18 12 18C11.4477 18 11 18.4477 11 19C11 19.5523 11.4477 20 12 20Z" stroke="#575757" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                        </svg>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" href="javascript:void(0);">Delete</a>
                                        <a class="dropdown-item" href="javascript:void(0);">Edit</a>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex mb-3 border-bottom justify-content-between flex-wrap align-items-center">
                                <div class="d-flex pb-3 align-items-center">
                                    <img src="images/card/3.jpg" alt="" class="rounded me-3 card-list-img" width="130">
                                    <div class="me-3">
                                        <p class="fs-14 mb-1">Card Type</p>
                                        <span class="text-black font-w500">Primary</span>
                                    </div>
                                </div>
                                <div class="me-3 pb-3">
                                    <p class="fs-14 mb-1">Bank</p>
                                    <span class="text-black font-w500">ABC Bank</span>
                                </div>
                                <div class="me-3 pb-3">
                                    <p class="fs-14 mb-1">Card Number</p>
                                    <span class="text-black font-w500">**** **** **** 2256</span>
                                </div>
                                <div class="me-3 pb-3">
                                    <p class="fs-14 mb-1">Namein Card</p>
                                    <span class="text-black font-w500">Franklin Jr.</span>
                                </div>
                                <a href="javascript:void(0);" class="fs-14 btn-link me-3 pb-3">See Number</a>
                                <div class="dropdown pb-3">
                                    <a href="javascript:void(0);" class="btn-link" data-bs-toggle="dropdown" aria-expanded="false">
                                        <svg width="24" height="24" viewbox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M12 13C12.5523 13 13 12.5523 13 12C13 11.4477 12.5523 11 12 11C11.4477 11 11 11.4477 11 12C11 12.5523 11.4477 13 12 13Z" stroke="#575757" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                            <path d="M12 6C12.5523 6 13 5.55228 13 5C13 4.44772 12.5523 4 12 4C11.4477 4 11 4.44772 11 5C11 5.55228 11.4477 6 12 6Z" stroke="#575757" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                            <path d="M12 20C12.5523 20 13 19.5523 13 19C13 18.4477 12.5523 18 12 18C11.4477 18 11 18.4477 11 19C11 19.5523 11.4477 20 12 20Z" stroke="#575757" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                        </svg>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" href="javascript:void(0);">Delete</a>
                                        <a class="dropdown-item" href="javascript:void(0);">Edit</a>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex mb-3 border-bottom justify-content-between flex-wrap align-items-center">
                                <div class="d-flex pb-3 align-items-center">
                                    <img src="images/card/4.jpg" alt="" class="rounded me-3 card-list-img" width="130">
                                    <div class="me-3">
                                        <p class="fs-14 mb-1">Card Type</p>
                                        <span class="text-black font-w500">Primary</span>
                                    </div>
                                </div>
                                <div class="me-3 pb-3">
                                    <p class="fs-14 mb-1">Bank</p>
                                    <span class="text-black font-w500">ABC Bank</span>
                                </div>
                                <div class="me-3 pb-3">
                                    <p class="fs-14 mb-1">Card Number</p>
                                    <span class="text-black font-w500">**** **** **** 2256</span>
                                </div>
                                <div class="me-3 pb-3">
                                    <p class="fs-14 mb-1">Namein Card</p>
                                    <span class="text-black font-w500">Franklin Jr.</span>
                                </div>
                                <a href="javascript:void(0);" class="fs-14 btn-link me-3 pb-3">See Number</a>
                                <div class="dropdown pb-3">
                                    <a href="javascript:void(0);" class="btn-link" data-bs-toggle="dropdown" aria-expanded="false">
                                        <svg width="24" height="24" viewbox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M12 13C12.5523 13 13 12.5523 13 12C13 11.4477 12.5523 11 12 11C11.4477 11 11 11.4477 11 12C11 12.5523 11.4477 13 12 13Z" stroke="#575757" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                            <path d="M12 6C12.5523 6 13 5.55228 13 5C13 4.44772 12.5523 4 12 4C11.4477 4 11 4.44772 11 5C11 5.55228 11.4477 6 12 6Z" stroke="#575757" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                            <path d="M12 20C12.5523 20 13 19.5523 13 19C13 18.4477 12.5523 18 12 18C11.4477 18 11 18.4477 11 19C11 19.5523 11.4477 20 12 20Z" stroke="#575757" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                        </svg>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" href="javascript:void(0);">Delete</a>
                                        <a class="dropdown-item" href="javascript:void(0);">Edit</a>
                                    </div>
                                </div>
                            </div> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-header border-0 pb-0">
                                <div>
                                    <h4 class="card-title mb-2">Card Statistic</h4>
                                    <span class="fs-12">Lorem ipsum dolor sit amet, consectetur</span>
                                </div>
                            </div>
                            <div class="card-body">
                                <div id="polarChart"></div>
                                <ul class="card-list mt-4">
                                    <li><span class="bg-blue circle"></span>Account<span>20%</span></li>
                                    <li><span class="bg-success circle"></span>Services<span>40%</span></li>
                                    <li><span class="bg-warning circle"></span>Restaurant<span>15%</span></li>
                                    <li><span class="bg-light circle"></span>Others<span>15%</span></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.getElementById('addNewTableLink').addEventListener('click', function(event) {
            event.preventDefault(); // Prevent the default link behavior
            document.getElementById('addNewTableForm').submit(); // Submit the form
        });
    </script>
@endsection
@section('js')
@endsection
