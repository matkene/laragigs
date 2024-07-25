<?php

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ListingController;


Route::get('/welcome', function () {
    return view('welcome');
});


#Manage Lisiting
Route::get('/listings/manage',[ListingController::class,'manage'])->middleware('auth');

# Using this as the endpoints ....ALL the listings
Route::get('/', [ListingController::class, 'index']);



# show form for listing
Route::get('/listings/create',[ListingController::class, 'create'])->middleware('auth');

# store listing
Route::post('/listings',[ListingController::class,'store'])->middleware('auth');

# Single Listings

Route::get('/listings/{listing}', [ListingController::class, 'show']);

# Edit a single listing
Route::get('/listings/{listing}/edit',[ListingController::class,'edit'])->middleware('auth');

# Update
Route::put('/listings/{listing}',[ListingController::class,'update'])->middleware('auth');

# Delete
Route::delete('/listings/{listing}',[ListingController::class,'destroy'])->middleware('auth');


#Show/ Register form
Route::get('/register',[UserController::class,'create'])->middleware('guest');

#Show/ Register form
Route::post('/users',[UserController::class,'store']);

#logout
Route::post('/logout',[UserController::class,'logout'])->middleware('auth');

#show login form
Route::get('/login',[UserController::class,'login'])->name('login')->middleware('guest');

#authenticate login
Route::post('/users/authenticate',[UserController::class,'authenticate']);


/*
Route::get('/lord', function(){
    return 'Jesus is My Lord and Saviour. Jesus is my Shepherd and I shall not want';    
});

Route::get('/hello', function(){
    // return '<b>The Lord is my Light and my Salvation</b>';
     return response('<h1> I serve a God of wonders</h1>',200)
     ->header('Content-Type', 'text/plain')
     ->header('foo', 'bar');
});

Route::get('/posts/{id}', function($id){
    dd($id);  // die and dump dd, dumo die debug ddd
    return response('Post '. $id);    // add restriction only numbers
    
})->where('id', '[0-9]+');

Route::get('/search', function(Request $request){
      dd($request->name.' '.$request->city.' '.$request->status);
});

// How to return json ...multi-dimensional array
Route::get('postings', function(){
    return response()->json([
        'posts' => [
            [
                'title' => 'Producers',
                'name' => 'Matthew Chizea',
                'status' => 'blessed',
                'age' => 40
            ],
            [
                'title' => 'Designers',
                'name' => 'Lovely Biola',
                'status' => 'great',
                'age' => 30
            ]

        ]
    ]); 
});
*/