@extends('layout.app2')
@section('title','ADMIN | LOGIN')
@section('content')
<div class="d-flex align-items-center" style="height: 100vh;">
	<div class="container">
		<div class="row">
			<div class="col-md-6 mx-auto card shadow">
				<div class="card-body p-3">
					<h2 class="text-center">Admin Login</h2><hr>

					<form action="" class="loginForm">
						<div class="form-group">
							<label for="uname">Username</label>
							<input type="text" id="uname" placeholder="Enter User Name" class="form-control">
						</div>
						<div class="form-group">
							<label for="upass">Password</label>
							<input type="password" id="upass" placeholder="Enter Password" class="form-control">
						</div>
						<div class="form-group">
							<button type="submit" id="loginSubmit" class="btn btn-block btn-danger rounded">Admin Login</button>
						</div>
					</form>

				</div>		
			</div>
		</div>
	</div>
</div>
@endsection
@section('script')
<script type="text/javascript">
$(document).ready(function(){

$('.loginForm').on('submit', function(event){

	event.preventDefault();
	let username =$('#uname').val();
	let password =$('#upass').val();

	if (username.length==0) {toastr.error('Username Required');}
	else if (password.length==0) {toastr.error('Password Required');}
	else{
		$('#loginSubmit').html('Authenticating....');

	axios.post('/adminLogin',{
		username:username,
		password:password
		
	}).then(function(response){
		if (response.status==200 && response.data==1) {
			$('#loginSubmit').html('Admin Login');
			toastr.success('Login Success');
			//REDIRECT......
			window.location.href="/";
		}else{ toastr.error('Login Failed');
		$('#loginSubmit').html('Admin Login');}

	}).catch(function(error){
		 toastr.error('Login Failed');
		 $('#loginSubmit').html('Admin Login');
	});
	}
});
});
</script>
@endsection