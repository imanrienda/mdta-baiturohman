Route::get('/tes-asset', function () {
    return [
        'asset' => asset('assets/dist/css/adminlte.min.css'),
        'secure_asset' => secure_asset('assets/dist/css/adminlte.min.css'),
    ];
});