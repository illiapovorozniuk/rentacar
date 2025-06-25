<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="Currency",
 *     type="object",
 *     title="Currency",
 *     required={"slug", "sign", "exchange_rate"},
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         format="int64",
 *         description="Currency ID"
 *     ),
 *     @OA\Property(
 *         property="slug",
 *         type="string",
 *         description="Unique slug identifier for the currency"
 *     ),
 *     @OA\Property(
 *         property="sign",
 *         type="string",
 *         description="Currency sign/symbol, e.g. $"
 *     ),
 *     @OA\Property(
 *         property="exchange_rate",
 *         type="number",
 *         format="float",
 *         description="Exchange rate relative to a base currency"
 *     ),
 *     @OA\Property(
 *         property="created_at",
 *         type="string",
 *         format="date-time",
 *         description="Record creation timestamp"
 *     ),
 *     @OA\Property(
 *         property="updated_at",
 *         type="string",
 *         format="date-time",
 *         description="Record update timestamp"
 *     ),
 *     @OA\Property(
 *         property="resource_url",
 *         type="string",
 *         description="URL to the currency resource"
 *     )
 * )
 */

class Currency extends Model
{
    protected $fillable = [
        'slug',
        'sign',
        'exchange_rate',

    ];


    protected $dates = [
        'created_at',
        'updated_at',

    ];

    protected $appends = ['resource_url'];

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/currencies/'.$this->getKey());
    }
}
