<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PlayerRequest;
use App\Http\Resources\Players\PlayerResource;
use App\Http\Resources\Players\ShowPlayerResource;
use App\Models\Player;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PlayerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $keyword = $request->search;
        $sortName = $request->sort_name;
        $sortDirection = $request->sort_direction ?: 'desc';
        $perPage = $request->per_page ?? 10;

        $players = Player::with(['team'])->when($request->search, function ($query) use ($keyword) {
            $query->where('name', 'LIKE', '%' . $keyword . '%')
                ->orWhere('surname', 'LIKE', '%' . $keyword . '%')
                ->orWhere('personal_number', 'LIKE', '%' . $keyword . '%');
        })->when($sortName, function ($query) use ($sortDirection, $sortName) {
            $query->orderBy($sortName, $sortDirection);
        })->paginate($perPage);

        return response([
            'status' => 'success',
            'players' => $players
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return response([
            'status' => 'success',
            'teams' => Team::all(['id', 'name']),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param PlayerRequest $request
     * @return Response
     */
    public function store(PlayerRequest $request)
    {
        $data = $request->validated();

        Player::create($data);

        return response([
            'status' => 'success',
        ]);

    }

    /**
     * Display the specified resource.
     *
     * @param Player $player
     * @return Response
     */
    public function show(Player $player)
    {
        $player->load(['team.championship']);

        return response([
            'status' => 'success',
            'player' => new ShowPlayerResource($player)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Player $player
     * @return Response
     */
    public function edit(Player $player)
    {
        return response([
            'status' => 'success',
            'player' => new PlayerResource($player),
            'teams' => Team::all(['id', 'name'])
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param PlayerRequest $request
     * @param Player $player
     * @return Response
     */
    public function update(PlayerRequest $request, Player $player)
    {
        $data = $request->validated();

        $player->update($data);

        return response([
            'status' => 'success',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Player $player
     * @return Response
     */
    public function destroy(Player $player)
    {

        if (\request()->user()->cannot('delete', Player::class)) {
            return response([
                'status' => 'fail',
                'message' => "You don't have permission",
            ], 403);
        }

        $player->delete();

        return response([
            'status' => 'success',
        ]);
    }
}
