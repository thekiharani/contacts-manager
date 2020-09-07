<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'phone_number',
    ];

    /**
     * Get the contact owner(user).
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * The groups that the contact belongs to.
     */
    public function groups()
    {
        return $this->belongsToMany(Group::class);
    }

}
