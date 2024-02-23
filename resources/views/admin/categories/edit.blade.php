@extends('admin.content.layout')
@section('content')
	<div class="page-header">
        <div class="header-sub-title">
            <nav class="breadcrumb breadcrumb-dash">
                <a href="{{ URL::to('admin') }}" class="breadcrumb-item"><i class="anticon anticon-home m-r-5"></i>Home</a>
                <a class="breadcrumb-item" href="{{ URL::to('admin/categories') }}">categories</a>
               
                <span class="breadcrumb-item active">{{ $data->name }}</span>
            </nav>
        </div>
    </div>
	<div class="card">
		<div class="card-body">
			{{ Form::open(['url'=>'admin/categories/edit/'.$data->id,'files'=>true,'enctype'=>'multipart']) }}
			   
			    <div class="form-row">
			    	<div class="form-group col-md-12">
			            <label for="inputEmail4">Title</label>
			            {{ Form::text('name',$data->name,['class'=>'form-control','placeholder'=>'service Title','required']) }}
			        </div>
			        
			    </div>
			   
			    <button type="submit" class="btn btn-primary">Save</button>
			{{ Form::token() }}
			{{ Form::close() }}
			@include('admin.categories.items')
		</div>
	</div>
	<script src="https://cdn.ckeditor.com/4.5.7/full-all/ckeditor.js"></script>
	<script type="text/javascript">
	        
			CKEDITOR.replace('editor', {
				skin: 'moono',
				language:'en',
				enterMode: CKEDITOR.ENTER_BR,
				shiftEnterMode:CKEDITOR.ENTER_P
				
			});
			
	</script>
@stop