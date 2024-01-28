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
//
// Route::view('/test-vue', 'test')->name('test');
//

Route::redirect('/', '/login')->name('welcome');

Route::view('/product', 'backend.products.index')->name('product');
Route::view('/product/add', 'backend.products.form')->name('createproduct');

Route::view('/manual-list', 'backend.manual.index')->name('manuallist');

Route::view('/manufacture', 'backend.manufacture.index')->name('manufacture');
Route::view('/manufacture/add', 'backend.manufacture.form')->name('createmanufacture');

Route::view('/station', 'backend.station.index')->name('station');
Route::view('/station/add', 'backend.station.form')->name('createstation');

Route::view('/ledger', 'backend.ledger.index')->name('ledger');
Route::view('/ledger/add', 'backend.ledger.form')->name('createledger');

Route::view('/intent', 'backend.intent.index')->name('intent');

Route::view('/srb', 'backend.srb.index')->middleware(['auth', 'role:storekeeper'])->name('srb');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::middleware('auth')->group(function () {
    Route::resource('faqs', 'FaqController');
    Route::resource('forum', 'ForumController');
    Route::resource('troubleshootings', 'TroubleshootingController');
    Route::resource('replies', 'ReplyController', ['only' => ['store', 'destroy']]);
    // User common routes
    Route::group(['as' => 'user.', 'prefix' => 'user', 'namespace' => 'User'], function () {
        // Profile
        Route::get('profile/', 'ProfileController@index')->name('profile.index');
        Route::post('profile/', 'ProfileController@update')->name('profile.update');

        // Security
        Route::get('profile/security', 'ProfileController@changePassword')->name('profile.password.change');
        Route::post('profile/security', 'ProfileController@updatePassword')->name('profile.password.update');
    });


    // Admin routes
    Route::group(['as' => 'admin.', 'prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => 'role:admin'], function () {
        Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
        Route::resource('manufactures', 'ManufactureController')->except(['show']);
        Route::resource('parts', 'PartController')->except(['show']);
        Route::resource('instruments', 'InstrumentController')->except(['show']);
        // Route for Export method
        Route::get('instruments/export/', 'InstrumentController@export')->name('instruments.export');
        // Route for Import method
        Route::post('instruments/import/', 'InstrumentController@storeImport')->name('instruments.import');
        //
        Route::resource('stations', 'StationController')->except(['show']);
        Route::resource('ledgers', 'LedgerController')->except(['show']);
        Route::resource('instrument-types', 'InstrumentTypeController')->except(['show']);
        Route::resource('part-types', 'PartTypeController')->except(['show']);
        Route::get('/getPartByInstrument/{id}', 'PartController@getPartByInstrument')->name('getPartByInstrument');
        Route::get('/getPartByType/{id}', 'PartController@getPartByType')->name('getPartByType');
        // Auto complete search
        Route::post('/autocomplete/fetch', 'PartController@autoComplete')->name('part.autocomplete');
        Route::get('/parts/create-update', 'PartController@partCreate')->name('parts.create.update');
        Route::post('/parts/get-data', 'PartController@getData')->name('parts.getData');
        Route::post('/parts/store', 'PartController@submitData')->name('parts.submitData');
        Route::get('/parts/single-data/{id}', 'PartController@getSingleData')->name('parts.getSingleData');
        // Route for Export method
        Route::get('parts/export/', 'PartController@export')->name('parts.export');
        // Route for Import method
        Route::post('parts/import/', 'PartController@storeImport')->name('parts.import');

        Route::group(['as'=>'stock.','prefix'=>'stock'],function(){
        Route::resource('instruments', 'StockInstrumentController')->except(['show']);
        Route::resource('parts', 'StockPartController')->except(['show']);
        });

        // Roles and Users
        Route::resource('roles', 'RoleController')->except(['show']);
        Route::resource('users', 'UserController');

        // Settings
        Route::group(['as' => 'settings.', 'prefix' => 'settings'], function () {
            Route::get('general', 'SettingController@index')->name('index');
            Route::patch('general', 'SettingController@update')->name('update');

            Route::get('appearance', 'SettingController@appearance')->name('appearance.index');
            Route::patch('appearance', 'SettingController@updateAppearance')->name('appearance.update');

            Route::get('mail', 'SettingController@mail')->name('mail.index');
            Route::patch('mail', 'SettingController@updateMailSettings')->name('mail.update');
        });
    });

    // Director general routes
    Route::group(['as' => 'directorGeneral.', 'prefix' => 'director-general', 'namespace' => 'DirectorGeneral', 'middleware' => 'role:director-general'], function () {
        Route::get('dashboard', 'DashboardController')->name('dashboard');
        Route::get('indents', 'IndentController@index')->name('indents.index');
        Route::get('indents/{id}', 'IndentController@show')->name('indents.show');
        Route::post('indents/{id}/status', 'IndentController@status')->name('indents.status');
        Route::get('indents/{indent}/export', 'IndentController@createPDF')->name('indents.export');

        // central 
        Route::get('central/indent/pdf/{id}', 'IndentController@pdf')->name('indents.pdf');
        Route::get('central-indent/generate', 'IndentController@manufactureList')->name('indents.manufactureList');
        Route::get('central-indent/{id}/part-lists', 'IndentController@CIPartList')->name('indents.partList');
        Route::post('central-indent/{id}/change-status', 'IndentController@changeStatus')->name('indents.statusChange');
        Route::post('central-indent/{id}/approved-status', 'IndentController@approved')->name('indents.approved');

        //srb
        Route::get('srb', 'SRBController@index')->name('srb.index');
        Route::get('srb/{id}/show', 'SRBController@show')->name('srb.show');
        Route::post('srb/{srb}/change-status', 'SRBController@changeStatus')->name('srb.changeStatus');
    });

    // SE routes
    Route::group(['as' => 'ACE.', 'prefix' => 'ace', 'namespace' => 'ACE', 'middleware' => 'role:ace'], function () {
        Route::get('dashboard', 'DashboardController')->name('dashboard');
        
        // central indent 
        Route::get('central/indent/pdf/{id}', 'IndentController@pdf')->name('indents.pdf');
        Route::post('central/indent/{part_id}/requisition-update/{central_indent_id}', 'IndentController@requisitionUpdate')->name('indents.requisitionUpdate');
        Route::get('central-indent/generate', 'IndentController@manufactureList')->name('indents.manufactureList');
        Route::get('central-indent/{id}/part-lists', 'IndentController@CIPartList')->name('indents.partList');
        Route::post('central-indent/{id}/change-status', 'IndentController@changeStatus')->name('indents.statusChange');
        Route::post('central-indent/{id}/approved-status', 'IndentController@approved')->name('indents.approved');

    });


    // Main Engineer routes
    Route::group(['as' => 'mainEngineer.', 'prefix' => 'main-engineer', 'namespace' => 'MainEngineer', 'middleware' => 'role:me'], function () {
        Route::get('dashboard', 'DashboardController')->name('dashboard');
        Route::get('indents', 'IndentController@index')->name('indents.index');
        Route::get('indents/{id}', 'IndentController@show')->name('indents.show');
        Route::post('indents/{id}/status', 'IndentController@status')->name('indents.status');
        Route::post('indents/{id}/approve-for-central-indent-generate', 'IndentController@forCentral')->name('indents.approved.forCentral');
        Route::get('all-approved-for-central-indent-generate', 'IndentController@updateAllForCentral')->name('allApproved.forCentral');
        Route::get('all-reject-for-central-indent-generate', 'IndentController@RejectAllForCentral')->name('allReject.forCentral');
        Route::get('indents/{indent}/export', 'IndentController@createPDF')->name('indents.export');





        // central incdent 
        Route::get('central/indent/pdf/{id}', 'IndentController@pdf')->name('indents.pdf');
        Route::post('central/indent/{part_id}/requisition-update/{central_indent_id}', 'IndentController@requisitionUpdate')->name('indents.requisitionUpdate');
        Route::get('central-indent/generate', 'IndentController@manufactureList')->name('indents.manufactureList');
        Route::get('central-indent/{id}/part-lists', 'IndentController@CIPartList')->name('indents.partList');
        Route::post('central-indent/{id}/change-status', 'IndentController@changeStatus')->name('indents.statusChange');
        Route::post('central-indent/{id}/approved-status', 'IndentController@approved')->name('indents.approved');
        Route::post('central-indent/{id}/final-approved', 'IndentController@finalApproved')->name('indents.finalApproved');
        
        //srb
        Route::get('srb', 'SRBController@index')->name('srb.index');
        Route::get('srb/{id}/show', 'SRBController@show')->name('srb.show');
        Route::post('srb/{srb}/change-status', 'SRBController@changeStatus')->name('srb.changeStatus');
    });

    // Central Engineer routes
    Route::group(['as' => 'centralEngineer.', 'prefix' => 'central-engineer', 'namespace' => 'CentralEngineer', 'middleware' => 'role:central-engineer'], function () {
        Route::get('dashboard', 'DashboardController')->name('dashboard');
        Route::get('indents', 'IndentController@index')->name('indents.index');
        Route::get('indents/{id}', 'IndentController@show')->name('indents.show');
        Route::post('indents/{id}/status', 'IndentController@status')->name('indents.status');
        Route::get('indents/{indent}/export', 'IndentController@createPDF')->name('indents.export');


        // central indent 
        Route::post('central/indent', 'IndentController@generateCentralIndent')->name('indents.central');
        Route::get('central/indent/pdf/{id}', 'IndentController@pdf')->name('indents.pdf');
        Route::post('central/indent/{part_id}/requisition-update/{central_indent_id}', 'IndentController@requisitionUpdate')->name('indents.requisitionUpdate');
        Route::get('central-indent/generate', 'IndentController@manufactureList')->name('indents.manufactureList');
        Route::get('central-indent/{id}/part-lists', 'IndentController@CIPartList')->name('indents.partList');
        Route::post('central-indent/{id}/change-status', 'IndentController@changeStatus')->name('indents.statusChange');
        Route::post('central-indent/{id}/approved-status', 'IndentController@approved')->name('indents.approved');
        Route::post('central-indent/{id}/final-approved', 'IndentController@finalApproved')->name('indents.finalApproved');

        //srb
        Route::get('srb', 'SRBController@index')->name('srb.index');
        Route::get('srb/{id}/show', 'SRBController@show')->name('srb.show');
        Route::post('srb/{srb}/change-status', 'SRBController@changeStatus')->name('srb.changeStatus');
    });

    
    // SE routes
    Route::group(['as' => 'SE.', 'prefix' => 'se', 'namespace' => 'SE', 'middleware' => 'role:se'], function () {
        Route::get('dashboard', 'DashboardController')->name('dashboard');
        
        // central indent 
        Route::get('central/indent/pdf/{id}', 'IndentController@pdf')->name('indents.pdf');
        Route::post('central/indent/{part_id}/requisition-update/{central_indent_id}', 'IndentController@requisitionUpdate')->name('indents.requisitionUpdate');
        Route::get('central-indent/generate', 'IndentController@manufactureList')->name('indents.manufactureList');
        Route::get('central-indent/{id}/part-lists', 'IndentController@CIPartList')->name('indents.partList');
        Route::post('central-indent/{id}/change-status', 'IndentController@changeStatus')->name('indents.statusChange');
        Route::post('central-indent/{id}/approved-status', 'IndentController@approved')->name('indents.approved');

    });

    // DSE routes
    Route::group(['as' => 'DSE.', 'prefix' => 'dse', 'namespace' => 'DSE', 'middleware' => 'role:dse'], function () {
        Route::get('dashboard', 'DashboardController')->name('dashboard');
        Route::get('indents', 'IndentController@index')->name('indents.index');
        Route::get('indents/{id}', 'IndentController@show')->name('indents.show');
        Route::post('indents/{id}/status', 'IndentController@status')->name('indents.status');
        Route::get('indents/{indent}/export', 'IndentController@createPDF')->name('indents.export');

        // central indent 
        Route::post('central/indent', 'IndentController@generateCentralIndent')->name('indents.central');
        Route::get('central/indent/{id}/stationwise-quantity', 'IndentController@stationwiseQuantity')->name('indents.stationwise.quantity');
        Route::get('central/indent/pdf/{id}', 'IndentController@pdf')->name('indents.pdf');
        Route::get('central/indent/report1/{id}', 'IndentController@report1')->name('indents.report1');
        Route::post('central/indent/{part_id}/requisition-update/{central_indent_id}', 'IndentController@requisitionUpdate')->name('indents.requisitionUpdate');
        Route::get('central-indent/generate', 'IndentController@manufactureList')->name('indents.manufactureList');
        Route::get('central-indent/{id}/part-lists', 'IndentController@CIPartList')->name('indents.partList');
        Route::post('central-indent/{id}/change-status', 'IndentController@changeStatus')->name('indents.statusChange');
        Route::post('central-indent/{id}/approved-status', 'IndentController@approved')->name('indents.approved');

    });

    // Intent Officer routes
    Route::group(['as' => 'intentOfficer.', 'prefix' => 'intent-officer', 'namespace' => 'IntentOfficer', 'middleware' => 'role:intent-officer'], function () {
        Route::get('dashboard', 'DashboardController')->name('dashboard');
        Route::post('indents/{indentId}/product', 'IndentController@addNewProduct')->name('indents.addNewProduct');
        Route::delete('indents/{indentId}/product/{productId}', 'IndentController@deleteProduct')->name('indents.product.delete');
        Route::post('indents/{indentId}/change-status', 'IndentController@changeStatus')->name('indents.changeStatus');
        Route::resource('indents', 'IndentController');
//        Route::get('indents/{indent}/export', 'IndentController@createPDF')->name('indents.export');
        Route::get('get-parts/{typeId}', 'IndentController@getParts')->name('getParts');
        Route::get('get-instruments/{typeId}', 'IndentController@getInstrument')->name('getInstrument');

        //stock

        Route::get('instruments/stock', 'StockInstrumentController@index')->name('stock.instruments');
        Route::get('parts/stock', 'StockPartController@index')->name('stock.parts');
        Route::get('stock/part/{partId}/instruments', 'StockPartController@stockPartInstrumentDetails')->name('sib.part.partInstruments');

        //srb
        Route::get('srb', 'SRBController@index')->name('srb.index');
        Route::post('srb', 'SRBController@store')->name('srb.store');
        Route::get('srb/{id}/edit', 'SRBController@edit')->name('srb.edit');
        Route::post('srb/{srb}/change-status', 'SRBController@changeStatus')->name('srb.changeStatus');

    });

    // Station Head routes
    Route::group(['as' => 'stationHead.', 'prefix' => 'station-head', 'namespace' => 'StationHead', 'middleware' => 'role:station-head'], function () {
        Route::get('dashboard', 'DashboardController')->name('dashboard');
        Route::get('indents', 'IndentController@index')->name('indents.index');
        Route::get('indents/{id}', 'IndentController@show')->name('indents.show');
        Route::post('indents/{id}/status', 'IndentController@status')->name('indents.status');

        //stock

        Route::get('instruments/stock', 'StockInstrumentController@index')->name('stock.instruments');
        Route::get('parts/stock', 'StockPartController@index')->name('stock.parts');
        Route::get('stock/part/{partId}/instruments', 'StockPartController@stockPartInstrumentDetails')->name('sib.part.partInstruments');
        //srb
        Route::get('srb', 'SRBController@index')->name('srb.index');
        Route::get('srb/{id}/show', 'SRBController@show')->name('srb.show');
        Route::post('srb/{srb}/change-status', 'SRBController@changeStatus')->name('srb.changeStatus');

        //sib
        Route::get('sib', 'SibController@index')->name('sib.index');
        Route::get('sib/{id}/show', 'SibController@show')->name('sib.show');
        Route::post('sib/{sib}/change-status', 'SibController@changeStatus')->name('sib.changeStatus');
        Route::get('sib/part/instrument-details/{id}', 'SibController@stockPartInstrumentDetails')->name('sib.part.instruments');
    });

    // Station Incharge routes
    Route::group(['as' => 'stationIncharge.', 'prefix' => 'station-incharge', 'namespace' => 'StationIncharge', 'middleware' => 'role:station-incharge'], function () {
        Route::get('dashboard', 'DashboardController')->name('dashboard');
        Route::get('indents', 'IndentController@index')->name('indents.index');
        Route::get('indents/{id}', 'IndentController@show')->name('indents.show');
        Route::post('indents/{id}/status', 'IndentController@status')->name('indents.status');
        //stock

        Route::get('instruments/stock', 'StockInstrumentController@index')->name('stock.instruments');
        Route::get('parts/stock', 'StockPartController@index')->name('stock.parts');
        Route::get('stock/part/{partId}/instruments', 'StockPartController@stockPartInstrumentDetails')->name('sib.part.partInstruments');

        //srb
        Route::get('srb', 'SRBController@index')->name('srb.index');
        Route::get('srb/{id}/show', 'SRBController@show')->name('srb.show');
        Route::post('srb/{srb}/change-status', 'SRBController@changeStatus')->name('srb.changeStatus');

        //sib
        Route::get('sib', 'SibController@index')->name('sib.index');
        Route::get('sib/{id}/show', 'SibController@show')->name('sib.show');
        Route::post('sib/{sib}/change-status', 'SibController@changeStatus')->name('sib.changeStatus');
        Route::get('sib/part/instrument-details/{id}', 'SibController@stockPartInstrumentDetails')->name('sib.part.instruments');
    });

    // Storekeeper routes
    Route::group(['as' => 'storekeeper.', 'prefix' => 'storekeeper', 'namespace' => 'Storekeeper', 'middleware' => 'role:storekeeper'], function () {
        Route::get('dashboard', 'DashboardController')->name('dashboard');

        //Srb

        Route::get('srb', 'SRBController@index')->name('srb.index');
        Route::post('srb', 'SRBController@store')->name('srb.store');
        Route::get('srb/{id}/edit', 'SRBController@edit')->name('srb.edit');
        Route::get('srb/{id}/show', 'SRBController@show')->name('srb.show');
//        Route::get('srb/{srb}/export', 'SRBController@createPDF')->name('srb.export');
        Route::get('srb/{srb}/stock/adjust', 'SRBController@adjust')->name('srb.adjust');
        Route::post('indents/{srb}/change-status', 'SRBController@changeStatus')->name('srb.changeStatus');
        Route::delete('srb/{id}/destroy', 'SRBController@destroy')->name('srb.destroy');
        Route::post('srb/{srb}/instrument/{instrument}/store', 'SrbInstrumentController@instrumentStore')->name('srb.instrument.store');
        Route::post('srb/{srb}/parts/{part}/store', 'SrbInstrumentController@partStore')->name('srb.part.store');
        //stock

        Route::get('instruments/stock', 'StockInstrumentController@index')->name('stock.instruments');
        Route::get('parts/stock', 'StockPartController@index')->name('stock.parts');
        Route::get('stock/part/{partId}/instruments', 'StockPartController@stockPartInstrumentDetails')->name('sib.part.partInstruments');


        //Sib
        Route::get('sib', 'SibController@index')->name('sib.index');
        Route::post('sib', 'SibController@store')->name('sib.store');
        Route::get('sib/{id}/edit', 'SibController@edit')->name('sib.edit');
        Route::get('sib/{id}/show', 'SibController@show')->name('sib.show');
        Route::get('sib/{sib}/stock/adjust', 'SibController@adjust')->name('sib.adjust');
        Route::get('sib/{sib}/export', 'SibController@createPDF')->name('sib.export');
        Route::post('sibs/{sibId}/change-status', 'SibController@changeStatus')->name('sib.changeStatus');
        Route::delete('sib/{id}/destroy', 'SibController@destroy')->name('sib.destroy');
        Route::get('damage', 'SibController@damage')->name('sib.damage');
        Route::post('damage/quantity/update', 'SibController@damageAction')->name('sib.damage.update');

        Route::post('sibs/{sibId}/product', 'SibController@addNewProduct')->name('sib.addNewProduct');
        Route::delete('sibs/{sibId}/product/{productId}', 'SibController@deleteProduct')->name('sib.product.delete');

        Route::put('sibs/update/instrument/quantity/{sibInstrument}', 'SibInstrumentController@updateQuantity')->name('sib.instrument.quantity.update');
        Route::put('sibs/update/part/quantity/{sibPart}', 'SibPartController@updateQuantity')->name('sib.parts.quantity.update');
        Route::get('sib/part/instrument-details/{id}', 'SibController@stockPartInstrumentDetails')->name('sib.part.instruments');
        Route::post('sib/part/{partId}/add-instrument', 'SibController@addInstrumentToPart')->name('sib.part.addInstruments');
        Route::delete('sib/part/{partId}/delete-instrument', 'SibController@deleteInstrumentFromPart')->name('sib.part.deleteInstruments');
    });

    //share

    Route::get('instruments/national_stock', 'ShareInstrumentController@index')->name('share.instruments');
    Route::get('parts/national_stock', 'SharePartController@index')->name('share.parts');
    Route::get('parts/part/{partId}/instruments', 'SharePartController@stockPartInstrumentDetails')->name('sib.part.partInstruments');

    // Global routes
    Route::group(['as' => 'intentOfficer.', 'prefix' => 'intent-officer', 'namespace' => 'IntentOfficer'], function () {
        Route::get('indents/{indent}/export', 'IndentController@createPDF')->name('indents.export');
    });

    Route::group(['as' => 'storekeeper.', 'prefix' => 'storekeeper', 'namespace' => 'Storekeeper'], function () {
        Route::get('srb/{srb}/export', 'SRBController@createPDF')->name('srb.export');
        Route::get('sib/{sib}/export', 'SibController@createPDF')->name('sib.export');
    });
});

