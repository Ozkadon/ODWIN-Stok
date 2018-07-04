<?php
	$breadcrumb = [];
	$breadcrumb[0]['title'] = 'Dashboard';
	$breadcrumb[0]['url'] = url('backend/dashboard');
	$breadcrumb[1]['title'] = 'Penjualan';
    $breadcrumb[1]['url'] = url('backend/penjualan');
	if (isset($data)){
		$breadcrumb[2]['title'] = $data[0]->no_inv;
		$breadcrumb[2]['url'] = url('backend/penjualan/'.$data[0]->id.'/edit');
	}
?>

<!-- LAYOUT -->
@extends('backend.layouts.main')

<!-- TITLE -->
@section('title', 'Penjualan')

<!-- CONTENT -->
@section('content')
    <div class="page-title">
        <div class="title_left">
            <h3>Penjualan</h3>
        </div>
        <div class="title_right">
            <div class="col-md-4 col-sm-4 col-xs-8 form-group pull-right top_search">
                <a href="<?=url('/backend/penjualan');?>" class="btn-index btn btn-primary btn-block" title="Back"><i class="fa fa-arrow-left"></i></a>
            </div>
        </div>
    </div>
	<div class="clearfix"></div>
	@include('backend.elements.breadcrumb',array('breadcrumb' => $breadcrumb))	
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_content">
					<div class="row">
                        <div class="col-xs-12">
                            <h4>Penjualan</h4>
                            No Nota : <b><?=$data[0]->no_nota;?></b><br/>
                            Tanggal : <b><?=date('d F Y', strtotime($data[0]->tanggal))?></b><br/>
                            Total : <b>Rp. <?=number_format($data[0]->total, 0, ',','.');?></b><br/>
                            Keterangan : <?=nl2br($data[0]->keterangan);?><br/>
                            <br/>
                        </div>
                    </div>
                    <table class="table table-striped table-hover table-bordered dt-responsive nowrap dataTable" cellspacing="0" width="100%">
						<thead>
							<tr>
                                <th>Nama Barang</th>
                                <th>Jumlah</th>
                                <th>Harga</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                foreach ($detail as $detail):
                            ?>
                                <tr>
                                    <td><?=$detail->barang->nama;?></td>
                                    <td><?=number_format($detail->jumlah,0,',','.');?></td>
                                    <td><?=number_format($detail->harga,0,',','.');?></td>
                                    <td><?=number_format($detail->harga*$detail->jumlah,0,',','.');?></td>
                                </tr>
                            <?php
                                endforeach;
                            ?>
                        </tbody>
					</table>
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