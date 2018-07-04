<?php
	$breadcrumb = [];
	$breadcrumb[0]['title'] = 'Dashboard';
	$breadcrumb[0]['url'] = url('backend/dashboard');
	$breadcrumb[1]['title'] = 'Purchase Order';
	$breadcrumb[1]['url'] = url('backend/purchase-order');
	$breadcrumb[2]['title'] = 'Add';
	$breadcrumb[2]['url'] = url('backend/purchase-order/create');
	if (isset($data)){
		$breadcrumb[2]['title'] = 'Edit';
		$breadcrumb[2]['url'] = url('backend/purchase-order/'.$data[0]->id.'/edit');
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
    Purchase Order  - <?=$mode;?>
@endsection

<!-- CONTENT -->
@section('content')
	<?php
        $no_inv = old('no_inv');
        $tanggal = date('d-m-Y');
        $keterangan = old('keterangan');
        $id_sup = 0;
        $nama_sup = "";
		$active = 1;
		$method = "POST";
		$mode = "Create";
		$url = "backend/purchase-order/";
        $detail_count = 0;
		if (isset($data)){
            $detail_count = count($detail);
            $no_inv = $data[0]->no_inv;
            $tanggal = date('d-m-Y', strtotime($data[0]->tanggal));
            $id_sup = $data[0]->id_sup;
            $nama_sup = $data[0]->supplier->nama;
            $keterangan = $data[0]->keterangan;
			$active = $data[0]->active;
			$method = "PUT";
			$mode = "Edit";
			$url = "backend/purchase-order/".$data[0]->id;
		}
    ?>
	<div class="page-title">
		<div class="title_left">
			<h3>Purchase Order - <?=$mode;?></h3>
		</div>
		<div class="title_right">
			<div class="col-md-4 col-sm-4 col-xs-8 form-group pull-right top_search">
                @include('backend.elements.back_button',array('url' => '/backend/purchase-order'))
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
                            <label class="col-sm-3 form-control-label">Tanggal: </label>
                            <div class="col-sm-4">
                                <div class='input-group date' id='myDatepicker'>
                                    <input type='text' class="form-control" / name="tanggal" value="<?=$tanggal;?>">
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                        </div>                            
                        <div class="form-group">
                            <label class="col-sm-3 form-control-label">No Invoice: </label>
                            <div class="col-sm-5">
                                <input type="text" name="no_inv" required="required" class="form-control col-md-7 col-xs-12" value="<?=$no_inv;?>" autofocus>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 form-control-label">Supplier : </label>
                            <div class="col-sm-9">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <input type="hidden" name="id_sup" id="id_sup" value="<?=$id_sup;?>">
                                        <input readonly type="text" name="nama_sup" id="nama_sup" class="form-control" placeholder="Nama Supplier" required value="<?=$nama_sup?>">
                                    </div>
                                    <div class="col-sm-3">
                                        <a href="<?=url('backend/purchase-order/supplier/popup-media/');?>" class="btn btn-success browse-bahan-baku" title="Browse">Browse</a>
                                    </div>
                                </div>    
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 form-control-label">Keterangan</label>
                            <div class="col-md-6 col-sm-6">
                                <textarea class="form-control" name="keterangan" rows=6><?=$keterangan;?></textarea>
                            </div>
                        </div>
                        <hr/>
                        <div class="form-group">
                            <label class="col-sm-3 form-control-label">Barang : </label>
                            <div class="col-sm-9">
                                <div class="field_wrapper">
                                    <?php
                                        if (isset($data)){
                                            $i = 1;
                                            foreach ($detail as $key => $value):
                                    ?>
                                    <div class="row" style="margin-bottom:10px;">
                                        <div class="col-sm-3">
                                            <input type="hidden" name="id_bahan_baku[]" id="id_bahan_baku_<?=$i;?>" value="<?=$value['id_barang'];?>">
                                            <input readonly type="text" name="nama_bahan_baku[]" id="nama_bahan_baku_<?=$i;?>" class="form-control" placeholder="Nama Barang" required value="<?=$value['barang']->nama;?>">
                                        </div>
                                        <div class="col-sm-2">
                                            <a href="<?=url('backend/purchase-order/barang/popup-media/'.$i);?>" class="btn btn-success browse-bahan-baku" title="Browse">Browse</a>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="input-group">
                                                <input type="text" name="harga[]" id="harga_<?=$i;?>" class="form-control" placeholder="Harga" required value="<?=$value['harga'];?>">
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="input-group">
                                                <input type="text" name="jumlah[]" id="jumlah_<?=$i;?>" class="form-control" placeholder="Jumlah" required value="<?=$value['jumlah'];?>">
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <?php
                                                if ($i == 1){
                                            ?>
                                            <a href="javascript:void(0);" class="add_button btn btn-primary" title="Tambah Baris">Tambah Baris</a>
                                            <?php
                                                } else {
                                            ?>
                                            <a href="javascript:void(0);" class="remove_button btn btn-danger" title="Hapus Baris">Hapus Baris</a>
                                            <?php
                                                }
                                            ?>
                                        </div>
                                    </div>
                                    <?php
                                            $i++;
                                            endforeach;
                                        } else {
                                    ?>
                                    <div class="row" style="margin-bottom:10px;">
                                        <div class="col-sm-3">
                                            <input type="hidden" name="id_bahan_baku[]" id="id_bahan_baku_1">
                                            <input readonly type="text" name="nama_bahan_baku[]" id="nama_bahan_baku_1" class="form-control" placeholder="Nama Barang" required>
                                        </div>
                                        <div class="col-sm-2">
                                            <a href="<?=url('backend/purchase-order/barang/popup-media/1');?>" class="btn btn-success browse-bahan-baku" title="Browse">Browse</a>
                                        </div>
                                        <div class="col-sm-3">
                                            <input type="text" name="harga[]" id="harga_1" class="form-control" placeholder="Harga" required>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="input-group">
                                                <input type="text" name="jumlah[]" id="jumlah_1" class="form-control" placeholder="Jumlah" required>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <a href="javascript:void(0);" class="add_button btn btn-primary" title="Tambah Baris">Tambah Baris</a>
                                        </div>
                                    </div>
                                    <?php
                                        }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-6 offset-sm-6 text-right">
                                <a href="<?=url('/backend/purchase-order')?>" class="btn btn-warning">Cancel</a>
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
<script type="text/javascript">
    $(document).ready(function(){
        var addButton = $('.add_button');
        var wrapper = $('.field_wrapper');
        var x = <?=$detail_count + 1;?>;
        $(addButton).click(function(){ //Once add button is clicked
            x++;
            var url = "<?=url('/')?>";
            url = url + '/backend/purchase-order/barang/popup-media/' + x;
            $(wrapper).append('<div class="row" style="margin-bottom:10px;"><div class="col-sm-3"><input type="hidden" name="id_bahan_baku[]" id="id_bahan_baku_'+x+'"> <input readonly type="text" name="nama_bahan_baku[]" id="nama_bahan_baku_'+x+'" class="form-control" placeholder="Nama Barang" required></div><div class="col-sm-2"><a href="'+url+'" class="btn btn-success browse-bahan-baku" title="Browse">Browse</a></div><div class="col-sm-3"><input type="text" name="harga[]" id="harga_'+x+'" class="form-control" placeholder="Harga" required></div><div class="col-sm-2"><div class="input-group"><input type="text" name="jumlah[]" id="jumlah_'+x+'" class="form-control" placeholder="Jumlah" required></div></div><div class="col-sm-2"><a href="javascript:void(0);" class="remove_button btn btn-danger" title="Hapus Baris">Hapus Baris</a></div><br/></div>'); 
        });
        $(wrapper).on('click', '.remove_button', function(e){ 
            if (confirm("Apakah anda yakin mau menghapus baris ini?")) {
                e.preventDefault();
                $(this).parent().parent().remove(); 
            }
        });
    });
</script>

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

    $('#myDatepicker').datetimepicker({
        format: 'DD-MM-YYYY'
    });
    
</script>
@endsection