<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateAdquiredSkillAPIRequest;
use App\Http\Requests\API\UpdateAdquiredSkillAPIRequest;
use App\Models\AdquiredSkill;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;
use Illuminate\Support\Str;

/**
 * Class AdquiredSkillController
 * @package App\Http\Controllers\API
 */

class AdquiredSkillAPIController extends AppBaseController
{
    /**
     * Display a listing of the AdquiredSkill.
     * GET|HEAD /adquiredSkills
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $query = AdquiredSkill::query();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $adquiredSkills = $query->get();

        return $this->sendResponse($adquiredSkills->toArray(), 'Adquired Skills retrieved successfully');
    }

    /**
     * Store a newly created AdquiredSkill in storage.
     * POST /adquiredSkills
     *
     * @param CreateAdquiredSkillAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateAdquiredSkillAPIRequest $request)
    {
        $input = $request->all();

        /** @var AdquiredSkill $adquiredSkill */
        $input['slug'] = Str::slug($request->title);
        $adquiredSkill = AdquiredSkill::create($input);

        return $this->sendResponse($adquiredSkill->toArray(), 'Adquired Skill saved successfully');
    }

    /**
     * Display the specified AdquiredSkill.
     * GET|HEAD /adquiredSkills/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var AdquiredSkill $adquiredSkill */
        $adquiredSkill = AdquiredSkill::find($id);

        if (empty($adquiredSkill)) {
            return $this->sendError('Adquired Skill not found');
        }

        return $this->sendResponse($adquiredSkill->toArray(), 'Adquired Skill retrieved successfully');
    }

    /**
     * Update the specified AdquiredSkill in storage.
     * PUT/PATCH /adquiredSkills/{id}
     *
     * @param int $id
     * @param UpdateAdquiredSkillAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateAdquiredSkillAPIRequest $request)
    {
        /** @var AdquiredSkill $adquiredSkill */
        $adquiredSkill = AdquiredSkill::find($id);

        if (empty($adquiredSkill)) {
            return $this->sendError('Adquired Skill not found');
        }
        if($request->title) $request['slug'] = Str::slug($request->title);

        $adquiredSkill->fill($request->all());
        $adquiredSkill->save();

        return $this->sendResponse($adquiredSkill->toArray(), 'AdquiredSkill updated successfully');
    }

    /**
     * Remove the specified AdquiredSkill from storage.
     * DELETE /adquiredSkills/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var AdquiredSkill $adquiredSkill */
        $adquiredSkill = AdquiredSkill::find($id);

        if (empty($adquiredSkill)) {
            return $this->sendError('Adquired Skill not found');
        }

        $adquiredSkill->delete();
        return $this->sendResponse($adquiredSkill->toArray(), 'Adquired Skill deleted successfully');
 
    }
}
