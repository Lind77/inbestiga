<?php

namespace App\Http\Controllers;

use App\Events\NewDirection;
use App\Events\NewProject;
use App\Models\Project;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Models\Activity;
use App\Models\Chat;
use App\Models\Customer;
use App\Models\FixedActivity;
use App\Models\Notification;
use App\Models\Order;
use App\Models\Price;
use App\Models\ProcessProject;
use App\Models\Product;
use App\Models\Progress;
use App\Models\Quotation;
use App\Models\Seen;
use App\Models\Task;
use App\Models\Team;
use App\Models\Time;
use App\Models\User;
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
        $projects = Project::orderBy('updated_at')->with(['customer', 'activities', 'activities.progresses', 'team', 'product'])->get();

        foreach ($projects as $project) {
            foreach ($project->activities as $activity) {
                if ($activity->progresses[0]->percentage == 100) {
                    $activity->isCompleted = true;
                } else {
                    $activity->isCompleted = false;
                }
            }
        }

        return $projects;
    }

    public function getAllProjectsAcad()
    {
        $projects = Project::with('team')->get();
        /* $numActivities = 0;
        $numTasks = 0;
        $numTasksCompleted = 0;

        foreach ($projects as $project) {
            foreach ($project->activities as $activity) {
                $numActivities++;
                foreach ($activity->tasks as $task) {
                    $numTasks++;
                    if ($task->status == 2) {
                        $numTasksCompleted++;
                    }
                }
            }
            $project->numActivities = $numActivities;
            $project->numTasks = $numTasks;
            $project->numTasksCompleted = $numTasksCompleted;
        } */

        return response()->json($projects);
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
            'product_id' => $request->get('product_id'),
            'level' => $request->get('level')
        ]);

        //Traer actividades de Inbestiga por default
        $fixedActivitiesEnterprise = FixedActivity::where('type', 0)->get();

        foreach ($fixedActivitiesEnterprise as $enterpriseActivity) {
            $defaultActivity = Activity::create([
                'project_id' => $project->id,
                'title' => $enterpriseActivity->title,
                'type' => 0,
                'fixed_activity_id' => $enterpriseActivity->id
            ]);

            $progressDefaultActivity = Progress::create([
                'progressable_id' => $defaultActivity->id,
                'progressable_type' => 'App\Models\Activity',
                'percentage' => 0.0,
                'comment' => 'Sin comentarios'
            ]);
        }


        return response()->json([
            'msg' => 'success'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        /* $project = Project::with(['projectable', 'projectable.quotation'])->find($id); */

        /* $quotation = $project->order->quotation;

        $projectDetails = $quotation->details;

        $total_mintime = 0;
        $total_maxtime = 0;



        foreach ($projectDetails as $detail) {
            if ($detail->product_id == 34) {
                $times = Time::where('product_id', '<', 34)->get();
                foreach ($times as $time) {
                    $total_mintime = $total_mintime + $time->min_time;
                    $total_maxtime = $total_mintime + $time->max_time;
                }
            } else {
                $price = Price::where('product_id', $detail->product_id)->where('price', $detail->price)->first();
                $time = Time::where('product_id', $detail->product_id)->where('level', $price->level)->get();
                $total_mintime = $total_mintime + $time->min_time;
                $total_maxtime = $total_mintime + $time->max_time;
            }
        }



        $total_time = $total_maxtime + $total_mintime / 2; */

        $project = Project::find($id);
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
    public function destroy($id)
    {
        $project = Project::find($id);

        $project->delete();

        return response()->json([
            'msg' => 'success'
        ]);
    }

    public function changeStatus(Request $request)
    {
        $project = Project::find($request->get('project_id'));
        $project->update([
            'status' => $request->get('status')
        ]);

        $notification = Notification::create([
            'emisor_id' => $request->get('emisor_id'),
            'content' => 'envió un nuevo proyecto a Dirección Académica',
            'type' => 1
        ]);

        $usersToNotify = User::role('AdminAcad')->get();

        foreach ($usersToNotify as $user) {
            Seen::create([
                'user_id' => $user->id,
                'notification_id' => $notification->id,
                'seen' => 0
            ]);
        }

        broadcast(new NewDirection($project));

        return response()->json([
            'msg' => 'success'
        ]);
    }

    public function updateQuality($id)
    {
        $project = Project::find($id);

        $project->update([
            'status' => 2
        ]);

        $fixedActivitiesEnterprise = FixedActivity::where('product_id', 1)->where('type', 2)->get();

        foreach ($fixedActivitiesEnterprise as $enterpriseActivity) {
            $defaultActivity = Activity::create([
                'project_id' => $project->id,
                'title' => $enterpriseActivity->title,
                'type' => 2,
                'fixed_activity_id' => $enterpriseActivity->id
            ]);

            $progressDefaultActivity = Progress::create([
                'progressable_id' => $defaultActivity->id,
                'progressable_type' => 'App\Models\Activity',
                'percentage' => 0.0,
                'comment' => 'Sin comentarios'
            ]);
        }


        return response()->json([
            'msg' => 'success'
        ]);
    }

    public function getMyProjects($id)
    {
        $projects = Project::all();
        return response()->json($projects);

        /* $user = User::find($id);
        $projects = Project::where('team_id', $user->memoir->team_id)->with(['customer', 'activities', 'activities.tasks', 'activities.tasks.progress', 'order', 'order.quotation', 'order.quotation.details', 'order.quotation.details.product'])->get();
        $numTasks = 0;
        $numTasksCompleted = 0;
        foreach ($projects as $project) {
            $project->num_activities = count($project->activities);
            foreach ($project->activities as $activity) {
                $numTasks += count($activity->tasks);
                foreach ($activity->tasks as $task) {
                    if ($task->status == 2) {
                        $numTasksCompleted++;
                    }
                }
            }
            $project->num_tasks = $numTasks;
            $project->num_tasks_completed = $numTasksCompleted;
        } */
    }

    public function setProject(Request $request)
    {

        $quotation = Quotation::with(['customers', 'contract', 'order'])->find($request->get('quotationId'));

        $quotation->customers->each->update([
            'status' => 11
        ]);

        if ($quotation->contract) {
            $project = Project::create([
                'projectable_id' => $quotation->contract->id,
                'projectable_type' => 'App\Models\Contract',
                'title' => 'Proyecto ' . $quotation->id,
                'user_id' => $request->get('emisor_id'),
                'deadline' => date('Y-m-d'),
                'status' => 0,
            ]);
        } else {
            $project = Project::create([
                'projectable_id' => $quotation->order->id,
                'projectable_type' => 'App\Models\Order',
                'title' => 'Proyecto ' . $quotation->id,
                'user_id' => $request->get('emisor_id'),
                'deadline' => date('Y-m-d'),
                'status' => 0,
            ]);
        }



        $notification = Notification::create([
            'emisor_id' => $request->get('emisor_id'),
            'content' => 'asignó el ' . $project->title,
            'type' => 1
        ]);

        $usersToNotify = User::role('Experience')->get();

        foreach ($usersToNotify as $user) {
            Seen::create([
                'user_id' => $user->id,
                'notification_id' => $notification->id,
                'seen' => 0
            ]);
        }

        /*  $fixedActivitiesEnterprise = FixedActivity::where('type', 0)->get();

        foreach ($fixedActivitiesEnterprise as $enterpriseActivity) {
            $defaultActivity = Activity::create([
                'project_id' => $project->id,
                'title' => $enterpriseActivity->title,
                'type' => 0,
                'fixed_activity_id' => $enterpriseActivity->id
            ]);

            $progressDefaultActivity = Progress::create([
                'progressable_id' => $defaultActivity->id,
                'progressable_type' => 'App\Models\Activity',
                'percentage' => 0.0,
                'comment' => 'Sin comentarios'
            ]);
        }
 */
        broadcast(new NewProject($project));
        /*           

        //Traer actividades de Inbestiga por default
       /*  

       $details = $lastQuotation->details; */

        //Prodcutos de la tesis
        /*  $thesisProducts = Product::where('id','<',34)->where('id','!=', 1)->where('id','!=',25)->with('fixedActivities')->get();

       foreach($details as $detail){
            if($detail->product_id == 34){
                foreach($thesisProducts as $thesisProduct){
                    foreach($thesisProduct->fixedActivities as $fixedActivity){
                        $activity = Activity::create([
                            'project_id' => $project->id,
                            'title' => $fixedActivity->title,
                            'type' => 1,
                            'fixed_activity_id' => $fixedActivity->id
                        ]);
            
                        $progressDefaultActivity = Progress::create([
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
                                    'status' => 0,
                                    'fixed_task_id' => $fixedTask->id
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
                
            }

            foreach($detail->product->fixedActivities as $fixedActivity){
                $activity = Activity::create([
                    'project_id' => $project->id,
                    'title' => $fixedActivity->title,
                    'type' => 1,
                    'fixed_activity_id' => $fixedActivity->id
                ]);
    
                $progressDefaultActivity = Progress::create([
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
                        'status' => 0,
                        'fixed_task_id' => $fixedTask->id
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
        */

        return response()->json([
            'msg' => 'success'
        ]);
    }

    public function search($search)
    {
        /* $contracts = Contract::with(['quotation', 'quotation.customers'])->whereHas('quotation.customers', function ($query) use ($search) {
            $query->where('name', 'like', '%' . $search . '%');
        })->get();
 */
        $customers = Customer::with(['quotations', 'quotations.order', 'quotations.contract', 'quotations.order.projects', 'quotations.contract.projects', 'quotations.order.projects.deliveries', 'quotations.contract.projects.deliveries'])->whereHas('quotations')->where('name', 'like', '%' . $search . '%')->get();

        $contracts = [];
        $orders = [];


        foreach ($customers as $customer) {
            foreach ($customer->quotations as $quotation) {
                if ($quotation->contract) {

                    $quotation->contract->customers = $quotation->customers;
                    array_push($contracts, $quotation->contract);
                }

                if ($quotation->order) {
                    $quotation->order->customers = $quotation->customers;
                    array_push($orders, $quotation->order);
                }
            }
        }

        $projects = [];

        foreach ($contracts as $contract) {
            foreach ($contract->projects as $project) {
                $project->customers = $contract->customers;
                array_push($projects, $project);
            }
        }

        foreach ($orders as $order) {
            foreach ($order->projects as $project) {
                $project->customers = $order->customers;
                array_push($projects, $project);
            }
        }



        return response()->json([
            'projects' => $projects
        ]);
        /* $projects = Project::with([
            'projectable',
            'projectable.quotation',
            'projectable.quotation.customers'
        ])->get(); */
    }
}
