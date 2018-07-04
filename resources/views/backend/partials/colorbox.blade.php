<script>
	$('body').on('click', '.gallery', function (e) {
		$.colorbox({href: $(this).attr('href')});
		e.preventDefault();
	});	
</script>