<!DOCTYPE html>
<?php 
        $lang =  App::getLocale();
        $setting  =  App\Models\Setting::first();
?>
<html lang="{{ $lang }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{ (isset($title))?$title:$setting->title }}</title>

    @include('admin.content.styles')
</head>

<body>
     <section style="color:#fff">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <table class="table" style="
                        border: 1px solid #eee;
                        margin: 30px 0;
                    ">
                        <thead>
                            <tr> 
                                <th scope="col">{{ trans('home.No') }}</th>
                                <th scope="col"> {{ trans('home.Store From') }}</th>
                                <th scope="col"> {{ trans('home.Store To') }}</th>
                                <th scope="col"> {{ trans('home.Amount') }}</th>
                                <th scope="col"> {{ trans('home.Recived Amount') }}</th>
                                <th scope="col"> {{ trans('home.Date') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{ $data->no }}</td>
                                
                                <td>
                                    {{ $data->store->title }}
                                </td>
                                <td>
                                    {{ $data->storeto->title }}
                                </td>
                                <td>
                                    {{ $data->amount }}
                                </td>
                                <td>
                                    {{ $data->recived_amount }}
                                </td>
                                <td>
                                    {{  date('d-m-y',strtotime($data->created_at)) }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <table class="table"  style="
                        border: 1px solid #eee;
                        margin: 30px 0;
                    ">
							<thead>
								<tr>
									<th scope="col">{{ trans('home.Product') }}</th>
									<th scope="col">{{ trans('home.Amount') }}</th>
									<th scope="col">{{ trans('home.Recived') }}</th>
									<td></td>
								</tr>
							</thead>
							<tbody id="products_row">
								@foreach($data->items as $item)
                                <tr>
                                    <td>
                                        {{ $item->product->title }}
                                    </td>
                                    <td>
                                        {{ $item->amount }}
                                    </td>
                                    <td>
                                        {{ $item->recived_amount }}
                                    </td>
                                   
                                </tr>
                                @endforeach
								
							</tbody>
						</table>
                        <div class="row">
                            <div class="col-md-6">
                               <h5>{{ trans('home.By') }} : {{ $data->user->username }}</h5>
                                <img src="{{ $data->signature }}"  width="200px" style="margin:10px auto" class="img-responsive" alt="" srcset="">
                            </div>
                            <div class="col-md-6">
                                @if($data->reciver)
                                  <h5>{{ trans('home.By') }} : {{ $data->reciver?$data->reciver->username:' ' }}</h5>
                                   <img src="{{ $data->signature_to }}"  width="200px" style="margin:10px auto" class="img-responsive" alt="" srcset="">
                                @endif
                            </div>
                        </div>
                        
            </div>
        </div>
     </section>
</body>
</html>