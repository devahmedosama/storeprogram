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
    <style>
        
    </style>
</head>

<body>
     <section style="color:#fff">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                   </br>
                    @if($data->purchase)
                    <h3>
                        {{ trans('home.Purchase No') }} : {{ $data->purchase->no }}
                    </h3>
                    @endif
                    <table class="table" style="
                        border: 1px solid #eee;
                        margin: 30px 0;
                    ">
                        <thead>
                            <tr>
                                <th scope="col">{{ trans('home.No') }}</th>
                                <th scope="col"> {{ trans('home.Shop') }}</th>
                                <th scope="col"> {{ trans('home.Store') }}</th>
                                <th scope="col"> {{ trans('home.Quantity') }}</th>
                                <th scope="col"> {{ trans('home.Date') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{ $data->no }}</td>
                                <td>
                                    {{ $data->shop?$data->shop->title:'' }}
                                </td>
                                <td>
                                    {{ $data->store->title }}
                                </td>
                                <td>
                                    {{ $data->amount }}
                                </td>
                               
                                <td>
                                    {{  date('d-m-Y h:i a',strtotime($data->created_at)) }}
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
                                    
                                   
                                </tr>
                                @endforeach
								
							</tbody>
						</table>
                        <h5>{{ trans('home.By') }} : {{ $data->user->username }}</h5>
                        <img src="{{ $data->signature }}"  width="200px" style="margin:10px auto" class="img-responsive" alt="" srcset="">
                </div>
            </div>
        </div>
     </section>
</body>
</html>