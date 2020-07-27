<?php
/**
 * @todo Analisar, provavelmente tera que sair
 */

Bancario\Models\Actors\Business;

use Support\Models\Base;
use Bancario\Models\Actors\Person;

class Collaborator extends Person
{

    protected $organizationPerspective = true;

    protected $table = 'business_collaborators';       

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'person_id',
        'business_id',
        'business_collaborator_type_id',
    ];


    protected $mappingProperties = array(

        'customer_id' => [
            'type' => 'integer',
            "analyzer" => "standard",
        ],
        'credit_card_id' => [
            'type' => 'integer',
            "analyzer" => "standard",
        ],
        'user_id' => [
            'type' => 'integer',
            "analyzer" => "standard",
        ],
        'score' => [
            'type' => 'float',
            "analyzer" => "standard",
        ],
    );


    public function user()
    {
        return $this->belongsTo(\Illuminate\Support\Facades\Config::get('sitec.core.models.user', \App\Models\User::class), 'user_id', 'id');
    }

}