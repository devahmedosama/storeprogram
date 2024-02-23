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
                                <th scope="col"> {{ trans('home.By') }}</th>
                                <th scope="col"> {{ trans('home.Product') }}</th>
                                <th scope="col"> {{ trans('home.Store') }}</th>
                                <th scope="col"> {{ trans('home.Old Quantity') }}</th>
                                <th scope="col"> {{ trans('home.Quantity') }}</th>
                                <th scope="col"> {{ trans('home.Date') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{ $data->user->username }}</td>
                                <td>{{ $data->product->title }}</td>
                                <td>
                                    {{ $data->store->title }}
                                </td>
                                <td>
                                    {{ $data->old_amount }}
                                </td>
                                <td>
                                    {{ $data->amount }}
                                </td>
                                <td>
                                    {{  date('d-m-y',strtotime($data->created_at)) }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
     </section>
</body>
</html>