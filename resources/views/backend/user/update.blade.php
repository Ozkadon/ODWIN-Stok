<?php
	$breadcrumb = [];
	$breadcrumb[0]['title'] = 'Dashboard';
	$breadcrumb[0]['url'] = url('backend/dashboard');
	$breadcrumb[1]['title'] = 'User';
	$breadcrumb[1]['url'] = url('backend/users-user');	
	$breadcrumb[2]['title'] = 'Add';
	$breadcrumb[2]['url'] = url('backend/users-user/create');
	if (isset($data)){
		$breadcrumb[2]['title'] = 'Edit';
		$breadcrumb[2]['url'] = url('backend/users-user/'.$data[0]->id.'/edit');
	}
?>

<?php
	$cover_1 = [];
	if (isset($data)){
		$cover_1 = $data[0];
		$cover_1->field = 'avatar_id';
	}
?>

@if(Session::has('errors'))
<?php 
	$errors = Session::get('errors'); 
?>
@endif

<!-- LAYOUT -->
@extends('backend.layouts.main')

<!-- TITLE -->
@section('title')
	<?php
		$mode = "Create";
		if (isset($data)){
			$mode = "Edit";
		}
	?>
    Master User - <?=$mode;?>
@endsection

<!-- CONTENT -->
@section('content')
	<?php
		$firstname = old('firstname');
        $lastname = old('lastname');
        $birthdate = date('d-m-Y');
        $phone = old('phone');
        $address = old('address');
        $gender = old('gender');
		$email = old('email');
		$username = old('username');
		$avatar_id = old('avatar_id', 0);
		$active = 1;
		$method = "POST";
		$mode = "Create";
		$url = "backend/users-user";
		$user_level_id = 0;
		if (isset($data)){
			$firstname = $data[0]->firstname;
            $lastname = $data[0]->lastname;
            $birthdate = date('d-m-Y',strtotime($data[0]->birthdate));
            $phone = $data[0]->phone;
            $address = $data[0]->address;
            $gender = $data[0]->gender;
			$email = $data[0]->email;
			$username = $data[0]->username;
			$avatar_id = $data[0]->avatar_id;
			$active = $data[0]->active;
			$user_level_id = $data[0]->user_level_id;
			$method = "PUT";
			$mode = "Edit";
			$url = "backend/users-user/".$data[0]->id;
		}
	?>
	<div class="page-title">
		<div class="title_left">
			<h3>Master User - <?=$mode;?></h3>
		</div>
		<div class="title_right">
			<div class="col-md-4 col-sm-4 col-xs-8 form-group pull-right top_search">
                @include('backend.elements.back_button',array('url' => '/backend/users-user'))
			</div>
        </div>
        <div class="clearfix"></div>
		@include('backend.elements.breadcrumb',array('breadcrumb' => $breadcrumb))
	</div>
	<div class="clearfix"></div>
	<br/><br/>	
	<div class="row">
		<div class="col-xs-12">
			<div class="x_panel">
				<div class="x_content">
					{{ Form::open(['url' => $url, 'method' => $method,'class' => 'form-horizontal form-label-left']) }}
						{!! csrf_field() !!}
						<div class="form-group">
							<label class="control-label col-sm-3 col-xs-12">First Name</label>
							<div class="col-sm-7 col-xs-12">
								<input type="text" id="firstname" name="firstname" class="form-control" value="<?=$firstname;?>" autofocus>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-3 col-xs-12">Last Name</label>
							<div class="col-sm-7 col-xs-12">
								<input type="text" id="lastname" name="lastname" class="form-control" value="<?=$lastname;?>">
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-3 col-xs-12">Avatar</label>
							<div class="col-sm-6 col-xs-9">
								<input type="hidden" name="avatar_id" value=<?=$avatar_id;?> id="id-cover-image_1">
								@include('backend.elements.change_cover',array('cover' => $cover_1, 'id_count' => 1))	
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-3 col-xs-12">Username <span class="required">*</span></label>
							<div class="col-sm-3 col-xs-12">
								<input type="text" id="username" name="username" required="required" class="form-control" value="<?=$username;?>">
								<span class="error">
									<?php
										if (isset($errors)){
											echo $errors->first('username');
										}
									?>
								</span>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-3 col-xs-12">Email <span class="required">*</span></label>
							<div class="col-sm-3 col-xs-12">
								<input type="email" id="email" name="email" required="required" class="form-control" value="<?=$email;?>">
								<span class="error">
									<?php
										if (isset($errors)){
											echo $errors->first('email');
										}
									?>
								</span>
							</div>
						</div>
						<?php
							if ($mode == "Edit"):
						?>
						<div class="form-group">
							<label class="control-label col-sm-3 col-xs-12">Password<br/><small>default 123456</small></label>
							<div class="col-sm-4 col-xs-12">
								<input type="password" id="password" name="password" class="form-control hide">
								<input type="checkbox" id="password_check" name="password_check" value="1">
								Change Password
							</div>
						</div>
						<?php
							endif;
						?>
						<div class="form-group">
							<label class="control-label col-sm-3 col-xs-12">Level</label>
							<div class="col-sm-3 col-xs-12">
								{{
								Form::select(
									'user_level_id',
									$userlevel,
									$user_level_id,
									array(
										'class' => 'form-control',
									))
								}}								
							</div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-3 col-xs-12">Birth Date</label>
                            <div class="col-sm-4">
                                <div class='input-group date' id='myDatepicker'>
                                    <input type='text' class="form-control" / name="birthdate" value="<?=$birthdate;?>">
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                        </div>
						<div class="form-group">
							<label class="control-label col-sm-3 col-xs-12">Gender</label>
							<div class="col-sm-5 col-xs-12">
								{{
								Form::select(
									'gender',
									['male' => 'Male', 'female' => 'Female', 'other' => 'Other'],
									$gender,
									array(
										'class' => 'form-control',
									))
								}}								
							</div>
                        </div>
						<div class="form-group">
							<label class="control-label col-sm-3 col-xs-12">Phone Number</label>
							<div class="col-sm-3 col-xs-12">
								<input type="text" name="phone" class="form-control" value="<?=$phone;?>">
							</div>
                        </div>
						<div class="form-group">
							<label class="control-label col-sm-3 col-xs-12">Address</label>
							<div class="col-sm-8 col-xs-12">
								<input type="text" name="address" class="form-control" value="<?=$address;?>">
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-3 col-xs-12">Status</label>
							<div class="col-sm-5 col-xs-12">
								{{
								Form::select(
									'active',
									['1' => 'Active', '2' => 'Banned', '3' => 'Non Active'],
									$active,
									array(
										'class' => 'form-control',
									))
								}}								
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-6 col-xs-12 col-sm-offset-3">
								<a href="<?=url('/backend/users-user')?>" class="btn btn-warning">Cancel</a>
								<button type="submit" class="btn btn-primary">Submit </button>
							</div>
						</div>
					{{ Form::close() }}
				</div>
			</div>
		</div>
	</div>
@endsection

<!-- CSS -->
@section('css')

@endsection

<!-- JAVASCRIPT -->
@section('script')
	<script>
		$("#password_check").on("change", function(){
			if($(this).prop('checked') == true){
				$("#password").removeClass("hide");
				$("#password").prop('required',true);
			} else {
				$("#password").addClass("hide");
				$("#password").prop('required',false);
			}
		});
        $('#myDatepicker').datetimepicker({
            format: 'DD-MM-YYYY'
        });
	</script>
	
	@include('backend.partials.colorbox')	
@endsection