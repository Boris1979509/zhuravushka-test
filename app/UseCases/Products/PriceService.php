<?php

namespace App\UseCases\Products;

use Illuminate\Database\Eloquent\Collection;

class PriceService
{
    /**
     * Percent
     */
    public const PERCENT = 15; // %
    public const MIN_SUM = 1000;

    /**
     * @param $price
     * @return mixed
     */
    public function subtractPercent($price)
    {
        if ($price instanceof Collection) {
            return $price->each(function ($item) {
                $item->old_price = $this->math($item->price);
            });
        }
        return $this->math($price);
    }

    /**
     * @param int $price
     * @return float|null
     */
    private function math($price): ?float
    {
        if ($price && $price >= self::MIN_SUM) {
            return round($price + ($price * (self::PERCENT / 100)));
        }
        return null;
    }
}
