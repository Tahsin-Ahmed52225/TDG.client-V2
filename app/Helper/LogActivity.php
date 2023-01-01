<?php


namespace App\Helper;
use Illuminate\Support\Facades\Auth;
use App\Models\Log;


class LogActivity
{

    /**
     * Adding a log into DB
     */
    public static function addToLog($message)
    {
    	$log = [];
    	$log['log_details'] = $message;
    	$log['user_id'] = Auth::user()->id;
    	Log::create($log);
    }
    /**
     * Getting all the log
     */
    public static function allLog()
    {
    	return Log::latest()->take(20)->get();
    }
    /**
     * Getting indiviudal log
     */
    public static function showlog($user_id)
    {
        return log::where('user_id', $user_id)->take(20)->get();
    }



}
