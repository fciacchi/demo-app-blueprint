<?php

namespace App\Models;

class Fundraiser extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'employee_id', 'name', 'website', 'image', 'description', 'goal_amount', 'goal_currency', 'goal_end_date'
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
        'goal_end_date' => 'datetime',
    ];

    /**
     * Define relationships.
     */
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function missions()
    {
        return $this->hasMany(Mission::class);
    }
}
