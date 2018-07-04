<ol class="breadcrumb">
	<?php
		$last_key = end($breadcrumb);
		foreach ($breadcrumb as $key => $value):
			if ($value['title'] == $last_key['title']){
	?>
				<li class="breadcrumb-item active"><?=$value['title']?></li>

	<?php
			} else {
	?>
				<li class="breadcrumb-item"><a href="<?=$value['url'];?>"><?=$value['title'];?></a></li>
	<?php
			}
		endforeach;
	?>
</ol>