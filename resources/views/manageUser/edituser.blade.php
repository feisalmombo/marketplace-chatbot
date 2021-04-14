@extends('layouts.app')

@section('title', 'Edit Profile')

@section('content')
<div class="col-lg-12">
	<h1 class="page-header">Edit Profile</h1>
</div>

<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				Edit Profile<a href="{{ url('/view-users') }}" class="col-2 pull-right" style="text-decoration: none;"><i class="fa fa-arrow-left"></i>&nbsp;Back</a>
			</div>
			<div class="panel-body">
				<div class="container-fluid">
					<section class="container col-sm-offset-3">
						<div class="container-page">
							<div class="col-sm-6">
								<form role="form" id="sev" action="{{ url('/view-users/'.$users->id) }}" method="POST" class="form-horizontal">

									{{ csrf_field() }}
									{{ method_field('PATCH') }}

									<div class="col-lg-12 center-block">
										<h2 style="text-align: center;">Profile Information</h2>
										<div class="form-group">
											<label>First Name: </label>
											<input class="form-control" name="fname"  value="{{ isset($users->first_name) ? $users->first_name : old('fname') }}">
                                        </div>

                                        <div class="form-group">
											<label>Last Name: </label>
											<input class="form-control" name="lname"  value="{{ isset($users->last_name) ? $users->last_name : old('lname') }}">
                                        </div>

										<div class="form-group">
											<label>Email: </label>
											<input class="form-control" name="useremail"  value="{{ isset($users->email) ? $users->email : old('useremail') }}">
                                        </div>

                                        <div class="form-group">
                                                <label>Phone Number: </label>
                                                <input class="form-control" name="phonenumber"  value="{{ isset($users->phone_number) ? $users->phone_number : old('phonenumber') }}">
                                        </div>

										<div class="form-group">
											<button type="submit" class="btn btn-primary center-block">
												Update
											</button>
										</div>
									</div>
								</form>
							</div>
						</div>
					</section>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
