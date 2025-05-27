<?php

namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromCollection;

class OrdersExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Order::all();
    }
    public function headings(): array
    {
        return [
            'ID',
            'Имя',
            'Телефон',
            'Адрес',
            'Комментарий',
            'Сумма',
            'Дата заказа',
        ];
    }
}
