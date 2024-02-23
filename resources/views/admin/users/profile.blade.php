@extends('admin.content.layout')
@section('content')
	<div class="page-header">
        <h2 class="header-title">{{ trans('home.My Profile') }}</h2>
        <div class="header-sub-title">
            <nav class="breadcrumb breadcrumb-dash">
                <a href="{{ URL::to('admin') }}" class="breadcrumb-item"><i class="anticon anticon-home m-r-5"></i>{{ trans('home.Home') }}</a>
                <span class="breadcrumb-item active">{{ trans('home.My Profile') }}</span>
            </nav>
        </div>
    </div>
	<div class="card"> 
		<div class="card-body">
			{{ Form::open(['url'=>'admin/profile','files'=>true,'enctype'=>'multipart']) }}
			    <div class="form-row">
			        <div class="form-group col-md-6">
			            <label for="inputEmail4">{{ trans('home.Name') }}</label>
			            {{ Form::text('username',$data->username,['class'=>'form-control','placeholder'=>trans('home.Name'),'required']) }}
			        </div>
					<div class="form-group col-md-6">
			            <label for="inputEmail4">{{ trans('home.Language') }}</label>
			            {{ Form::select('lang',$langs,$data->lang,['class'=>'form-control','required']) }}
			        </div>
			    </div>
			    
			    <div class="form-row">
			        <div class="form-group col-md-6">
			            <label for="inputEmail4">{{ trans('home.Password') }}</label>
			            {{ Form::password('password',['class'=>'form-control']) }}
			        </div>
			        <div class="form-group col-md-6">
			            <label for="inputEmail4">{{ trans('home.Confirm Password') }}</label>
			            {{ Form::password('confirm_password',['class'=>'form-control']) }}
			        </div>
			    </div>
			    <button type="submit" class="btn btn-primary">{{ trans('home.Save') }}</button>
			{{ Form::token() }}
			{{ Form::close() }}
		</div>
	</div>
@stop