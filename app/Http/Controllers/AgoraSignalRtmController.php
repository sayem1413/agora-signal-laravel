<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use BoogieFromZk\AgoraToken\RtcTokenBuilder2;
use BoogieFromZk\AgoraToken\RtmTokenBuilder2;
use BoogieFromZk\AgoraToken\RtcTokenBuilder;

class AgoraSignalRtmController extends Controller
{

    public $app_id;
    public $lifetime;
    public $app_certificate;
    public $app_name;
    public $org_name;
    public $app_url;

    public function __construct()
    {
        $this->app_id = config('credentials.agora.app_id');
        $this->lifetime = config('credentials.agora.lifetime');
        $this->app_certificate = config('credentials.agora.app_certificate');
        $this->org_name = config('credentials.agora.org_name');
        $this->app_name = config('credentials.agora.app_name');
        $this->app_url = config('credentials.agora.app_url');
    }

    public function getAgoraRtmData()
    {
        $channel = 'channel_' . Str::random(8);
        $uid = mt_rand(1000000, 9999999);
        $role = RtcTokenBuilder2::ROLE_PUBLISHER;
        $expireTimeInSeconds = 3600;
        $currentTimestamp = time();
        $privilegeExpiredTs = $currentTimestamp + $expireTimeInSeconds;

        $rtm_token = RtcTokenBuilder2::buildTokenWithUserAccount($this->app_id, $this->app_certificate, $channel, $uid, $role, $privilegeExpiredTs);

        $response = [
            'rtm_token' => $rtm_token,
            'channel' => $channel,
            'u_id' => $uid,
        ];
        return response()->json([
            'status' => true,
            'message' => 'Fetched',
            'errors' => null,
            'data' => $response,
        ]);
    }
}
