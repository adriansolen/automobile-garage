<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Engine extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'engines';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'engine_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'engine_type',
        'displacement',
        'maximum_output',
        'maximum_torque',
        'fuel_type',
        'fuel_capacity',
        'user_id',
        'VIN',
    ];
}
