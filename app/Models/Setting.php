<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'primary_color',
        'secondary_color',
        'business_id'
    ];
    public function business()
    {
        return $this->belongsTo(Business::class);
    }
}
