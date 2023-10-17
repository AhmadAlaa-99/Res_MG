@extends('layouts.master')
@section('css')
@endsection
@section('title')
    Restrants Management - Profile
@stop
@section('content')
    <div class="container-fluid">
        <div class="row page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active">
                    <a href="javascript:void(0)">App</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="javascript:void(0)">Profile</a>
                </li>
            </ol>
        </div>
        <!-- row -->

        <div class="row">

            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <div class="profile-tab">
                            <div class="custom-tab-1">
                                <ul class="nav nav-tabs">
                                    {{-- <li class="nav-item">
                                        <a href="#my-posts" data-bs-toggle="tab" class="nav-link active show">Posts</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#about-me" data-bs-toggle="tab" class="nav-link">About Me</a>
                                    </li> --}}
                                    <li class="nav-item">
                                        <a href="#profile-settings" data-bs-toggle="tab"
                                            class="nav-link active show">Setting</a>
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    {{-- <div id="my-posts" class="tab-pane fade active show">
                                        <div class="my-post-content pt-3">
                                            <div class="post-input">
                                                <textarea name="textarea" id="textarea" cols="30" rows="5" class="form-control bg-transparent"
                                                    placeholder="Please type what you want...."></textarea>
                                                <a href="javascript:void(0);" class="btn btn-primary light me-1 px-3"
                                                    data-bs-toggle="modal" data-bs-target="#linkModal"><i
                                                        class="fa fa-link m-0"></i>
                                                </a>
                                                <!-- Modal -->
                                                <div class="modal fade" id="linkModal">
                                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Social Links</h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <a class="btn-social facebook" href="javascript:void(0)"><i
                                                                        class="fab fa-facebook-f"></i></a>
                                                                <a class="btn-social google-plus"
                                                                    href="javascript:void(0)"><i
                                                                        class="fab fa-google-plus-g"></i></a>
                                                                <a class="btn-social linkedin" href="javascript:void(0)"><i
                                                                        class="fab fa-linkedin"></i></a>
                                                                <a class="btn-social instagram" href="javascript:void(0)"><i
                                                                        class="fab fa-instagram"></i></a>
                                                                <a class="btn-social twitter" href="javascript:void(0)"><i
                                                                        class="fab fa-twitter"></i></a>
                                                                <a class="btn-social youtube" href="javascript:void(0)"><i
                                                                        class="fab fa-youtube"></i></a>
                                                                <a class="btn-social whatsapp" href="javascript:void(0)"><i
                                                                        class="fab fa-whatsapp"></i></a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <a href="javascript:void(0);" class="btn btn-primary light me-1 px-3"
                                                    data-bs-toggle="modal" data-bs-target="#cameraModal"><i
                                                        class="fa fa-camera m-0"></i>
                                                </a>
                                                <!-- Modal -->
                                                <div class="modal fade" id="cameraModal">
                                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Upload images</h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="input-group mb-3">
                                                                    <span class="input-group-text">Upload</span>
                                                                    <div class="form-file">
                                                                        <input type="file"
                                                                            class="form-file-input form-control" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <a href="javascript:void(0);" class="btn btn-primary" data-bs-toggle="modal"
                                                    data-bs-target="#postModal">Post</a>
                                                <!-- Modal -->
                                                <div class="modal fade" id="postModal">
                                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Post</h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <textarea name="textarea" id="textarea2" cols="30" rows="5" class="form-control bg-transparent"
                                                                    placeholder="Please type what you want...."></textarea>
                                                                <a class="btn btn-primary btn-rounded"
                                                                    href="javascript:void(0)">Post</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="profile-uoloaded-post border-bottom-1 pb-5">
                                                <img src="images/profile/8.jpg" alt=""
                                                    class="img-fluid w-100 rounded" />
                                                <a class="post-title" href="post-details.html">
                                                    <h3 class="text-black">
                                                        Collection of textile samples lay spread
                                                    </h3>
                                                </a>
                                                <p>
                                                    A wonderful serenity has take possession of my
                                                    entire soul like these sweet morning of spare
                                                    which enjoy whole heart.A wonderful serenity has
                                                    take possession of my entire soul like these
                                                    sweet morning of spare which enjoy whole heart.
                                                </p>
                                                <button class="btn btn-primary me-2">
                                                    <span class="me-2"><i class="fa fa-heart"></i></span>Like
                                                </button>
                                                <button class="btn btn-secondary" data-bs-toggle="modal"
                                                    data-bs-target="#replyModal">
                                                    <span class="me-2"><i class="fa fa-reply"></i></span>Reply
                                                </button>
                                            </div>
                                            <div class="profile-uoloaded-post border-bottom-1 pb-5">
                                                <img src="images/profile/9.jpg" alt=""
                                                    class="img-fluid w-100 rounded" />
                                                <a class="post-title" href="post-details.html">
                                                    <h3 class="text-black">
                                                        Collection of textile samples lay spread
                                                    </h3>
                                                </a>
                                                <p>
                                                    A wonderful serenity has take possession of my
                                                    entire soul like these sweet morning of spare
                                                    which enjoy whole heart.A wonderful serenity has
                                                    take possession of my entire soul like these
                                                    sweet morning of spare which enjoy whole heart.
                                                </p>
                                                <button class="btn btn-primary me-2">
                                                    <span class="me-2"><i class="fa fa-heart"></i></span>Like
                                                </button>
                                                <button class="btn btn-secondary" data-bs-toggle="modal"
                                                    data-bs-target="#replyModal">
                                                    <span class="me-2"><i class="fa fa-reply"></i></span>Reply
                                                </button>
                                            </div>
                                            <div class="profile-uoloaded-post pb-3">
                                                <img src="images/profile/8.jpg" alt=""
                                                    class="img-fluid w-100 rounded" />
                                                <a class="post-title" href="post-details.html">
                                                    <h3 class="text-black">
                                                        Collection of textile samples lay spread
                                                    </h3>
                                                </a>
                                                <p>
                                                    A wonderful serenity has take possession of my
                                                    entire soul like these sweet morning of spare
                                                    which enjoy whole heart.A wonderful serenity has
                                                    take possession of my entire soul like these
                                                    sweet morning of spare which enjoy whole heart.
                                                </p>
                                                <button class="btn btn-primary me-2">
                                                    <span class="me-2"><i class="fa fa-heart"></i></span>Like
                                                </button>
                                                <button class="btn btn-secondary" data-bs-toggle="modal"
                                                    data-bs-target="#replyModal">
                                                    <span class="me-2"><i class="fa fa-reply"></i></span>Reply
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="about-me" class="tab-pane fade">
                                        <div class="profile-about-me">
                                            <div class="pt-4 border-bottom-1 pb-3">
                                                <h4 class="text-primary">About Me</h4>
                                                <p class="mb-2">
                                                    A wonderful serenity has taken possession of my
                                                    entire soul, like these sweet mornings of spring
                                                    which I enjoy with my whole heart. I am alone,
                                                    and feel the charm of existence was created for
                                                    the bliss of souls like mine.I am so happy, my
                                                    dear friend, so absorbed in the exquisite sense
                                                    of mere tranquil existence, that I neglect my
                                                    talents.
                                                </p>
                                                <p>
                                                    A collection of textile samples lay spread out
                                                    on the table - Samsa was a travelling salesman -
                                                    and above it there hung a picture that he had
                                                    recently cut out of an illustrated magazine and
                                                    housed in a nice, gilded frame.
                                                </p>
                                            </div>
                                        </div>
                                        <div class="profile-skills mb-5">
                                            <h4 class="text-primary mb-2">Skills</h4>
                                            <a href="javascript:void(0);"
                                                class="btn btn-primary light btn-xs mb-1">Admin</a>
                                            <a href="javascript:void(0);"
                                                class="btn btn-primary light btn-xs mb-1">Dashboard</a>
                                            <a href="javascript:void(0);"
                                                class="btn btn-primary light btn-xs mb-1">Photoshop</a>
                                            <a href="javascript:void(0);"
                                                class="btn btn-primary light btn-xs mb-1">Bootstrap</a>
                                            <a href="javascript:void(0);"
                                                class="btn btn-primary light btn-xs mb-1">Responsive</a>
                                            <a href="javascript:void(0);"
                                                class="btn btn-primary light btn-xs mb-1">Crypto</a>
                                        </div>
                                        <div class="profile-lang mb-5">
                                            <h4 class="text-primary mb-2">Language</h4>
                                            <a href="javascript:void(0);" class="text-muted pe-3 f-s-16"><i
                                                    class="flag-icon flag-icon-us"></i> English</a>
                                            <a href="javascript:void(0);" class="text-muted pe-3 f-s-16"><i
                                                    class="flag-icon flag-icon-fr"></i> French</a>
                                            <a href="javascript:void(0);" class="text-muted pe-3 f-s-16"><i
                                                    class="flag-icon flag-icon-bd"></i> Bangla</a>
                                        </div>
                                        <div class="profile-personal-info">
                                            <h4 class="text-primary mb-4">
                                                Personal Information
                                            </h4>
                                            <div class="row mb-2">
                                                <div class="col-sm-3 col-5">
                                                    <h5 class="f-w-500">
                                                        Name <span class="pull-end">:</span>
                                                    </h5>
                                                </div>
                                                <div class="col-sm-9 col-7">
                                                    <span>Mitchell C.Shay</span>
                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col-sm-3 col-5">
                                                    <h5 class="f-w-500">
                                                        Email <span class="pull-end">:</span>
                                                    </h5>
                                                </div>
                                                <div class="col-sm-9 col-7">
                                                    <span>example@examplel.com</span>
                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col-sm-3 col-5">
                                                    <h5 class="f-w-500">
                                                        Availability <span class="pull-end">:</span>
                                                    </h5>
                                                </div>
                                                <div class="col-sm-9 col-7">
                                                    <span>Full Time (Free Lancer)</span>
                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col-sm-3 col-5">
                                                    <h5 class="f-w-500">
                                                        Age <span class="pull-end">:</span>
                                                    </h5>
                                                </div>
                                                <div class="col-sm-9 col-7"><span>27</span></div>
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col-sm-3 col-5">
                                                    <h5 class="f-w-500">
                                                        Location <span class="pull-end">:</span>
                                                    </h5>
                                                </div>
                                                <div class="col-sm-9 col-7">
                                                    <span>Rosemont Avenue Melbourne, Florida</span>
                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col-sm-3 col-5">
                                                    <h5 class="f-w-500">
                                                        Year Experience
                                                        <span class="pull-end">:</span>
                                                    </h5>
                                                </div>
                                                <div class="col-sm-9 col-7">
                                                    <span>07 Year Experiences</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div> --}}
                                    <div id="profile-settings" class="tab-pane fade active show">
                                        <div class="pt-3">
                                            <div class="settings-form">
                                                <h4 class="text-primary">Account</h4>
                                                <form method="post" action="{{ route('update_profile_staff') }}" autocomplete="off"
                                                enctype="multipart/form-data">
                                                @csrf
                                                    <div class="row">
                                                        <div class="mb-3 col-md-6">
                                                            <label class="form-label">Email</label>
                                                            <input type="email" style="background-color:#5bcfc5"
                                                                placeholder="Email" value="{{ $user->email }}" name="email"
                                                                class="form-control" disabled />
                                                        </div>
                                                        <div class="mb-3 col-md-6">
                                                            <label class="form-label">Password</label>
                                                            <input type="password" style="background-color:#5bcfc5"
                                                                placeholder="*************" class="form-control"name="password" disabled />
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="mb-4 col-md-4">
                                                            <label class="form-label">Name</label>
                                                            <input type="text" placeholder="Name"
                                                                value="{{ $user->name }}" class="form-control" name="name" required />
                                                        </div>
                                                        <div class="mb-4 col-md-4">
                                                            <label class="form-label">Phone</label>
                                                            <input type="text" placeholder="phone" name="phone"
                                                                value="{{ $user->phone }}" class="form-control" name="phone" required />
                                                        </div>
                                                        <div class="mb-4 col-md-4">
                                                            <label class="form-label">Role</label>
                                                            <input type="text" style="background-color:#5bcfc5"
                                                                value="{{ $user->role_name }}"disabled
                                                                class="form-control" />
                                                        </div>
                                                    </div>
                                                    <button class="btn btn-primary" type="submit">
                                                        Confirm
                                                    </button>
                                                </form>
                                            </div>
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
                                                <textarea class="form-control" rows="4">
    Message</textarea>
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-danger light" data-bs-dismiss="modal">
                                                btn-close
                                            </button>
                                            <button type="button" class="btn btn-primary">
                                                Reply
                                            </button>
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
