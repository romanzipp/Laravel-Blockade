<?php

use romanzipp\Blockade\Http\Controllers\ValidatePasswordController;

\Route::prefix(config('blockade.routes.prefix'))
    ->middleware(config('blockade.routes.middleware'))
    ->group(function () {
        \Route::post('', ValidatePasswordController::class)->name('blockade.validate');
    });
