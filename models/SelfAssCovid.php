<?php namespace Yfktn\SelfAssCovid\Models;

use Model;

/**
 * Model
 */
class SelfAssCovid extends Model
{
    use \October\Rain\Database\Traits\Validation;
    

    /**
     * @var string The database table used by the model.
     */
    public $table = 'yfktn_selfasscovid_';

    /**
     * @var array Validation rules
     */
    public $rules = [
        'jawab01' => 'required|numeric|integer|in:0,1',
        'jawab02' => 'required|numeric|integer|in:0,1',
        'jawab03' => 'required|numeric|integer|in:0,1',
        'jawab04' => 'required|numeric|integer|in:0,1',
        'jawab05' => 'required|numeric|integer|in:0,5',
        'jawab06' => 'required|numeric|integer|in:0,5'
    ];

    public function getNilaiResiko()
    {
        return $this->jawab01 + $this->jawab02 + $this->jawab03 + $this->jawab04 + $this->jawab05 + $this->jawab06;
    }
}
