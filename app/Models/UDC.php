<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Builder;

class UDC extends BaseModel
{
    protected $table = 'udcs';

    protected $casts = [
        //'price' => 'decimal:2',
        'disabled' => 'boolean',
    ];

    
    protected static function boot()
    {
        parent::boot();
        

        //UDC::withoutGlobalScopes()
        // Add product-specific conditions
        static::addGlobalScope('initial', function (Builder $builder) {

            $builder->where(function ($query) {
                $query->where("company_id", session("company_id"))
                    ->orWhere('company_id', 0);
            });
        });
    }

    public static function getAll($udc)
    {
        return UDC::where("udc", $udc)->get()->toArray();
    }

    public static function isUDC(string $udc)
    {
        return count(UDC::getAll($udc)) > 0;
    }
}
