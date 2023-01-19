<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FaqTitle extends Model
{
    use HasFactory;

    protected $fillable = [
        'user',        
        'title',        
    ];

    protected $appends = ['faqs'];

    public function faq()
    {
        return $this->hasMany(Faq::class, 'title_id', 'id');
    }

    public function modelFilter()
    {
        return $this->provideFilter(\App\ModelFilters\FaqFilter::class);
    }

    public function getFaqsAttribute()
    {
        return Faq::where('title_id', $this->attributes['id'])->first();
    }
}
