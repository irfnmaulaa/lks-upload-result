<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/files', function () {
    return collect(\Illuminate\Support\Facades\Storage::files('public'))->map(function($file) {
        return collect(explode('/', $file))->slice(1)->join('/');
    });
})->name('files');

Route::get('/', function (\Illuminate\Http\Request $request) {
    $files = collect(\Illuminate\Support\Facades\Storage::files('public'))->map(function($file) {
        return collect(explode('/', $file))->slice(1)->join('/');
    });

    return view('upload', compact('files'));
})->name('home');

Route::post('/up', function (\Illuminate\Http\Request $request) {

    // validate file
    $request->validate([
        'file' => ['file', 'mimes:zip']
    ]);

    // define file
    $file = $request->file('file');

    // upload file
    $file->storeAs('public', $file->getClientOriginalName());

    return redirect()->back()->with('message', 'File berhasil diupload. Terima kasih☺️');

})->name('up');
