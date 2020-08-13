<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'Webapp\HomeController@index')->name('app.home');
Route::get('/busca','Webapp\SearchController@index')->name('app.search');
Route::post('/busca/produto', 'Webapp\SearchController@searchProduct')->name('app.search.product');
Route::get('/busca/produto', 'Webapp\SearchController@searchRollback');
Route::post('/busca/produto/promocao', 'Webapp\SearchController@searchProductOffer')->name('app.search.product.offer');
Route::get('/busca/produto/promocao', 'Webapp\SearchController@searchRollback');
Route::get('/promocoes', 'Webapp\OfferController@index')->name('app.offer');
Route::post('/comercio/filtrar', 'Webapp\SearchController@filterStoreCategory')->name('app.filter.store');
Route::post('/comercio/buscar', 'Webapp\SearchController@searchStore')->name('app.search.store');
Route::get('/comercio/buscar', 'Webapp\SearchController@searchRollback');
Route::get('/comercio/categoria/{id}', 'Webapp\StoreController@storeCategory')->name('app.storeCategory');
Route::get('/comercio/{id}', 'Webapp\StoreController@index')->name('app.store');
Route::post('/comercio/{id}', 'Webapp\SearchController@searchProductInStore')->name('app.store.search');
Route::get('/localizacao-usuario', 'Webapp\HelperController@getUserGeolocation')->name('app.getusergeolocation');
Route::get('/location', 'Webapp\HelperController@userLocationData');

Route::prefix('/painel')->group(function(){
    Route::get('/', 'Admin\HomeController@index')->name('painel.home');
    Route::get('login', 'Auth\LoginController@index')->name('login');
    Route::post('login', 'Auth\LoginController@authenticate')->name('login.auth');
    Route::get('logout', 'Auth\LoginController@logout')->name('logout');
    Route::get('cadastrar', 'Auth\RegisterController@index')->name('panel.register');
    Route::post('cadastrar', 'Auth\RegisterController@register')->name('register.save');
    Route::get('recuperacao', 'Auth\ForgotPasswordController@forgot')->name('forgot');
    Route::post('recuperacao/enviar', 'Auth\ForgotPasswordController@recover')->name('recover');
    Route::get('recuperar-senha', 'Auth\ForgotPasswordController@getToken')->name('gettoken');
    Route::post('recuperar-senha', 'Auth\ForgotPasswordController@getToken')->name('gettokenpost');
    Route::post('trocar-senha', 'Auth\ForgotPasswordController@sendPassword')->name('sendpassword');
  
    // COMÉRCIO
    Route::get('comercio', 'Admin\CommerceController@index')->name('panel.commerce');
    Route::get('comercio/cadastrar', 'Admin\CommerceController@register')->name('commerce.register');
    Route::post('comercio/cadastrar', 'Admin\CommerceController@save')->name('commerce.save');
    Route::get('comercio/editar/{id}', 'Admin\CommerceController@edit')->name('commerce.edit');
    Route::put('comercio/editar/{id}', 'Admin\CommerceController@update')->name('commerce.update');
    Route::get('comercio/excluir/{id}', 'Admin\CommerceController@delete')->name('commerce.delete');
    Route::get('comercio/gerenciar/{id}', 'Admin\CommerceController@manage')->name('commerce.manage');
    Route::post('comercio/gerenciar/{id}', 'Admin\CommerceController@add')->name('commerce.add');
    Route::post('comercio/gerenciar/desvincular/{id}', 'Admin\CommerceController@unlink')->name('commerce.unlink');
    // USUÁRIO
    Route::get('usuario', 'Admin\UserController@index')->name('panel.user');
    Route::get('usuario/cadastrar', 'Admin\UserController@register')->name('user.register');
    Route::post('usuario/cadastrar', 'Admin\UserController@save')->name('user.save');
    Route::get('usuario/editar/{id}', 'Admin\UserController@edit')->name('user.edit');
    Route::put('usuario/editar/{id}', 'Admin\UserController@update')->name('user.update');
    Route::get('usuario/excluir/{id}', 'Admin\UserController@delete')->name('user.delete');
    //PROFILE
    Route::get('perfil', 'Admin\ProfileController@index')->name('panel.profile');
    Route::put('perfil/atualizar', 'Admin\ProfileController@update')->name('profile.update');
    // Route::get('minha-conta', 'Admin\ProfileController@myaccount')->name('myaccount');
    Route::get('suporte', 'Admin\ProfileController@suport')->name('suport');
    //PLANOS
    Route::get('planos', 'Admin\PlanController@index')->name('panel.plan');
    //PRODUCT
    Route::get('produto/secao', 'Admin\SessionController@index')->name('panel.session');
    Route::get('produto/secao/cadastrar', 'Admin\SessionController@register')->name('session.register');
    Route::post('produto/secao/cadastrar', 'Admin\SessionController@save')->name('session.save');
    Route::get('produto/secao/editar/{id}', 'Admin\SessionController@edit')->name('session.edit');
    Route::put('produto/secao/editar/{id}', 'Admin\SessionController@update')->name('session.update');
    Route::get('produto/secao/excluir/{id}', 'Admin\SessionController@delete')->name('session.delete');
    
    
    Route::get('produto/secao/{id}', 'Admin\ProductController@index')->name('panel.product');
    Route::get('produto/cadastrar/{id}', 'Admin\ProductController@register')->name('product.register');
    Route::post('produto/cadastrar/{id}', 'Admin\ProductController@save')->name('product.save');
    Route::get('produto/editar/{id}', 'Admin\ProductController@edit')->name('product.edit');
    Route::put('produto/editar/{id}', 'Admin\ProductController@update')->name('product.update');
    Route::delete('produto/excluir/{id}', 'Admin\ProductController@delete')->name('product.delete');

    
});

