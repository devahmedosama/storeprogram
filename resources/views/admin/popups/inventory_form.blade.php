<div class="modal fade" id="inventory_form" tabindex="-1" role="dialog" 
aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="writer_form"> {{ trans('home.Finish Inventory') }} </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            {{ Form::open(['url'=>'admin/finish-process','files'=>true,'enctype'=>'multipart'
                ,'class'=>'append_import','data-msg'=>"inventory_msg",'id'=>'signatureForm']) }}
                
                        <div class="form_loader ">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                        <div class="msg inventory_msg">
                        </div>
                        <div class="form-row">
                            <div class="col-md-12">
                                    <a class="button-text" id="clear_button">{{ trans('home.Clear') }}</a>
                                    <canvas id="signature_pad" height="150"></canvas>
                                    <input type="hidden" name="image"  required id="signature_image" required>
                            </div>
                        </div>
                        <button type="submit" id="finish_button"  class="btn btn-primary">{{ trans('home.Save') }}</button>
                    {{ Form::token() }}
                </form>
            </div>
        </div>
    </div>
</div>
