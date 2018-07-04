<div style="width:96%;margin:auto;" id="content-popup">
	<br/>
	<div class="row">
		<div class="col-xs-12">
			<div class="x_panel">
				<div class="x_content">
					<div class="" role="tabpanel">
						<ul class="nav nav-tabs bar_tabs" role="tablist">				
							<li role="presentation">
								<a href="#tab-insert" data-toggle="tab" class="nav-link active" role="tab" data-toggle="tab" aria-controls="tab-insert" id="insert">
									<span>Insert from Media Library</span>
								</a>
							</li>
							<li class="" role="presentation">
								<a href="#tab-upload" data-toggle="tab" class="nav-link" role="tab" data-toggle="tab" aria-controls="tab-upload" id="upload">
									<span>Upload from Local Disk</span>
								</a>
							</li>
						</ul>
						<div class="tab-content" style="overflow-y : auto; overflow-x:hidden;">
                            <div class="checkbox_wrapper">
                                <div class="row">
                                    <div class="col-sm-3" style="margin-top:5px;">
                                        <a href="#" class="check_all">Check All</a>
                                        /
                                        <a href="#" class="uncheck_all">Uncheck All</a>
                                    </div>
                                    <div class="col-sm-2 col-sm-offset-7">
                                        <button class="btn btn-success btn-block btn_gallery">Add item(s)</button>
                                    </div>
                                </div>
                            </div>
                            <hr/>
							<div class="tab-pane active" id="tab-insert" role="tabpanel">
								<table class="table table-striped table-bordered datatable-media-library" width="100%" id="table-media">
									<thead>
										<tr>
                                            <th>&nbsp;</th>
											<th>ID</th>
											<th>Image</th>
											<th>Name</th>
											<th>Type</th>
											<th>Size</th>
										</tr>
									</thead>   
								</table>
								<script>
									$('.datatable-media-library').dataTable({
										processing: true,
										serverSide: true,
                                        "order": [[ 1, "desc" ]],
										ajax: "<?=url('backend/media-library/datatable');?>",
										columns: [
                                            {data: 'checkbox', name: 'checkbox'},
											{data: 'id', name: 'id'},
											{data:  'url', render: function ( data, type, row ) {
												url = "<?=url('/')?>";
												var lastPart = data.split("/").pop();
												return "<img data-url='"+url+'/'+data+"' width='40px' src='"+url+'/upload/img/thumbnails/'+lastPart+"' class='img-responsive'>";
											}, orderable: false, searchable: false},				
											{data: 'name', name: 'name'},
											{data: 'type', name: 'type'},
											{data: 'size', name: 'size'},
										],
										responsive: true
									});
								</script>	
							</div>
							<div class="tab-pane" id="tab-upload" role="tabpanel">
								<div class="dataTables_wrapper_popup" role="grid">
									<div id="file-upload">
										{{ Form::open(['url' => 'backend/media-library/upload', 'method' => 'POST', 'id' => 'fileupload', 'class' => 'form-horizontal form-label-left', 'files' => true]) }}
										<div class="fileupload-buttonbar">
												<!-- The fileinput-button span is used to style the file input field as button -->
                                                <div class="btn btn-success fileinput-button">
                                                    <i class="glyphicon glyphicon-plus"></i>
                                                    <span>Add files...</span>
                                                    <input type="file" name="files[]" multiple>
                                                </div>
												<button type="submit" class="btn btn-primary start">
													<i class="glyphicon glyphicon-upload"></i>
													<span>Start upload</span>
												</button>
												<button type="reset" class="btn btn-warning cancel">
													<i class="glyphicon glyphicon-ban-circle"></i>
													<span>Cancel upload</span>
                                                </button>
                                                Max file size : 1Mb
												<!-- The global file processing state -->
												<span class="fileupload-process"></span>
										</div>
										<div class="table-content" style="overflow:auto">
											<!-- The table listing the files available for upload/download -->
											<table role="presentation" class="table table-striped"><tbody class="files"></tbody></table>
										</div>
										{{ Form::close() }}
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- The template to display files available for upload -->
	<script id="template-upload" type="text/x-tmpl">
	{% for (var i=0, file; file=o.files[i]; i++) { %}
		<tr class="template-upload">
			<td class="preview"><span class=""></span></td>
			<td class="name"><span>{%=file.name%}</span></td>
			<td class="size"><span>{%=o.formatFileSize(file.size)%}</span></td>
			{% if (file.error) { %}
				<td class="error" colspan="2"><span class="label label-important">{%=locale.fileupload.error%}</span> {%=locale.fileupload.errors[file.error] || file.error%}</td>
			{% } else if (o.files.valid && !i) { %}
				<td>
					<div class="progress progress-success progress-striped active"><div class="progress-bar progress-bar-success bar" style="width:0%;"></div></div>
				</td>
				<td class="start">{% if (!o.options.autoUpload) { %}
					<button class="btn btn-primary start">
						<i class="glyphicon glyphicon-upload"></i>
						<span>{%=locale.fileupload.start%}</span>
					</button>
				{% } %}</td>
			{% } else { %}
				<td colspan="2"></td>
			{% } %}
			<td class="cancel">{% if (!i) { %}
				<button class="btn btn-warning cancel">
					<i class="glyphicon glyphicon-ban-circle"></i>
					<span>{%=locale.fileupload.cancel%}</span>
				</button>
			{% } %}</td>
		</tr>
	{% } %}
	</script>
		

	<!-- The template to display files available for download -->
	<script id="template-download" type="text/x-tmpl">
	{% for (var i=0, file; file=o.files[i]; i++) { %}
		<tr class="template-download">
			{% if (file.error) { %}
				<td></td>
				<td class="name"><span>{%=file.name%}</span></td>
				<td class="size"><span>{%=o.formatFileSize(file.size)%}</span></td>
				<td class="error" colspan="2"><span class="label label-important">{%=locale.fileupload.error%}</span> {%=locale.fileupload.errors[file.error] || file.error%}</td>
			{% } else { %}
				<td class="preview">{% if (file.thumbnail_url) { %}
					<a href="#" title="{%=file.name%}" rel="gallery" download="{%=file.name%}"><img src="{%=file.thumbnail_url%}"></a>
				{% } %}</td>
				<td class="name">
					<a href="#" title="{%=file.name%}" rel="{%=file.thumbnail_url&&'gallery'%}" download="{%=file.name%}">{%=file.name%}</a>
				</td>
				<td class="size"><span>{%=o.formatFileSize(file.size)%}</span></td>
				<td colspan="3"></td>
			{% } %}        
		</tr>
	{% } %}
	</script>

	<!-- The localization script -->
	<script src="<?=url('vendors/blueimp/js/locale.js');?>"></script>
	<!-- The main application script -->
	<script src="<?=url('vendors/blueimp/js/main.js');?>"></script>

	<script>
		$('.check_all').on('click', function(e){
			e.preventDefault();
			var cbs = document.getElementsByTagName('input');
			for(var i=0; i < cbs.length; i++) {
				if(cbs[i].type == 'checkbox') {
					cbs[i].checked = true;
				}
			}			
		});	
		
		$('.uncheck_all').on('click', function(e){
			e.preventDefault();
			var cbs = document.getElementsByTagName('input');
			for(var i=0; i < cbs.length; i++) {
				if(cbs[i].type == 'checkbox') {
					cbs[i].checked = false;
				}
			}			
		});	
        
		$( document ).ready(function() {
			$('div#content-popup').on("click", 'a#insert', function(e){
				$('.datatable-media-library').dataTable().fnDestroy();
				$('.datatable-media-library tbody').empty();
				$('.datatable-media-library').dataTable({
					processing: true,
					serverSide: true,
                    "order": [[ 1, "desc" ]],
					ajax: "<?=url('backend/media-library/datatable');?>",
                    columns: [
                        {data: 'checkbox', name: 'checkbox'},
                        {data: 'id', name: 'id'},
                        {data:  'url', render: function ( data, type, row ) {
                            url = "<?=url('/')?>";
                            var lastPart = data.split("/").pop();
                            return "<img data-url='"+url+'/'+data+"' width='40px' src='"+url+'/upload/img/thumbnails/'+lastPart+"' class='img-responsive'>";
                        }, orderable: false, searchable: false},				
                        {data: 'name', name: 'name'},
                        {data: 'type', name: 'type'},
                        {data: 'size', name: 'size'},
                    ],
					responsive: true
				});
			});
		});

		$('.btn_gallery').on('click', function(e){
			e.preventDefault();
			var checked = [];
			var content = "";
			$("input[name='checkall[]']:checked").each(function (){
				content='\
                    <div class="col-md-55 wrapper-gallery">\
                        <div class="thumbnail">\
                            <input name="gallery_detail_id[]" type="hidden" class="media-id" value="' + $(this).parent().prevAll('.media-id').val() + '">\
                            <div class="image view view-first">\
                                <img style="width: 100%; display: block;" src="'+$(this).parent().parent().next().next().find('img').attr('src')+'" alt="">\
                                <div class="mask">\
                                    <p>Click X to remove</p>\
                                    <div class="tools tools-bottom">\
                                        <a class="delete" href="#"><i class="fa fa-times"></i></a>\
                                    </div>\
                                </div>\
                            </div>\
                            <div class="caption">\
                                <p>'+$(this).parent().parent().next().next().next().html()+'</p>\
                            </div>\
                        </div>\
                    </div>\
				';
				
				$('#gallery_detail').append(content);
			});
			$.colorbox.close();
		});	        
	</script>
</div>