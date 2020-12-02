<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\AppBaseController;
use App\Models\Neighborhood;
use Illuminate\Support\Str;

use Illuminate\Http\Request;

class NeighborhoodAPIController extends AppBaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Neighborhood::query();
        if ($request->get('per_page')) {
            $per_page = $request->get('per_page');
        }else{
            $per_page = 20;
        }
        
        if ($request->get('sort')) {
            $sort = $request->get('sort');
        }else{
            $sort = "desc";
        }

        if ($request->get('filter')) {
            $filter = $request->get('filter');
        }else{
            $filter = "";
        }

        $neighborhoods = $query
        ->with('city')
        ->filter($filter)
        ->orderBy('id', $sort)
        ->paginate($per_page);

        return $this->sendResponse($neighborhoods->toArray(), 'Neighborhood retrieved successfully');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();

        $input['slug'] = Str::slug($request->name);
        $neighborhood = Neighborhood::create($input);

        return $this->sendResponse($neighborhood->toArray(), 'Neighborhood saved successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $neighborhood = Neighborhood::find($id);

        if (empty($neighborhood)) {
            return $this->sendError('Neighborhood not found');
        }

        return $this->sendResponse($neighborhood->toArray(), 'Neighborhood retrieved successfully');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $neighborhood = Neighborhood::find($id);


        if($request->name) $request['slug'] = Str::slug($request->name);

        $neighborhood->fill($request->all());
        $neighborhood->save();

        return $this->sendResponse($neighborhood->toArray(), 'Neighborhood updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $neighborhood = Neighborhood::find($id);

        if (empty($neighborhood)) {
            return $this->sendError('Neighborhood not found');
        }

        $neighborhood->delete();
        return $this->sendResponse($neighborhood->toArray(), 'Neighborhood deleted successfully');
    }
}
