<?php
	$breadcrumb = [];
	$breadcrumb[0]['title'] = 'Dashboard';
	$breadcrumb[0]['url'] = url('backend/dashboard');
	$breadcrumb[1]['title'] = 'User';
	$breadcrumb[1]['url'] = url('backend/users-user');
?>

<!-- LAYOUT -->
@extends('backend.layouts.main')

<!-- TITLE -->
@section('title', 'Master User')

<!-- CONTENT -->
@section('content')
    {{ Form::open(['url' => url('/backend/users-user/delete'), 'method' => 'POST','class' => 'form-horizontal']) }}
	<div class="page-title">
		<div class="title_left">
			<h3>Master User</h3>
		</div>
		<div class="title_right">
			<div class="col-md-4 col-sm-4 col-xs-6 form-group pull-right top_search">
                <?php
                    $segment =  Request::segment(2);
                    $userinfo = Session::get('userinfo');
                    $access_control = Session::get('access_control');
                    if (!empty($access_control)) :
                        if ($access_control[$userinfo['user_level_id']][$segment] == "a"):
                ?>           
                        <button type="submit" class="btn btn-block btn-danger btn-delete-check"><i class="fa fa-minus"></i>&nbsp; Delete</a>
                <?php
                        endif;
                    endif;
                ?>
			</div>
			<div class="col-md-4 col-sm-4 col-xs-6 form-group pull-right top_search">
				@include('backend.elements.create_button',array('url' => '/backend/users-user/create'))
            </div>
		</div>
	</div>
	<div class="clearfix"></div>
    @include('backend.elements.breadcrumb',array('breadcrumb' => $breadcrumb))
    <div class="row">
        <div class="col-xs-12 text-right">
            <a href="<?=url('backend/user/export/xls');?>" class="btn btn-success">Export Excel</a>
        </div>
    </div>
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_content">
					@include('backend.elements.notification')
					<table class="table table-striped table-hover table-bordered dt-responsive nowrap dataTable" cellspacing="0" width="100%">
						<thead>
							<tr>
								<th>
									<span class="uni">
									  <input type='checkbox' value='checkall' onclick='checkAll(this)' />
									</span>
								</th>
								<th>ID</th>
								<th>Name</th>
								<th>Email</th>
                                <th>Phone</th>
								<th>Level</th>
								<th>Status</th>
								<th>Actions</th>
							</tr>
						</thead>
					</table>
				</div>
			</div>
		</div>
    </div>
    {{ Form::close() }}
@endsection

<!-- CSS -->
@section('css')

@endsection

<!-- JAVASCRIPT -->
@section('script')
	<script>
		$('.dataTable').dataTable({
			processing: true,
			serverSide: true,
            "order": [[ 1, "desc" ]],
			ajax: "<?=url('backend/users-user/datatable');?>",
			columns: [
                {data: 'check', name: 'check', orderable: false, searchable: false},
				{data: 'id', name: 'id'},
				{data: 'firstname', name: 'firstname'},
				{data: 'email', name: 'email'},
				{data: 'phone', name: 'phone'},
				{data: 'name', name: 'user_levels.name'},
				{data:  'active', render: function ( data, type, row ) {
					var text = "";
					var label = "";
					if (data == 1){
						text = "Active";
						label = "success";
					} else 
					if (data == 2){
						text = "Banned";
						label = "danger";
					}else 
					if (data == 3){
						text = "Non Active";
						label = "warning";
					}
					return "<span class='label label-" + label + "'>"+ text + "</span>";
                }},				
				{data: 'action', name: 'action', orderable: false, searchable: false}
			],
			responsive: true
		});

        function checkAll(bx) {
            var cbs = document.getElementsByTagName('input');
            for(var i=0; i < cbs.length; i++) {
                if(cbs[i].type == 'checkbox') {
                cbs[i].checked = bx.checked;
                }
            }
        }	

        $('.btn-delete-check').on('click', function(e){
            e.preventDefault();
            if (confirm("Apakah anda yakin mau menghapus data-data ini?")) {
                $(this).parents('form').submit();
            }
        });
	</script>
@endsection