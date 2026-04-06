<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResearchAnalytic extends Model
{
    protected $fillable = [
        'user_id',
        'pre_test_score',
        'post_test_score',
        'n_gain_score',
        'category'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function calculateNGain($maxScore = 100)
    {
        if ($this->pre_test_score !== null && $this->post_test_score !== null) {

            if ($maxScore - $this->pre_test_score == 0) {
                $nGain = 0;
            } else {
                $nGain = ($this->post_test_score - $this->pre_test_score) / ($maxScore - $this->pre_test_score);
            }

            $this->n_gain_score = $nGain;

            if ($nGain > 0.7) {
                $this->category = 'High';
            } elseif ($nGain >= 0.3 && $nGain <= 0.7) {
                $this->category = 'Medium';
            } else {
                $this->category = 'Low';
            }

            $this->save();
        }
    }
}
