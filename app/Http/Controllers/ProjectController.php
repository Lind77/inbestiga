<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Models\Activity;
use App\Models\FixedActivity;
use App\Models\ProcessProject;
use App\Models\Product;
use App\Models\Task;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects = Project::with(['progresses','progresses.activity','progresses.task','customer'])->get();
    
        return $projects;
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
     * @param  \App\Http\Requests\StoreProjectRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       $project =  Project::create([
        'title' => $request->get('title'),
        'team_id' => $request->get('team_id'),
        'customer_id' => $request->get('customer_id'),
        'deadline' => $request->get('deadline'),
        'status' => 0,
        'product_id' => $request->get('product_id')
       ]);

       //Traer actividades de la empresa por default

       $fixedActivitiesEnterprise = FixedActivity::where('type',0)->get();

       foreach($fixedActivitiesEnterprise as $enterpriseActivity) {
            $activity = Activity::create([
                'project_id' => $project->id,
                'title' => $enterpriseActivity->title,
                'type' => $enterpriseActivity->type
            ]);
       }

       //Traer actividades del producto

       $product = Product::where('id', $request->get('product_id'))->with(['fixedActivities','fixedActivities.fixedTasks'])->get();
       return response()->json([
        'msg' => $product[0]
       ]); 
       
       
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateProjectRequest  $request
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProjectRequest $request, Project $project)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        //
    }

    public function changeStatus(Request $request){
        $project = Project::find($request->get('project_id'));
        
        $project->update([
            'status' => $request->get('status')
        ]);
        return response()->json([
            'msg' => 'success'
        ]);
    }  
}
