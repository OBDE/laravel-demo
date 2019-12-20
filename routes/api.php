<?php

use App\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

Route::get('test', function () {
    return response()->json([
        'APP_NAME' => env('APP_NAME'),
        'HOSTNAME' => gethostname(),
        'DB_CONNECTION' => env('DB_CONNECTION'),
        'DB_HOST' => env('DB_HOST'),
        'DB_PORT' => env('DB_PORT'),
        'DB_DATABASE' => env('DB_DATABASE'),
        'DB_USERNAME' => env('DB_USERNAME')
    ]);
});

Route::get('users',function() {
    return User::all();
});

Route::get('initdatabase',function() {

    $success = false;
    
    Schema::create('users', function (Blueprint $table) {
        $table->bigIncrements('id');
        $table->string('name');
        $table->string('email')->unique();
        $table->timestamp('email_verified_at')->nullable();
        $table->string('password');
        $table->rememberToken();
        $table->timestamps();
    });
    
    User::firstOrCreate([
        'name' => 'DemoUser',
        'email' => 'demo@demo.com',
        'password' => Hash::make('demo')
    ]);
    $success = true;
    
    // Laravel would throw error if something happens upper
    return response()->json(['success' => $success]);
});

