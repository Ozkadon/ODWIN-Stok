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
				<label class="control-label">Name :</label>
				<span class="form-control"><?=$data->firstname." ".$data->lastname;?></span>
			</div>
			<div class="form-group col-xs-12">
				<label class="control-label">Email :</label>
				<span class="form-control"><?=$data->email;?></span>
			</div>
			<div class="form-group col-xs-12">
				<label class="control-label">Username :</label>
				<span class="form-control"><?=$data->username;?></span>
			</div>
			<div class="form-group col-xs-12">
				<label class="control-label">Level :</label>
				<span class="form-control"><?=$data->level->name;?></span>
			</div>
			<div class="form-group col-xs-12">
				<label class="control-label">Avatar :</label><br/>
				<img width=50 class="img-responsive" src="<?=url('upload/img/thumbnails/'.$data->media_image_1->name.".".$data->media_image_1->type);?>"><br/>
            </div>
			<div class="form-group col-xs-12">
				<label class="control-label">Gender :</label>
				<span class="form-control">
					<?php
						if ($data->gender == "male"){
							$text = "Male";
							$label = "success";
						} else 
						if ($data->gender == "female"){
							$text = "Female";
							$label = "success";
						} else 
						if ($data->gender == "other"){
							$text = "Other";
							$label = "success";
						}
						echo "<span class='badge badge-" . $label . "'>". $text . "</span>";
					
					?>
				</span>
			</div>
			<div class="form-group col-xs-12">
				<label class="control-label">Birth Date :</label>
				<span class="form-control"><?=date('d M Y', strtotime($data->birthdate));?></span>
			</div>
			<div class="form-group col-xs-12">
				<label class="control-label">Phone Number:</label>
				<span class="form-control"><?=$data->phone;?></span>
            </div>
			<div class="form-group col-xs-12">
				<label class="control-label">Address:</label>
				<span class="form-control"><?=$data->address;?></span>
			</div>
			<div class="form-group col-xs-12">
				<label class="control-label">Last Login :</label>
				<span class="form-control"><?=date('d M Y:H:i:s', strtotime($data->last_activity));?></span>
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

