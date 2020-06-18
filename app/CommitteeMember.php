<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CommitteeMember extends Model
{
    protected $table = 'committee_members';
    protected $guarded = ['id'];

    public function committee()
    {
        return $this->belongsTo('App\Committee');
    }
}
