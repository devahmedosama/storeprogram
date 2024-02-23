@extends('admin.content.layout')
@section('content')
	<div class="page-header">
        <h2 class="header-title"> All services</h2>
        <div class="header-sub-title">
            <nav class="breadcrumb breadcrumb-dash">
                <a href="{{ URL::to('admin') }}" class="breadcrumb-item"><i class="anticon anticon-home m-r-5"></i> Home</a>

                <a href="{{ URL::to('admin/services') }}" class="breadcrumb-item"> services</a>
               
            </nav>
        </div>
    </div>
	<div class="card">
		<div class="card-body">
			<div class="table-responsive">
			    <table class="table">
			        <thead>
			            <tr>
			                <th scope="col">#</th>
			                <th scope="col"> Name</th>
			                <th scope="col"> E-mail</th>
			                <th scope="col"> phone</th>
			                <th scope="col"> Options</th>
			            </tr>
			        </thead>
			        <tbody>
			        	@foreach($allData as $data)
			            <tr>
			                <td>{{ $data->id }}</td>
			                <td>{{ $data->name }}</td>
			                <td>{{ $data->email }}</td>
			                <td>{{ $data->phone }}</td>
			                
			                <td>
			                	<!-- Button trigger modal -->
								<button type="button" class="btn btn-xs btn-info"
								 data-toggle="modal" data-target="#exampleModaltext{{ $data->id }}">
								   view message
								</button>
								<!-- Modal -->
								<div class="modal fade" id="exampleModaltext{{ $data->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
								  <div class="modal-dialog" role="document">
								    <div class="modal-content">
								      <div class="modal-header">
								        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
								          <span aria-hidden="true">&times;</span>
								        </button>
								      </div>
								      <div class="modal-body">
								        {{ $data->text }}
								      </div>
								      <div class="modal-footer">
								        <button type="button" class="btn btn-secondary" data-dismiss="modal"> Close</button>
								      </div>
								    </div>
								  </div>
								</div>
			                	<!-- Button trigger modal -->
								<button type="button" class="btn btn-xs btn-danger" data-toggle="modal" data-target="#exampleModal{{ $data->id }}">
								   Delete
								</button>
								<!-- Modal -->
								<div class="modal fade" id="exampleModal{{ $data->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
								        <a href="{{ URL::to('admin/contacts/delete/'.$data->id) }}" class="btn btn-danger"> Confirm</a>
								      </div>
								    </div>
								  </div>
								</div>
			                </td>
			            </tr>
			           @endforeach
			           <tr>
			           	<td colspan="3">{{ $allData->links() }}</td>
			           </tr>
			        </tbody>
			    </table>
			</div>
		</div>
	</div>
@stop