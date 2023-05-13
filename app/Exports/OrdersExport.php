<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class OrdersExport implements FromCollection,ShouldAutoSize
{
    private $columnas;

    public function __construct($columnas)
    {
        $this->columnas = $columnas;
    }
    public function collection()
    {
        return collect([$this->columnas]);
    }


}
