<?php

namespace App\Models;

class Employee extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'username', 'email', 'first_name', 'last_name', 'role', 'department'
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
    public function fundraisers()
    {
        return $this->hasMany(Fundraiser::class);
    }

    public function missions()
    {
        return $this->hasMany(Mission::class);
    }

    public function donations()
    {
        return $this->hasMany(Donation::class);
    }

    public function paymentMethods()
    {
        return $this->hasMany(PaymentMethod::class);
    }
}
