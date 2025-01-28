<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QrCodeType extends Model
{
    use HasFactory;

    protected $fillable = ['category_id', 'name', 'description', 'url'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function formFields()
    {
        return $this->hasMany(FormField::class)->orderBy('id');
    }
}
