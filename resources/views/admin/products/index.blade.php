@extends('admin.content.layout')
@section('content')
	<div class="page-header">
        <h2 class="header-title">{{ trans('home.All Products') }} </h2>
        <div class="header-sub-title">
            <nav class="breadcrumb breadcrumb-dash">
                <a href="{{ URL::to('admin') }}" class="breadcrumb-item">
					<i class="anticon anticon-home m-r-5"></i>{{ trans('home.Home') }} </a>

                <a href="{{ URL::to('admin/products') }}" class="breadcrumb-item">
					{{ trans('home.Products') }} </a>
               
            </nav>
        </div>
    </div>
	<div class="card">
		<div class="card-body">
			<div class="table-responsive">
			    <a href="{{ URL::to('admin/products/add') }}" 
				class="btn-xs btn btn-primary pull-right">{{ trans('home.Add New') }}</a>
				
				<a data-toggle="modal" data-target="#product_import_form"
							 class=" btn btn-xs btn-primary">&nbsp;&nbsp;&nbsp;{{ trans('home.Xsl') }}</a>
			    <table class="table">
			        <thead>
			            <tr>
						    <th scope="col">#</th>
			                <th scope="col">{{ trans('home.Code') }}</th>
			                <th scope="col"> {{ trans('home.Name')  }}</th>
			                <th scope="col"> {{ trans('home.Stock')  }}</th>
			                <th scope="col"> {{ trans('home.Stock Movement')  }}</th>
			                <th scope="col"> {{ trans('home.Options') }}</th>
			            </tr>
			        </thead>
			        <tbody>
			        	@foreach($allData as $data)
			            <tr>
						    <td>{{ $data->id }}</td>
			                <td>{{ $data->code }}</td>
			                <td>{{ $data->title }}</td>
			                <td>
								{{ $data->stock }}
							</td>
							<td>
								<a href="{{  URL::to('admin/product-movement/'.$data->id) }}" 
								   class="btn btn-xs btn-success">
									<i class="anticon anticon-eye"></i>
								</a>
							</td>
			                <td>
			                	<a href="{{ URL::to('admin/products/edit/'.$data->id) }}" 
								class="btn btn-primary btn-xs">{{ trans('home.Edit') }} </a>
			                	
			                </td>
			            </tr>
			           @endforeach
			           <tr>
			           	<td colspan="5">{{ $allData->links() }}</td>
			           </tr>
			        </tbody>
			    </table>
			</div>
		</div>
	</div>
	@include('admin.popups.product_import')
	@section('scripts')
	   <script>
		   
	   </script>
	@endsection
@stop