<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="robots" content="all,follow">
		<meta name="description" content="<?=getData('web_description');?>">
		<meta name="author" content="ODWin">
		<title><?=getData('web_title');?> | @yield('title')</title>
		<link rel="apple-touch-icon" href="<?=url(getData('logo'));?>">
		<link rel="shortcut icon" href="<?=url(getData('logo'));?>">
		<!-- Ladda -->
		<link rel="stylesheet" href="<?=url('vendors/ladda/ladda.min.css');?>">
		<!-- Bootstrap -->
		<link href="<?=url('vendors/bootstrap/dist/css/bootstrap.min.css');?>" rel="stylesheet">
		<!-- Font Awesome -->
		<link href="<?=url('vendors/font-awesome/css/font-awesome.min.css');?>" rel="stylesheet">
		<!-- NProgress -->
		<link href="<?=url('vendors/nprogress/nprogress.css');?>" rel="stylesheet">
		<!-- Animate.css -->
		<link href="<?=url('vendors/animate.css/animate.min.css');?>" rel="stylesheet">

		<!-- Custom Theme Style -->
		<link href="<?=url('build/css/custom.min.css');?>" rel="stylesheet">
	</head>
	<body class="login">
		@yield('content')
		<!-- jQuery -->
		<script src="<?=url('vendors/jquery/dist/jquery.min.js');?>"></script>
		<!-- Bootstrap -->
		<script src="<?=url('vendors/bootstrap/dist/js/bootstrap.min.js');?>"></script>
		<!-- Ladda -->
		<script src="<?=url('vendors/ladda/spin.min.js');?>"></script>
		<script src="<?=url('vendors/ladda/ladda.min.js');?>"></script>
		<script type="text/javascript">
			Ladda.bind('.btn-submit');
			$("#formLogin").submit(function() {
				var url = "<?php echo url('/'); ?>/backend/login";
				var frm_data = $("#formLogin").serialize();
				$.ajax({
					type: "POST",
					url: url,
					data: frm_data,
					success: function(response){ 
						Ladda.stopAll();
						if (response.status) {
							window.location.href = "<?php echo url('/'); ?>/backend/dashboard";
						}
						else {
							$('.error-alert').html("");
							$.each( response.message, function(key, value ) {
								$('.error-alert').append('<div class="alert alert-danger" role="alert"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>'+value+'</strong></div>');
							});
						}
					}, 
					error: function(response){
						console.log(response);
					}
				});
				return false;
			});
		</script>		
	</body>
</html>
