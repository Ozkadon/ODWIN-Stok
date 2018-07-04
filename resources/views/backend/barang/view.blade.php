<?php
	if (!empty($data)):
        $data = $data[0];
?>
	<div class="x_panel">
		<div class="x_content">
			<div class="form-group col-xs-12">
				<label class="control-label">ID :</label>
				<span class="form-control"><?=$data->id;?></span>
            </div>
			<div class="form-group col-xs-12">
				<label class="control-label">Kode :</label>
				<span class="form-control"><?=$data->kode;?></span>
            </div>
			<div class="form-group col-xs-12">
				<label class="control-label">Nama :</label>
				<span class="form-control"><?=$data->nama;?></span>
            </div>
			<div class="form-group col-xs-12">
				<label class="control-label">Image :</label><br/>
				<img width=50 class="img-responsive" src="<?=url('upload/img/thumbnails/'.$data->media_image_1->name.".".$data->media_image_1->type);?>"><br/>
            </div>
			<div class="form-group col-xs-12">
				<label class="control-label">Stok Awal :</label>
				<span class="form-control"><?=number_format($data->stok_awal,0,',','.');?></span>
            </div>
			<div class="form-group col-xs-12">
				<label class="control-label">Stok Total :</label>
				<span class="form-control"><?=number_format($data->stok_total,0,',','.');?></span>
            </div>
			<div class="form-group col-xs-12">
                <label class="control-label">Harga Beli :</label>
                <span class="form-control"><?=number_format($data->harga_beli,0,',','.');?></span>
            </div>
            <div class="form-group col-xs-12">
				<label class="control-label">Harga Jual :</label>
				<span class="form-control"><?=number_format($data->harga_jual,0,',','.');?></span>
            </div>
			<div class="form-group col-xs-12">
				<label class="control-label">Keterangan :</label>
				<div class="detail-view"><?=nl2br($data->keterangan);?></div>
			</div>
			<div class="form-group col-xs-12">
				<label class="control-label">Status :</label>
				<span class="form-control">
					<?php
						if ($data->active == 1){
							$text = "Active";
							$label = "success";
						} else 
						if ($data->active == 2){
							$text = "Deactive";
							$label = "warning";
						}
						echo "<span class='badge badge-" . $label . "'>". $text . "</span>";
					
					?>
				</span>
			</div>
			<div class="form-group col-xs-12">
				<label class="control-label">Date Created :</label>
				<span class="form-control"><?=date('d M Y H:i:s', strtotime($data->created_at));?></span>
			</div>
			<div class="form-group col-xs-12">
				<label class="control-label">Last Modified :</label>
				<span class="form-control"><?=date('d M Y H:i:s', strtotime($data->updated_at));?></span>
			</div>
			<div class="form-group col-xs-12">
				<label class="control-label">Last Modified by :</label>
				<span class="form-control"><?=$data->user_modify->username;?></span>
			</div>
		</div>
	</div>
<?php
	endif;
?>

