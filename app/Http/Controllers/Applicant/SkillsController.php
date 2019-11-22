<?php

namespace App\Http\Controllers\Applicant;

use App\Model\Skill;
use App\Traits\SkillsTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SkillsController extends Controller
{
    use SkillsTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->createSkill(auth()->user(), $request->all());

        return response()->json([
            'success' => 'Skills has been updated.'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Skill $skill)
    {
        $this->authorize($skill);
        
        $this->createSkill(auth()->user(), $request->all());

        return response()->json([
            'success' => 'Skills has been updated.'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  App\Model\Skill $skill
     * @return \Illuminate\Http\Response
     */
    public function destroy(Skill $skill)
    {
        $this->deleteSkill($skill);
        
        return response()->json([
            'success' => 'Skill has been deleted.'
        ]);
    }
}
