<?php
	$breadcrumb = [];
	$breadcrumb[0]['title'] = 'Dashboard';
	$breadcrumb[0]['url'] = url('backend/dashboard');
	$breadcrumb[1]['title'] = 'Access Control';
	$breadcrumb[1]['url'] = url('backend/access-control');
?>

<!-- LAYOUT -->
@extends('backend.layouts.main')

<!-- TITLE -->
@section('title', 'Access Control')

<!-- CONTENT -->
@section('content')
	<div class="page-title">
		<div class="title_left">
			<h3>Access Control</h3>
		</div>
		<div class="title_right">
			<div class="col-md-4 col-sm-4 col-xs-8 form-group pull-right top_search">
				
			</div>
		</div>
	</div>
	<div class="clearfix"></div>
	@include('backend.elements.breadcrumb',array('breadcrumb' => $breadcrumb))
	<div class="row">
		<div class="col-xs-12">
			<div class="x_panel">
				<div class="x_content">
					<div class="col-sm-6 col-xs-12">
						@include('backend.elements.notification')
						<div class="panel panel-bordered">
							<div class="panel-heading">
								<h3 class="panel-title">User Level</h3>
							</div>
							<table class="table table-hover">
								<thead>
									<tr>
										<th>ID</th>
										<th>Level</th>
										<th>Detail</th>
									</tr>
								</thead>
								<tbody>
								<?php
									foreach ($user_level as $data):
								?>
									<tr>
										<td><?=$data->id;?></td>
										<td><?=$data->name;?></td>
										<td><button class="btn btn-primary btn-control" data-id=<?=$data->id;?>>Edit</button></td>
									</tr>
								<?php
									endforeach;
								?>
								</tbody>
							</table>
						</div>
					</div>
					<div class="col-sm-6 col-xs-12">
						<div class="panel panel-bordered">
							<?php
								foreach ($user_level as $data):
							?>
							<div id="module-<?=$data->id;?>" class="hide module">
								<div class="panel-heading">
									<h3 class="panel-title"><?=$data->name;?></h3>
								</div>
								{{ Form::open(['url' => 'backend/access-control', 'method' => 'POST','class' => 'form-horizontal form-label-left']) }}
									{!! csrf_field() !!}
									<input type="hidden" name="user_level" value=<?=$data->id;?>>
									<table class="table table-hover">
										<thead>
											<tr>
												<th align="center">Modul</th>
												<th align="center">View</th>
												<th align="center">View + Update</th>
												<th align="center">All</th>
											</tr>
										</thead>
										<?php
											foreach ($module as $data_module):
												$checked_v = "";
												$checked_vu = "";
												$checked_a = "";
												if (!empty($access_control)){
													if ((isset($access_control[$data->id][$data_module->id])) && ($access_control[$data->id][$data_module->id] == "v")){
														$checked_v = "checked";
													} else 
													if ((isset($access_control[$data->id][$data_module->id])) && ($access_control[$data->id][$data_module->id] == "vu")){
														$checked_vu = "checked";
													} else 
													if ((isset($access_control[$data->id][$data_module->id])) && ($access_control[$data->id][$data_module->id] == "a")){
														$checked_a = "checked";
													}
												}
										?>
											<tr>
												<td><?=$data_module->name;?></td>
												<td>
													<input required="required" type="radio" name="access_<?=$data_module->id;?>" value="v" <?=$checked_v;?>>
												</td>
												<td>
													<input required="required" type="radio" name="access_<?=$data_module->id;?>" value="vu" <?=$checked_vu;?>>
												</td>
												<td>
													<input required="required" type="radio" name="access_<?=$data_module->id;?>" value="a" <?=$checked_a;?>>
												</td>
											</tr>
										<?php
											endforeach;
										?>
									</table>
									<div class="form-group row">
										<div class="col-sm-5 offset-sm-6 text-right col-xs-12">
											<button type="submit" class="btn btn-primary btn-block">Submit </button>
											<br/>
										</div>
									</div>
								{{ Form::close() }}
							</div>
							<?php
								endforeach;
							?>
						</div>
					</div>
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
		$('.btn-control').on('click', function(e){
			var id = $(this).data('id');
			$('.module').addClass('hide');
			$('#module-'+id).removeClass('hide');
		});
	</script>
@endsection