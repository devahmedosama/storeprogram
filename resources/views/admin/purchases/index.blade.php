@extends('admin.content.layout')
@section('content')
	<div class="page-header">
        <h2 class="header-title"> {{ trans('home.Purchases') }} </h2>
        <div class="header-sub-title">
            <nav class="breadcrumb breadcrumb-dash">
                <a href="{{ URL::to('admin') }}" class="breadcrumb-item">
					<i class="anticon anticon-home m-r-5"></i>{{ trans('home.Home') }} </a>

                <a href="{{ URL::to('admin/purchases') }}" class="breadcrumb-item">{{ trans('home.Purchases') }} </a>
               
            </nav>
        </div>
    </div>
	<div class="card">
		<div class="card-body">
			<div class="table-responsive">
				@if(auth()->user()->type == 0)
					<a href="{{ URL::to('admin/purchases/add') }}" class="btn-xs btn btn-primary pull-right">
						{{ trans('home.Add New') }}</a>
				@endif
			    <table class="table">
			        <thead>
			            <tr>
			                <th scope="col">{{ trans('home.No') }}</th>
			                <th scope="col"> {{ trans('home.Supplier') }}</th>
			                <th scope="col"> {{ trans('home.Amount') }}</th>
			                <th scope="col"> {{ trans('home.Recived Amount') }}</th>
			                <th scope="col"> {{ trans('home.Status') }}</th>
			                <th scope="col"> {{ trans('home.Options') }}</th>
			            </tr>
			        </thead>
			        <tbody>
			        	@foreach($allData as $data)
						<?php
						   $amount          = $data->recive?$data->recive->items()->sum('amount'):0;
						   $recived_amount  = $data->recive?$data->recive->items()->sum('recived_amount'):0;
						 ?>
			            <tr>
			                <td>{{ $data->no }}</td>
			                <td>{{ $data->supplier?$data->supplier->title:' ' }}</td>
							<td>
								{{ $data->items()->sum('amount') }}
							</td>
							<td>
							{{ $data->recive?$data->recive->items()->sum('recived_amount'):0 }}
							</td>
			                <td>
							   @if($recived_amount == 0)
							        {{ trans('home.Not Recived') }}
							   @elseif($amount <= $recived_amount)
							        {{ trans('home.Recived') }}
								@else
								    {{ trans('home.Partial Recived') }}
							    @endif
							
							</td>
			                <td>
								<a href="{{ URL::to('admin/view-pdf/'.$data->id) }}" 
								class="btn btn-xs btn-success" target="_blank">
									<i class="anticon anticon-eye"></i>
								</a>
			                	<a href="{{ URL::to('admin/purchases/recive/'.$data->id) }}" 
								class="btn btn-primary btn-xs"> {{  trans('home.Recive & update') }}</a>
			                	@if(empty($data->recive) && auth()->user()->type == 0)
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
								        <a href="{{ URL::to('admin/purchases/delete/'.$data->id) }}" class="btn btn-danger"> Confirm</a>
								      </div>
								    </div>
								  </div>
								</div>
								@endif
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