@extends('admin.content.layout')
@section('content')
	<div class="page-header">
        <h2 class="header-title">{{ $data->title }}</h2>
        <div class="header-sub-title">
            <nav class="breadcrumb breadcrumb-dash">
                <a href="{{ URL::to('admin') }}" class="breadcrumb-item"><i class="anticon anticon-home m-r-5"></i>Home</a>
                <a class="breadcrumb-item" href="{{ URL::to('admin/settings') }}"> {{ trans('home.Settings') }}</a>
               
                <span class="breadcrumb-item active">{{ $data->title }}</span>
            </nav>
        </div>
    </div>
	<div class="card">
		<div class="card-body">
			{{ Form::open(['url'=>'admin/settings','files'=>true,'enctype'=>'multipart']) }}
			   
			    <div class="form-row">
			    	<div class="form-group col-md-12">
			            <label for="inputEmail4">{{ trans('home.Name') }}</label>
			            {{ Form::text('name',$data->name,['class'=>'form-control','required']) }}
			        </div>
					<div class="form-group col-md-12">
			            <label for="inputEmail4">{{ trans('home.Name in english') }}</label>
			            {{ Form::text('name_en',$data->name_en,['class'=>'form-control','required']) }}
			        </div>
					
			        <div class="form-group col-md-8">
			            <label for="inputEmail4">website logo</label>
			            {{ Form::file('logo',['class'=>'form-control']) }}
			        </div>
					<div class="form-group col-md-4">
						
			            <img src="{{ URL::to($data->logo) }}" height="100" alt="" srcset="">
			        </div>
			    </div>
			   
			    <button type="submit" class="btn btn-primary">{{ trans('home.Save') }}</button>
			{{ Form::token() }}
			{{ Form::close() }}
		</div>
	</div>
@stop