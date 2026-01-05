<?php

namespace App\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;
use Money\Money;
use Money\Currency;

class MoneyCast implements CastsAttributes
{
    /**
     * Cast the given value.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function get(Model $model, string $key, mixed $value, array $attributes): Money
    {
        return new Money(
            $value,
            new Currency($attributes['currency'])
        );
    }

    /**
     * Prepare the given value for storage.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function set(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        if ($value instanceof Money) {
            return [
                'amount' => (int) $value->getAmount(),
                'currency' => $value->getCurrency()->getCode(),
            ];
        }
        throw new \InvalidArgumentException('The given value is not a Money instance.');
    }
}
