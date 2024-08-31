<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;
    protected $fillable = [
        'data_layout',
        'data_topbar',
        'data_sidebar',
        'data_sidebar_size',
        'data_sidebar_image',
        'data_preloader',
        'data_bs_theme',
        'data_layout_width',
        'data_layout_position',
        'data_layout_style',
        'data_sidebar_visibility',
        'humburger',
        'user_id',
    ];
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}
