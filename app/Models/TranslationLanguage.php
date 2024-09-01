<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TranslationLanguage extends Model
{
    use HasFactory;

    protected $table= 'translation_languages';
    protected $fillable=[
        'lang_name',
        'slug',
        'svg',
        'is_default',
    ];

    public function scopeDefaultLanguage($query)
    {
        return $query->where('is_default', 1);
    }
    public function getSvg()
    {
        return asset($this->svg);
    }
}
