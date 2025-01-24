<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    // Define the relationship with QrCodeType
    public function qrCodeTypes()
    {
        return $this->hasMany(QrCodeType::class);
    }
}
