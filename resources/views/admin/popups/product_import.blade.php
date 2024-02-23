<div class="modal fade" id="product_import_form" tabindex="-1" role="dialog" 
aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="writer_form"> {{ trans('home.Product') }} </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            {{ Form::open(['url'=>'admin/products/import','files'=>true,'enctype'=>'multipart','class'=>'append_import']) }}
                
                        <div class="form_loader ">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                        <div class="msg product_import_msg">
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-12 ">
                                <label for="inputEmail4">{{ trans('home.Supplier') }}</label>
                                {{ Form::select('suplier_id',$items,null,['class'=>'form-control'
                                    ,'placeholder'=>trans('home.Choose Supplier'),'id'=>'suplier_id']) }}
                            </div>
                            <div class="form-group col-md-12 ">
                                <label for="inputEmail4">{{ trans('home.File') }}</label>
                                {{ Form::file('file',['class'=>'form-control','accept'=>".xlsx, .xls, .ods"
                                    ]) }}
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">{{ trans('home.Save') }}</button>
                    {{ Form::token() }}
                </form>
            </div>
        </div>
    </div>
</div>