	<script type="text/javascript">
		$(document).ready(function() {
			$("#popup_media_cover_<?php echo $id_count; ?>").colorbox({
				'width'				: '75%',
				'height'			: '90%',
				'maxWidth'			: '75%',
				'maxHeight'			: '90%',
				'transition'		: 'elastic',
				'scrolling'			: false,
				
				onComplete			: function() { 
													$( ".tab-content" ).height(0.75 * $( "#cboxLoadedContent" ).height());
													$( ".table-content" ).height($( ".tab-content" ).height()-60);
													$( ".fancybox-inner" ).css('overflow','hidden');
												 },
			});
		})
	</script>
	
	<div class="gallery-env">
		<div class="col-sm-3">
			<article class="image-thumb" style="overflow:hidden;">
				<?php 
					$image_url = "img/noprofileimage.png";
					$image_thumbnail = "img/noprofileimage.png";
					if (!empty($cover)){
						$field = $cover->field;
						if ($cover->{$field} != 0) {
                            $media_image = 'media_image_'.$id_count;
                            if (isset($cover->{$media_image})){
                                $image_url = $cover->{$media_image}->url;
                                $image_thumbnail = "upload/img/thumbnails/".$cover->{$media_image}->name.".".$cover->{$media_image}->type;
                            }
						}
					}
				?>
				<a class="gallery image" id="image-url_<?= $id_count; ?>" href="<?= url($image_url); ?>">
					<img id="cover-image_<?= $id_count; ?>" class="im-media" width=100% src="<?= url($image_thumbnail) ?>" />
				</a>
			</article>
		</div>
		<i class="fa fa-cog"></i> <a id="remove_<?= $id_count; ?>" href="#">Remove</a> / 
		<a href="<?=url('/backend/media-library/popup-media/1/'.$id_count);?>" id="popup_media_cover_<?=$id_count?>">Change Cover</a>
	</div>
	
	<script>
		$( document ).ready(function() {
			$('a#remove_<?= $id_count; ?>').on('click', function(e){
				e.preventDefault();
				$('#id-cover-image_<?= $id_count; ?>').val(0);
				$('#cover-image_<?= $id_count; ?>').attr('src','<?=url("img/noprofileimage.png") ?>');
				$('#image-url_<?= $id_count; ?>').attr('href','<?=url("img/noprofileimage.png") ?>');
			});	
		});	
	</script>