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
                                data-bs-target="#Resturants" role="tab">All Offers</a>
                        </li>


                    </ul>
                </div>
            </div>
            <a href="javascript:void()" data-bs-toggle="modal"
                data-bs-target="#add_employee"class="btn btn-outline-primary mb-3">
                <i class="fa fa-add me-3 scale3"></i>Offer
                Add</a>


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
                                    <th>Description</th>
                                    <th>price_old</th>
                                    <th>price_new</th>
                                    <th>featured</th>
                                    <th>Status</th>
                                    <th>Operations</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $i = 0;
                                @endphp
                                @foreach ($offers as $offer)
                                    @php
                                        $i++;
                                    @endphp





                                    <tr>
                                        <td><span>#{{ $i }}</span></td>
                                        <td>
                                            <span class="text-nowrap">{{ $offer->name }}</span>
                                        </td>

                                        <td><span class="badge light badge-danger">{{ $offer->desc }}</span>
                                        </td>
                                        <td>
                                            <div>
                                                <span class="badge light badge-warning">
                                                    {{ $offer->price_old }}
                                                </span>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge badge-primary">
                                                {{ $offer->price_new }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge badge-primary">
                                                {{-- {{ $offer->featured }} --}} features
                                            </span>
                                        </td>

                                        <td>
                                            <div class="d-flex align-items-center">
                                                @if ($offer->status == 'active')
                                                    <i class="fa fa-circle text-success me-1"></i>
                                                @else
                                                    <i class="fa fa-circle text-danger me-1"></i>
                                                @endif
                                                {{ $offer->status }}
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
                                                        href="{{ route('offers.show', $offer->id) }}">Offer
                                                        Details</a>



                                                    <a class="dropdown-item"
                                                        href="{{ route('offers.edit', $offer->id) }}"></i>edit</a>
                                                    <a class="dropdown-item" href="#"
                                                        onclick="event.preventDefault();
                                                                 document.getElementById('destroy-form-{{ $offer->id }}').submit();">
                                                        Delete
                                                    </a>
                                                    <form id="destroy-form-{{ $offer->id }}"
                                                        action="{{ route('offers.destroy', $offer->id) }}" method="POST"
                                                        style="display: none;">
                                                        @method('DELETE')
                                                        @csrf
                                                    </form>
                                                    @if ($offer->status == 'active')
                                                        <a class="dropdown-item"
                                                            href="{{ route('act_inact__offer', $offer->id) }}"></i>inActive</a>
                                                    @else
                                                        <a class="dropdown-item"
                                                            href="{{ route('act_inact__offer', $offer->id) }}"></i>Active</a>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                <!-- Modal -->
                                <div class="modal fade" id="add_employee" role="dialog">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Send Message</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form method="post" action="{{ route('offers.store') }}"
                                                    autocomplete="off" enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            <div class="mb-3">
                                                                <label class="text-black font-w600 form-label">
                                                                    price_old
                                                                    <span class="required">*</span></label>
                                                                <input type="text" class="form-control"
                                                                    id="validationCustom01" placeholder="Enter a username.."
                                                                    value="testname"name="price_old" required="">
                                                                @error('price_old')
                                                                    <div class="alert alert-danger">{{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="mb-3">
                                                                <label class="text-black font-w600 form-label">
                                                                    price_new
                                                                    <span class="required">*</span></label>
                                                                <input type="text" class="form-control"
                                                                    id="validationCustom01" placeholder="Enter a username.."
                                                                    value="testname"name="price_new" required="">
                                                                @error('price_new')
                                                                    <div class="alert alert-danger">{{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="mb-3">
                                                                <label class="text-black font-w600 form-label">
                                                                    desc
                                                                    <span class="required">*</span></label>
                                                                <input type="text" class="form-control"
                                                                    id="validationCustom01" placeholder="Enter a username.."
                                                                    value="testname"name="desc" required="">
                                                                @error('desc')
                                                                    <div class="alert alert-danger">{{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="mb-3">
                                                                <label class="text-black font-w600 form-label">
                                                                    name
                                                                    <span class="required">*</span></label>
                                                                <input type="text" class="form-control"
                                                                    id="validationCustom01" placeholder="Enter a username.."
                                                                    value="testname"name="name" required="">
                                                                @error('name')
                                                                    <div class="alert alert-danger">{{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="mb-3">
                                                                <label class="text-black font-w600 form-label">
                                                                    featured
                                                                    <span class="required">*</span></label>
                                                                <input type="text" class="form-control"
                                                                    id="validationCustom01" placeholder="Enter a username.."
                                                                    value="testname"name="featured" required="">
                                                                @error('featured')
                                                                    <div class="alert alert-danger">{{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="mb-3">
                                                                <label class="text-black font-w600 form-label">
                                                                    cover
                                                                    <span class="required">*</span></label>
                                                                    <input type="file" name="cover[]" accept="images/*"
                                                                    class="form-file-input form-control" multiple>
                                                                @error('cover')
                                                                    <div class="alert alert-danger">{{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="mb-3">
                                                                <label class="text-black font-w600 form-label">
                                                                    main
                                                                    <span class="required">*</span></label>
                                                                    <input type="file" name="main[]" accept="images/*"
                                                                    class="form-file-input form-control" multiple>
                                                                @error('main')
                                                                    <div class="alert alert-danger">{{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="mb-3">
                                                                <label class="text-black font-w600 form-label">
                                                                    others
                                                                    <span class="required">*</span></label>
                                                                    <input type="file" name="others[]" accept="images/*"
                                                                    class="form-file-input form-control" multiple>
                                                                    
                                                                    <input type="hidden" name="res_id" value={{$res_id}}>
                                                                @error('others')
                                                                    <div class="alert alert-danger">{{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                        </div>


                                                        <div class="col-lg-12">
                                                            <div class="mb-3 mb-0">
                                                                <input type="submit" value="Confirm"
                                                                    class="submit btn btn-primary" name="submit" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
                                <script>
                                    $(document).ready(function() {
                                        if ($(".alert-danger").length) {
                                            $("#add_employee").modal('show');
                                        }
                                    });
                                </script>
                            </tbody>
                        </table>
                    </div>
                </div>


            </div>
        </div>
    </div>
@endsection
@section('js')
@endsection
