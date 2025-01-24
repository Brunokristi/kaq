<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DashboardController;
use App\Models\QrCodeType;


Route::get('/', function () {
    return view('homepage');
});

Route::get('/mission', function () {
    return view('mission');
})->name('mission');

Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'submit'])->name('contact.submit');

Route::get('/create', [DashboardController::class, 'index'])->name('create');

Route::get('/api/types/{id}', function ($id) {
    $type = QrCodeType::with('formFields')->findOrFail($id);

    return response()->json([
        'name' => $type->name,
        'description' => $type->description,
        'form_fields' => $type->formFields->map(function ($field) {
            return [
                'label' => $field->label,
                'type' => $field->type,
                'required' => $field->required,
                'placeholder' => $field->placeholder,
                'value' => $field->value
            ];
        }),
    ]);
});