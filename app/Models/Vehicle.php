<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'vehicles';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'VIN';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'price',
        'transmission',
        'color',
        'image',
        'user_id',
        'model_id',
        'brand_id',
        'dealer_id',
    ];

    /**
     * Define a many-to-one relationship between the Vehicle model and the Models model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function models()
    {
        // Establish a belongsTo relationship with the Models model
        // 'Models::class' specifies the related model class
        // 'model_id' is the foreign key column in the Vehicle model
        // 'model_id' is the primary key column in the Models model
        return $this->belongsTo(Models::class, 'model_id', 'model_id');
    }

    /**
     * Define a many-to-one relationship between the Vehicle model and the Brand model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function brand()
    {
        // Establish a belongsTo relationship with the Brand model
        // 'Brand::class' specifies the related model class
        // 'brand_id' is the foreign key column in the Vehicle model
        // 'brand_id' is the primary key column in the Brand model
        return $this->belongsTo(Brand::class, 'brand_id', 'brand_id');
    }
}
