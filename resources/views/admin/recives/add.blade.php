@extends('admin.content.layout')
@section('content')
	<div class="page-header">
        <div class="header-sub-title">
            <nav class="breadcrumb breadcrumb-dash">
                <a href="{{ URL::to('admin') }}" class="breadcrumb-item"><i class="anticon anticon-home
				 m-r-5"></i> {{ trans('home.Home')}} </a>
                <a class="breadcrumb-item" href="{{ URL::to('admin/recives') }}">{{ trans('home.Recives')}} </a>
                <span class="breadcrumb-item active">{{ $title }}</span>
            </nav>
        </div>
    </div>
	<div class="card">
		<div class="card-body">
			{{ Form::open(['url'=>'admin/recives/add',
				'files'=>true,'enctype'=>'multipart','id'=>'signatureForm']) }}
			    
			    <div class="form-row">
					<div class="col-md-12 text-right">
						<a data-toggle="modal" data-target="#product_import_form"
								class=" btn btn-xs btn-primary">{{ trans('home.Xsl') }}</a>
					</div>
                    <div class="form-group col-md-6  list_holder">
			            <label for="inputEmail4">{{ trans('home.Purchase No') }}</label>
			            {{ Form::text('purchase_no',null,['class'=>'form-control'
							,'id'=>'purchase_search']) }}
							<ul class="purchase_list">
							</ul>
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
                    <div class="form-group col-md-6 plus_div">
			            <label for="inputEmail4">{{ trans('home.Supplier') }}</label>
			            {{ Form::select('suplier_id',$supliers,null,['class'=>'form-control','required'
							,'id'=>'suplier_id']) }}
							<a data-toggle="modal" data-target="#supplier_form" class="plus_btn btn bt-xs btn-primary">+</a>	
			        </div>
				    <div class="form-group col-md-6 plus_div">
			            <label for="inputEmail4">{{ trans('home.Store') }}</label>
			            {{ Form::select('store_id',$stores,null,['class'=>'form-control','required'
							,'id'=>'store_id']) }}
							<a data-toggle="modal" data-target="#store_form" class="plus_btn btn bt-xs btn-primary">+</a>	
			        </div>
                    <input type="hidden" name="purchase_id" id="purchase_id">
					<div class="col-md-12">
						<table class="table">
							<thead>
								<tr>
								     <th scope="col">{{ trans('home.Code') }}</th>
									<th scope="col">{{ trans('home.Product') }}</th>
									<th scope="col">{{ trans('home.Amount') }}</th>
									<th scope="col">{{ trans('home.Recived') }}</th>
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
			    <button type="submit" id="finish_button" class="btn btn-primary">{{ trans('home.Save') }}</button>
			{{ Form::token() }}
			{{ Form::close() }}
		</div>
	</div>
	@include('admin.popups.store')
	@include('admin.popups.product_recive')
	@include('admin.popups.supplier')
	@include('admin.popups.product_import')
	@section('scripts')
	   <script>
         
           var  ids =  [];
           
		   function update_amount(id) {
			       var amount  =  0;
				    if (parseInt($('tr[data-id="'+id+'"]').data('amount'))) {
						var  start = parseInt($('tr[data-id="'+id+'"]').data('amount')); 
					}else{
						var  start = 0;
					}
				    
					$('tr[data-id="'+id+'"]').each(function(){
							amount = amount +  parseInt($(this).find('input[name="recived_amount[]"]').val()); 
							
						})
						return start -  amount;
			  
			   
		   }  
		   $('.product_list').on('click', 'li',function() {
			  var  name =  $(this).data('name');
			  var  id   =  $(this).data('id');
			  var  code   =  $(this).data('code');
                ids.push(id);
				var  amount  =  update_amount(id);
                var  text =  '<tr data-id="'+id+'" >';
				text      = text+'<td>'+code+'</td>';
                text      = text+'<td> <input type="hidden" name="product_id[]" value="'+id+'" >'+name+'</td>' ;
                text      = text+'<td><input type="hidden" name="amount[]" value="0"><span class="amount">'+amount+'</span></td>';
                text      = text+'<td><input type="number" class="form-control" min="0" name="recived_amount[]" value="0" ></td>' ;
                text      = text+'<td> <a data-id="'+id+'" class="remove_item"> X </a> </td></tr>' ;
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
							// if (data.count == 1) {
                                    // var  item = products[0];
                                    // var  name =  item.title;
                                    // var  id   =  item.id;
                                    // ids.push(id);
									// var  amount  =  update_amount(id);
                                    // var  text =  '<tr data-id="'+id+'">';
                                    // text      = text+'<td> <input type="hidden" name="product_id[]" value="'+id+'" >'+name+'</td>' ;
                                    // text      = text+'<td><input type="hidden" name="amount[]" value="0"><span class="amount">'+amount+'</span></td>';
                                    // text      = text+'<td><input type="number" class="form-control" min="0" name="recived_amount[]" value="0" ></td>' ;
                                    // text      = text+'<td> <a data-id="'+id+'" class="remove_item"> X </a> </td></tr>' ;
                                    // $('#products_row').append(text);
                                    // $("#product_search").addClass('success');
                                    // setTimeout(() => {
                                    //     $("#product_search").removeClass('success');
                                    // }, 1000);
                                
							// }else{
								$.each(products,function(index,item) {
									$('.product_list').append('<li data-code="'+item.code+'"  data-id="'+item.id+'" data-name="'+item.title+'">'+item.title+'</li>')
								})
							// }
							
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
							   $('.purchase_list').append('<li   data-store_id="'+item.store_id+'" data-suplier_id="'+item.suplier_id+'"  data-id="'+item.id+'" data-name="'+item.no+'">'+item.no+' (-'+item.supplier_name+'-)</li>')
							   items[item.id] = item.purchase_items;
                            })
					   })
			   }
		   })
           $('.purchase_list').on('click', 'li',function() {
                 var  suplier_id =  $(this).data('suplier_id');
                 $('#suplier_id').val(suplier_id);
				 var  store_id =  $(this).data('store_id');
				 if (store_id > 0) {
					$('#store_id').val(store_id);
				 }
                 var  id =  $(this).data('id');
                 $('#purchase_id').val(id);
                 products =  items[id];
                 $('#products_row').html('');
                 $('.purchase_list').html('');
                 $.each(products,function(index,data){
                        var  id =  data.product_id;
                        var  name =  data.title;
                        var  text =  '<tr data-id="'+id+'" data-amount="'+data.amount+'">';
						text      = text+'<td>'+data.code+'</td>';
                        text      = text+'<td> <input type="hidden" name="product_id[]" value="'+id+'" >'+name+'</td>' ;
                        text      = text+'<td><input type="hidden" name="amount[]" value="'+data.amount+'"><span class="amount">'+data.amount+'</span></td>';
                        text      = text+'<td><input type="number" class="form-control" min="0" name="recived_amount[]" value="'+data.recived_amount+'" ></td>' ;
                        text      = text+'<td>  </td></tr>' ;
                        $('#products_row').append(text);
                 })

           });
		   $('#products_row').on('click','.remove_item',function(){
		        var id =  $(this).data('id');
				$(this).parent().parent().remove();
				if (parseInt($('#purchase_id').val()))  {
					var amount = 0;
					$('tr[data-id="'+id+'"]').each(function(index,item){
						var  start = parseInt($('tr[data-id="'+id+'"]').data('amount'));
						var am = start - amount;
						$(this).find('.amount').text(am);
						amount  =  amount + parseInt($(this).closest("tr").find('input[name="recived_amount[]"]').val())
						
					})
				}
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
								html += '<tr>';
								html += '<td>'+item.code+'</td>';
								html += '<td><input type="hidden" name="product_id[]" value="' + id + '">' + name + '</td>';
								html += '<td><input type="hidden" class="form-control" min="0" name="amount[]" value="0"><span>0</span></td>';
								html += '<td><input type="number" class="form-control" min="0" name="recived_amount[]" value="0"></td>';
								html += '<td><a class="remove_item"> X </a></td></tr>';
							});
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
							text      = text+'<td> <a data-id="'+id+'" class="remove_item"> X </a> </td></tr>' ;
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