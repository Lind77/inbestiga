<?php

namespace App\Http\Controllers;

use App\Events\NewDirection;
use App\Events\NewProject;
use App\Models\Project;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Models\Activity;
use App\Models\Chat;
use App\Models\Contract;
use App\Models\Customer;
use App\Models\FixedActivity;
use App\Models\Notification;
use App\Models\Order;
use App\Models\Price;
use App\Models\ProcessProject;
use App\Models\Product;
use App\Models\Progress;
use App\Models\Property;
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
        $project = Project::with(['deliveries', 'projectable', 'files', 'projectable.properties', 'projectable.quotation', 'projectable.quotation.details', 'projectable.quotation.customers', 'posts' => function ($query) {
            $query->orderBy('created_at', 'desc')->get();
        }, 'posts.postable', 'posts.files', 'team', 'team.users', 'team.users.roles'])->find($id);
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
        $user = User::find($id);
        $projects = Project::with(['projectable', 'projectable.properties', 'projectable.quotation', 'projectable.quotation.customers', 'deliveries', 'deliveries.assigned_activities', 'team'])->where('team_id', '!=', null)->where('team_id', $user->team_id)->orderBy('updated_at', 'desc')->get();

        $numTasks = 0;
        $numTasksCompleted = 0;
        foreach ($projects as $project) {
            foreach ($project->deliveries as $delivery) {
                foreach ($delivery->assigned_activities as $activity) {
                    $numTasks = $numTasks + 1;
                    if ($activity->status == 5) {
                        $numTasksCompleted++;
                    }
                }
            }

            $project->num_tasks = $numTasks;
            $project->num_tasks_completed = $numTasksCompleted;

            $numTasks = 0;
            $numTasksCompleted = 0;
        }

        return response()->json($projects);
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

        $customers = Customer::with(['quotations', 'quotations.order', 'quotations.contract', 'quotations.contract.projects', 'quotations.contract.projects.projectable', 'quotations.contract.projects.projectable.properties', 'quotations.contract.projects.deliveries', 'quotations.contract.projects.projectable.quotation.customers'])->whereHas('quotations')->where('name', 'like', '%' . $search . '%')->get();

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

    public function projectPendings()
    {
        $number_contracts =  Quotation::whereHas('contract')->where('status', 11)->get();
        $contracts_properties = Contract::whereHas('properties')->get();

        return response()->json(count($number_contracts) - count($contracts_properties));
        /* $contracts = Contract::doesntHave('properties')->get();
        return response()->json(count($contracts)); */
    }

    public function enable($id)
    {
        $contract = Contract::with('projects')->find($id);
        $project = $contract->projects->first();
        $project->update([
            'status' => 1
        ]);
        return response()->json([
            'msg' => 'success'
        ]);
    }

    public function sprints($id)
    {
        $project = Project::with(['deliveries', 'deliveries.assigned_activities', 'deliveries.assigned_activities.user', 'deliveries.assigned_activities.quality_indicators', 'projectable', 'projectable.quotation', 'projectable.quotation.customers', 'team', 'team.users', 'files'])->find($id);
        return response()->json($project);
    }

    public function searchProject($search)
    {

        $projects = Project::with(['projectable', 'projectable.quotation',])->get();

        $customers = Customer::with(['quotations', 'quotations.contract', 'quotations.contract.projects', 'quotations.contract.projects.deliveries', 'quotations.contract.projects.projectable.quotation.customers', 'quotations.contract.projects.team'])
            ->where('name', 'like', '%' . $search . '%')
            ->whereHas('quotations.contract.projects')
            ->get();

        $projects = [];

        foreach ($customers as $customer) {
            foreach ($customer->quotations as $quotation) {
                if ($quotation->contract) {
                    foreach ($quotation->contract->projects as $project) {
                        array_push($projects, $project);
                    }
                }
            }
        }


        return response()->json($projects);
    }

    public function updateProjectTitle($id, $name)
    {
        Project::find($id)->update([
            'title' => $name
        ]);

        return response()->json([
            'msg' => 'success'
        ]);
    }

    public function updateProjectStatus($id, $status)
    {
        Project::find($id)->update([
            'status' => $status
        ]);

        return response()->json([
            'msg' => 'success'
        ]);
    }
}
