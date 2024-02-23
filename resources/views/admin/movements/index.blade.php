@extends('admin.content.layout')
@section('content')
	<div class="page-header">
        <h2 class="header-title"> All products</h2>
        <div class="header-sub-title">
            <nav class="breadcrumb breadcrumb-dash">
                <a href="{{ URL::to('admin') }}" class="breadcrumb-item">
                    <i class="anticon anticon-home m-r-5"></i>{{ trans('home.Home') }} </a>

                <a href="{{ URL::to('admin/products') }}" class="breadcrumb-item"> products</a>
                <a class="breadcrumb-item"> {{ trans('home.Product Movement').' : '.$data->title }}</a>
               
            </nav>
        </div>
    </div>
	<div class="card">
		<div class="card-body">
			<div class="table-responsive">
			    <table class="table">
			        <thead>
			            <tr>
			                <th scope="col"> {{ trans('home.Action')  }}</th>
                            <th scope="col"> {{ trans('home.Store') }}</th>
                            <th scope="col"> {{ trans('home.By') }}</th>
			                <th scope="col"> {{ trans('home.Date') }}</th>
                            <th scope="col"> {{ trans('home.In')  }}</th>
			                <th scope="col"> {{ trans('home.Out')  }}</th>
			                <th scope="col"> {{ trans('home.Store Amount')  }}</th>
			                <th scope="col"> {{ trans('home.Amount')  }}</th>
			            </tr>
			        </thead>
			        <tbody>
			        	@foreach($allData as $data)
			            <tr>
                            <td>
								<a href="{{ URL::to('admin/'.$data->link) }}" class="popup-link">
									{{ $data->note }}
								</a>
								
                            </td>
							<td>
                                {{ $data->store->title }}
                            </td>
                            <td>
                                {{ $data->user->username }}
                            </td>
                            <td>
                                {{ $data->date }}
                            </td>
                            <td>
								{{ $data->in }}
							</td>
                            <td>
								{{ $data->out }}
							</td>
                            <td>
                                {{ $data->store_total }}
                            </td>
                            <td>
                                {{ $data->total  }}
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