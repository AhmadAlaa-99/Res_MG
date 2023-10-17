@extends('layouts.master')
@section('css')
    <link href="{{ URL::asset('dashboard/calender.css') }}" rel="stylesheet">
@endsection
@section('title')
    Restrants Management - Reservations
@stop
@section('content')
    <div class="container-fluid">
        <div class="row page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active">
                    <a href="javascript:void(0)">Notifications</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="javascript:void(0)">Browse</a>
                </li>
            </ol>
        </div>

        <!-- row -->
        <div class="row">
            <div class="col-xl-12 col-xxl-12">
                <div class="card">
                    <div class="card-header d-block">
                        <h4 class="card-title">Notifications Browse</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-xl-6">
                                <div class="alert alert-primary left-icon-big alert-dismissible fade show">
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close">
                                        <span><i class="mdi mdi-btn-close"></i></span>
                                    </button>
                                    <div class="media">
                                        <div class="alert-left-icon-big">
                                            <span><i class="mdi mdi-email-alert"></i></span>
                                        </div>
                                        <div class="media-body">
                                            <h6 class="mt-1 mb-2">
                                                Welcome to your account, Dear user!
                                            </h6>
                                            <p class="mb-0">
                                                Please confirm your email address:
                                                email@example.com
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <div class="alert alert-warning left-icon-big alert-dismissible fade show">
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close">
                                        <span><i class="mdi mdi-btn-close"></i></span>
                                    </button>
                                    <div class="media">
                                        <div class="alert-left-icon-big">
                                            <span><i class="mdi mdi-help-circle-outline"></i></span>
                                        </div>
                                        <div class="media-body">
                                            <h5 class="mt-1 mb-2">Pending!</h5>
                                            <p class="mb-0">You message sending failed.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <div class="alert alert-success left-icon-big alert-dismissible fade show">
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close">
                                        <span><i class="mdi mdi-btn-close"></i></span>
                                    </button>
                                    <div class="media">
                                        <div class="alert-left-icon-big">
                                            <span><i class="mdi mdi-check-circle-outline"></i></span>
                                        </div>
                                        <div class="media-body">
                                            <h5 class="mt-1 mb-2">Congratulations!</h5>
                                            <p class="mb-0">
                                                You have successfully created a account.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <div class="alert alert-danger left-icon-big alert-dismissible fade show">
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close">
                                        <span><i class="mdi mdi-btn-close"></i></span>
                                    </button>
                                    <div class="media">
                                        <div class="alert-left-icon-big">
                                            <span><i class="mdi mdi-alert"></i></span>
                                        </div>
                                        <div class="media-body">
                                            <h5 class="mt-1 mb-2">Loading failed!</h5>
                                            <p class="mb-0">Again upload your server</p>
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


@endsection
@section('js')
@endsection
