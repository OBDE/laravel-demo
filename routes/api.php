<?php

use App\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

Route::get('demo', function () {

    $users = null;

    try{
        $users = User::all();
    }
    catch(Exception $e)
    {
        $users = null;
    }

    return response()->json([        
        'version' => '1.0.1',
        'APP_NAME' => env('APP_NAME'),
        'HOSTNAME' => gethostname(),
        'DB_CONNECTION' => env('DB_CONNECTION'),
        'DB_HOST' => env('DB_HOST'),
        'DB_PORT' => env('DB_PORT'),
        'DB_DATABASE' => env('DB_DATABASE'),
        'DB_USERNAME' => env('DB_USERNAME'),
        'DB_PASSWORD' => env('DB_PASSWORD'),
        'users' => $users
    ]);
});

Route::prefix('v1')->group(function(){
    Route::get('demo', function() {
        return response()->json([        
            'version' => '1.0.2',
            'APP_NAME' => env('APP_NAME'),
            'HOSTNAME' => gethostname(),
            'DB_CONNECTION' => env('DB_CONNECTION'),
            'DB_HOST' => env('DB_HOST'),
            'DB_PORT' => env('DB_PORT'),
            'DB_DATABASE' => env('DB_DATABASE'),
            'DB_USERNAME' => env('DB_USERNAME'),
            'DB_PASSWORD' => env('DB_PASSWORD'),
            'version' => 'v1'
        ]);
    });
});

Route::prefix('v2')->group(function(){
    Route::get('demo', function() {
        return response()->json([        
            'version' => '2.0.0',
            'APP_NAME' => env('APP_NAME'),
            'HOSTNAME' => gethostname(),
            'DB_CONNECTION' => env('DB_CONNECTION'),
            'DB_HOST' => env('DB_HOST'),
            'DB_PORT' => env('DB_PORT'),
            'DB_DATABASE' => env('DB_DATABASE'),
            'DB_USERNAME' => env('DB_USERNAME'),
            'DB_PASSWORD' => env('DB_PASSWORD'),
            'version' => 'v2'
        ]);
    });
});

Route::get('init',function() {

    $success = false;
    if (!Schema::hasTable('users')) {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
    }
    
    User::firstOrCreate([
        'name' => 'DemoUser',
        'email' => 'demo@demo.com',
        'password' => Hash::make('demo')
    ]);
    $success = true;
    
    // Laravel would throw error if something happens upper
    return response()->json(['success' => $success]);
});

