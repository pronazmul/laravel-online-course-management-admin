@extends('layout.app')

@section('content')
<div class="container p-4">
	<div class="row">
		<div class="col-md-4 p-2">
			<div class="card shadow">
				<div class="card-body text-center">
					<h2>Total Visitors</h2><hr>
					<h4>{{$TotalVisitor}}</h4>
				</div>	
			</div>
		</div>
		<div class="col-md-4 p-2">
			<div class="card shadow">
				<div class="card-body text-center">
					<h2>Enrolled User</h2><hr>
					<h4>{{$TotalUser}}</h4>
				</div>	
			</div>
		</div>
		<div class="col-md-4 p-2">
			<div class="card shadow">
				<div class="card-body text-center">
					<h2>Total Message</h2><hr>
					<h4>{{$TotalContract}}</h4>
				</div>	
			</div>
		</div>

	</div>
</div>
@endsection