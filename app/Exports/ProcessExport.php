<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use App\Models\InventoryProcess;

class ProcessExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected  $id;
    public  function __construct($id) {
        $this->id  =  $id;
    }
    public function collection()
    {
        $data  = InventoryProcess::find($this->id);
        $arr =  [
                    [
                        'Code',
                        'Description of Goods',
                        'الاسم بالعربي',
                        'Store',
                        'Old Quantity',
                        'Quantity',
                    ]
               ];
        foreach ($data->items as $key => $item) {
            array_push($arr,[
                $item->product->code,
                $item->product->name_en,
                $item->product->name,
                $item->store->name_en,
                $item->old_amount??0,
                $item->amount
            ]);
        }
        return collect($arr);
    }
}
