<div class="modal fade" id="store_form" tabindex="-1" role="dialog" 
aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="writer_form"> {{ trans('home.Store') }} </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            
                <form action="{{ URL::to('admin/stores/add') }}" data-msg="store_msg" class="append_form " 
                    data-input="store_id">
                        <div class="form_loader ">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                        <div class="msg store_msg">
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
                            </div>
                    <button type="submit" class="btn btn-primary">{{ trans('home.Save') }}</button>
                    {{ Form::token() }}
                </form>
            </div>
        </div>
    </div>
</div>