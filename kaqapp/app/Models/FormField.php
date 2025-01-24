<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormField extends Model
{
    use HasFactory;

    protected $fillable = ['qr_code_type_id', 'label', 'type', 'required', 'placeholder', 'value'];

    public function qrCodeType()
    {
        return $this->belongsTo(QrCodeType::class);
    }
}

