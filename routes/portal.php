<?php

use App\Livewire\Portal\About;
use App\Livewire\Portal\Blogs;
use App\Livewire\Portal\Contact;
use App\Livewire\Portal\Home;
use App\Livewire\Portal\WebsiteTemplates;
use Illuminate\Support\Facades\Route;


Route::get('/', Home::class)->name('portal.home');
Route::get('/about', About::class)->name('portal.about');
Route::get('/blogs', Blogs::class)->name('portal.blogs');
Route::get('/website-templates', WebsiteTemplates::class)->name('portal.website-templates');
Route::get('/contact', Contact::class)->name('portal.contact');

Route::get('/{slug}', function ($slug) {
    $article = \App\Models\Article::where('slug', $slug)->firstOrFail();
    return view('portal.article', compact('article'));
})->name('portal.article');
