<?php

namespace App\Enums;

enum Visibility: string
{
    case Public = 'public';
    case Private = 'private';
    case RoomOnly = 'room_only';
    case Friends = 'friends';
    case Custom = 'custom';
}
