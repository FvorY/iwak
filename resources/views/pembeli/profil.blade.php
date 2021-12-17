@extends('layouts.homepage.app_home')

@section('content')
	<!-- mt main start here -->
			<main id="mt-main">
				<!-- Mt Contact Banner of the Page -->

				<br>
				<div class="container" style="border:2px solid #cccccc; border-radius:5px">
					<div class="row">
						<form method="post" class="form-inline " action="{{ url('editmember') }}" accept-charset="UTF-8" enctype="multipart/form-data">
          					{{ csrf_field() }}
						<center>
						<div class="col-xs-12">
							<h2>My Profile</h2>
						</div>
						<hr class="text-center" style="width:50%;">
						</center>
						<div class="col-md-12 container">
							<center>
							<div class="col-md-4">
								<img class='img-circle img-responsive' alt="Responsive image" src="{{url('/')}}/{{$data->profile_picture}}" style="border-radius:100%;width: 200pt;height: 180pt;margin-bottom: 10px;">

								<input type="file" class="form-control form-control-sm uploadGambar" name="image" accept="image/*">
							</div>
							</center>
							<div class="col-md-8">
								<div class="col-md-6">
								  <label for="email">Fullname :</label>
								  <input type="text" class="form-control" placeholder="Enter Fullname" id="email" value="@isset($data){{$data->fullname}}@endisset" style="width:100%" name="fullname">
								</div>
								<div class="col-md-6">
								  <label for="email">Email Address :</label>
								  <input type="email" class="form-control" placeholder="Enter Email" value="@isset($data){{$data->email}}@endisset" id="email" style="width:100%" disabled name="email">
								</div>
								<div class="col-md-12"><br></div>
								<div class="col-md-6">
								  <label for="pwd">Password :</label>
								  <input type="password" class="form-control" placeholder="Enter password" id="pwd" value="@isset($data){{$data->password}}@endisset" style="width:100%" name="password">
								</div>
								<div class="col-md-6">
								  <label for="pwd">Confirmation Password :</label>
								  <input id="password" type="password" class="form-control" placeholder="Re Type Password" id="password_confirmation" name="password_confirmation" value="@isset($data){{$data->password}}@endisset" style="width:100%">

								</div>
								<br>
								<div class="col-md-12"><br></div>
								<div class="col-md-6">
								  <label for="email">Phone :</label>
								  <input type="text" class="form-control" placeholder="Enter Phone" value="@isset($data){{$data->phone}}@endisset" id="email" style="width:100%" name="phone">
								</div>
								<div class="col-md-6">
								  <label for="email">Gender :</label>
								 <!-- <select class="form-control" name="gender" id="gender" style="width:100%">
								  	<option value="L">Male</option>
								  	<option value="P">Female</option>
								</select> -->
								@if($data->gender = "L")
								<input type="text" class="form-control" value="Male" id="pwd" style="width:100%" disabled>
								@elseif($data->gender = "P")
								<input type="text" class="form-control" value="Female" id="pwd" style="width:100%" disabled>
								@endif
								</div>
								<div class="col-md-12"><br></div>
								<div class="col-md-12">
									<label for="code">Code Forgot Password :</label>
									<input type="text" class="form-control" maxlength="6" placeholder="Enter Code" value="" id="code" style="width:100%" name="code">
								</div>
								<div class="col-md-12"><br></div>
								<div class="col-md-12">
								  <label for="pwd">Address :</label>
								  <input type="text" class="form-control" placeholder="Enter Address" value="@isset($data){{$data->address}}@endisset" id="pwd" style="width:100%" name="address">
										<div class="alert alert-warning" role="alert">
			                This address will also be used for the shop address (Format: street name and house number (space) sub-district (space) city)
			              </div>
								</div>
								<br>
								<div class="col-md-12"><br></div>
								<br>
								<div class="col-md-6">
								  <label for="pwd">Account Number :</label>
								  <input type="number" class="form-control" placeholder="Enter Your Account Number" value="@isset($data){{$data->nomor_rekening}}@endisset" id="pwd" style="width:100%; margin-bottom: 5px;" name="norek">
								  <div class="alert alert-warning" role="alert">
								  Please fill in your account number for successful payment
                                    </div>
								</div>
								<div class="col-md-6">
								  <label for="pwd">Bank Name :</label>
								  <input type="text" class="form-control" placeholder="Enter Bank" value="@isset($data){{$data->bank}}@endisset" id="pwd" style="width:100%; margin-bottom: 5px;" name="bank">
								  <div class="alert alert-warning" role="alert">
								  Please fill in your bank name for successful payment
                                    </div>
								</div>
								</div>
								<div class="col-lg-12 text-center">
								<button type="submit" class="btn btn-lg btn-success" style="margin-bottom: 10px;">Edit</button>
								</div>
							</form>
						</div>
						<div class="col-xs-12 col-md-1"></div>


					</div>
					<br>
				</div>


			</main> <!-- end main -->
			<br>
@endsection
