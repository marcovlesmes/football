<?php

namespace App\Http\Controllers;

use App\Models\Team;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    public function search(Request $request)
    {
        $team = Team::where('name', 'like', '%' . $request->Name . '%')->first();

        $page = $request->Page ? $request->Page : 1;
        $response = collect([
            "Page" => $page,
            "totalPages" => $page,
            "Items" => $team->players->count(),
            "totalItems" => $team->players->count(),
            "Players" => $team->players->map(function ($player) {
                return [
                    'name' => $player->first_name . ' ' . $player->last_name,
                    'position' => $player->position,
                    'nation' => $player->nation->name,
                    'team' => $player->team->name
                ];
            })
        ]);
        
        return $response->toJson();
    }
}
