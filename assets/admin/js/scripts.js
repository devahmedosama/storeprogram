if ($('.js-example-basic-single').length) {
	$('.js-example-basic-single').select2();
}
if ($('.basic-select').length) {
	$('.basic-select').select2();
}
$('.ajax_form').submit(function(e){
	e.preventDefault();
	var  url  =  $(this).attr('action');
	var el =  $(this);
	el.addClass('form_loader');
	 var formData = new FormData(this);

	 $.ajax({
        url: url,
        type: 'POST',
        data: formData,
        success: function (data) {
            if (data.state == 1) {
					   	 el.children('.alert_msg').html('');
					  	 successClick(data.msg);
					  	 $('.modal').modal('hide');

					  	 if (el.hasClass('add_form')) {
					  	 	el[0].reset();
					  	 }
					  	 if (data.order_cart) {
					  	 	$('#cart_count').html(data.order_cart);
					  	 }
					  	 if (el.hasClass('add_stock')) {
					  	 	$('.'+data.name).html(data.count+' Item');
					  	 }
					  	 if (el.hasClass('edit_stock')) {
					  	 	setTimeout(function(){
					  	 		location.reload();
					  	 	},3000)
					  	 	
					  	 }
					  	 if (el.hasClass('finish_order')) {
					  	 	setTimeout(function(){
					  	 		window.location = base_url+'/admin/invoices';
					  	 	},1000)
					  	 }
					  	 if (el.hasClass('finish_order_keeper')) {
					  	 	setTimeout(function(){
					  	 		window.location = base_url+'/keepers/dashboard/invoices';
					  	 	},1000)
					  	 }
					   }else{
					   	 el.children('.alert_msg').html('<h3>'+data.msg+'</h3>');
					   }
	           el.removeClass('form_loader');
        },
        cache: false,
        contentType: false,
        processData: false
    });
	
});
$('.add_batch').click(function(){
	var el =  $(this);
	var  id =  el.data('id');
	el.attr("disabled", true);
	el.addClass('btn_loader');
	$.get(base_url+'/admin/add/batch/product/'+id,function(data){
      el.attr("disabled", false);
      successClick(data.msg);
	    el.removeClass('btn_loader');
	    if (data.state == 1) {
	    	el.addClass('in_batch');
	    }else{
	    	el.removeClass('in_batch');
	    }
	    $('#batch_cart_count').html(data.count);
	});
});
$('.add_normal').click(function(){
	var el =  $(this);
	var  id =  el.data('id');
	el.attr("disabled", true);
	el.addClass('btn_loader');
	$.get(base_url+'/admin/add/normal/product/'+id,function(data){
      el.attr("disabled", false);
      successClick(data.msg);
	    el.removeClass('btn_loader');
	    if (data.state == 1) {
	    	el.addClass('in_normal');
	    }else{
	    	el.removeClass('in_normal');
	    }
	    $('#normal_cart_count').html(data.count);
	});
});
$('.change_supplier').change(function(){
	var supplier_id =  $(this).val();
	$('.supplier_price').each(function(){
				var product_id = $(this).data('id');
				var el =  $(this);
				el.parent().addClass('btn_loader');
				$.get(base_url+'/admin/supplier/price',{supplier_id:supplier_id,product_id:product_id},function(data){
						el.val(data);
						change_amount(el)
				    el.parent().removeClass('btn_loader');
				})
	});
	
}); 
$('.change_client').change(function(){
	var client_id =  $(this).val();
	$('.client_price').each(function(){
				var product_id = $(this).data('id');   
				var el =  $(this);
				el.parent().addClass('btn_loader');
				$.get(base_url+'/admin/client/price',{client_id:client_id,product_id:product_id},function(data){
						if(data){
							el.val(data);
						    invoice_change(el);
						}
						
				    el.parent().removeClass('btn_loader');
				})
	});
	
})
$('.accept_items').submit(function(e){
	  e.preventDefault();
	  var url =  e.attr('action');
	  $.post(url,$(this).serialize(),function(data){
	   if (data.state == 1) {
	   	$('.modal').modal('hide');
	   	 el.children('.alert_msg').html('');
	  	 successClick(data.msg);
	  	 
	  	 $('.accept_btn[data-id="item_'+data.id+'"]').addClass('already_accepted');
	   }else{
	   	 el.children('.alert_msg').html('<h3>'+data.msg+'</h3>');
	   }
	   el.removeClass('form_loader');
	});
})
$('.add_invoice').click(function(){
	$(this).addClass('in_cart');
})
var successClick = function(msg){
    $.notify({

      // options

      title: '<strong></strong>',

      message: "<br>"+msg,

        icon: 'glyphicon glyphicon-ok',
    },{

      // settings

      element: 'body',

      //position: null,

      type: "success",

      //allow_dismiss: true,

      //newest_on_top: false,

      showProgressbar: false,

      placement: {

        from: "top",

        align: "left"

      },

      offset: 150,

      spacing: 10,

      z_index: 1031,

      delay: 3000,

      timer: 1000,

      url_target: '_blank',

      mouse_over: null,

      animate: {

        enter: 'animated fadeInDown',

        exit: 'animated fadeOutRight'

      },

      onShow: null,

      onShown: null,

      onClose: null,

      onClosed: null,

      icon_type: 'class',
    });
} 
if ($('.alert-success').length) {
		setTimeout(function(){
				$('.alert-success').hide();
		},3000);
}
$('.note_click').click(function(){
	var id =  $(this).data('id');
	$.get(base_url+'/drivers/dashboard/noteview/'+id,function(data){
		$('#notifications_count').html(data);
	})
});
$('.admin_note_click').click(function(){
	var id =  $(this).data('id');
	$.get(base_url+'/admin/noteview/'+id,function(data){
		$('#notifications_count').html(data);
	})
});
$('.keeper_note_click').click(function(){
	var id =  $(this).data('id');
	$.get(base_url+'/keepers/dashboard/noteview/'+id,function(data){
		$('#notifications_count').html(data);
	})
});
$('.close_item').click(function(){
	$(this).parent().remove();
	console.log(22);
});
$('.add_grv').click(function(){
	var text  =  '<div class="row grv_item"> <a class="close_item">X</a>';
	text+='<div class="col-md-4"><select name="stock_product_id[]" class="form-control">';
	$.each(grv, function( index, value ) {
       text+='<option value="'+index+'">'+value+'</option>';
  });
	text+='</select></div>';
	text+='<div class="col-md-4"><input type="number" name="quantity[]" value="1" min="1" class="form-control"></div>'
	text+='<div class="col-md-4"><select name="type[]" class="form-control">\
			<option value="0">Damage</option>\
			<option value="1">expired or near to expired</option>\
			<option value="2">normal</option>\
			<option value="3">grv by client</option>\
	</select></div>';
	$('#grv_items').append(text);
	$('.close_item').click(function(){
		$(this).parent().remove();
	});
})
if ($('#data-table').length) {
	$('#data-table').DataTable();
}
$('.driver_cart').click(function(){
	var el =  $(this);
	var  id =  el.data('id');
	el.attr("disabled", true);
	el.addClass('btn_loader');
	$.get(base_url+'/drivers/dashboard/add/cart/'+id,function(data){
      el.attr("disabled", false);
      successClick(data.msg);
	    el.removeClass('btn_loader');
	    if (data.state == 1) {
	    	el.addClass('in_cart');
	    }else{
	    	el.removeClass('in_cart');
	    }
	    $('#driver_cart_count').html(data.count);
	});
})
$('.custom-map-control-button').click(function(e){
			e.preventDefault();
});
function invoice_change (el) {
	var quantity =  el.parent().parent().find('.invoice_item_quantity').val();
	var price    =  el.parent().parent().find('.invoice_item_price').val();
	var  vat     =  el.parent().parent().find('.item_vat').data('id');
	var amount   =  (quantity*price) + (quantity*price*(vat/100));
	el.parent().parent().find('.total_amount').html(amount);
	invoice_price();
}
$('.item_per_package, .unit_price, .package_no').change(function(){
	var el =  $(this);
	change_amount(el);
});
$('.invoice_item_quantity, .invoice_item_price').change(function(){
	var el =  $(this);
	invoice_change(el);

});
function invoice_price() {
		var total = 0;
		var vat   = 0;
		$('.invoice_row').each(function(){
			var par  =  $(this);
			var quantity =  par.find('.invoice_item_quantity').val();
			var price    =  par.find('.invoice_item_price').val();
			var  vat_perecentage     =  par.find('.item_vat').data('id');

			total += quantity*price;
			console.log(total);
			vat   += (quantity*price*(vat_perecentage/100));
		})
		$('#final_amount').html(total);
		$('#final_vat').html(vat);
		var final = total+vat;
		$('#final_price').html(final);
}
function change_amount(el) {
			var unit_price			 =   el.parent().parent().find('.unit_price').val();
		  var package_no			 =   el.parent().parent().find('.package_no').val();
		  var item_per_package =  el.parent().parent().find('.item_per_package').val();
		  var amount_price     = unit_price*(package_no*item_per_package);
		  var  total_quantity  = package_no*item_per_package;
		  el.parent().parent().find('.total_amount').html(amount_price);
		  el.parent().parent().find('.total_quantity').html(total_quantity);
}
$('.item_quantity, .item_price').change(function(){
			var el =  $(this);
			var unit_price			 =   el.parent().parent().find('.item_price').val();
		  var item_quantity		 =   el.parent().parent().find('.item_quantity').val();
		  var amount_price     = unit_price*item_quantity;
		  el.parent().parent().find('.total_amount').html(amount_price);
});