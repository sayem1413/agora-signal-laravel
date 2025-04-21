<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use BoogieFromZk\AgoraToken\RtcTokenBuilder2;
use BoogieFromZk\AgoraToken\RtmTokenBuilder;
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
        $channel = 'channel654654687';
        $uid = '654654687';
        $role = RtcTokenBuilder2::ROLE_PUBLISHER;
        $expireTimeInSeconds = 3600000;
        $currentTimestamp = time();
        $privilegeExpiredTs = $currentTimestamp + $expireTimeInSeconds;

        $rtm_token = RtcTokenBuilder2::buildTokenWithUserAccount(
            $this->app_id, 
            $this->app_certificate, 
            (string) $channel, 
            (string) $uid, 
            $role, 
            $privilegeExpiredTs
        );

        /* $rtm_token = RtmTokenBuilder2::buildToken(
            $this->app_id,
            $this->app_certificate,
            $uid,
            $role,
            $privilegeExpiredTs
        ); */

        $response = [
            'rtm_token' => $rtm_token,
            'channel' => (string) $channel,
            'u_id' => (string) $uid,
        ];
        return response()->json([
            'data' => $response,
        ]);
    }

    public function getAgoraRtmTokenByUid ($uid)
    {
        if (!preg_match('/^[a-zA-Z0-9_-]{1,64}$/', $uid)) {
            return response()->json(['error' => 'Invalid UID'], 400);
        }
        $appID = config('credentials.agora.app_id');
        $appCertificate = config('credentials.agora.app_certificate');
        $expireTimeInSeconds = 3600;
        $currentTimestamp = time();
        $privilegeExpiredTs = $currentTimestamp + $expireTimeInSeconds;
    
        /* $token = RtmTokenBuilder2::buildToken(
            $appID,
            $appCertificate,
            $uid,
            $privilegeExpiredTs
        ); */
    
        $role = RtcTokenBuilder2::ROLE_PUBLISHER;
        $expireTimeInSeconds = 3600000;
        $currentTimestamp = time();
        $privilegeExpiredTs = $currentTimestamp + $expireTimeInSeconds;
    
        /* $token = RtcTokenBuilder2::buildTokenWithUserAccount(
            $appID, 
            $appCertificate, 
            (string) 'testChannel', 
            (string) $uid, 
            $role, 
            $privilegeExpiredTs
        ); */

        $token = RtcTokenBuilder2::buildTokenWithRtm(
            $appID, 
            $appCertificate, 
            (string) 'testChannel', 
            (string) $uid, 
            $role, 
            $privilegeExpiredTs
        );
    
        return response()->json([
            'token' => $token,
            'uid' => $uid,
            'channelName' => 'testChannel',
            'appID' => $appID,
        ]);
    }
}
