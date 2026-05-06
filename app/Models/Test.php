<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    protected $guarded = ['id'];



    public function module()
    {
        return $this->belongsTo(Module::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function testPassages()
    {
        return $this->hasMany(TestPassage::class)->orderBy('order');
    }

    // public function questions()
    // {
    //     return $this->belongsToMany(Question::class, 'test_questions')
    //         ->withPivot('sort_order')
    //         ->orderByPivot('sort_order', 'asc'); // Gunakan orderByPivot
    // }
}
