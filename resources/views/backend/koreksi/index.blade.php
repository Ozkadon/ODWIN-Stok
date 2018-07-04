<?php
	$breadcrumb = [];
	$breadcrumb[0]['title'] = 'Dashboard';
	$breadcrumb[0]['url'] = url('backend/dashboard');
	$breadcrumb[1]['title'] = 'Koreksi Stok';
	$breadcrumb[1]['url'] = url('backend/koreksi-stok');
?>

<!-- LAYOUT -->
@extends('backend.layouts.main')

<!-- TITLE -->
@section('title')
    Koreksi Stok
@endsection

<!-- CONTENT -->
@section('content')
	<div class="page-title">
		<div class="title_left">
			<h3>Koreksi Stok</h3>
		</div>
		<div class="title_right">
			<div class="col-md-4 col-sm-4 col-xs-8 form-group pull-right top_search">

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
                    @include('backend.elements.notification')
                    {{ Form::open(['method' => 'POST','class' => 'form-horizontal form-label-left']) }}
                        {!! csrf_field() !!}
                        <div class="form-group">
                            <label class="control-label col-sm-3 col-xs-12">Nama Barang</label>
                            <div class="col-sm-9 col-xs-12">
                                <div class="row">
                                    <div class="col-sm-5">
                                        <input type="hidden" name="id_bahan_baku" id="id_bahan_baku" required>
                                        <input readonly type="text" name="nama_bahan_baku" id="nama_bahan_baku" class="form-control" placeholder="Nama Barang" required>
                                    </div>
                                    <div class="col-sm-2">
                                        <a href="<?=url('backend/koreksi-stok/barang/popup-media/');?>" class="btn btn-success browse-bahan-baku" title="Browse">Browse</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-3 col-xs-12">Jumlah</label>
                            <div class="col-sm-4 col-xs-12">
                                <input type="text" class="form-control" name="jumlah" placeholder="Jumlah" autocomplete="off" value="" required />
                                <small>Masukkan - jika mengurangi stok. Misal -5 atau 5 jika menambah</small>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-12 col-sm-9 col-sm-offset-3">
                                <button type="submit" class="btn btn-primary btn-block">Submit </button>
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
	$('body').on('click', '.browse-bahan-baku', function (e) {
		$.colorbox({
            'width'				: '90%',
            'height'			: '95%',
            'maxWidth'			: '75%',
            'maxHeight'			: '95%',
            'transition'		: 'elastic',
            'scrolling'			: true,
            'href'              : $(this).attr('href')
        });
		e.preventDefault();
	});    
</script>
@endsection