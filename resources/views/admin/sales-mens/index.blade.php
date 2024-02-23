@extends('admin.content.layout')
@section('content')
	<div class="page-header">
        <h2 class="header-title">{{ trans('home.Sales Men') }}</h2>
        <div class="header-sub-title">
            <nav class="breadcrumb breadcrumb-dash">
                <a href="{{ URL::to('admin') }}" class="breadcrumb-item"><i class="anticon anticon-home m-r-5"></i>
				{{ trans('home.Home') }} </a>

                <a href="{{ URL::to('admin/sales-men') }}" class="breadcrumb-item">{{ trans('home.Sales Men') }} </a>
               
            </nav>
        </div>
    </div>
	<div class="card">
		<div class="card-body">
			<div class="table-responsive">
				<a href="{{ URL::to('admin/sales-men/add') }}" class="btn-xs btn btn-primary pull-right">
					{{ trans('home.Add New') }}</a>
			    <table class="table">
			        <thead>
			            <tr>
			                <th scope="col">#</th>
			                <th scope="col">{{ trans('home.Name') }} </th>
			                <th scope="col">{{ trans('home.Options') }} </th>
			            </tr>
			        </thead>
			        <tbody>
			        	@foreach($allData as $data)
			            <tr>
			                <td>{{ $data->id }}</td>
			                <td>{{ $data->name }}</td>
			                
			                <td>
			                	<a href="{{ URL::to('admin/sales-men/edit/'.$data->id) }}" 
								class="btn btn-primary btn-xs">{{ trans('home.Edit') }} </a>
			                	<!-- Button trigger modal -->
								
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