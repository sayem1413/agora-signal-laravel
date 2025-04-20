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
    if (!preg_match('/^[a-zA-Z0-9_-]{1,64}$/', $uid)) {
        return response()->json(['error' => 'Invalid UID'], 400);
    }
    $appID = config('credentials.agora.app_id');
    $appCertificate = config('credentials.agora.app_certificate');
    $expireTimeInSeconds = 3600;
    $currentTimestamp = time();
    $privilegeExpiredTs = $currentTimestamp + $expireTimeInSeconds;

    $token = RtmTokenBuilder2::buildToken(
        $appID,
        $appCertificate,
        $uid,
        $privilegeExpiredTs // ✅ must be timestamp
    );

    return response()->json([
        'token' => $token,
        'uid' => $uid,
        'channelName' => 'testChannel',
        'appID' => $appID,
    ]);
});