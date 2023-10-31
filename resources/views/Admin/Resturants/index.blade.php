@extends('layouts.master')
@section('css')
@endsection
@section('title')
    Restrants Management - Resturants Data
@stop
@section('content')
    <!-- row -->
    <div class="container-fluid">
        <div class="d-flex flex-wrap align-items-center mb-3">
            <div class="mb-3 me-auto">
                <div class="card-tabs style-1 mt-3 mt-sm-0">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" href="javascript:void(0);" data-bs-toggle="tab" id="transaction-tab"
                                data-bs-target="#Resturants" role="tab">All Resturants</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="javascript:void(0);" data-bs-toggle="tab" id="Completed-tab"
                                data-bs-target="#Actived" role="tab">Actived</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="javascript:void(0);" data-bs-toggle="tab" id="Pending-tab"
                                data-bs-target="#Pending" role="tab">Pending</a>
                        </li>

                    </ul>
                </div>
            </div>
            <a href="javascript:void(0);" class="btn btn-outline-primary mb-3"><i
                    class="fa fa-add me-3 scale3"></i>Resturant Add</a>
        </div>
        <div class="row">
            <div class="col-xl-12 tab-content">
                <div class="tab-pane fade show active" id="Resturants" role="tabpanel" aria-labelledby="Resturants-tab">
                    <div class="table-responsive fs-14">
                        <table class="table card-table display mb-4 dataTablesCard text-black" id="example5">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Account</th>
                                    <th>Phone</th>
                                    <th>Location</th>
                                    <th>Cuisine</th>
                                    <!-- <th>Work_time</th> -->
                                    <th>Status</th>
                                    <th>Operations</th>
                                    <!-- profile - details reservaions - edit - delete - active/unActive - -->
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $i = 0;
                                @endphp
                                @foreach ($all as $resturant)
                                    @php
                                        $i++;
                                    @endphp
                                    <tr>
                                        <td><span>#{{ $i }}</span></td>
                                        <td>
                                            <span class="text-nowrap">{{ $resturant->name }}</span>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="{{ URL::asset('dashboard/images/avatar/R.jpg') }}" alt=""
                                                    class="rounded-circle me-3" width="50">
                                                <div>
                                                    <h6 class="fs-16 mb-0 text-nowrap">
                                                        {{ $resturant->staff->name }}</h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td><span class="badge light badge-danger">{{ $resturant->phone_number }}</span>
                                        </td>
                                        <td>
                                            <div>
                                                <span class="badge light badge-warning">
                                                    {{ $resturant->location->state }}
                                                </span>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge badge-primary">
                                                {{ $resturant->Cuisine->name }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                @if ($resturant->staff->status == 'active')
                                                    <i class="fa fa-circle text-success me-1"></i>
                                                @else
                                                    <i class="fa fa-circle text-danger me-1"></i>
                                                @endif
                                                {{ $resturant->staff->status }}
                                            </div>
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                <button type="button" class="btn btn-danger light sharp"
                                                    data-bs-toggle="dropdown">
                                                    <svg width="20px" height="20px" viewBox="0 0 24 24" version="1.1">
                                                        <g stroke="none" stroke-width="1" fill="none"
                                                            fill-rule="evenodd">
                                                            <rect x="0" y="0" width="24" height="24"></rect>
                                                            <circle fill="#000000" cx="5" cy="12" r="2">
                                                            </circle>
                                                            <circle fill="#000000" cx="12" cy="12" r="2">
                                                            </circle>
                                                            <circle fill="#000000" cx="19" cy="12" r="2">
                                                            </circle>
                                                        </g>
                                                    </svg>
                                                </button>
                                                <div class="dropdown-menu">

                                                    <a class="dropdown-item"
                                                        href="{{ route('resturants.show', $resturant->id) }}">Profile
                                                        Details</a>
                                                    <a class="dropdown-item"
                                                        href="{{ route('rest_tables', $resturant->id) }}">Tables
                                                        Management</a>
                                                    <a class="dropdown-item"
                                                        href="{{ route('offers_index', $resturant->id) }}">Offers
                                                        Management</a>
                                                    <a class="dropdown-item"
                                                        href="{{ route('resturant_reservations', $resturant->id) }}">
                                                        reservaions Details</a>
                                                    <a class="dropdown-item"
                                                        href="{{ route('resturants.edit', $resturant->id) }}"></i>edit</a>
                                                    <a class="dropdown-item" href="#"
                                                        onclick="event.preventDefault();
                                                                 document.getElementById('destroy-form-{{ $resturant->id }}').submit();">
                                                        Delete
                                                    </a>
                                                    <form id="destroy-form-{{ $resturant->id }}"
                                                        action="{{ route('resturants.destroy', $resturant->id) }}"
                                                        method="POST" style="display: none;">
                                                        @method('DELETE')
                                                        @csrf
                                                    </form>
                                                    @if ($resturant->staff->status == 'active')
                                                        <a class="dropdown-item"
                                                            href="{{ route('act_inact__resturant', $resturant->id) }}"></i>inActive</a>
                                                    @else
                                                        <a class="dropdown-item"
                                                            href="{{ route('act_inact__resturant', $resturant->id) }}"></i>Active</a>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade" id="Actived" role="tabpanel" aria-labelledby="Actived-tab">
                    <div class="table-responsive fs-14">
                        <table class="table card-table display mb-4 dataTablesCard text-black" id="example6">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Account</th>
                                    <th>Phone</th>
                                    <th>Location</th>
                                    <th>Cuisine</th>
                                    <!-- <th>Work_time</th> -->
                                    <th>Status</th>
                                    <th>Operations</th>
                                    <!-- profile - details reservaions - edit - delete - active/unActive - -->
                                </tr>
                            </thead>
                            @php
                                $i = 0;
                            @endphp
                            @foreach ($active as $resturant)
                                @php
                                    $i++;
                                @endphp
                                <tr>
                                    <td><span>#{{ $i }}</span></td>
                                    <td>
                                        <span class="text-nowrap">{{ $resturant->name }}</span>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="{{ URL::asset('dashboard/images/avatar/R.jpg') }}" alt=""
                                                class="rounded-circle me-3" width="50">
                                            <div>
                                                <h6 class="fs-16 mb-0 text-nowrap">
                                                    {{ $resturant->staff->name }}</h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td><span class="badge light badge-danger">{{ $resturant->phone_number }}</span>
                                    </td>
                                    <td>
                                        <div>
                                            <span class="badge light badge-warning">
                                                {{ $resturant->location->state }}

                                            </span>

                                        </div>
                                    </td>

                                    <td>
                                        <span class="badge badge-primary">
                                            {{ $resturant->Cuisine->name }}
                                        </span>
                                    </td>



                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if ($resturant->staff->status == 'active')
                                                <i class="fa fa-circle text-success me-1"></i>
                                            @else
                                                <i class="fa fa-circle text-danger me-1"></i>
                                            @endif
                                            {{ $resturant->staff->status }}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn btn-danger light sharp"
                                                data-bs-toggle="dropdown">
                                                <svg width="20px" height="20px" viewBox="0 0 24 24" version="1.1">
                                                    <g stroke="none" stroke-width="1" fill="none"
                                                        fill-rule="evenodd">
                                                        <rect x="0" y="0" width="24" height="24"></rect>
                                                        <circle fill="#000000" cx="5" cy="12" r="2">
                                                        </circle>
                                                        <circle fill="#000000" cx="12" cy="12" r="2">
                                                        </circle>
                                                        <circle fill="#000000" cx="19" cy="12" r="2">
                                                        </circle>
                                                    </g>
                                                </svg>
                                            </button>
                                            <div class="dropdown-menu">

                                                <a class="dropdown-item"
                                                    href="{{ route('resturants.show', $resturant->id) }}">Profile
                                                    Details</a>
                                                <a class="dropdown-item"
                                                    href="{{ route('resturant_reservations', $resturant->id) }}">reservaions
                                                    Details</a>
                                                <a class="dropdown-item"
                                                    href="{{ route('resturants.edit', $resturant->id) }}"></i>edit</a>



                                                <a class="dropdown-item" href="#"
                                                    onclick="event.preventDefault();
                                                             document.getElementById('destroy-form-{{ $resturant->id }}').submit();">
                                                    Delete
                                                </a>
                                                <form id="destroy-form-{{ $resturant->id }}"
                                                    action="{{ route('resturants.destroy', $resturant->id) }}"
                                                    method="POST" style="display: none;">
                                                    @method('DELETE')
                                                    @csrf
                                                </form>


                                                @if ($resturant->staff->status == 'active')
                                                    <a class="dropdown-item"
                                                        href="{{ route('act_inact__resturant', $resturant->id) }}"></i>inActive</a>
                                                @else
                                                    <a class="dropdown-item"
                                                        href="{{ route('act_inact__resturant', $resturant->id) }}"></i>Active</a>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade" id="Pending" role="tabpanel" aria-labelledby="Pending-tab">
                    <div class="table-responsive fs-14">
                        <table class="table card-table display mb-4 dataTablesCard text-black" id="example6">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Account</th>
                                    <th>Phone</th>
                                    <th>Location</th>
                                    <th>Cuisine</th>
                                    <!-- <th>Work_time</th> -->
                                    <th>Status</th>
                                    <th>Operations</th>
                                    <!-- profile - details reservaions - edit - delete - active/unActive - -->
                                </tr>
                            </thead>
                            @php
                                $i = 0;
                            @endphp
                            @foreach ($pending as $resturant)
                                @php
                                    $i++;
                                @endphp
                                <tr>
                                    <td><span>#{{ $i }}</span></td>
                                    <td>
                                        <span class="text-nowrap">{{ $resturant->name }}</span>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="{{ URL::asset('dashboard/images/avatar/R.jpg') }}" alt=""
                                                class="rounded-circle me-3" width="50">
                                            <div>
                                                <h6 class="fs-16 mb-0 text-nowrap">
                                                    {{ $resturant->staff->name }}</h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td><span class="badge light badge-danger">{{ $resturant->phone_number }}</span>
                                    </td>
                                    <td>
                                        <div>
                                            <span class="badge light badge-warning">
                                                {{ $resturant->location->state }}

                                            </span>

                                        </div>
                                    </td>

                                    <td>
                                        <span class="badge badge-primary">
                                            {{ $resturant->Cuisine->name }}
                                        </span>
                                    </td>



                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if ($resturant->staff->status == 'active')
                                                <i class="fa fa-circle text-success me-1"></i>
                                            @else
                                                <i class="fa fa-circle text-danger me-1"></i>
                                            @endif
                                            {{ $resturant->staff->status }}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn btn-danger light sharp"
                                                data-bs-toggle="dropdown">
                                                <svg width="20px" height="20px" viewBox="0 0 24 24" version="1.1">
                                                    <g stroke="none" stroke-width="1" fill="none"
                                                        fill-rule="evenodd">
                                                        <rect x="0" y="0" width="24" height="24"></rect>
                                                        <circle fill="#000000" cx="5" cy="12" r="2">
                                                        </circle>
                                                        <circle fill="#000000" cx="12" cy="12" r="2">
                                                        </circle>
                                                        <circle fill="#000000" cx="19" cy="12" r="2">
                                                        </circle>
                                                    </g>
                                                </svg>
                                            </button>
                                            <div class="dropdown-menu">

                                                <a class="dropdown-item"
                                                    href="{{ route('resturants.show', $resturant->id) }}">Profile
                                                    Details</a>
                                                <a class="dropdown-item"
                                                    href="{{ route('resturant_reservations', $resturant->id) }}">reservaions
                                                    Details</a>
                                                <a class="dropdown-item"
                                                    href="{{ route('resturants.edit', $resturant->id) }}"></i>edit</a>

                                                <a class="dropdown-item" href="#"
                                                    onclick="event.preventDefault();
                                                             document.getElementById('destroy-form-{{ $resturant->id }}').submit();">
                                                    Delete
                                                </a>
                                                <form id="destroy-form-{{ $resturant->id }}"
                                                    action="{{ route('resturants.destroy', $resturant->id) }}"
                                                    method="POST" style="display: none;">
                                                    @method('DELETE')
                                                    @csrf
                                                </form>
                                                @if ($resturant->staff->status == 'active')
                                                    <a class="dropdown-item"
                                                        href="{{ route('act_inact__resturant', $resturant->id) }}"></i>inActive</a>
                                                @else
                                                    <a class="dropdown-item"
                                                        href="{{ route('act_inact__resturant', $resturant->id) }}"></i>Active</a>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                {{-- <div class="tab-pane fade" id="Canceled" role="tabpanel" aria-labelledby="Canceled-tab">
                    <div class="table-responsive fs-14">
                        <table class="table card-table display mb-4 dataTablesCard text-black" id="example6">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Phone</th>
                                    <th>Location</th>
                                    <th>Cuisine</th>
                                    <th>Work_time</th>
                                    <th>Account</th>
                                    <th>Profile</th>
                                </tr>
                            </thead>
                            @php
                                $i = 0;
                            @endphp
                            @foreach ($resturants as $resturant)
                                @php
                                    $i++;
                                @endphp
                                <tr>
                                    <td><span>#{{ $i }}</span></td>
                                    <td>
                                        <span class="text-nowrap">{{ $resturant->name }}</span>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="{{ URL::asset('dashboard/images/avatar/R.jpg') }}" alt=""
                                                class="rounded-circle me-3" width="50">
                                            <div>
                                                <h6 class="fs-16 mb-0 text-nowrap">
                                                    {{ $resturant->staff->name }}</h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td><span class="badge light badge-danger">{{ $resturant->phone_number }}</span>
                                    </td>
                                    <td>
                                        <div>
                                            <span class="badge light badge-warning">
                                                {{ $resturant->location->state }}

                                            </span>

                                        </div>
                                    </td>

                                    <td>
                                        <span class="badge badge-primary">
                                            {{ $resturant->Cuisine->name }}
                                        </span>
                                    </td>


                                    <td>
                                        <div class="d-flex align-items-center">
                                            <i class="fa fa-circle text-success me-1"></i>
                                            {{ $resturant->staff->status }}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn btn-danger light sharp"
                                                data-bs-toggle="dropdown">
                                                <svg width="20px" height="20px" viewBox="0 0 24 24" version="1.1">
                                                    <g stroke="none" stroke-width="1" fill="none"
                                                        fill-rule="evenodd">
                                                        <rect x="0" y="0" width="24"
                                                            height="24"></rect>
                                                        <circle fill="#000000" cx="5" cy="12"
                                                            r="2"></circle>
                                                        <circle fill="#000000" cx="12" cy="12"
                                                            r="2"></circle>
                                                        <circle fill="#000000" cx="19" cy="12"
                                                            r="2"></circle>
                                                    </g>
                                                </svg>
                                            </button>
                                            <div class="dropdown-menu">

                                                <a class="dropdown-item"
                                                    href="{{ route('resturants.show', $resturant->id) }}">Profile
                                                    Details</a>
                                                <a class="dropdown-item" href="transaction-details.html">reservaions
                                                    Details</a>
                                                <a class="dropdown-item"
                                                    href="{{ route('resturants.edit', $resturant->id) }}"></i>edit</a>
                                                <a class="dropdown-item" href="transaction-details.html"></i>Delete</a>
                                                @if ($resturant->staff->status == 'active')
                                                    <a class="dropdown-item"
                                                        href="transaction-details.html"></i>inActive</a>
                                                @else
                                                    <a class="dropdown-item"
                                                        href="transaction-details.html"></i>Active</a>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div> --}}
            </div>
        </div>
    </div>
@endsection
@section('js')
@endsection
