@extends('admin.content.layout')
@section('content')
	<div class="page-header">
        <div class="header-sub-title">
            <nav class="breadcrumb breadcrumb-dash">
                <a href="{{ URL::to('admin') }}" class="breadcrumb-item">
					<i class="anticon anticon-home m-r-5"></i> {{ trans('home.Home') }} </a>

                <a href="{{ URL::to('admin/processes') }}" class="breadcrumb-item"> {{ trans('home.Inventory Process') }}</a>
               
            </nav>
        </div>
    </div>
	<div class="card">
		<div class="card-body">
			<div class="table-responsive">
			    <table class="table">
			        <thead>
			            <tr>
			                <th scope="col">#</th>
                            <th scope="col"> {{ trans('home.Date') }}</th>
			                <th scope="col"> {{ trans('home.By') }}</th>
			                <th scope="col"> {{ trans('home.Signature') }}</th>
			                <th scope="col"> {{ trans('home.Products No') }}</th>
			                <th scope="col"> {{ trans('home.Options') }}</th>
			            </tr>
			        </thead>
			        <tbody>
			        	@foreach($allData as $data)
			            <tr>
			                <td>{{ $data->id }}</td>
			                <td>{{ date('d-m-Y h:i a',strtotime($data->created_at)) }}</td>
			                <td>
                                {{ $data->user->username }}
                            </td>
                            <td>
                                <img src="{{ $data->signature }}" height="80" alt="">
                            </td>
                            <td>
                                {{ $data->items()->count() }}
                            </td>
			                <td>
                            <a href="{{ URL::to('admin/view-process/'.$data->id) }}" 
                                class="btn btn-md btn-primary">{{ trans('home.Xsl') }}</a>
			                	
			                </td>
			            </tr>
			           @endforeach
			           <tr>
			           	<td colspan="3">{{ $allData->links() }}</td>
			           </tr>
			        </tbody>
			    </table>
			</div>
		</div>
	</div>
@stop