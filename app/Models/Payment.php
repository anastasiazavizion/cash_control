<?php

namespace App\Models;

use App\Observers\PaymentObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use \Illuminate\Database\Eloquent\Relations\BelongsTo;

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

    public function paymentDate() : Attribute
    {
        return Attribute::make(
            set: fn ($value) => (new \DateTime($value))->format('Y-m-d')
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

    public function scopeByCategories(Builder $query, array $categories)
    {
        return $query->whereHas('category',function (Builder $query) use ($categories){
            $query->whereIn('id',$categories);
        });
    }

    public function scopeFilter(Builder $query, array $filters)
    {
        return $query->when(isset($filters['payment_type_id']), function ($query) use ($filters) {
            $query->byPaymentType($filters['payment_type_id']);
        })
            ->when(isset($filters['categories']), function ($query) use ($filters) {
                $query->byCategories($filters['categories']);
            })
            ->when(isset($filters['date_from']), function ($query) use ($filters) {
                return $query->where('payment_date', '>=', $filters['date_from']);
            })
            ->when(isset($filters['date_to']), function ($query) use ($filters) {
                return $query->where('payment_date', '<=', $filters['date_to']);
            });
    }

}
