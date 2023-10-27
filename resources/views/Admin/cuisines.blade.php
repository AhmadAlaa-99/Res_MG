@extends('layouts.master')
@section('css')
@endsection
@section('title')
    Restrants Management - Cuisines
@stop
@section('content')
    <div class="container-fluid">
        <div class="d-flex mb-3">
            <div class="mb-3 align-items-center me-auto">
                <h4 class="card-title">Payment History</h4>
                <span class="fs-12">Lorem ipsum dolor sit amet, consectetur</span>
            </div>


            <a href="javascript:void(0);" class="btn btn-outline-primary mb-3" data-bs-toggle="modal"
                data-bs-target="#sendMessageModal">
                <i class="fa fa-calendar me-3 scale3">
                </i>Add a Cuisine
            </a>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div class="table-responsive fs-14">
                    <table class="table card-table display mb-4 dataTablesCard " id="example5">
                        <thead>
                            <tr>
                                <th>ID Cuisine</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Resturants Num</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($cuisines as $cuisine)
                                <tr>
                                    <td><span class="text-black font-w500">#{{ $cuisine->id }}</span></td>
                                    <td><span class="btn btn-danger light">{{ $cuisine->name }}</span></td>
                                    <td><span class="btn btn-warning light">{{ $cuisine->desc }}</span></td>
                                    <td><span class="btn btn-success light">{{ $cuisine->resturants->count() }}</span></td>
                                    <td>
                                        <div class="dropdown">
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

                                                <a class="dropdown-item delete-cuisine" href="javascript:void(0);"
                                                    class="btn btn-primary mb-1" data-bs-toggle="modal"
                                                    data-id="{{ $cuisine->id }}"
                                                    data-bs-target="#deleteMessageModal">Delete</a>


                                                <a class="dropdown-item edit-cuisine" href="javascript:void(0);"
                                                    class="btn btn-primary mb-1" data-bs-toggle="modal"
                                                    data-id="{{ $cuisine->id }}"
                                                    data-bs-target="#editMessageModal">Edit</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                            @endforelse


                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="sendMessageModal">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <form method="post" action="{{ route('cuisines.store') }}" autocomplete="off" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add a Cuisine</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <form class="comment-form">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="mb-3">
                                        <label class="text-black font-w600 form-label">Name
                                            <span class="required">*</span></label>
                                        <input type="text" class="form-control" name="name"
                                            placeholder="name"required />
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="mb-3">
                                        <label class="text-black font-w600 form-label">Description</label>
                                        <textarea rows="8" class="form-control" name="description" placeholder="description"required>
                                    </textarea>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="mb-3 mb-0">
                                        <input type="submit" value="submit" class="submit btn btn-primary"
                                            name="submit" />
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </form>
        </div>
    </div>


    <div class="modal fade" id="editMessageModal">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <form method="post" action="{{ route('cuisines.update', $cuisine->id) }}" autocomplete="off"
                enctype="multipart/form-data">
                {{ method_field('patch') }}
                {{ csrf_field() }}
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Cuisine</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <form class="comment-form">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="mb-3">
                                        <label class="text-black font-w600 form-label">Name
                                            <span class="required">*</span></label>
                                        <input type="text" class="form-control" name="name"
                                            placeholder="name"required />
                                        <input type="text" id="edit_cuisine_id"
                                            value="{{ $cuisine->id }}"name="cuisine_id">
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="mb-3">
                                        <label class="text-black font-w600 form-label">Description</label>
                                        <textarea rows="8" class="form-control" name="description" placeholder="description"required>
                                    </textarea>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="mb-3 mb-0">
                                        <input type="submit" value="submit" class="submit btn btn-primary"
                                            name="submit" />
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="deleteMessageModal">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <form method="post" action="{{ route('cuisines.destroy', $cuisine->id) }}" autocomplete="off"
                enctype="multipart/form-data">
                {{ method_field('delete') }}
                {{ csrf_field() }}
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Delete Cuisine</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <form class="comment-form">
                            <div class="row">
                                <div class="swal2-header">
                                    <ul class="swal2-progresssteps" style="display: none;"></ul>
                                    <div class="swal2-icon swal2-error" style="display: none;"><span
                                            class="swal2-x-mark"><span class="swal2-x-mark-line-left"></span><span
                                                class="swal2-x-mark-line-right"></span></span></div>
                                    <div class="swal2-icon swal2-question" style="display: none;"><span
                                            class="swal2-icon-text">?</span></div>
                                    <div class="swal2-icon swal2-warning swal2-animate-warning-icon"
                                        style="display: flex;"><span class="swal2-icon-text"></span></div>
                                    <div class="swal2-icon swal2-info" style="display: none;"><span
                                            class="swal2-icon-text">i</span></div>
                                    <div class="swal2-icon swal2-success" style="display: none;">
                                        <div class="swal2-success-circular-line-left"
                                            style="background-color: rgb(255, 255, 255);"></div><span
                                            class="swal2-success-line-tip"></span> <span
                                            class="swal2-success-line-long"></span>
                                        <div class="swal2-success-ring"></div>
                                        <div class="swal2-success-fix" style="background-color: rgb(255, 255, 255);">
                                        </div>
                                        <div class="swal2-success-circular-line-right"
                                            style="background-color: rgb(255, 255, 255);"></div>
                                    </div><img class="swal2-image" style="display: none;">
                                    <h2 class="swal2-title" id="swal2-title" style="display: flex;">Are you sure to
                                        delete ?</h2><button type="button" class="swal2-close"
                                        style="display: none;">×</button>
                                </div>
                                <div class="col-lg-12">
                                    <div class="mb-3 mb-0">
                                        <input type="submit" value="submit" class="submit btn btn-primary"
                                            name="submit" />
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            // استرداد الهوية عند النقر على رابط الحذف
            $('.edit-cuisine').click(function() {
                var cuisineId = $(this).data('id');
                // تحديث الهوية في حقل النموذج المخفي
                $('#edit_cuisine_id').val(cuisineId);
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            // استرداد الهوية عند النقر على رابط الحذف
            $('.delete-cuisine').click(function() {
                var cuisineId = $(this).data('id');
                // تحديث الهوية في حقل النموذج المخفي
                $('#delete_cuisine_id').val(cuisineId);
            });
        });
    </script>

@endsection
@section('js')
@endsection
