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

Route::get('api/agora/token/{uid}', function ($uid) {
    $appID = config('credentials.agora.app_id');
    $appCertificate = config('credentials.agora.app_certificate');
    $channelName = 'testChannel';
    $currentTimestamp = time();
    $expireTimeInSeconds = 36000000;
    $currentTimestamp = time();
    $privilegeExpiredTs = $currentTimestamp + $expireTimeInSeconds;

    $token = RtmTokenBuilder::buildToken($appID, $appCertificate, $uid, 1, $privilegeExpiredTs);
    return response()->json([
        'token' => $token,
        'uid' => $uid,
        'channelName' => $channelName,
        'appID' => $appID,
    ]);
});