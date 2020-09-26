<?php

namespace Bancario\Models\Banks;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\Hash;
use Muleta\Traits\Models\EloquentGetTableNameTrait;

class Gateway extends Model
{
    use EloquentGetTableNameTrait;

    /**
     * @var false
     */
    protected static bool $organizationPerspective = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'slug',
        'description',
        'status',
    ];
    

    public function processingFailedPayments(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany('App\Models\Shopping\ProcessingFailedPayment');
    }
}