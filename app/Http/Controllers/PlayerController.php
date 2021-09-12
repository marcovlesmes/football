<?php

namespace App\Http\Controllers;

use App\Models\Nation;
use App\Models\Player;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

use function PHPSTORM_META\map;

class PlayerController extends Controller
{

    public function index()
    {
        return view('welcome');
    }

    public function search(Request $request)
    {
        if ($name = $request->query('search')) {
            $search = '%' . $name . '%';
            $order =  $request->query('order');
            $page =  $request->query('page');
            $players = Player::where('first_name', 'like', $search)
                            ->orWhere('last_name', 'like', $search)
                            ->orderBy('first_name', $order)
                            ->get();
        } else {
            $players = Player::get();
            $page = 1;
        }


        $response = collect([
            "Page" => $page,
            "totalPages" => $page,
            "Items" => $players->count(),
            "totalItems" => $players->count(),
            "Players" => $players->map(function ($player) {
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

    public function populate()
    {
        try {
            $url = 'https://www.easports.com/fifa/ultimate-team/api/fut/item';
            do {
                $page = 1;
                $response = Http::get($url, ['page' => $page]);
                $responseArr = $response->json();
                $pages = $responseArr['totalPages'];
                $items = $responseArr['items'];
                $registers = 0;
                
                foreach ($items as $player) {
                    
                    $nation = Nation::firstOrCreate([
                        'name' => $player['nation']['name']
                    ]);
        
                    $team = Team::firstOrCreate([
                        'name' => $player['club']['name']
                    ]);
                    
                    /*
                    Player::firstOrCreate([
                        'first_name' => $player['firstName'],
                        'last_name' => $player['lastName'],
                        'position' => $player['position'],
                        'nation_id' => $nation->id,
                        'team_id' => $team->id
                    ]);*/
                    
                    $reg_player = Player::where([
                        'first_name' => $player['firstName'],
                        'last_name' => $player['lastName'],
                        'position' => $player['position'],
                        'nation_id' => $nation->id,
                        'team_id' => $team->id
                    ])->first();

                    if (!$reg_player) {
                        $newPlayer = new Player();
                        $newPlayer->first_name = $player['firstName'];
                        $newPlayer->last_name = $player['lastName'];
                        $newPlayer->position = $player['position'];
                        $newPlayer->nation_id = $nation->id;
                        $newPlayer->team_id = $team->id;
                        $newPlayer->save();
                    }
                }
                $page++;
            } while ($page <= $pages);

        } catch (\Exception $exeption) {
            dd($exeption->getMessage());
        }

        return 'Registrados ' . $registers . ' jugadores';
    }
}
