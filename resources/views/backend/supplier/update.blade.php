<?php
	$breadcrumb = [];
	$breadcrumb[0]['title'] = 'Dashboard';
	$breadcrumb[0]['url'] = url('backend/dashboard');
	$breadcrumb[1]['title'] = 'Supplier';
	$breadcrumb[1]['url'] = url('backend/supplier');	
	$breadcrumb[2]['title'] = 'Add';
	$breadcrumb[2]['url'] = url('backend/supplier/create');
	if (isset($data)){
		$breadcrumb[2]['title'] = 'Edit';
		$breadcrumb[2]['url'] = url('backend/supplier/'.$data[0]->id.'/edit');
	}
?>

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
    Master Supplier - <?=$mode;?>
@endsection

<!-- CONTENT -->
@section('content')
	<?php
        $nama = old('nama');
        $alamat = old('alamat');
        $cp = old('cp');
        $telp = old('telp');
		$active = 1;
		$method = "POST";
		$mode = "Create";
		$url = "backend/supplier/";
		if (isset($data)){
            $nama = $data[0]->nama;
            $alamat = $data[0]->alamat;
            $cp = $data[0]->cp;
            $telp = $data[0]->telp;
			$active = $data[0]->active;
			$method = "PUT";
			$mode = "Edit";
			$url = "backend/supplier/".$data[0]->id;
		}
	?>
	<div class="page-title">
		<div class="title_left">
			<h3>Master Supplier - <?=$mode;?></h3>
		</div>
		<div class="title_right">
			<div class="col-md-4 col-sm-4 col-xs-8 form-group pull-right top_search">
                @include('backend.elements.back_button',array('url' => '/backend/supplier'))
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
							<label class="control-label col-sm-3 col-xs-12">Nama <span class="required">*</span></label>
							<div class="col-sm-7 col-xs-12">
								<input type="text" id="nama" name="nama" required="required" class="form-control col-md-7 col-xs-12" value="<?=$nama;?>" autofocus>
							</div>
                        </div>
						<div class="form-group">
							<label class="control-label col-sm-3 col-xs-12">Alamat</label>
							<div class="col-sm-9 col-xs-12">
								<textarea  name="alamat" class="form-control col-md-7 col-xs-12" rows=5><?=$alamat;?></textarea>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-3 col-xs-12">Kontak Person</label>
							<div class="col-md-5 col-xs-12">
								<input type="text" name="cp" class="form-control col-md-7 col-xs-12" value="<?=$cp;?>">
							</div>
                        </div>
						<div class="form-group">
							<label class="control-label col-sm-3 col-xs-12">Telp</label>
							<div class="col-sm-4 col-xs-12">
								<textarea  name="telp" class="form-control col-md-7 col-xs-12" rows=5><?=$telp;?></textarea>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-3 col-xs-12">Status: </label>
							<div class="col-sm-5 col-xs-12">
								{{
								Form::select(
									'active',
									['1' => 'Active', '2' => 'Deactive'],
									$active,
									array(
										'class' => 'form-control',
									))
								}}								
							</div>
						</div>
						<div class="ln_solid"></div>
						<div class="form-group">
							<div class="col-sm-6 col-xs-12 col-sm-offset-3">
								<a href="<?=url('/backend/supplier')?>" class="btn btn-warning">Cancel</a>
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

@endsection