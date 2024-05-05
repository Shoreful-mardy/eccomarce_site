@extends('vendor.vendor_dashboard')
@section('vendor')
<div class="page-content">
				<!--breadcrumb-->
				<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
					<div class="breadcrumb-title pe-3">All Review</div>
					<div class="ps-3">
						<nav aria-label="breadcrumb">
							<ol class="breadcrumb mb-0 p-0">
								<li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
								</li>
								<li class="breadcrumb-item active" aria-current="page">All Review</li>
							</ol>
						</nav>
					</div>
					<div class="ms-auto">
						<div class="btn-group">
                       
						</div>
					</div>
				</div>
				<!--end breadcrumb-->
		
				<hr/>
				<div class="card">
					<div class="card-body">
						<div class="table-responsive">
							<table id="example" class="table table-striped table-bordered" style="width:100%">
								<thead>
									<tr>
										<th>SL</th>
										<th>Product Image</th>
										<th>Product Name</th>
										<th>Comment</th>
										<th>User Name</th>
										<th>Rating</th>
										<th>Status</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
                                    @foreach ($review as $key => $item)
                                        
                                    
									<tr>
										<td>{{ $key+1}}</td>
										<td><img src="{{ asset($item['product']['product_thambnail']) }}" style="width:60px; height:40px;"></td>
										<td>{{ Str::limit($item['product']['product_name'],25) }}</td>
										<td>{{ Str::limit($item->comment,25) }}</td>
										<td>{{ $item['user']['name'] }}</td>
										<td>
											@if( $item->rating == NULL)
											<i class="bx bxs-star text-secondary"></i>
											@elseif($item->rating == 1)
											<i class="bx bxs-star text-warning"></i>
											<i class="bx bxs-star text-secondary"></i>
											<i class="bx bxs-star text-secondary"></i>
											<i class="bx bxs-star text-secondary"></i>
											<i class="bx bxs-star text-secondary"></i>
											@elseif($item->rating == 2)
											<i class="bx bxs-star text-warning"></i>
											<i class="bx bxs-star text-warning"></i>
											<i class="bx bxs-star text-secondary"></i>
											<i class="bx bxs-star text-secondary"></i>
											<i class="bx bxs-star text-secondary"></i>
											@elseif($item->rating == 3)
											<i class="bx bxs-star text-warning"></i>
											<i class="bx bxs-star text-warning"></i>
											<i class="bx bxs-star text-warning"></i>
											<i class="bx bxs-star text-secondary"></i>
											<i class="bx bxs-star text-secondary"></i>
											@elseif($item->rating == 4)
											<i class="bx bxs-star text-warning"></i>
											<i class="bx bxs-star text-warning"></i>
											<i class="bx bxs-star text-warning"></i>
											<i class="bx bxs-star text-warning"></i>
											<i class="bx bxs-star text-secondary"></i>
											@elseif($item->rating == 5)
											<i class="bx bxs-star text-warning"></i>
											<i class="bx bxs-star text-warning"></i>
											<i class="bx bxs-star text-warning"></i>
											<i class="bx bxs-star text-warning"></i>
											<i class="bx bxs-star text-warning"></i>
											@endif
										</td>
										<td>
											@if($item->status == 0)
											<span class="badge rounded-pill bg-danger">Pending</span>
											@else
											<span class="badge rounded-pill bg-success">Approved</span>
											@endif
											
										</td>
										<td>
                                            <a href="{{route('admin.approve.review',$item->id)}}" class="btn btn-info">Approve</a>
                                        </td>
									</tr>

                                    @endforeach
								</tbody>
								<tfoot>
									<tr>
										<th>SL</th>
										<th>Product Image</th>
										<th>Product Name</th>
										<th>Comment</th>
										<th>User Name</th>
										<th>Rating</th>
										<th>Status</th>
										<th>Action</th>
									</tr>
								</tfoot>
							</table>
						</div>
					</div>
				</div>


	
			</div>

@endsection