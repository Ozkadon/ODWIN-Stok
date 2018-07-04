<?php
	$breadcrumb = [];
	$breadcrumb[0]['title'] = 'Dashboard';
	$breadcrumb[0]['url'] = url('backend/dashboard');
	$breadcrumb[1]['title'] = 'Setting';
	$breadcrumb[1]['url'] = url('backend/setting');
?>

<!-- LAYOUT -->
@extends('backend.layouts.main')

<!-- TITLE -->
@section('title', 'Setting')

<!-- CONTENT -->
@section('content')
	<div class="page-title">
		<div class="title_left" style="width : 100%">
			<h3>Setting</h3>
		</div>
	</div>
	<div class="clearfix"></div>
	@include('backend.elements.breadcrumb',array('breadcrumb' => $breadcrumb))
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_content">
                    @include('backend.elements.notification')
                    {{ Form::open(['url' => 'backend/setting', 'method' => 'POST','class' => 'form-horizontal', 'files' => true]) }}
                    <div class="" role="tabpanel" data-example-id="togglable-tabs">
                        <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                            <li role="presentation" class="active"><a href="#tab_content1" id="general-tab" role="tab" data-toggle="tab" aria-expanded="true">General</a></li>
                        </ul>
                        <div id="myTabContent" class="tab-content">
                            <div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="general-tab">
                                <div class="form-group">
                                    <label class="control-label col-sm-3 col-xs-12">Website Title</label>
                                    <div class="col-sm-9 col-xs-12">
                                        <input type="text" class="form-control" name="1" placeholder="Title" autocomplete="off" value="<?=getData('web_title')?>" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-3 col-xs-12">Website Description</label>
                                    <div class="col-sm-9 col-xs-12">
                                        <input type="text" class="form-control" name="4" placeholder="Description" autocomplete="off" value="<?=getData('web_description')?>" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-3 col-xs-12">Website Logo <br/><small>Max file size : 1Mb</small></label>
                                    <div class="col-sm-4 col-xs-12">
                                        <input type="file" name="logo" class="dropify" data-default-file="<?=url(getData('logo'))?>"/>
                                        <input type="hidden" name="default_logo" value=<?=url(getData('logo'))?>>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-3 col-xs-12">Email Admin</label>
                                    <div class="col-sm-9 col-xs-12">
                                        <textarea type="text" class="form-control" name="3" rows=5><?=getData('email_admin')?></textarea>
                                        <span class="text-help">
                                                    If there is more than one email, use enter as delimiter<br/>
                                                    Example :<br/>
                                                    email_1<br/>
                                                    email_2
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-12 col-sm-9 col-sm-offset-3">
                                    <button type="submit" class="btn btn-primary btn-block">Submit </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{ Form::close() }}
				</div>
			</div>
		</div>
	</div>
@endsection

<!-- CSS -->
@section('css')
    <link href="<?=url('vendors/dropify/css/dropify.min.css');?>" rel="stylesheet">
@endsection

<!-- JAVASCRIPT -->
@section('script')
    <script src="<?=url('vendors/dropify/js/dropify.js');?>"></script>
    <script>
        $('.dropify').dropify();
    </script>
@endsection