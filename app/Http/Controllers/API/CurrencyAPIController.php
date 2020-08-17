<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateCurrencyAPIRequest;
use App\Http\Requests\API\UpdateCurrencyAPIRequest;
use App\Models\Currency;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class CurrencyController
 * @package App\Http\Controllers\API
 */

class CurrencyAPIController extends AppBaseController
{
    /**
     * Display a listing of the Currency.
     * GET|HEAD /currencies
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $query = Currency::query();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $currencies = $query->get();

        return $this->sendResponse($currencies->toArray(), 'Currencies retrieved successfully');
    }

    /**
     * Store a newly created Currency in storage.
     * POST /currencies
     *
     * @param CreateCurrencyAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateCurrencyAPIRequest $request)
    {
        $input = $request->all();

        /** @var Currency $currency */
        $currency = Currency::create($input);

        return $this->sendResponse($currency->toArray(), 'Currency saved successfully');
    }

    /**
     * Display the specified Currency.
     * GET|HEAD /currencies/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Currency $currency */
        $currency = Currency::find($id);

        if (empty($currency)) {
            return $this->sendError('Currency not found');
        }

        return $this->sendResponse($currency->toArray(), 'Currency retrieved successfully');
    }

    /**
     * Update the specified Currency in storage.
     * PUT/PATCH /currencies/{id}
     *
     * @param int $id
     * @param UpdateCurrencyAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCurrencyAPIRequest $request)
    {
        /** @var Currency $currency */
        $currency = Currency::find($id);

        if (empty($currency)) {
            return $this->sendError('Currency not found');
        }

        $currency->fill($request->all());
        $currency->save();

        return $this->sendResponse($currency->toArray(), 'Currency updated successfully');
    }

    /**
     * Remove the specified Currency from storage.
     * DELETE /currencies/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Currency $currency */
        $currency = Currency::find($id);

        if (empty($currency)) {
            return $this->sendError('Currency not found');
        }

        $currency->delete();

        return $this->sendSuccess('Currency deleted successfully');
    }
}
