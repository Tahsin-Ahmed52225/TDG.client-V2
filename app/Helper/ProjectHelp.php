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

}
