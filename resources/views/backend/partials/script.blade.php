<script>
	function deleteData(dt){
		if (confirm("Apakah anda yakin mau menghapus data ini?")) {
			$.ajax({
				type:"DELETE",
				url:$(dt).data("url"),
				data: {
					"_token": "{{ csrf_token() }}"
				},				
				success:function(response){
					if(response.status){
						location.reload();
					}
				},
                error: function(response){
                    //console.log(response);
                }
			});
		}
		return false;
	}
	
	$(document).ready(function() {
		$('body').on('click', '.btn-view', function() {
			$(".btn-view").colorbox({
				'width'				: '600px',
				'maxWidth'			: '90%',
				'maxHeight'			: '90%',
				'transition'		: 'elastic',
				'scrolling'			: true,
			});
		});
		
	})
	
	function received(dt){
		if (confirm("Apakah anda yakin mau mengubah status PO ini menjadi terima ?")) {
			$.ajax({
				type:"POST",
				url:$(dt).data("url"),
				data: {
					"_token": "{{ csrf_token() }}"
				},				
				success:function(response){
					if(response.status){
						location.reload();
					}
				},
			});
		}
		return false;
	}
</script>