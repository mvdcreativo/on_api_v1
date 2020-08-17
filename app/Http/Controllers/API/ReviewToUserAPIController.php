<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateReviewToUserAPIRequest;
use App\Http\Requests\API\UpdateReviewToUserAPIRequest;
use App\Models\ReviewToUser;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class ReviewToUserController
 * @package App\Http\Controllers\API
 */

class ReviewToUserAPIController extends AppBaseController
{
    /**
     * Display a listing of the ReviewToUser.
     * GET|HEAD /reviewToUsers
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $query = ReviewToUser::query();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $reviewToUsers = $query->get();

        return $this->sendResponse($reviewToUsers->toArray(), 'Review To Users retrieved successfully');
    }

    /**
     * Store a newly created ReviewToUser in storage.
     * POST /reviewToUsers
     *
     * @param CreateReviewToUserAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateReviewToUserAPIRequest $request)
    {
        $input = $request->all();

        /** @var ReviewToUser $reviewToUser */
        $reviewToUser = ReviewToUser::create($input);

        return $this->sendResponse($reviewToUser->toArray(), 'Review To User saved successfully');
    }

    /**
     * Display the specified ReviewToUser.
     * GET|HEAD /reviewToUsers/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var ReviewToUser $reviewToUser */
        $reviewToUser = ReviewToUser::find($id);

        if (empty($reviewToUser)) {
            return $this->sendError('Review To User not found');
        }

        return $this->sendResponse($reviewToUser->toArray(), 'Review To User retrieved successfully');
    }

    /**
     * Update the specified ReviewToUser in storage.
     * PUT/PATCH /reviewToUsers/{id}
     *
     * @param int $id
     * @param UpdateReviewToUserAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateReviewToUserAPIRequest $request)
    {
        /** @var ReviewToUser $reviewToUser */
        $reviewToUser = ReviewToUser::find($id);

        if (empty($reviewToUser)) {
            return $this->sendError('Review To User not found');
        }

        $reviewToUser->fill($request->all());
        $reviewToUser->save();

        return $this->sendResponse($reviewToUser->toArray(), 'ReviewToUser updated successfully');
    }

    /**
     * Remove the specified ReviewToUser from storage.
     * DELETE /reviewToUsers/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var ReviewToUser $reviewToUser */
        $reviewToUser = ReviewToUser::find($id);

        if (empty($reviewToUser)) {
            return $this->sendError('Review To User not found');
        }

        $reviewToUser->delete();

        return $this->sendSuccess('Review To User deleted successfully');
    }
}
