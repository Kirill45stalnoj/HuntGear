<?php

namespace App\Exports;

use App\Models\Review;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ReviewsExport implements FromCollection, WithHeadings, WithMapping
{
    /**
     * Получаем коллекцию данных для экспорта
     */
    public function collection()
    {
        return Review::with('user', 'product')->get();
    }

    /**
     * Заголовки колонок
     */
    public function headings(): array
    {
        return [
            'ID',
            'Продукт',
            'Описание продукта',
            'Пользователь',
            'Оценка',
            'Комментарий',
            'Дата создания',
        ];
    }

    /**
     * Форматируем данные перед экспортом
     */
    public function map($review): array
    {
        return [
            $review->id,
            $review->product->name,
            $review->product->description,
            $review->user->name,
            $review->rating,
            $review->review,
            $review->created_at->format('Y-m-d H:i:s'),
        ];
    }
}

