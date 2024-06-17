<?php

namespace App\Models;

class PaymentMethod extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'employee_id', 'type', 'cc_number', 'cc_ccv', 'expiration_month', 'expiration_year'
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var boolean
     */
    public $timestamps = true;

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Define relationships.
     */
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
