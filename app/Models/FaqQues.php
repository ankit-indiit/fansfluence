<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FaqQues extends Model
{
    use HasFactory;

    protected $fillable = [
        'user',
        'question',
    ];

    public function faq()
    {
        return $this->hasMany(FaqAns::class, 'qus_id', 'id');
    }
}
