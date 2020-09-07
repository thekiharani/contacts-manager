<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description',
    ];

    /**
     * Get the group owner(user).
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * The contacts that belong to the group.
     */
    public function contacts()
    {
        return $this->belongsToMany(Contact::class);
    }
}
