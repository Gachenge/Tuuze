<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends BaseModel
{
    protected $fillable = [
        'user_id',
        'business_id',
        'total'
    ];
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
    public function business()
    {
        return $this->belongsTo(Business::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
