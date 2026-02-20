<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PlaylistController extends Controller
{
    public function generateM3U()
    {
        $songs = [
            '/music/song1.mp3',
            '/music/song2.mp3',
            '/music/song3.mp3'
        ];

        $content = "#EXTM3U\n";

        foreach ($songs as $song) {
            $content .= $song . "\n";
        }

        Storage::disk('public')->put('playlist.m3u', $content);

        return response()->json([
            'status' => 'success',
            'message' => 'Playlist generated successfully'
        ]);
    }
}