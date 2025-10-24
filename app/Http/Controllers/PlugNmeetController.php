<?php

namespace App\Http\Controllers;

use App\Application\DTOs\PlugNmeet\CreateRoomDTO;
use App\Application\DTOs\PlugNmeet\JoinDTO;
use App\Application\UseCases\PlugNmeet\CreateRoom as CreateRoomUC;
use App\Application\UseCases\PlugNmeet\GetJoinToken as GetJoinTokenUC;
use App\Services\PlugnmeetService;
use Illuminate\Http\Request;
use Illuminate\View\View;

final class PlugNmeetController extends Controller
{
    public function create(PlugnmeetService $plug)
    {
        $data = [
            "room_id" => "room01",
            "name" => "Test Room",
            "max_participants" => 10,
            "recording" => false,
            "metadata" => [
                "room_title" => "My Test Room",
                "room_features" => [
                    "allow_screen_share" => true,
                    "allow_chat" => true,
                    "allow_file_upload" => true
                ]
            ]
        ];

        $res = $plug->createRoom($data);

        return response()->json($res);
    }

    public function join(PlugnmeetService $plug)
    {
        $res = $plug->getJoinToken();

        if ($res['status']) {
            return response()->json([
                'join_url' => config('plugnmeet.base_url') . '/?access_token=' . $res['token']
            ]);
        }

        return response()->json($res);
    }
}
