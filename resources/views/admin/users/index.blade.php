@extends('admin.content.layout')
@section('content')
	<div class="page-header">
        <h2 class="header-title">{{ $title }}</h2>
        <div class="header-sub-title">
            <nav class="breadcrumb breadcrumb-dash">
                <a href="{{ URL::to('admin') }}" class="breadcrumb-item"><i class="anticon anticon-home m-r-5"></i>{{ trans('home.Home') }}</a>
                <span class="breadcrumb-item active">{{ $title }}</span>
            </nav>
        </div> 
    </div>
	<div class="card">
		<div class="card-body">
			
			<div class="panel-heading ">
			       <div class="row">
					<div class="col-md-12">
					<a href="{{ URL::to('admin/users/add') }}"
				    class="btn-xs btn btn-info pull-right">{{ trans('home.Add New') }}</a>
					</div>
				   </div>
			        {{ Form::open(['url'=>'admin/users','method'=>'get','class'=>'search-form']) }}
			        <div class="row">
			            <div class="col-sm-5">
			            		{{ trans('home.Name') }}  :
			                    {{ Form::text('name',app('request')->input('name'),['class'=>'form-control']) }}
			            </div>
						<div class="col-sm-5">
			            		{{ trans('home.Type') }}  :
			                    {{ Form::select('type',$types,app('request')->input('type'),['class'=>'form-control',
									'placeholder'=>trans('home.Choose User Type')]) }}
			            </div>
			             <div class="col-sm-2">
			               </br>
			                {{ Form::submit(trans('home.Search'),['class'=>' btn btn-md btn-primary']) }}
			            </div>
			        </div>
			        {{ Form::close() }}
			    </div>
			<div class="table-responsive">
				
			    <table class="table"> 
			        <thead>
			            <tr> 
			                <th scope="col">#</th>
			                <th scope="col">{{ trans('home.Username') }}</th>
			                <th scope="col">{{ trans('home.Type') }}</th>
			                <th scope="col">{{ trans('home.Options') }}</th>
			            </tr>
			        </thead>
			        <tbody>
			        	@foreach($allData as $data)
			            <tr>
			                <th scope="row">{{ $data->id }}</th>
			                <td>{{ $data->username }}</td>
			                <td>{{ $data->type_name }}</td>
			                <td>
			                	@if($data->type >  0)
			                	   @if($data->active == 0)
			                			<a  class="btn btn-primary btn-xs activate_user stop"  data-id="{{ $data->id }}">{{ trans('home.Activate') }}</a>
			                	   @else
			                	        <a  class="btn btn-primary btn-xs activate_user active"  data-id="{{ $data->id }}">{{ trans('home.Stop') }}</a>
			                	   @endif
			                	@endif
			                	<a href="{{ URL::to('admin/users/edit/'.$data->id) }}" class="btn btn-primary btn-xs">{{ trans('home.Edit') }}</a>								
			                </td>
			            </tr>
			           @endforeach
			           <tr>
			           	<td colspan="4">
			           		{{  $allData->appends(request()->input())->links() }}</td>
			           </tr>
			        </tbody>
			    </table>
			</div>
		</div>
	</div>
@stop