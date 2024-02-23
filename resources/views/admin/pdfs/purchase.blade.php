<html>
    <head>
        <title>Order No {{ $data->no }}</title>
        <style>
            table{
                width:100%
            }
            .products_table{
                margin:50px 0;
                border:1px solid #eee;

            }
            .products_table th{
                color:#fff;
                background-color: #b1cfdb;
                text-align:left;
            }
            .products_table td, .products_table th{
                padding:5px ;
                border:1px solid #eee;
            }
        </style>
    </head>
    <body>
        <section>
            <div class="container">
                <table>
                    <tbody>
                        <tr>
                            <td style="text-align:center;background-color:#b1cfdb">
                               <img  src="{{ URL::to($setting->logo) }}" style="height:100px;margin:5px auto" alt="">
                            </td>
                        </tr>
                    </tbody>
                </table>
                <table class="products_table">
                    <thead>
                        <tr>
                            <th>
                                Product Code 
                            </th>
                            <th>
                                Product Name
                            </th>
                            <th>
                                Quantity
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data->items as $item)
                        <tr>
                            <td>
                                {{ $item->product->code  }}
                            </td>
                            <td>
                                {{ $item->product->name_en}}
                            </td>
                            <td>
                                {{ $item->amount }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>
    </body>
</html>