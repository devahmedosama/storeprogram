<div class="modal fade" id="sales_man_form" tabindex="-1" role="dialog" 
aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="writer_form"> {{ trans('home.Sales Man') }} </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            
                <form action="{{ URL::to('admin/sales-men/add') }}" data-msg="sales_man_msg" class="append_form " 
                    data-input="sales_man_id">
                        <div class="form_loader ">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                        <div class="msg sales_man_msg">
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="inputEmail4">{{ trans('home.Name') }}</label>
                                    {{ Form::text('name',null,['class'=>'form-control','required']) }}
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="inputEmail4">{{ trans('home.Name in english') }}</label>
                                    {{ Form::text('name_en',null,['class'=>'form-control']) }}
                                </div>
                                
                                <div class="form-group col-md-12">
                                    <label for="inputEmail4">{{ trans('home.Phone') }}</label>
                                    {{ Form::text('phone',null,['class'=>'form-control']) }}
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="inputEmail4">{{ trans('home.Username') }}</label>
                                    {{ Form::text('username',null,['class'=>'form-control','required']) }}
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="inputEmail4">{{ trans('home.Password') }}</label>
                                    {{ Form::password('password',['class'=>'form-control','required']) }}
                                </div>
                            </div>
                    <button type="submit" class="btn btn-primary">{{ trans('home.Save') }}</button>
                    {{ Form::token() }}
                </form>
            </div>
        </div>
    </div>
</div>