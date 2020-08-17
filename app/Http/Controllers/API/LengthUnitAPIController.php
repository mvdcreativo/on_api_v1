<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateLengthUnitAPIRequest;
use App\Http\Requests\API\UpdateLengthUnitAPIRequest;
use App\Models\LengthUnit;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class LengthUnitController
 * @package App\Http\Controllers\API
 */

class LengthUnitAPIController extends AppBaseController
{
    /**
     * Display a listing of the LengthUnit.
     * GET|HEAD /lengthUnits
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $query = LengthUnit::query();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $lengthUnits = $query->get();

        return $this->sendResponse($lengthUnits->toArray(), 'Length Units retrieved successfully');
    }

    /**
     * Store a newly created LengthUnit in storage.
     * POST /lengthUnits
     *
     * @param CreateLengthUnitAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateLengthUnitAPIRequest $request)
    {
        $input = $request->all();

        /** @var LengthUnit $lengthUnit */
        $lengthUnit = LengthUnit::create($input);

        return $this->sendResponse($lengthUnit->toArray(), 'Length Unit saved successfully');
    }

    /**
     * Display the specified LengthUnit.
     * GET|HEAD /lengthUnits/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var LengthUnit $lengthUnit */
        $lengthUnit = LengthUnit::find($id);

        if (empty($lengthUnit)) {
            return $this->sendError('Length Unit not found');
        }

        return $this->sendResponse($lengthUnit->toArray(), 'Length Unit retrieved successfully');
    }

    /**
     * Update the specified LengthUnit in storage.
     * PUT/PATCH /lengthUnits/{id}
     *
     * @param int $id
     * @param UpdateLengthUnitAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateLengthUnitAPIRequest $request)
    {
        /** @var LengthUnit $lengthUnit */
        $lengthUnit = LengthUnit::find($id);

        if (empty($lengthUnit)) {
            return $this->sendError('Length Unit not found');
        }

        $lengthUnit->fill($request->all());
        $lengthUnit->save();

        return $this->sendResponse($lengthUnit->toArray(), 'LengthUnit updated successfully');
    }

    /**
     * Remove the specified LengthUnit from storage.
     * DELETE /lengthUnits/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var LengthUnit $lengthUnit */
        $lengthUnit = LengthUnit::find($id);

        if (empty($lengthUnit)) {
            return $this->sendError('Length Unit not found');
        }

        $lengthUnit->delete();

        return $this->sendSuccess('Length Unit deleted successfully');
    }
}
