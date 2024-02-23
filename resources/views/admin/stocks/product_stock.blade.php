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
                  </br>
                    <h3>
                        {{ $data->title }}
                    </h3>
                    <table class="table"  style="
                        border: 1px solid #eee;
                        margin: 30px 0;
                    ">
							<thead>
								<tr>
									<th scope="col">{{ trans('home.Store') }}</th>
									<th scope="col">{{ trans('home.Amount') }}</th>
								</tr>
							</thead>
							<tbody id="products_row">
								@foreach($allData as $item)
                                <tr>
                                    <td>
                                        {{ $item->store->title }}
                                    </td>
                                    <td>
                                        {{ $item->amount }}
                                    </td>
                                    
                                </tr>
                                @endforeach
								
							</tbody>
						</table>
                        
            </div>
        </div>
     </section>
</body>
</html>