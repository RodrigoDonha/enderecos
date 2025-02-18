<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EnderecoController;

/** login user and token create and exibe token */
Route::post('/login', function (Request $request) {
    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials)) {
        $user = $request->user();
        $token = $user->createToken('authToken')->plainTextToken;

        return response()->json([
            "access_token" => $token,
            "token_type" => 'Bearer'
        ]);
    }

    return response()->json([
        "message" => "Usuário inválido ou não cadastrado"
    ]);
});

/** see profile user loged */
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

/** test the working route */
Route::get('/teste', function () {
    // return var_dump('entrou');

});

/** pega todos os registros da tabela enderecos após atualizar a tabela endrecos retornando um array*/
Route::get('/atualizar-end-completo', [EnderecoController::class, 'atualizarEndCompleto']);

/** trata o array com os registros da tabela endereços */
Route::get('/insert-camp-end-completo', [EnderecoController::class, 'insertCampEndCompleto']);
