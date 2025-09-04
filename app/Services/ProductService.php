<?php

namespace App\Services;

use App\Models\Product;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class ProductService implements ProductServiceInterface
{
    protected $threshHold = 5;

    public function reduceStock(int $productId, int $quantity): bool
    {
        $product = Product::findOrFail($productId);
        if ($quantity > $product->stock)
        {
            $this->notify($product);
            return false;
        }

        $product->stock -= $quantity;
        $product->save();
        if ($product->stock < $this->threshHold)
            $this->notify($product);

        return true;
    }
    public function notify(Product $product): bool
    {
        $businessId = auth()->user()->business_id;
        $users = User::whereHas('role', function ($query) use ($businessId)
        {
            $query->where('business_id', $businessId)->where('role_category', 'staff');
        })->get();

        $data = [
            'subject' => 'Depleted stocks',
            'message' => $product->name . ' (ID: ' . $product->id . ') is about to be depleted. Stock remaining is ' . $product->stock,
        ];

        foreach ($users as $user)
        {
            $data['receiver_id'] = $user->id;
            \App\Models\Notification::create($data);
        }
        return true;
    }
    public function myNotifications(int $id): Collection
    {
        $notifications = Notification::where('receiver_id', $id)
            ->where('read', false)->get();
        return $notifications;
    }
}
