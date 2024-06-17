<?php

namespace App\Models;

class Mission extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'employee_id', 'fundraiser_id', 'name', 'website', 'image', 'description', 'goal_amount', 'goal_currency', 'goal_end_date'
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
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
        'goal_end_date' => 'datetime',
    ];

    /**
     * Define relationships.
     */
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function fundraiser()
    {
        return $this->belongsTo(Fundraiser::class);
    }

    public function donations()
    {
        return $this->hasMany(Donation::class);
    }
}
