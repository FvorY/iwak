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
						<div class="col-md-1"></div>
						<div class="col-xs-12 col-md-6">
							<!-- <div class="row"> -->
								<div class="col-md-6">
								  <label for="email">Fullname :</label>
								  <input type="text" class="form-control" placeholder="Enter Fullname" id="email" value="@isset($data){{$data->fullname}}@endisset" style="width:100%" name="fullname">
								</div>
								<div class="col-md-6">
								  <label for="email"></label>
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
								  <label for="pwd">Address :</label>
								  <input type="text" class="form-control" placeholder="Enter Address" value="@isset($data){{$data->address}}@endisset" id="pwd" style="width:100%" name="address">
								</div>
								<br>
								<div class="col-md-12"><br></div>
								<br>
								<div class="col-md-6">
								  <label for="pwd">Nomor Rekening :</label>
								  <input type="number" class="form-control" placeholder="Enter Rekening" value="@isset($data){{$data->nomor_rekening}}@endisset" id="pwd" style="width:100%; margin-bottom: 5px;" name="norek">
								  <div class="alert alert-warning" role="alert">
                                      Mohon isi nomor rekening anda untuk kelancaran pembayaran
                                    </div>
								</div>
								<div class="col-md-6">
								  <label for="pwd">Nama Bank :</label>
								  <input type="text" class="form-control" placeholder="Enter Bank" value="@isset($data){{$data->bank}}@endisset" id="pwd" style="width:100%; margin-bottom: 5px;" name="bank">
								  <div class="alert alert-warning" role="alert">
                                      Mohon isi Nama Bank anda untuk kelancaran pembayaran
                                    </div>
								</div>
							  <!-- <button type="submit" class="btn btn-primary">Submit</button> -->
							<br>
						<!-- </div> -->
						</div>
						<div class="col-xs-12 col-md-1"></div>
						<div class="col-xs-12 col-md-3">
							<img class='img-circle img-responsive' src="{{url('/')}}/{{$data->profile_picture}}" style="width:100%; height: 200pt; border-radius:100%;">
							<br>
							<input type="file" class="form-control form-control-sm uploadGambar" name="image" accept="image/*">
						</div>
						<div class="col-xs-12 col-md-1"></div>

						<div class="col-lg-12 text-center">
						<button type="submit" class="btn btn-lg btn-success">Edit</button>
						</div>
						</form>
					</div>
					<br>
				</div>


			</main> <!-- end main -->
			<br>
@endsection