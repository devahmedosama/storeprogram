@extends('admin.content.layout')
@section('content')
	<div class="page-header">
        <div class="header-sub-title">
            <nav class="breadcrumb breadcrumb-dash">
                <a href="{{ URL::to('admin') }}" class="breadcrumb-item"><i class="anticon anticon-home
				 m-r-5"></i>{{ trans('home.Home') }}</a>
                <a class="breadcrumb-item" href="{{ URL::to('admin/purchases') }}">{{ trans('home.Purchases') }}</a>
                <span class="breadcrumb-item active">{{ trans('home.Add New') }}</span>
            </nav>
        </div>
    </div>
	<div class="card">
		<div class="card-body">
			{{ Form::open(['url'=>'admin/purchases/add','files'=>true,'enctype'=>'multipart','id'=>'signatureForm']) }}
			    
			    <div class="form-row">
					<div class="col-md-12 text-right">
					<a data-toggle="modal" data-target="#product_import_form"
							 class=" btn btn-xs btn-primary">{{ trans('home.Xsl') }}</a>
					</div>
				    <div class="form-group col-md-6 plus_div">
			            <label for="inputEmail4">{{ trans('home.Supplier') }}</label>
			            {{ Form::select('suplier_id',$items,null,['class'=>'form-control'
							,'id'=>'suplier_id']) }}
							<a data-toggle="modal" data-target="#supplier_form" class="plus_btn btn bt-xs btn-primary">+</a>	
			        </div>
				    <div class="form-group col-md-6 plus_div list_holder">
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
								    <th scope="col">{{ trans('home.Code') }}</th>
									<th scope="col">{{ trans('home.Product') }}</th>
									<th scope="col">{{ trans('home.Amount') }}</th>
									<td></td>
								</tr>
							</thead>
							<tbody id="products_row">
								
							</tbody>
						</table>
					</div>
					<div class="col-md-6">
					        <a class="button-text" id="clear_button">{{ trans('home.Clear') }}</a>
							<canvas id="signature_pad"></canvas>
							<input type="hidden" name="image"  required id="signature_image" required>
					</div>
			    </div>
			    <button type="submit"  id="finish_button"  class="btn btn-primary">{{ trans('home.Save') }}</button>
			{{ Form::token() }}
			{{ Form::close() }}
		</div>
	</div>
	@include('admin.popups.supplier')
	@include('admin.popups.product_purchase')
	@include('admin.popups.product_import')
	@section('scripts')
	   <script>
		   var  ids =  [];
		   $('.product_list').on('click', 'li',function() {
			  var  name =  $(this).data('name');
			  var  id   =  $(this).data('id');
			  if (!ids.includes(id)) {
				ids.push(id);
				var  name =  $(this).data('name');
				var  id   =  $(this).data('id');
				var  code   =  $(this).data('code');
				var  text =  '<tr>';
				text      = text+'<td> '+code+'</td>' ;
				text      = text+'<td> <input type="hidden" name="product_id[]" value="'+id+'" >'+name+'</td>' ;
				text      = text+'<td><input type="number" class="form-control" min="1" name="quantity[]" value="1" ></td>' ;
				text      = text+'<td> <a  data-id="'+id+'"  class="remove_item"> X </a> </td></tr>' ;
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
			   var suplier_id  =  $('#suplier_id option:selected').val();
			   if(name.length > 2){
						$.get('{{ URL::to("admin/products/search") }}',{name:name,suplier_id:suplier_id},function(data){
							var products  =  data.data;
							// if (data.count == 1) {
							// 	var  item = products[0];
							// 	var  name =  item.title;
							// 	var  id   =  item.id;
							// 	if (!ids.includes(id)) {
				            //         ids.push(item.id);
							// 		var  text =  '<tr>';
							// 		text      = text+'<td>'+item.code+'</td>';
							// 		text      = text+'<td> <input type="hidden" name="product_id[]" value="'+id+'" >'+name+'</td>' ;
							// 		text      = text+'<td><input type="number" class="form-control" min="1" name="quantity[]" value="1" ></td>' ;
							// 		text      = text+'<td> <a data-id="'+id+'" class="remove_item"> X </a> </td></tr>' ;
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
									$('.product_list').append('<li data-code="'+item.code+'" data-id="'+item.id+'" data-name="'+item.title+'">'+item.title+'</li>')
								})
							// }
							
					   })
			   }
		   })
		   $('#products_row').on('click','.remove_item',function(){
			    var  id = $(this).data('id');
			    var indexToRemove = ids.indexOf(id);
				if (indexToRemove !== -1) {
			    	ids.splice(indexToRemove, 1);
				}
			  $(this).parent().parent().remove();
		   })
		   $('.append_purcahse').submit(function(e){
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
							var  text =  '<tr >';
							text      = text+'<td> <input type="hidden" name="product_id[]" value="'+id+'" >'+name+'</td>' ;
							text      = text+'<td><input type="number" class="form-control" min="1" name="quantity"[] value="1" ></td>' ;
							text      = text+'<td> <a class="remove_item"> X </a> </td></tr>' ;
							$('#products_row').append(text);
							el.removeClass('loading');
							el[0].reset();
							$('.'+msg).text('{{ trans("home.Done Successfully") }}');
							$('.modal').modal('hide');
						}else{
							el.removeClass('loading');
							$('.'+msg).text('{{ trans("home.Product Code Used ") }}');		
						}
					})
		    })
	        $('.append_import').submit(function(e){
					e.preventDefault();
					var  url        =  $(this).attr('action');
					var  input_name = $(this).data('input');
					var  msg = $(this).data('msg');
					var  items  =  $(this).serialize();
					$(this).addClass('loading');
					var  el =  $(this);
					var formData = new FormData(this);
					$.ajax({
						type: 'POST',
						url: url,
						data: formData,
						contentType: false,
						processData: false,
						success: function(data) {
							var html = ''; // Build HTML string outside the loop
							$.each(data, function(index, item) {
								var name = item.name;
								var id = item.id;
                                 console.log(name);
								html += '<tr>';
								html += '<td><input type="hidden" name="product_id[]" value="' + id + '">' + name + '</td>';
								html += '<td><input type="number" class="form-control" min="1" name="quantity[]" value="1"></td>';
								html += '<td><a class="remove_item"> X </a></td></tr>';
							});
							console.log(html);
							$('#products_row').append(html); // Append HTML string in one go

							el.removeClass('loading');
							el[0].reset();
							$('.' + msg).text('{{ trans("home.Done Successfully") }}');
							$('.modal').modal('hide');
						},
						error: function(error) {
							console.error(error);
						}
					});

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