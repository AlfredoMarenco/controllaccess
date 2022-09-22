<?php

namespace App\Imports;

use App\Models\Admin\Code;
use Maatwebsite\Excel\Concerns\ToModel;

class CodesImport implements ToModel
{

    public $code_function;

    public function __construct($code_function){
        $this->code_function = $code_function;
    }
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Code([
            'barcode' => $row[0],
            'name' => $row[1],
            'section' => $row[2],
            'price_category' => $row[3],
            'row' => $row[4],
            'seat' => $row[5],
            'amount' => $row[6],
            'order' => $row[7],
            'sales_channel' => $row[8],
            'ext' => $row[9],
            'code_function' => $this->code_function
        ]);
    }


    public function chunkSize(): int
    {
        return 1000;
    }
}
