<?php

namespace App\Models;

class Donation extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'employee_id', 'mission_id', 'payment_method_id', 'amount', 'currency', 'recurring', 'recurring_days'
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

    public function mission()
    {
        return $this->belongsTo(Mission::class);
    }

    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class);
    }
}
