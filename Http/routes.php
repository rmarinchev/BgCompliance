<?php

/*
|--------------------------------------------------------------------------
| Module Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for the module.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::group(['middleware' => ['web'], 'prefix' => 'bgcompliance', 'namespace' => 'Modules\BgCompliance\Http\Controllers'], function () {
    // Debug route to test the module
    Route::get('/debug', function () {
        return response()->json([
            'message' => 'BgCompliance module is loaded and working!',
            'timestamp' => now(),
            'test_transformer' => class_exists('\Modules\BgCompliance\Transformers\InvoiceTransformerWithWords'),
            'test_bulgarian_converter' => class_exists('\Modules\BgCompliance\Services\BulgarianNumberToWords'),
            'test_conversion' => \Modules\BgCompliance\Services\BulgarianNumberToWords::convert(125),
        ]);
    });

    // Test transformer binding
    Route::get('/test-binding', function () {
        $transformer = app(\App\Transformers\InvoiceTransformer::class);
        return response()->json([
            'bound_class' => get_class($transformer),
            'is_custom' => $transformer instanceof \Modules\BgCompliance\Transformers\InvoiceTransformerWithWords,
            'expected_class' => \Modules\BgCompliance\Transformers\InvoiceTransformerWithWords::class,
        ]);
    });
});