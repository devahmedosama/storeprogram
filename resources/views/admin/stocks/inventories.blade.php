@extends('admin.content.layout')
@section('content')
    <style>
        .dot-flashing {
            display: inline-block;
            width: 10px;
            height: 10px;
            background-color: #333;
            border-radius: 50%;
            animation: dotFlashing 1s infinite alternate;
            margin-left: 5px;
        }

        @keyframes dotFlashing {
            0% {
                opacity: 0.2;
            }

            100% {
                opacity: 1;
            }
        }
        .loader_holder{
            position: relative;
        }
        .loader{
            position: absolute;
            width:100%;
            height:100%;
            z-index: 1;
        }
        .success{
            background-color:#dff5e8;
        }
    </style>
	<div class="page-header">
        <div class="header-sub-title">
            <nav class="breadcrumb breadcrumb-dash">
                <a href="{{ URL::to('admin') }}" class="breadcrumb-item">
                    <i class="anticon anticon-home m-r-5"></i>{{ trans('home.Home') }} </a>

                <a href="{{ URL::to('admin/inventories') }}" class="breadcrumb-item">
                    {{ trans('home.Inventories') }}</a>
               
            </nav>
        </div>
    </div>
	<div class="card">
		<div class="card-body">
                <div class="panel-heading ">
                    <a href="{{ URL::to('admin/view-process/'.$data->id) }}" 
                        class="btn btn-md btn-primary">{{ trans('home.Review') }}</a>
                    @if($data->items()->count() > 0)
                    <a data-toggle="modal" data-target="#inventory_form"
							 class=" btn btn-md pull-right btn-primary">&nbsp;&nbsp;&nbsp;{{ trans('home.Finish Inventory') }}</a>
                    @endif
			        {{ Form::open(['url'=>'admin/inventories','method'=>'get','class'=>'search-form']) }}
			        </br>
                    </br>
                    <div class="row">
			            <div class="col-sm-3">
			            		{{ trans('home.Name') }}  :
			                    {{ Form::text('name',app('request')->input('name'),['class'=>'form-control']) }}
			            </div>
                        <div class="col-sm-3">
			            		{{ trans('home.Store') }}  :
			                    {{ Form::select('store_id',$stores,app('request')->input('store_id'),['class'=>'form-control','placeholder'=>trans('home.Choose Store')]) }}
			            </div>
                        <div class="col-sm-3">
			            		{{ trans('home.Supplier') }}  :
			                    {{ Form::select('suplier_id',$supliers,app('request')->input('suplier_id'),['class'=>'form-control','placeholder'=>trans('home.Choose Supplier')]) }}
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
                           <th scope="col"> {{ trans('home.Product') }}</th>
			                <th scope="col"> {{ trans('home.Store') }}</th>
			                <th scope="col"> {{ trans('home.Quantity') }}</th>
                            <th>
                                {{ trans('home.Real Quantity') }}
                            </th>
			                <th scope="col"> {{ trans('home.Options') }}</th>
			            </tr>
			        </thead>
			        <tbody>
			        	@foreach($allData as $data)
			            <tr>
                            {{ Form::open(['url'=>'admin/inventories/add/'.$data->product_id,'class'=>'update_tr']) }}
                            <td>
                                {{ $data->product->title }}
                            </td>
                            <td>
                                {{ $data->store->title }}
                            </td>
                            
                            <td>
                                {{ $data->amount }}
                                <input type="hidden" name="old_amount" value="{{ $data->amount }}">
                                <input type="hidden" name="store_id" value="{{ $data->store_id }}">
                            </td>
                            <td>
                               {{ Form::number('amount',$data->amount,['class'=>'form-control','required']) }}
                            </td>
                            

                            <td class="loader_holder">
                                <div class="loader" style="display: none;">
                                    <div class="dot-flashing"></div>
                                    <div class="dot-flashing"></div>
                                    <div class="dot-flashing"></div>
                                </div>
                               <button type="submit" class="btn btn-md btn-primary">{{ trans('home.Update') }}</button>
                            </td>
                            
                            {{ Form::token() }}
                            {{ Form::close() }}
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
    @include('admin.popups.inventory_form')
    @section('scripts')
    <script>
     
        $('table').on('submit','.update_tr',function(e){
            e.preventDefault();
            el =  $(this);
            var url  =  $(this).attr('action');
            var  items =  $(this).serialize();
            $(this).find('.loader').show();
            $.post(url,items,function(data){
                el.closest('tr').addClass('success');
            })
        })
    </script>
    <script src="https://cdn.jsdelivr.net/npm/signature_pad@2.3.2/dist/signature_pad.min.js" 
        integrity="sha256-W+ivNvVjmQX6FTlF0S+SCDMjAuTVNKzH16+kQvRWcTg=" crossorigin="anonymous"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var canvas = document.querySelector("#signature_pad");
            var signaturePad = new SignaturePad(canvas, {
                minWidth: 2,
                maxWidth: 4,
            });

            function resizeCanvas() {
                var ratio =  Math.max(window.devicePixelRatio || 1, 1);
                var hei = 200;
                var wid = 200;
                if (canvas.offsetWidth * ratio > 0) {
                    canvas.width = canvas.offsetWidth * ratio;
                }else{
                    canvas.width = 400;
                }
                if (canvas.offsetHeight * ratio > 0) {
                    canvas.height = canvas.offsetHeight * ratio;
                } else {
                    canvas.height = 200;
                }
                
                canvas.getContext("2d").scale(ratio, ratio);
                let storedData = signaturePad.toData();
                signaturePad.clear(); // otherwise isEmpty() might return incorrect value
                signaturePad.fromData(storedData);
            }

            window.addEventListener("resize", resizeCanvas);
            resizeCanvas();
            
            var clearButton = document.querySelector("#clear_button");
            clearButton.addEventListener("click", function() {
                signaturePad.clear();
            });
            
            var finishButton = document.querySelector("#finish_button");
            finishButton.addEventListener("click", function(event) {
                event.preventDefault(); // Prevent default button behavior (form submission)
                const svgDataUrl = signaturePad.toDataURL("image/svg+xml");
                document.querySelector('#signature_image').value = svgDataUrl;
                // Submit the form after setting the signature image value
                document.querySelector("#signatureForm").submit();
                
            });
        });
    </script>
    
    @endsection
@stop