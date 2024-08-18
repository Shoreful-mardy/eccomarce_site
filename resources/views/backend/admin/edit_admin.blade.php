@extends('admin.admin_dashboard')
@section('admin')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<div class="page-content">

				<!--breadcrumb-->
				<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
					<div class="breadcrumb-title pe-3">Home</div>
					<div class="ps-3">
						<nav aria-label="breadcrumb">
							<ol class="breadcrumb mb-0 p-0">
								<li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
								</li>
								<li class="breadcrumb-item active" aria-current="page">Edit Admin</li>
							</ol>
						</nav>
					</div>
				</div>
				<!--end breadcrumb-->

<div class="card">
    <div class="card-body p-4">
        <h5 class="card-title">Edit Admin</h5>
        <hr/>
  <form id="myForm" method="POST" action="{{ route('update.admin',$user->id)}}">
                    @csrf


        <div class="form-body mt-4">
        <div class="row">
            <div class="col-lg-12">
            <div class="border border-3 p-4 rounded">


                <div class="form-group mb-3">
                <label for="inputProductTitle" class="form-label">Admin User Name</label>
                <input type="text" name="name" class="form-control" value="{{ $user->name }}"  id="inputProductTitle">
                </div>

                <div class="form-group mb-3">
                <label for="inputProductTitle" class="form-label">Admin User Email</label>
                <input type="text" name="email" class="form-control"  value="{{ $user->email }}" id="inputProductTitle">
                </div>

                <div class="form-group mb-3">
                <label for="inputProductTitle" class="form-label">Admin User Address</label>
                <input type="text" name="address" class="form-control" value="{{ $user->address }}"  id="inputProductTitle">
                </div>

                <div class="form-group mb-3">
                <label for="inputProductTitle" class="form-label">Admin User Phone</label>
                <input type="text" name="phone" class="form-control" value="{{ $user->phone }}"  id="inputProductTitle">
                </div>

                <div class="form-group mb-3">
                <label for="inputProductTitle" class="form-label">Admin Role</label>
                <select name="roles" class="form-select mb-3" aria-label="Default select example">
                    <option selected="">Open this select Role</option>
                    @foreach($roles as $role)
                    <option value="{{ $role->name }}" {{ $user->hasRole($role->name) ? 'selected' : '' }}>{{ $role->name }}</option>
                    @endforeach
                </select>
                </div>



               

                <div class="form-group mb-3">
                    <input type="submit" class="btn btn-primary" value="Save Changes" />
                </div>
            </div>
            </div>
        </div><!--end row-->
    </div>
    </div>
</form>
</div>

			</div>

<!-- script for Validation -->
<script type="text/javascript">
                
                $(document).ready(function(){
                    $('#myForm').validate({
                        rules:{
                            name:{
                                required:true,
                            },
                            email:{
                                required:true,
                            },
                            address:{
                                required:true,
                            },
                            phone:{
                                required:true,
                            },
                            password:{
                                required:true,
                            },
                            roles:{
                                required:true,
                            },
                        },
                        messages :{
                            name:{
                                required : 'Please Enter Admin Name',
                            },
                            email:{
                                required : 'Please Enter Admin User Email',
                            },
                            address:{
                                required : 'Please Enter Admin Address',
                            },
                            phone:{
                                required : 'Please Enter Admin Phone No',
                            },
                            password:{
                                required : 'Please Enter Admin Password',
                            },
                            roles:{
                                required : 'Please Select Admin Role',
                            },
                        },

                        
                        errorElement : 'span',
                        errorPlacement :function(error,element){
                            error.addClass('invalid-feedback');
                            element.closest('.form-group').append(error);
                        },
                        highlight:function(element, errorClass, validClass){
                            $(element).addClass('is-invalid');
                        },
                        unhighlight:function(element, errorClass, validClass){
                            $(element).removeClass('is-invalid');
                        },
                    });
                });

            </script>

@endsection