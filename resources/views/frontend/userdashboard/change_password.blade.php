@extends('dashboard')
@section('user')
@section('title')
BD-Shop || Change Password
@endsection

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<div class="page-header breadcrumb-wrap">
            <div class="container">
                <div class="breadcrumb">
                    <a href="index.html" rel="nofollow"><i class="fi-rs-home mr-5"></i>Home</a>
                    <span></span> Change Password
                </div>
            </div>
        </div>
        <div class="page-content pt-50 pb-50">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 m-auto">
                        <div class="row">

                      <!-- Start col-md-3 menu -->

                            @include('frontend.body.dashboard_sidebar_menu')

                            <!-- end col-md-3 menu -->

                            <div class="col-md-9">
                                <div class="tab-content account dashboard-content pl-50">
                                    <div class="tab-pane fade active show" id="dashboard" role="tabpanel" aria-labelledby="dashboard-tab">
                                        <div class="card">
    <div class="card-header">
        <h5>Change Password</h5>
    </div>
    
    <div class="card-body">
<form method="POST" action="{{ route('user.change.password')}}">
@csrf

                @if(session('status'))
                <div class="alert alert-success" role="alert">{{session('status')}}</div>
                @elseif (session('error'))
                <div class="alert alert-danger" role="alert">{{session('error')}}</div>
                @endif


<div class="row">

    <div class="form-group col-md-12">
        <label>Current Password</label>
        <input type="password" class="form-control @error('old_password') is-invalid @enderror"  id="old_password"  name="old_password" />
        @error('old_password')
            <span class="text-danger">{{$message}}</span>
        @enderror
    </div>
    
    <div class="form-group col-md-12">
        <label>New Password</label>
        <input type="password" class="form-control @error('new_password') is-invalid @enderror"  id="new_password"  name="new_password" />
        @error('new_password')
            <span class="text-danger">{{$message}}</span>
        @enderror
    </div>

    <div class="form-group col-md-12">
        <label>Confirmation Password</label>
        <input type="password" class="form-control @error('new_password') is-invalid @enderror"  id="confirmation_password"  name="confirmation_password" />

        @error('confirmation_password')
            <span class="text-danger">{{$message}}</span>
        @enderror
    </div>

    <div class="col-md-12">
        <button type="submit" class="btn btn-fill-out submit font-weight-bold" name="submit" value="Submit">Save Changes</button>
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
                </div>
            </div>
        </div>


@endsection