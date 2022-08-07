<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TeamRequest;
use App\Http\Resources\Teams\ShowTeamResource;
use App\Http\Resources\Teams\TeamResource;
use App\Models\Championship;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TeamController extends Controller
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

        $teams = Team::with(['championship', 'players'])->when($request->search, function ($query) use ($keyword) {
            $query->where('name', 'LIKE', '%' . $keyword . '%');
        })->when($sortName, function ($query) use ($sortDirection, $sortName) {
            $query->orderBy($sortName, $sortDirection);
        })->paginate($perPage);

        return response([
            'status' => 'success',
            'teams' => $teams
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
            'championships' => Championship::all(['id', 'name'])
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param TeamRequest $request
     * @return Response
     */
    public function store(TeamRequest $request)
    {
        $data = $request->validated();

        Team::create($data);

        return response([
            'status' => 'success',
        ]);

    }

    /**
     * Display the specified resource.
     *
     * @param Team $team
     * @return Response
     */
    public function show(Team $team)
    {
        $team->load(['championship', 'players']);

        return response([
            'status' => 'success',
            'team' => new ShowTeamResource($team)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Team $team
     * @return Response
     */
    public function edit(Team $team)
    {
        return response([
            'status' => 'success',
            'team' => new TeamResource($team),
            'championships' => Championship::all(['id', 'name'])
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param TeamRequest $request
     * @param Team $team
     * @return Response
     */
    public function update(TeamRequest $request, Team $team)
    {
        $data = $request->validated();

        $team->update($data);

        return response([
            'status' => 'success',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Team $team
     * @return Response
     */
    public function destroy(Team $team)
    {
        if (\request()->user()->cannot('delete', Team::class)) {
            return response([
                'status' => 'fail',
                'message' => "You don't have permission",
            ], 403);
        }

        $team->delete();

        return response([
            'status' => 'success',
        ]);
    }
}
