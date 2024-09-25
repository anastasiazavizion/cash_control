<?php

namespace App\Models;

use App\Observers\PaymentObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use \Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

#[ObservedBy([PaymentObserver::class])]
class Payment extends Model
{
    use HasFactory;

    protected $fillable = ['payment_type_id','payment_currency_id','amount', 'category_id', 'payment_date',
        'description', 'user_id'];



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
            set: fn ($value) => Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d'),
        );
    }

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeByPaymentType(Builder $query, int $typeId)
    {
        return $query->where('payment_type_id',$typeId);
    }

}
