<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChampionshipRequest;
use App\Http\Resources\Championships\ChampionshipResource;
use App\Http\Resources\Championships\ShowChampionshipResource;
use App\Models\Championship;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ChampionshipController extends Controller
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

        $championships = Championship::with(['teams'])->when($request->search, function ($query) use ($keyword) {
            $query->where('name', 'LIKE', '%' . $keyword . '%');
        })->when($sortName, function ($query) use ($sortDirection, $sortName) {
            $query->orderBy($sortName, $sortDirection);
        })->paginate($perPage);

        return response([
            'status' => 'success',
            'championships' => $championships
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ChampionshipRequest $request
     * @return Response
     */
    public function store(ChampionshipRequest $request)
    {
        $data = $request->validated();

        if($request->hasFile('logo')){
            $data['logo'] = uploadFile('/upload', $data['logo']);
        }

        Championship::create($data);

        return response([
            'status' => 'success',
        ]);

    }

    /**
     * Display the specified resource.
     *
     * @param Championship $championship
     * @return Response
     */
    public function show(Championship $championship)
    {
        $championship->load('teams.players');

        return response([
            'status' => 'success',
            'championship' => new ShowChampionshipResource($championship)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Championship $championship
     * @return Response
     */
    public function edit(Championship $championship)
    {
        return response([
            'status' => 'success',
            'championship' => new ChampionshipResource($championship)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ChampionshipRequest $request
     * @param Championship $championship
     * @return Response
     */
    public function update(ChampionshipRequest $request, Championship $championship)
    {
        $data = $request->validated();

        if($request->hasFile('logo')){
            deleteFile($championship->logo);
            $data['logo'] = uploadFile('/upload', $data['logo']);
        }

        $championship->update($data);

        return response([
            'status' => 'success',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Championship $championship
     * @return Response
     */
    public function destroy(Championship $championship)
    {
        if (\request()->user()->cannot('delete', Championship::class)) {
            return response([
                'status' => 'fail',
                'message' => "You don't have permission",
            ], 403);
        }

        deleteFile($championship->logo);
        $championship->delete();

        return response([
            'status' => 'success',
        ]);
    }
}
