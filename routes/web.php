<?php

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

Route::get('/', ['domain' => 'laravel.dev', function () {
    return view('welcome');
}])->name('index');

Route::match(['get', 'post'], '/about', ['domain' => 'laravel.dev', function () {
    return view('welcome');
}])->name('page.about');

Route::get('/console/email/log', function (\Illuminate\Http\Request $request) {
    $email = $request->get('email', ['anggadarkprince@gmail.com']);
    $password = $request->get('password', '');
    $queue = $request->get('queue', true);

    // $exitCode = Artisan::queue('email:send', [
    $exitCode = Artisan::call('email:log', [
        'email' => $email, '--queue' => $queue, '--password' => $password, '--noconfirm' => true
    ]);

    return "All logger email was sent to admins! exit code {$exitCode}";
});

Route::get('/secret', function (\Illuminate\Http\Request $request) {
    $encrypted = encrypt($request->all());
    try {
        $decrypted = decrypt($encrypted);
    } catch (DecryptException $e) {
        return $e->getMessage();
    }

    return [
        'data' => $request->all(),
        'encrypt' => $encrypted,
        'decrypt' => $decrypted,
    ];
});

Route::get('/helper', ['uses' => 'HelperController']);
Route::get('/collection', ['uses' => 'CollectionController']);

// Download Route
Route::get('download/{filename}', function ($filename) {
    // Check if file exists in app/storage/file folder
    $file_path = storage_path() . '/logs/' . $filename;
    if (file_exists($file_path)) {
        // Send Download
        return Response::download($file_path, $filename, [
            'Content-Length: ' . filesize($file_path)
        ]);
    } else {
        // Error
        exit('Requested file does not exist on our server!');
    }
})->where('filename', '[A-Za-z0-9\-\_\.]+');

Route::group(['domain' => 'laravel.dev'], function () {
    Route::get('/explore', [
        'as' => 'page.explore',
        'uses' => 'PageController@explore'
    ]);

    Route::get('/help', [
        'as' => 'page.help',
        'uses' => 'PageController@help'
    ]);

    Route::get('/tag/search/{query}', [
        'as' => 'tag.search',
        'uses' => 'TagController@searchTag'
    ]);

    Route::get('/search', [
        'as' => 'page.search',
        'uses' => 'SearchController@searchQuery'
    ]);

    Route::group(['prefix' => 'portfolio'], function () {
        Route::get('/company/{company}', [
            'as' => 'portfolio.search.company',
            'uses' => 'SearchController@searchByCompany'
        ]);

        Route::get('/category/{category}', [
            'as' => 'portfolio.search.category',
            'uses' => 'SearchController@searchByCategory'
        ]);

        Route::get('/tag/{tag}', [
            'as' => 'portfolio.search.tag',
            'uses' => 'SearchController@searchByTag'
        ]);
    });

    Route::group(['prefix' => '{user}'], function () {
        Route::get('/', [
            'as' => 'profile.show',
            'uses' => 'UserController@portfolio'
        ]);

        Route::get('/portfolio/{portfolio}', [
            'as' => 'profile.portfolio.show',
            'uses' => 'PortfolioController@show'
        ]);
    });
});

Route::group(['domain' => 'admin.laravel.dev', 'namespace' => 'Admin'], function () {
    // Authentication Routes...
    Route::get('login', 'Auth\LoginController@showLoginForm')->name('admin.login');
    Route::post('login', 'Auth\LoginController@login');
    Route::post('logout', 'Auth\LoginController@logout')->name('admin.logout');

    Route::get('/', function () {
        return redirect('dashboard');
    })->middleware('auth:admin');

    Route::post('/trash/empty', function () {
        App\Portfolio::onlyTrashed()->forceDelete();
        Cache::flush();
        return redirect('dashboard')->with([
            'action' => 'warning',
            'message' => 'All trashed data was deleted permanently'
        ]);
    })->middleware('auth:admin');

    Route::group(['middleware' => 'auth:admin'], function () {
        Route::get('dashboard', [
            'as' => 'admin.dashboard',
            'uses' => 'DashboardController',
            'middleware' => 'auth:admin'
        ]);

        Route::resource('users', 'UserController', [
            'names' => [
                'index' => 'admin.user',
                'create' => 'admin.user.create',
                'store' => 'admin.user.store',
                'edit' => 'admin.user.edit',
                'update' => 'admin.user.update',
                'show' => 'admin.user.show',
                'destroy' => 'admin.user.destroy'
            ]
        ]);

        Route::resource('portfolios', 'PortfolioController', [
            'names' => [
                'index' => 'admin.portfolio',
                'create' => 'admin.portfolio.create',
                'store' => 'admin.portfolio.store',
                'edit' => 'admin.portfolio.edit',
                'update' => 'admin.portfolio.update',
                'show' => 'admin.portfolio.show',
                'destroy' => 'admin.portfolio.destroy'
            ]
        ]);

        Route::resource('tags', 'TagController', [
            'only' => ['index', 'store', 'destroy'],
            'parameters' => [
                'tag' => 'id'
            ],
            'names' => [
                'index' => 'admin.tag',
                'store' => 'admin.tag.store',
                'destroy' => 'admin.tag.destroy'
            ]
        ]);

        Route::resource('categories', 'CategoryController', [
            'except' => ['show', 'create', 'edit', 'update'],
            'names' => [
                'index' => 'admin.category',
                'store' => 'admin.category.store',
                'destroy' => 'admin.category.destroy'
            ]
        ]);

        Route::any('contact', [
            'as' => 'admin.contact',
            'uses' => 'ContactController'
        ]);
    });
});

