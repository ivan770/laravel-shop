<?php


namespace App\Services;


use App\Models\Cart;
use Illuminate\Database\Eloquent\Collection;
use App\Contracts\ChargeBuilder as ChargeBuilderContract;

class ChargeBuilder implements ChargeBuilderContract
{
    /**
     * @var Cart $cart
     */
    protected $cart;

    /**
     * @var Collection $prices;
     */
    protected $prices;

    /**
     * @var float
     */
    protected $total = 0;

    public function build($cart)
    {
        $this->cart = $cart;
        return $this;
    }

    public function calculatePrices()
    {
        $this->prices = $this->cart->items()->with('item')->get()->mapWithKeys(function ($item) {
            return [$item->item->id => $item->item->price * $item->count];
        });
        return $this;
    }

    public function calculateTotal()
    {
        $this->total = $this->prices->sum();
        return $this;
    }

    public function toResult()
    {
        return ["prices" => $this->prices, "total" => $this->total];
    }
}