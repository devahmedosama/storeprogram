@extends('admin.content.layout')
@section('content')
	<div class="page-header">
        <div class="header-sub-title">
            <nav class="breadcrumb breadcrumb-dash">
                <a href="{{ URL::to('admin') }}" class="breadcrumb-item"><i class="anticon anticon-home
				 m-r-5"></i>{{ trans('home.Home') }}</a>
                <a class="breadcrumb-item" href="{{ URL::to('admin/sales-men') }}">{{ trans('home.Sales Men') }}</a>
                <span class="breadcrumb-item active">{{ trans('home.Add New') }}</span>
            </nav>
        </div>
    </div>
	<div class="card">
		<div class="card-body">
			{{ Form::open(['url'=>'admin/sales-men/add','files'=>true,'enctype'=>'multipart']) }}
			    
			    <div class="form-row">
			    	<div class="form-group col-md-12">
			            <label for="inputEmail4">{{ trans('home.Name') }}</label>
			            {{ Form::text('name',null,['class'=>'form-control','required']) }}
			        </div>
					<div class="form-group col-md-12">
			            <label for="inputEmail4">{{ trans('home.Name in english') }}</label>
			            {{ Form::text('name_en',null,['class'=>'form-control']) }}
			        </div>
					
			        <div class="form-group col-md-12">
			            <label for="inputEmail4">{{ trans('home.Phone') }}</label>
			            {{ Form::text('phone',null,['class'=>'form-control']) }}
			        </div>
					<div class="form-group col-md-12">
			            <label for="inputEmail4">{{ trans('home.E-mail') }}</label>
			            {{ Form::email('email',null,['class'=>'form-control']) }}
			        </div>
			    </div>
			    <button type="submit" class="btn btn-primary">{{ trans('home.Save') }}</button>
			{{ Form::token() }}
			{{ Form::close() }}
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