<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Models\Activity;
use App\Models\FixedActivity;
use App\Models\ProcessProject;
use App\Models\Product;
use App\Models\Progress;
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
        $projects = Project::with(['customer','activities','activities.progress'])->get();
    
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
        'customer_id' => $request->get('customer_id'),
        'team_id' => null,
        'deadline' => $request->get('deadline'),
        'status' => 0,
        'product_id' => $request->get('product_id')
       ]);

       //Traer actividades de la empresa por default

       $fixedActivitiesEnterprise = FixedActivity::where('type',0)->get();

       foreach($fixedActivitiesEnterprise as $enterpriseActivity) {
            $defaultActivity = Activity::create([
                'project_id' => $project->id,
                'title' => $enterpriseActivity->title,
                'type' => 0
            ]);

            $progressDefaultActivity = Progress::create([
                'progressable_id' => $defaultActivity->id,
                'progressable_type' => 'App\Models\Activity',
                'percentage' => 0.0,
                'comment' => 'Sin comentarios'
            ]);
       }

       //Traer actividades del producto

       $fixedActivities = FixedActivity::where('product_id',$request->get('product_id'))->where('type', '!=', 0)->with('fixedTasks')->get();
       
       foreach($fixedActivities as $fixedActivity){
                $activity = Activity::create([
                    'project_id' => $project->id,
                    'title' => $fixedActivity->title,
                    'type' => 1
                ]);

                $progressActivity = Progress::create([
                    'progressable_id' => $activity->id,
                    'progressable_type' => 'App\Models\Activity',
                    'percentage' => 0.0,
                    'comment' => 'Sin comentarios'
                ]);

                foreach($fixedActivity->fixedTasks as $fixedTask){
                    $task = Task::create([
                        'activity_id' => $activity->id,
                        'type' => 0,
                        'title' => $fixedTask->title,
                        'status' => 0
                    ]);

                    $progressTask = Progress::create([
                        'progressable_id' => $task->id,
                        'progressable_type' => 'App\Models\Task',
                        'percentage' => 0.0,
                        'comment' => 'Sin comentarios'
                    ]);
                }
       }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $project = Project::where('id',$id)->with(['activities','activities.tasks','activities.tasks.progress'])->get();
        return response()->json($project);
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
