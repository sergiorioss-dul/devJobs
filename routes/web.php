<?php

use App\Http\Controllers\VacanteController;
use Illuminate\Support\Facades\Route;



Auth::routes(['verify'=> true]);


//Rutas protegidas
Route::group(['middlware'=>['auth','verified']],function(){
    //Rutas de vacante
    Route::get('/vacantes','VacanteController@index')->name('vacante.index');
    Route::get('/vacantes/create','VacanteController@create')->name('vacante.create'); 
    Route::post('/vacantes','VacanteController@store')->name('vacante.store');
    Route::delete('/vacantes/{vacante}','VacanteController@destroy')->name('vacante.destroy');
    Route::get('/vacantes/{vacante}/edit','VacanteController@edit')->name('vacante.edit');
    Route::put('/vacantes/{vacante}', 'VacanteController@update')->name('vacante.update');
    //Subir imagen
    Route::post('/vacantes/imagen','VacanteController@imagen')->name('vacante.imagen');
    Route::post('/vacantes/borrarimagen','VacanteController@borrarimagen')->name('vacante.borrar');
    // Cambiar estado de la vacante
    Route::post('/vacantes/{vacante}','VacanteController@estado')->name('vacante.estado');
    //Notificaciones
    Route::get('/notificaciones','NotificacionesController')->name('notificaciones');
    
});
//Pagina de inicio
Route::get('/','InicioController')->name('inicio');

//Categoria
Route::get('/categorias/{categoria}','CategoriaController@show')->name('categorias.show');

// Enviar datos para una vacante
Route::get('/candidatos/{id}','CandidatoController@index')->name('candidatos.index');
Route::post('/candidatos/store','CandidatoController@store')->name('candidatos.store');

//Busqueda de vacantes
Route::post('/busqueda/buscar', 'VacanteController@buscar')->name('vacante.buscar');
Route::get('/busqueda/buscar','VacanteController@resultados')->name('vacante.resultados');
// Muestra los trabajos en el front sin autenticación
Route::get('/vacantes/{vacante}','VacanteController@show')->name('vacante.show');

