<?php

use App\Livewire\FetchPosts;

use Illuminate\Support\Facades\Route;


Route::get('/', FetchPosts::class);


