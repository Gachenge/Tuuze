<?php

namespace App\Services;

use App\Models\Notification;
use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;

interface ProductServiceInterface
{
    public function reduceStock(int $productId, int $quantity): bool;
    public function myNotifications(int $id): Collection;
}
