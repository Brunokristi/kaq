<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DocController;
use App\Http\Controllers\StoriesController;

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

Route::get('/documentation', [DocController::class, 'index'])->name('documentation');

Route::get('/story1', [StoriesController::class, 'story1'])->name('story1');
Route::get('/story2', [StoriesController::class, 'story2'])->name('story2');
Route::get('/story3', [StoriesController::class, 'story3'])->name('story3');



Route::get('/api/types/{id}', function ($id) {
    $type = QrCodeType::with('formFields')->findOrFail($id);

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
                'value' => $field->value
            ];
        }),
    ]);
});
