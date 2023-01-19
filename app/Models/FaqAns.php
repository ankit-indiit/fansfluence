<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FaqAns extends Model
{
    use HasFactory;

    protected $fillable = [
        'qus_id',
        'answer',
    ];

    public function faqAns()
    {
        return $this->belongsTo(FaqQues::class);
    }
}
