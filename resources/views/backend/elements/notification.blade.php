@if (Session::has('success'))
    <div class="row">
	    <div class="col-md-12 alert alert-<?=Session::get('mode');?> alert-dismissible" role="alert">
		    {{ Session::get('success') }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        </div>
    </div>
@endif