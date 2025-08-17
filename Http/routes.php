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
            'test_twig_extension' => class_exists('\Modules\BgCompliance\Extensions\BulgarianWordsExtension'),
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

    // Test Twig extension directly
    Route::get('/test-twig', function () {
        $extension = new \Modules\BgCompliance\Extensions\BulgarianWordsExtension();
        return response()->json([
            'test_125_bgn' => $extension->formatAmountInWords(125.50, 'BGN'),
            'test_1000_eur' => $extension->formatAmountInWords(1000.00, 'EUR'),
            'test_1_bgn' => $extension->formatAmountInWords(1.01, 'BGN'),
        ]);
    });
});