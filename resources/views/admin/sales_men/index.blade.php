@extends('admin.content.layout')
@section('content')
	<div class="page-header">
        <h2 class="header-title"> {{ trans('home.Sales Bills') }}</h2>
        <div class="header-sub-title">
            <nav class="breadcrumb breadcrumb-dash">
                <a href="{{ URL::to('admin') }}" class="breadcrumb-item">
                    <i class="anticon anticon-home m-r-5"></i>{{ trans('home.Home') }} </a>

                <a href="{{ URL::to('admin/sales-bills') }}" class="breadcrumb-item">
                    {{ trans('home.Sales Bills') }}</a>
               
            </nav>
        </div>
    </div>
	<div class="card">
		<div class="card-body">
			<div class="table-responsive">
				<a href="{{ URL::to('admin/ask-bills/add') }}" class="btn-xs btn btn-primary pull-right">
                {{ trans('home.Ask Bills') }}</a>
			    <table class="table">
			        <thead>
			            <tr>
			                <th scope="col">{{ trans('home.No') }}</th>
			                <th scope="col"> {{ trans('home.Sales Man') }}</th>
			                <th scope="col"> {{ trans('home.Store') }}</th>
			                <th scope="col"> {{ trans('home.By') }}</th>
			                <th scope="col"> {{ trans('home.Amount') }}</th>
			                <th scope="col"> {{ trans('home.Date') }}</th>
			                <th scope="col"> {{ trans('home.Options') }}</th>
			            </tr>
			        </thead>
			        <tbody>
			        	@foreach($allData as $data)
			            <tr>
			                <td>{{ $data->no }}</td>
                            <td>
                                {{ $data->sales_man->title }}
                            </td>
                            <td>
                                {{ $data->store->title }}
                            </td>
                            <td>
                                {{ $data->user->username }}
                            </td>
                            <td>
                                {{ $data->items()->sum('amount') }}
                            </td>
                            
                            <td>
                                {{  date('d-m-y',strtotime($data->created_at)) }}
                            </td>
                            <td>
                                <a href="{{ URL::to('admin/bills/view/'.$data->id) }}" title="{{ trans('home.View') }}" class="popup-link btn btn-xs btn-primary">
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