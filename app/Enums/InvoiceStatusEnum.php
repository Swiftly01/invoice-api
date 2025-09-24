<?php

namespace App\Enums;

enum InvoiceStatusEnum: string
{
    case DRAFT = 'draft';
    case ISSUED = 'issued';
    case PAID = 'paid';
    case CANCELLED = 'cancelled';

    public function label(): string{
        return match($this){
            self::DRAFT => 'draft',
            self::ISSUED => 'issued',
            self::PAID => 'paid',
            self::CANCELLED => 'canceled',  
        };
    }

    public static function values(): array{ 
        return  array_column(self::cases(),'value');
    }
}
