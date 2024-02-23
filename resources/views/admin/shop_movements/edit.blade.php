@extends('admin.content.layout')
@section('content')
	<div class="page-header">
        <div class="header-sub-title">
            <nav class="breadcrumb breadcrumb-dash">
                <a href="{{ URL::to('admin') }}" class="breadcrumb-item"><i class="anticon anticon-home
				 m-r-5"></i>{{ trans('home.Home') }}</a>
                <a class="breadcrumb-item" href="{{ URL::to('admin/shop-movements') }}">{{ trans('home.Shop Movements') }}</a>
                <span class="breadcrumb-item active">{{ $title }}</span>
            </nav>
        </div>
    </div>
	<div class="card">
		<div class="card-body">
			{{ Form::open(['url'=>'admin/shop-movements/edit/'.$data->id,'files'=>true,'enctype'=>'multipart','id'=>'signatureForm']) }}
			    
			    <div class="form-row">
				    <input type="hidden" name="store_id" value="{{ $data->store_id }}">
					
				    <div class="form-group col-md-12 ">
			            <label for="inputEmail4">{{ trans('home.Product') }}</label>
			            {{ Form::text('product',null,['class'=>'form-control'
							,'id'=>'product_search']) }}
						<ul class="product_list">

						</ul>
			        </div>
					<div class="col-md-12">
						<table class="table">
							<thead>
								<tr>
								     <th scope="col">{{ trans('home.Code') }}</th>
									<th scope="col">{{ trans('home.Product') }}</th>
									<th scope="col">{{ trans('home.Amount') }}</th>
									<td></td>
								</tr>
							</thead>
							<tbody id="products_row">
                                @foreach($data->items as $item)
								<tr>
									<td>
										{{ $item->product->code  }}
									</td>
                                    <td>
                                        {{ $item->product->title }}
                                        <input type="hidden" name="product_id[]" value="{{ $item->product_id }}">
                                    </td>
                                    <td>
                                        {{ Form::number('quantity[]',$item->amount,['class'=>'form-control','min'=>0,'max'=>$item->max]) }}
                                    </td>
                                </tr>
                                @endforeach
							
							</tbody>
						</table>
						     
					</div>
			    </div>
			    <button type="submit"  id="finish_button"  class="btn btn-primary">
					{{ trans('home.Save') }}</button>
			{{ Form::token() }}
			{{ Form::close() }}
		</div>
	</div>
	@include('admin.popups.sales_man')
	@section('scripts')
	   <script>
		   var  ids =  [];
           @foreach($data->items as $item)
                  ids.push({{ $item->product_id }});
           @endforeach
		   $('#store_id').change(function(){
			  ids =  [];
			  $('#products_row').html('');
			  $('.product_list').html('');
		   })
		   $(document).ready(function() {
			$(document).on('input', 'input[name="quantity[]"]', function() {
                var enteredValue = parseInt($(this).val(), 10);
                var maxAllowed = parseInt($(this).attr('max'), 10);

                if (enteredValue > maxAllowed) {
                    // If the entered value is greater than the max, set it to the max value
                    $(this).val(maxAllowed);
                }
            });
			
		   })
		   $('.product_list').on('click', 'li',function() {
			  var  name =  $(this).data('name');
			  var  id   =  $(this).data('id');
			  var  max   =  $(this).data('max');
			  if (!ids.includes(id)) {
				ids.push(id);
				var  name =  $(this).data('name');
				var  id   =  $(this).data('id');
				var  code =  $(this).data('code');
				var  text =  '<tr>';
				text      = text+'<td>'+code+'</td>';
				text      = text+'<td> <input type="hidden" name="product_id[]" value="'+id+'" >'+name+'</td>' ;
				text      = text+'<td><input type="number" class="form-control" max="'+max+'" min="1" name="quantity[]" value="1" ></td>' ;
				text      = text+'<td> <a class="remove_item"> X </a> </td></tr>' ;
				$('#products_row').append(text);
				$('.product_list').html('');
				$("#product_search").addClass('success');
                setTimeout(() => {
                            $("#product_search").removeClass('success');
                        }, 1000);
			   }else{
				  $("#product_search").addClass('alertsearch');
                    setTimeout(() => {
                        $("#product_search").removeClass('alertsearch');
                    }, 1000);
			   }
			  
		   })
		   $('#product_search').on('keyup',function(){
			   var name =  $(this).val();
			   $('.product_list').html('');
			   if(name.length > 2){
			            var  store_id =  {{ $data->store_id }};
						$.get('{{ URL::to("admin/products/search") }}',{name:name,store_id:store_id},function(data){
							var products  =  data.data;
							// if (data.count == 1) {

							// 	var  item = products[0];
							// 	var  name =  item.title;
							// 	var  id   =  item.id;
							// 	if (!ids.includes(id)) {
				            //         ids.push(item.id);
							// 		var  text =  '<tr>';
							// 		text      = text+'<td> <input type="hidden" name="product_id[]" value="'+id+'" >'+name+'</td>' ;
							// 		text      = text+'<td><input type="number" class="form-control" max="'+item.amount+'" min="1" name="quantity[]" value="1" ></td>' ;
							// 		text      = text+'<td> <a class="remove_item"> X </a> </td></tr>' ;
							// 		$('#products_row').append(text);
							// 		$("#product_search").addClass('success');
							// 			setTimeout(() => {
							// 						$("#product_search").removeClass('success');
							// 					}, 1000);
							// 		}else{
							// 			$("#product_search").addClass('alertsearch');
							// 				setTimeout(() => {
							// 					$("#product_search").removeClass('alertsearch');
							// 				}, 1000);
							// 		}
								
							// }else{
								$('.product_list').html('');
								$.each(products,function(index,item) {
									$('.product_list').append('<li data-code="'+item.code+'" data-id="'+item.id+'" data-max="'+item.amount+'" data-name="'+item.title+'">'+item.title+'</li>')
								})
							// }
							
					   })
			   }
		   })
		   $('#products_row').on('click','.remove_item',function(){
			  $(this).parent().parent().remove();
		   })
		   
	         
	   </script>
	   
	@endsection
@stop