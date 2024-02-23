@extends('admin.content.layout')
@section('content')
	<div class="page-header">
        <div class="header-sub-title">
            <nav class="breadcrumb breadcrumb-dash">
                <a href="{{ URL::to('admin') }}" class="breadcrumb-item">
					<i class="anticon anticon-home
				 m-r-5"></i>{{ trans('home.Home') }}</a>
                <a class="breadcrumb-item" href="{{ URL::to('admin/recives') }}">
				{{ trans('home.Recives') }}
				</a>
                <span class="breadcrumb-item active">{{ $title }}</span>
            </nav>
        </div>
    </div>
	<div class="card">
		<div class="card-body">
            <div class="row">
                <div class="col-md-8">
                    <div class="details_holder">
                        <h5>
                            {{ trans('home.Recive No') }} : {{ $data->no }}
                        </h5>
						@if($data->purchase)
                        <h5>
                            {{ trans('home.Purchase No') }} : {{ $data->purchase->no }}
                        </h5>
						@endif
                        <h5>
                            {{ trans('home.Supplier') }} : {{ $data->purchase?$data->purchase->supplier->title:' ' }}
                            {{ $data->suplier?$data->suplier->title:' ' }}
                        </h5>
                        <h5>
                            {{ trans('home.Store') }} : {{ $data->store->title }}
                        </h5>
                    </div>
                </div>
                <div class="col-md-4">
                    <h5>
                            {{ trans('home.Recivening Date') }} : {{ date('Y-m-d',strtotime($data->created_at)) }}
                   </h5>
                    <h5>
                        {{ trans('home.Amount')}} : {{ $data->items()->sum('amount') }}
                    </h5>
                    <h5>
                        {{ trans('home.Recived')}} : {{ $data->items()->sum('recived_amount') }}
                    </h5>
                    <h5>
                        {{ trans('home.Recived By')}} : {{ $data->user->username }}
                    </h5>
                    <img src="{{ $data->signature }}" class="img-responsive" height="120" alt="">
                </div> 
            </div>
            
			{{ Form::open(['url'=>'admin/recives/edit/'.$data->id,
				'files'=>true,'enctype'=>'multipart','id'=>'signatureForm']) }}
			    
			    <div class="form-row">
                    
				    <div class="form-group col-md-12 plus_div list_holder">
			            <label for="inputEmail4">{{ trans('home.Product') }}</label>
			            {{ Form::text('product',null,['class'=>'form-control'
							,'id'=>'product_search']) }}
							<a data-toggle="modal" data-target="#product_purchase_form"
							 class="plus_btn btn bt-xs btn-primary">+</a>	
							<ul class="product_list">
							</ul>
			        </div>
                    
					<div class="col-md-12">
						<table class="table">
							<thead>
								<tr>
									<th scope="col">{{ trans('home.Product') }}</th>
									<th scope="col">{{ trans('home.Amount') }}</th>
									<th scope="col">{{ trans('home.Recived') }}</th>
									<td></td>
								</tr>
							</thead>
							<tbody id="products_row">
                                @foreach($data->items as $item)
								<tr>
                                    <td>
                                        {{ $item->product->title }}
                                    </td>
                                    <td>
                                        <input type="hidden" name="product_id[]" value="{{ $item->product_id }}">
                                        <input type="hidden" name="amount[]" value="{{ $item->amount }}">
                                        {{ $item->amount }}
                                    </td>
                                    <td>
                                        <input class="form-control" type="number" min="0" step="any" value="{{ $item->recived_amount??0 }}" name="recived_amount[]"> 
                                    </td>
                                    <td>

                                    </td>
                                </tr>
                                @endforeach
							</tbody>
						</table>
					</div>
			    </div>
			    <button type="submit" id="finish_button" class="btn btn-primary">
				{{ trans('home.Save') }}</button>
			{{ Form::token() }}
			{{ Form::close() }}
		</div>
	</div>
	@include('admin.popups.store')
	@include('admin.popups.product_recive')
	@include('admin.popups.supplier')
	@section('scripts')
	   <script>
         
           var  ids =  [];
            
		   $('.product_list').on('click', 'li',function() {
			  var  name =  $(this).data('name');
			  var  id   =  $(this).data('id');
              ids.push(id);
              var  text =  '<tr>';
            text      = text+'<td> <input type="hidden" name="product_id[]" value="'+id+'" >'+name+'</td>' ;
            text      = text+'<td><input type="hidden" name="amount[]" value="0">0</td>';
            text      = text+'<td><input type="number" class="form-control" min="1" name="recived_amount[]" value="1" ></td>' ;
            text      = text+'<td> <a class="remove_item"> X </a> </td></tr>' ;
            $('#products_row').append(text);
            $('.product_list').html('');
            $("#product_search").addClass('success');
            setTimeout(() => {
                        $("#product_search").removeClass('success');
                    }, 1000);
               
			  
		   })
		   $('#product_search').on('keyup',function(){
			   var name =  $(this).val();
			   $('.product_list').html('');
			   if(name.length > 2){
						$.get('{{ URL::to("admin/products/search") }}',{name:name},function(data){
							var products  =  data.data;
							if (data.count == 1) {
                                var  item = products[0];
								var  name =  item.title;
								var  id   =  item.id;
								ids.push(id);
								var  text =  '<tr>';
								text      = text+'<td> <input type="hidden" name="product_id[]" value="'+id+'" >'+name+'</td>' ;
								text      = text+'<td><input type="hidden" name="amount[]" value="0">0</td>';
								text      = text+'<td><input type="number" class="form-control" min="1" name="recived_amount[]" value="1" ></td>' ;
								text      = text+'<td> <a class="remove_item"> X </a> </td></tr>' ;
								$('#products_row').append(text);
								$("#product_search").addClass('success');
								setTimeout(() => {
									$("#product_search").removeClass('success');
								}, 1000);
                               
							}else{
								$.each(products,function(index,item) {
									$('.product_list').append('<li  data-id="'+item.id+'" data-name="'+item.title+'">'+item.title+'</li>')
								})
							}
							
					   })
			   }
		   })
           var items = [];
           $('#purchase_search').on('keyup',function(){
			   var name =  $(this).val();
			   $('.purchase_list').html('');
			   if(name.length > 2){
						$.get('{{ URL::to("admin/purchases/search") }}',{name:name},function(data){
							var products  =  data.data;
                            $.each(products,function(index,item) {
							   $('.purchase_list').append('<li   data-suplier_id="'+item.suplier_id+'"  data-id="'+item.id+'" data-name="'+item.no+'">'+item.no+' (-'+item.supplier_name+'-)</li>')
							   items[item.id] = item.purchase_items;
                            })
					   })
			   }
		   })
           $('.purchase_list').on('click', 'li',function() {
                 var  suplier_id =  $(this).data('suplier_id');
                 $('#suplier_id').val(suplier_id);
                 var  id =  $(this).data('id');
                 $('#purchase_id').val(id);
                 products =  items[id];
                 $('#products_row').html('');
                 $('.purchase_list').html('');
                 $.each(products,function(index,data){
                        var  id =  data.product_id;
                        var  name =  data.title;
                        var  text =  '<tr>';
                        text      = text+'<td> <input type="hidden" name="product_id[]" value="'+id+'" >'+name+'</td>' ;
                        text      = text+'<td><input type="hidden" name="amount[]" value="'+data.amount+'">'+data.amount+'</td>';
                        text      = text+'<td><input type="number" class="form-control" min="1" name="recived_amount[]" value="'+data.recived_amount+'" ></td>' ;
                        text      = text+'<td> <a class="remove_item"> X </a> </td></tr>' ;
                        $('#products_row').append(text);
                 })

           });
		   $('#products_row').on('click','.remove_item',function(){
			  $(this).parent().parent().remove();
		   })
		   $('.append_recive').submit(function(e){
					e.preventDefault();
					var  url        =  $(this).attr('action');
					var  input_name = $(this).data('input');
					var  msg = $(this).data('msg');
					var  items  =  $(this).serialize();
					$(this).addClass('loading');
					var  el =  $(this);
					$.post(url,items,function(data){
						if (data.state == 1) {
							// start 
							var  name =  data.name;
							var  id   =  data.id;
							var  text =  '<tr>';
							text      = text+'<td> <input type="hidden" name="product_id[]" value="'+id+'" >'+name+'</td>' ;
							text      = text+'<td><input type="hidden" value="0" name="amount[]" >0 </td>';
                            text      = text+'<td><input type="number" class="form-control" min="1" name="recived_amount"[] value="1" ></td>' ;
							text      = text+'<td> <a class="remove_item"> X </a> </td></tr>' ;
							$('#products_row').append(text);
							el.removeClass('loading');
							el[0].reset();
							$('.'+msg).text('{{ trans("home.Done Successfully") }}');
							$('.modal').modal('hide');
						}else{
							el.removeClass('loading');
							$('.'+msg).text('{{ trans("home.This Name Allready Existing") }}');		
						}
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
					canvas.width = canvas.offsetWidth * ratio;
					canvas.height = canvas.offsetHeight * ratio;
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