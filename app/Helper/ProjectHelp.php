<?php


namespace App\Helper;
use App\Models\ProjectSubtask;


class ProjectHelp
{

    /**
     * Calculating the progress percentage
     */
    public static function calculateProgressPercentage($project_id)
    {
        $completedTask = count(ProjectSubtask::where('project_id',$project_id)->where('complete',1)->get());
        $totalTasks =  count(ProjectSubtask::where('project_id',$project_id)->get());
        return round(($completedTask / $totalTasks) * 100, 2);
    }
    public static function taskformat($tasks,$status){
        $data = [];
        foreach($tasks->where("status",$status) as $ele){
            $data[] = [
                'title' => '<span class="font-weight-bold" data-id='.$ele->id.' data-toggle="modal" data-target="#viewSubtask">'.$ele->title.'</span>',
                'class' => 'bg-white',
            ];
        }
        return $data;
    }
    public static function taskReorder($order){
            foreach( $order as $key=>$value ){
               $task =  ProjectSubtask::find($value);
               $task->order = $key+1;
               $task->save();
            }
    }

}
