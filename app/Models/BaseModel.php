<?php

namespace App\Models;

use App\Constants\Constants;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class BaseModel extends Model
{
    protected $guarded = ['id'];
    protected $primaryKey = 'id'; // Asegurar que Laravel sepa cuál es la clave primaria

    // Disable auto-incrementing as we'll work with different tables
    //public $incrementing = false;

    // No timestamps by default
    public $timestamps = false;

    public $hidden = ['company_id'];

    public $columns = [], $hasCompany = false;

    protected static function boot()
    {
        parent::boot();

        // Add product-specific conditions
        static::addGlobalScope('initial', function (Builder $builder) {

            $table = $builder->getModel()->getTable();
            $list = \Schema::getColumnListing($table);

            if (in_array(Constants::FD_COMPANY, $list)) {
                /*$builder->where(function ($query) {
                                $query->where("company_id", session("company_id"))
                                    ->orWhere('company_id', 0);
                            });*/
                $builder->where(Constants::FD_COMPANY, session(Constants::FD_COMPANY));
            }

        });
    }


    /**
     * Get the column listing of the table
     */
    public function getColumnsList($field = false)
    {
        return collect($this->columns)
            ->map(fn($column) => $field ? $column->{$field} : $column->id)
            ->toArray();
    }

    public function has($name)
    {
        return in_array($name, $this->columnsList);
    }
}
