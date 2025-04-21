<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\AgoraSignalRtmController;
use BoogieFromZk\AgoraToken\RtcTokenBuilder2;
use BoogieFromZk\AgoraToken\RtmTokenBuilder;
use BoogieFromZk\AgoraToken\RtmTokenBuilder2;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';

Route::get('api/agora-rtm-data', [AgoraSignalRTMController::class, 'getAgoraRtmData'])->name('agora-rtm-data');

Route::get('api/agora/rtm-token-by-uid/{uid}', [AgoraSignalRTMController::class, 'getAgoraRtmTokenByUid'])->name('agora-rtm-data');