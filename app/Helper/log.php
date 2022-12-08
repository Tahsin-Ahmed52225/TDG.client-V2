<?php


namespace App\Helpers;
use Request;
use App\Models\Log;


class LogActivity
{

    /**
     * Adding a log into DB
     */
    public static function addToLog($message)
    {
    	$log = [];
    	$log['Message'] = $message;
    	$log['user_id'] = auth()->user()->id;
    	Log::create($log);
    }
    /**
     * Getting all the log
     */
    public static function allLog()
    {
    	return Log::latest()->get();
    }
    /**
     * Getting indiviudal log
     */
    public static function showlog($user_id)
    {
        return log::where('user_id', $user_id)->get(['*']);
    }



}