Route::group(['domain' => 'account.laravel.dev'], function () {
    // Auth::routes();

    // Authentication Routes...
    $this->get('login', 'Auth\LoginController@showLoginForm')->name('account.login');
    $this->post('login', 'Auth\LoginController@login');
    $this->post('logout', 'Auth\LoginController@logout')->name('account.logout');

    // Registration Routes...
    $this->get('register', 'Auth\RegisterController@showRegistrationForm')->name('account.register');
    $this->post('register', 'Auth\RegisterController@register');

    // Social Auth Github
    Route::get('login/github', 'OAuth\GithubController@redirectToProvider')->name('github.provider');
    Route::get('login/github/callback', 'OAuth\GithubController@handleProviderCallback')->name('github.callback');

    // Social Auth Twitter
    Route::get('login/twitter', 'OAuth\TwitterController@redirectToProvider')->name('twitter.provider');
    Route::get('login/twitter/callback', 'OAuth\TwitterController@handleProviderCallback')->name('twitter.callback');

    // Social Auth Facebook
    Route::get('login/facebook', 'OAuth\FacebookController@redirectToProvider')->name('facebook.provider');
    Route::get('login/facebook/callback', 'OAuth\FacebookController@handleProviderCallback')->name('facebook.callback');

    // Social Auth Google
    Route::get('login/google', 'OAuth\GoogleController@redirectToProvider')->name('google.provider');
    Route::get('login/google/callback', 'OAuth\GoogleController@handleProviderCallback')->name('google.callback');

    // Password Reset Routes...
    $this->get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm');
    $this->post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');
    $this->get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm');
    $this->post('password/reset', 'Auth\ResetPasswordController@reset');

    // Activation Route...
    Route::get('/activation/{token}', 'Auth\RegisterController@userActivation')->name('account.activation');

    // After Login Route...
    Route::get('/', [
        'as' => 'account.profile',
        'uses' => 'UserController@index'
    ]);

    Route::group(['prefix' => '{user}', 'middleware' => ['account', 'auth']], function () {
        Route::get('/', [
            'as' => 'account.show',
            'uses' => 'UserController@show'
        ]);

        Route::resource('portfolio', 'PortfolioController', [
            'names' => [
                'index' => 'account.portfolio',
                'show' => 'account.portfolio.show',
                'create' => 'account.portfolio.create',
                'edit' => 'account.portfolio.edit',
                'update' => 'account.portfolio.update',
                'store' => 'account.portfolio.store',
                'destroy' => 'account.portfolio.destroy'
            ]
        ]);

        Route::delete('/screenshot/delete/{screenshot}', [
            'as' => 'account.screenshot.destroy',
            'uses' => 'ScreenshotController@deleteScreenshot'
        ]);

        Route::get('/activities', [
            'as' => 'account.activity',
            'uses' => 'ActivityController@index'
        ]);

        Route::get('/developer', [
            'as' => 'account.developer',
            'uses' => 'DeveloperController@index'
        ]);

        Route::put('/settings', [
            'as' => 'account.settings.store',
            'uses' => 'UserController@storeSettings'
        ]);

        Route::get('/settings', [
            'as' => 'account.settings',
            'uses' => 'UserController@settings'
        ]);
    });
});