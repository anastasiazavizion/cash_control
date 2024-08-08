<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use \Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = ['payment_type_id','payment_currency_id','amount', 'category_id', 'payment_date',
        'description'];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function paymentType(): BelongsTo
    {
        return $this->belongsTo(PaymentType::class);
    }

    public function currency(): BelongsTo
    {
        return $this->belongsTo(PaymentCurrency::class, 'payment_currency_id');
    }

    public function paymentDate() : Attribute
    {
        return Attribute::make(
            set: fn ($value) => date('Y-m-d',strtotime($value))
        );

    }
}
