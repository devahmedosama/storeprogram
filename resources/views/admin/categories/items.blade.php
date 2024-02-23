<div class="table-responsive">
	<button type="button" class="btn btn-primary pull-right" 
	data-toggle="modal" 
    data-target="#exampleModalreviewadd">
	    Add Item 
	</button>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col"> Name</th>
                <th scope="col"> Options</th>
            </tr>
        </thead>
        <tbody>
        	@foreach($data->items as $key=>$item)
            <tr>
                <td>{{ $key+1 }}</td>
                <td>{{ $item->name }}</td>
               <td>
                	<button type="button" class="btn btn-xs btn-primary" 
                	data-toggle="modal" data-target="#exampleModaleditreviewe{{ $item->id }}">
					   Edit
					</button>
					<!-- Modal -->
					<div class="modal fade" id="exampleModaleditreviewe{{ $item->id }}" 
						tabindex="-1" role="dialog" 
					    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
						<div class="modal-dialog modal-dialog-centered" role="document">
							<div class="modal-content">
								<div class="modal-header">
									<h5 class="modal-title" id="exampleModalLongTitle">Page Item </h5>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
									</button>
								</div>
								<div class="modal-body">
								{{ Form::open(['url'=>'admin/projects/edit/'.$item->id,'files'=>true,'enctype'=>'multipart']) }}
									<div class="form-row">
										<div class="form-group col-md-12">
											<label for="inputEmail4">Name</label>
											{{ Form::text('name',$item->name,['class'=>'form-control','required'
												]) }}
										</div>
										<div class="form-row">
												<label for="inputEmail4">Link </label>
												{{ Form::url('url',$item->url,['class'=>
												'form-control'
													]) }}
										</div>
										<div class="form-group col-md-8">
								            <label for="inputEmail4">Image</label>
								            {{ Form::file('image',['class'=>'form-control']) }}
								        </div>
										<div class="form-group col-md-4">
											<img src="{{ URL::to($item->image) }}" class="img-thumbnail"	>
										</div>
									</div>
									
									<div class="form-row">
										<div class="form-group col-md-12">
											<label for="inputEmail4">Text</label>
											{{ Form::textarea('text',$item->text,['class'=>'form-control'
												,'rows'=>5]) }}
										</div>
									</div>
									<button type="submit" class="btn btn-primary">Save</button>
								{{ Form::token() }}
								{{ Form::close() }}
								</div>
							</div>
						</div>
					</div>
                	<!-- Button trigger modal -->
					<button type="button" class="btn btn-xs btn-danger" 
					data-toggle="modal" data-target="#exampleModal{{ $item->id }}">
					   Delete
					</button>

					<!-- Modal -->
					<div class="modal fade" id="exampleModal{{ $item->id }}" 
						tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
					  <div class="modal-dialog" role="document">
					    <div class="modal-content">
					      <div class="modal-header">
					        <h5 class="modal-title" id="exampleModalLabel"> Alert</h5>
					        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
					          <span aria-hidden="true">&times;</span>
					        </button>
					      </div>
					      <div class="modal-body">
					         Are You Sure You Want to Delete This ?
					      </div>
					      <div class="modal-footer">
					        <button type="button" class="btn btn-secondary" data-dismiss="modal"> Close</button>
					        <a href="{{ URL::to('admin/projects/delete/'.$item->id) }}" class="btn btn-danger"> Confirm</a>
					      </div>
					    </div>
					  </div>
					</div>
                </td>
            </tr>
           @endforeach
         
        </tbody>
    </table>
    <!-- Modal -->
	<div class="modal fade" id="exampleModalreviewadd" tabindex="-1" role="dialog" 
	    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLongTitle">Add Item </h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
				{{ Form::open(['url'=>'admin/projects/add/'.$data->id,'files'=>true,'enctype'=>'multipart']) }}
					<div class="form-row">
						<div class="form-group col-md-12">
							<label for="inputEmail4">Name</label>
							{{ Form::text('name',null,['class'=>'form-control','required'
								]) }}
						</div>
					</div>
					<div class="form-row">
						<div class="form-group col-md-12">
							<label for="inputEmail4">Link</label>
							{{ Form::url('url',null,['class'=>'form-control'

								]) }}
						</div>
					</div>
					
					<div class="form-row">
						<div class="form-group col-md-12">
							<label for="inputEmail4">Image</label>
							{{ Form::file('image',['class'=>'form-control'
								]) }}
						</div>
					</div>
					<div class="form-row">
						<div class="form-group col-md-12">
							<label for="inputEmail4">Text</label>
							{{ Form::textarea('text',null,['class'=>'form-control'
								,'rows'=>5]) }}
						</div>
					</div>
					<button type="submit" class="btn btn-primary">Save</button>
				{{ Form::token() }}
				{{ Form::close() }}
				</div>
			</div>
		</div>
	</div>
</div>