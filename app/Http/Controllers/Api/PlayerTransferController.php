<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PlayerTransferRequest;
use App\Models\Player;
use App\Models\PlayerTransfer;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PlayerTransferController extends Controller
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

        $playerTransfers = PlayerTransfer::with(['player', 'fromTeam', 'toTeam'])
            ->when($request->search, function ($query) use ($keyword) {
                $query->whereHas('player', function ($query) use ($keyword) {
                    $query->where('name', 'LIKE', '%' . $keyword . '%')
                        ->orWhere('surname', 'LIKE', '%' . $keyword . '%');
                });
            })->when($sortName, function ($query) use ($sortDirection, $sortName) {
                $query->orderBy($sortName, $sortDirection);
            })->paginate($perPage);

        return response([
            'status' => 'success',
            'player_transfers' => $playerTransfers
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
            'players' => Player::all(),
            'teams' => Team::all(['id', 'name'])
        ]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param PlayerTransferRequest $request
     * @return Response
     */
    public function store(PlayerTransferRequest $request)
    {
        $data = $request->validated();

        \PLayerTransfer::transfer($data);

        return response([
            'status' => 'success',
        ]);

    }
}
