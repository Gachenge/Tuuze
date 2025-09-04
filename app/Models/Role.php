<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends BaseModel
{
    protected $fillable = [
        'name',
        'status',
        'business_id',
        'role_category'
    ];

    public function business()
    {
        return $this->belongsTo(Business::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }
    public function isStaff()
    {
        return $this->role_category === 'staff';
    }

    public function isCustomer()
    {
        return $this->role_category === 'customer';
    }
}
