<?php
/**
 * Created by PhpStorm.
 * User: jmillerfun
 * Date: 2020/5/30
 * Time: 16:45
 */

namespace App\Exports;
use Maatwebsite\Excel\Concerns\FromArray;

class DataExport implements FromArray
{
    private $arr;
    public function __construct($arr)
    {
        $this->arr = $arr;
    }

    public function array (): array
    {
        return $this->arr;
    }
}