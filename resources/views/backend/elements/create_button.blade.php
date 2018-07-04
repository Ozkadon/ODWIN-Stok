<?php
	$segment =  Request::segment(2);
	$userinfo = Session::get('userinfo');
	$access_control = Session::get('access_control');
	if (!empty($access_control)) :
		if ($access_control[$userinfo['user_level_id']][$segment] == "a"):
?>
	<a href="<?=url($url);?>" class="btn-index btn btn-primary btn-block" title="Add"><i class="fa fa-plus"></i>&nbsp; Add</a>
<?php
		endif;
	endif;
?>