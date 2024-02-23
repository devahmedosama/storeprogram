@extends('admin.content.layout')

@section('content')

<div class="page-header">

    <h2 class="header-title">User Statistics </h2>

    <div class="header-sub-title">

        <nav class="breadcrumb breadcrumb-dash">

            <a href="{{ URL::to('admin') }}" class="breadcrumb-item"><i class="anticon anticon-home m-r-5"></i>{{ trans('home.Home') }}</a>

            <a href="{{ URL::to('admin/users?type=2') }}" class="breadcrumb-item"><i class="anticon anticon-user m-r-5"></i>{{ trans('home.Services Providers') }}</a>

            <span class="breadcrumb-item active">{{ $data->name }}</span>

        </nav>

    </div>

</div>

<div class="main-content">

	<div class="row">

    	<div class="col-md-12">

    		<div class="card">

                <div class="card-body">

                    <div class="row align-items-center">

                        <div class="col-md-7">

                            <div class="d-md-flex align-items-center">

                                <div class="text-center text-sm-left ">

                                    <div class="avatar avatar-image" style="width: 150px; height:150px">

                                        <img src="{{ URL::to($data->image) }}" alt="">

                                    </div>

                                </div>

                                <div class="text-center text-sm-left m-v-15 p-l-30">

                                    <h2 class="m-b-5">{{ $data->name }}</h2>

                                    <p class="text-dark m-b-20">{{ $data->service_name}}</p>

                                </div>

                            </div>

                        </div>

                        <div class="col-md-5">

                            <div class="row">

                                <div class="d-md-block d-none border-left col-1"></div>

                                <div class="col">

                                    <ul class="list-unstyled m-t-10">

                                        <li class="row">

                                            <p class="col-sm-4 col-4 font-weight-semibold text-dark m-b-5">

                                                <i class="m-r-10 text-primary anticon anticon-mail"></i>

                                                <span>Email: </span> 

                                            </p>

                                            <p class="col font-weight-semibold"> {{  $data->email }}</p>

                                        </li>

                                        <li class="row">

                                            <p class="col-sm-4 col-4 font-weight-semibold text-dark m-b-5">

                                                <i class="m-r-10 text-primary anticon anticon-phone"></i>

                                                <span>Phone: </span> 

                                            </p>

                                            <p class="col font-weight-semibold"> {{ $data->phone }}</p>

                                        </li>

                                        <li class="row">

                                            <p class="col-sm-4 col-5 font-weight-semibold text-dark m-b-5">

                                                <i class="m-r-10 text-primary anticon anticon-compass"></i>

                                                <span>Location: </span> 

                                            </p>

                                            <p class="col font-weight-semibold"> {{ ($data->country)?$data->country->name.'-':' ' }} {{ ($data->city)?$data->city->name.'-':' ' }} {{ $data->address }}</p>

                                        </li>

                                    </ul>

                                    <div class="d-flex font-size-22 m-t-15">

                                        <a href="{{ $data->facebook }}" target="_blank" class="text-gray p-r-20">

                                            <i class="anticon anticon-facebook"></i>

                                        </a>        

                                        <a href="{{ $data->twitter }}" target="_blank" class="text-gray p-r-20">    

                                            <i class="anticon anticon-twitter"></i>

                                        </a>

                                        <a href="{{ $data->youtube }}" target="_blank" class="text-gray p-r-20">

                                            <i class="anticon anticon-youtube"></i>

                                        </a> 

                                        <a href="{{ $data->instagram }}" target="_blank" class="text-gray p-r-20">   

                                            <i class="anticon anticon-instagram"></i>

                                        </a>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

            <div class="card">

                <div class="card-body">

                    <h5>Documents </h5>

                    <div class="m-t-20">

                        <ul class="documents_list">

                        	<li class="list-group-item p-h-0">

                                <img src="{{ URL::to($data->image) }}" class="img-responsive">

                            </li>

                        	@foreach($data->documents as $document)

                            <li class="list-group-item p-h-0">

                                <img src="{{ URL::to($document) }}" class="img-responsive">

                            </li>

                            @endforeach

                        </ul> 

                    </div>  

                </div>

            </div>

    	</div>

        <div class="col-md-6">

            <div class="card">

                <div class="card-body">

                    <h5>About </h5>

                    <div class="m-t-20">

                        <ul class="list-group list-group-flush">

                            <li class="list-group-item p-h-0">

                                <span>{!! $data->about !!}</span>

                            </li>

                        </ul> 

                    </div>  

                </div>

            </div>

        </div>

        <div class="col-md-6">

            <div class="card">

                <div class="card-body">

                    <h5>Description </h5>

                    <div class="m-t-20">

                        <ul class="list-group list-group-flush">

                            <li class="list-group-item p-h-0">

                                <span>{!! $data->description !!}</span>

                            </li>

                        </ul> 

                    </div>  

                </div>

            </div>

        </div>

    </div>

    <div class="row">

        <div class="col-md-12">

            <div class="card">

                <div class="card-body">

                    <h5>Reviews ({{ $data->rates_count }})</h5>

                    <div class="m-t-20">

                        <ul class="li st-group list-group-flush">

                            @foreach($data->rates as $key=>$rate)

                            <li class="list-group-item p-h-0" style="width: 50%;float: left;">

                                <a class="delete_item" data-id="{{ $rate->id }}">X</a>

                                <div class="media m-b-15">

                                    <div class="avatar avatar-image">

                                        <img src="{{ URL::to($rate->image) }}" alt="">

                                    </div>

                                    <div class="media-body m-l-20">

                                        <h6 class="m-b-0">

                                            <a href="" class="text-dark">{{  $rate->name }}</a>

                                        </h6>

                                        <span class="font-size-13 text-gray">{{ date('M , d , Y',strtotime($rate->created_at)) }}</span>

                                    </div>

                                </div>

                                <span>{{ $rate->text }}</span>

                                <div class="star-rating m-t-15">

                                    <input type="radio" id="star{{ $rate->id }}-5" name="rating-{{ $rate->id }}" value="5" {{ ($rate->rate == 5)?'checked':'' }} disabled/><label for="star{{ $rate->id }}-5" title="5 star"></label>

                                    <input type="radio" id="star{{ $rate->id }}-4" name="rating-{{ $rate->id }}" value="4" {{ ($rate->rate == 4)?'checked':'' }}  disabled/>

                                    <label for="star1-4" title="4 star"></label>

                                    <input type="radio" id="star{{ $rate->id }}-3" name="rating-{{ $rate->id }}" value="3" {{ ($rate->rate == 3)?'checked':'' }}  disabled/><label for="star{{ $rate->id }}-3" title="3 star"></label>

                                    <input type="radio" id="star{{ $rate->id }}-2" name="rating-{{ $rate->id }}" value="2" {{ ($rate->rate == 2)?'checked':'' }}  disabled/><label for="star{{ $rate->id }}-2" title="2 star"></label>

                                    <input type="radio" id="star{{ $rate->id }}-1" name="rating-{{ $rate->id }}" value="1" {{ ($rate->rate == 1)?'checked':'' }}  disabled/><label for="star{{ $rate->id }}-1" title="1 star"></label>

                                </div>

                            </li>

                            @endforeach

                        </ul> 

                    </div>  

                </div>

            </div>

        </div>

    </div>

    <div class="row"> 

    	<div class="col-md-6 col-lg-3">

            <div class="card">

                <div class="card-body">

                    <div class="media align-items-center">

                        <div class="avatar avatar-icon avatar-lg avatar-blue">

                            <i class="anticon anticon-mail"></i>

                        </div>

                        <div class="m-l-15">

                            <h2 class="m-b-0">{{ $data->contacts_count }}</h2>

                            <p class="m-b-0 text-muted">Total Contacts</p>

                        </div>

                    </div>

                </div> 

            </div>

        </div>

        <div class="col-md-6 col-lg-3">

            <div class="card">

                <div class="card-body">

                    <div class="media align-items-center">

                        <div class="avatar avatar-icon avatar-lg avatar-blue">

                            <i class="anticon anticon-message"></i>

                        </div>

                        <div class="m-l-15">

                            <h2 class="m-b-0">{{ $contact_no_6 }}</h2>

                            <p class="m-b-0 text-muted">Open Contacts</p>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <div class="col-md-6 col-lg-3">

            <div class="card">

                <div class="card-body">

                    <div class="media align-items-center">

                        <div class="avatar avatar-icon avatar-lg avatar-cyan">

                            <i class="anticon anticon-phone"></i>

                        </div>

                        <div class="m-l-15">

                            <h2 class="m-b-0">{{ $contact_no }}</h2>

                            <p class="m-b-0 text-muted">phone </p>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <div class="col-md-6 col-lg-3">

            <div class="card">

                <div class="card-body">

                    <div class="media align-items-center">

                        <div class="avatar avatar-icon avatar-lg avatar-gold">

                            <i class="anticon anticon-mail"></i>

                        </div>

                        <div class="m-l-15">

                            <h2 class="m-b-0">{{ $contact_no_1 }}</h2>

                            <p class="m-b-0 text-muted">E-mail</p>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <div class="row">

        <div class="col-md-6 col-lg-3">

            <div class="card">

                <div class="card-body">

                    <div class="media align-items-center">

                        <div class="avatar avatar-icon avatar-lg avatar-blue">

                            <i class="anticon anticon-facebook"></i>

                        </div>

                        <div class="m-l-15">

                            <h2 class="m-b-0">{{ $contact_no_3 }}</h2>

                            <p class="m-b-0 text-muted">Facebook</p>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <div class="col-md-6 col-lg-3">

            <div class="card">

                <div class="card-body">

                    <div class="media align-items-center">

                        <div class="avatar avatar-icon avatar-lg avatar-cyan">

                            <i class="anticon anticon-instagram"></i>

                        </div>

                        <div class="m-l-15">

                            <h2 class="m-b-0">{{ $contact_no_4 }}</h2>

                            <p class="m-b-0 text-muted">Instagram  </p>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <div class="col-md-6 col-lg-3">

            <div class="card">

                <div class="card-body">

                    <div class="media align-items-center">

                        <div class="avatar avatar-icon avatar-lg avatar-gold">

                            <i class="anticon anticon-youtube"></i>

                        </div>

                        <div class="m-l-15">

                            <h2 class="m-b-0">{{ $contact_no_5 }}</h2>

                            <p class="m-b-0 text-muted">Youtube</p>

                        </div>

                    </div>

                </div>

            </div>

        </div>

       <div class="col-md-6 col-lg-3">

            <div class="card">

                <div class="card-body">

                    <div class="media align-items-center">

                        <div class="avatar avatar-icon avatar-lg avatar-purple">

                            <i class="anticon anticon-twitter"></i>

                        </div>

                        <div class="m-l-15">

                            <h2 class="m-b-0">{{ $contact_no_2 }}</h2>

                            <p class="m-b-0 text-muted">Twitter </p>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <div class="col-md-12 col-lg-12">

	        <div class="card">

	            <div class="card-body">

	                <div class="d-flex justify-content-between align-items-center">

	                    <h5>Contacts Chart</h5>

	                </div>

	                <div class="m-t-50" style="height: 330px">

	                    <canvas class="chart" id="revenue-chart"></canvas>

	                </div>

	            </div>

	        </div>

	    </div>
    </div>
</div>
<script type="text/javascript">

   var days = [

           @foreach($days as $day)

                  '{{ $day }}',

           @endforeach

   ];

   var values = [

           @foreach($registers as $day)

                  '{{ $day }}',

           @endforeach

   ];

</script>

@stop