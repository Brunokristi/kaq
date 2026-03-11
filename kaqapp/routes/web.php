<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DocController;
use App\Http\Controllers\StoriesController;

use App\Models\QrCodeType;


Route::get('/', function () {
    if (!request()->has('type')) {
        return redirect()->route('home', ['type' => 2]);
    }
    return view('dashboard');
})->name('home');

Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'submit'])->name('contact.submit');
Route::get('/create', [DashboardController::class, 'index'])->name('create');
Route::get('/documentation', [DocController::class, 'index'])->name('documentation');



Route::get('/api/types/{id}', function ($id) {
    try {
        $type = QrCodeType::with('formFields')->find($id);

        if (!$type) {
            return response()->json([
                'error' => 'QR code type not found',
            ], 404);
        }

        return response()->json([
            'name' => $type->name,
            'description' => $type->description,
            'url' => $type->url,
            'form_fields' => $type->formFields->map(function ($field) {
                return [
                    'label' => $field->label,
                    'type' => $field->type,
                    'required' => $field->required,
                    'placeholder' => $field->placeholder,
                    'value' => $field->value,
                    'help_text' => $field->help_text,
                ];
            }),
        ]);
    } catch (\Throwable $exception) {
        return response()->json([
            'error' => 'Failed to fetch QR code type',
        ], 500);
    }
});
