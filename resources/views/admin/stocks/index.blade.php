@extends('admin.content.layout')
@section('content')
	<div class="page-header">
        <h2 class="header-title"> {{ $title }}</h2>
        <div class="header-sub-title">
            <nav class="breadcrumb breadcrumb-dash">
                <a href="{{ URL::to('admin') }}" class="breadcrumb-item">
                    <i class="anticon anticon-home m-r-5"></i> {{ trans('home.Home') }} </a>

                <a href="{{ URL::to('admin/stocks') }}" class="breadcrumb-item">
                    {{ trans('home.Stock') }}</a>
               
            </nav>
        </div>
    </div>
	<div class="card">
		<div class="card-body">
        <div class="panel-heading ">
                   
			        {{ Form::open(['url'=>'admin/stocks','method'=>'get','class'=>'search-form']) }}
			        </br>
                    </br>
                    <div class="row">
			            <div class="col-sm-10">
			            		{{ trans('home.Name') }}  :
			                    {{ Form::text('name',app('request')->input('name'),['class'=>'form-control']) }}
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
                           <th scope="col"> {{ trans('home.Code') }}</th>
			                <th scope="col"> {{ trans('home.Product') }}</th>
			                <th scope="col"> {{ trans('home.Amount') }}</th>
			                <th scope="col"> {{ trans('home.Options') }}</th>
			            </tr>
			        </thead>
			        <tbody>
			        	@foreach($allData as $data)
			            <tr>
                            <td>
                                {{ $data->product->code }}
                            </td>
                            <td>
                                {{ $data->product->title }}
                            </td>
                            
                            <td>
                                {{ $data->amount }}
                            </td>
                           
                            <td>
                                <a href="{{ URL::to('admin/stocks/view/'.$data->product_id) }}" title="{{ trans('home.View') }}" class="popup-link btn btn-xs btn-primary">
                                    <i class="anticon anticon-eye"></i>
                                </a>
                               
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
    @section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.min.js"></script>
    <script>
            $('.popup-link').magnificPopup({
                type: 'iframe', // Change this based on the type of content you want to display
                    gallery: {
                        enabled: true
                    },
                    callbacks: {
                        open: function() {
                            this.content.find('iframe').addClass('popup-iframe');
                            // Set the height of the iframe to 100vh
                            this.content.find('iframe').css({
                                'width': '100%',
                                'height': '100%',
                                'min-height':'70vh'
                            });
                        }
                    }
                });
    </script>
    @endsection
@stop