<?php

use App\Http\Controllers\MainController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\OnlyAdmin;
use Illuminate\Support\Facades\Route;

// Route::view('/','home');
Route::get('/index', [MainController::class, 'index']);
Route::get('/about', [MainController::class, 'about']);
Route::redirect('/saltar', '/index');
Route::view('/view', 'home');
Route::view('/view2', 'home', ['myName' => 'Jheorgenes Warlley']);

Route::get('/valor/{value}', [MainController::class, 'mostrarValor']);
Route::get('/valores/{value1}/{value2}', [MainController::class, 'mostrarValores']);

Route::get('/opcional/{value?}', [MainController::class, 'mostrarValorOpcional']);
Route::get('/opcional1/{value1}/{value2?}', [MainController::class, 'mostrarValorOpcional2']);

Route::get('/user/{user_id}/post/{post_id}', [MainController::class, 'mostrarPosts']);

// Route Parameters with constraints
Route::get('/exp1/{value}', function($value) {
    echo $value;
})->where('value', '[0-9]+'); //Pegando o parametro que será recebido e definindo uma regra (regex) de entrada nesse parametro


Route::get('/exp2/{value}', function($value) {
    echo $value;
})->where('value', '[A-Za-z0-9]+');


Route::get('/exp3/{value1}/{value2}', function($value1, $value2) {
    echo "$value1 e $value2";
})->where([
    'value'=> '[0-9]+',
    'value2'=> '[A-Za-z0-9]+'
]);

// Route names
Route::get('/nota_abc', function() {
    return "Rota nomeada";
})->name('rota_nomeada');

Route::get('/rota_referenciada', function() {
    return redirect()->route('rota_nomeada');
});

// Route groups
Route::prefix('admin')->group(function() {
    Route::get('/home', [MainController::class, 'index']);
    Route::get('/about', [MainController::class, 'about']);
    Route::get('/management', [MainController::class, 'mostrarValor']);
});

//routes with middlewares
Route::get('/admin/only', function() {
    echo "Apenas Administradores!";
})->middleware([OnlyAdmin::class]);

Route::middleware([OnlyAdmin::class])->group(function () {
    Route::get('/admin/only2', function() {
        return 'apenas administradores 1';
    });
    Route::get('/admin/only3', function() {
        return 'apenas administradores 2';
    });
});

// Simplificando rotas com Controladores
// Route::get('/new', [UserController::class, 'new']);
// Route::get('/edit', [UserController::class, 'edit']);
// Route::get('/delete', [UserController::class, 'delete']);

Route::controller(UserController::class)->group(function() {
    Route::get('/user/new', 'new');
    Route::get('/user/edit', 'edit');
    Route::get('/user/delete', 'delete');
});

Route::fallback(function () {
    echo "PAGINA NAO ENCONTRADA";
});
