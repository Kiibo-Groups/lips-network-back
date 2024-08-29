<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Twilio\Rest\Client;
use App\Models\Admin;
use App\Language;
use Twilio;
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    // Usuarios
    function sendPush($title,$description,$uid = 0,$img = null)
	{
		$content = ["en" => $description];
		$head 	 = ["en" => $title];		

		$daTags = [];

		if($uid > 0)
		{
			$daTags = ["field" => "tag", "key" => "user_id", "relation" => "=", "value" => $uid];
		}
		else
		{
			$daTags = ["field" => "tag", "key" => "user_id", "relation" => "!=", "value" => 'NAN'];
		}
		
		$fields = array(
			'app_id' => "0883c43e-0272-4c81-9e54-4649ab40d6fa",
			'included_segments' => array('All'),	
			'filters' => [$daTags],
			'data' => array("foo" => "bar"),
			'contents' => $content,
			'headings' => $head,
			'big_picture' => $img
		);
        
     
		$fields = json_encode($fields);
        
		$ch = curl_init();
		
		curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json',
		'Authorization: Basic NTJjOTA2MTEtYmU1Yi00NDI0LTk2NjQtMjFiZWNiYzA1YmZm'));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_HEADER, FALSE);
		curl_setopt($ch, CURLOPT_POST, TRUE);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

		$response = curl_exec($ch);
		curl_close($ch);
       
	    return $response;
	}
 
	// Restaurantes
	function sendPushS($title,$description,$uid = 0)
	{
		$content = ["en" => $description];
		$head 	 = ["en" => $title];		

		$daTags = [];

		if($uid > 0)
		{
			$daTags = ["field" => "tag", "key" => "store_id", "relation" => "=", "value" => $uid];
		}
		else
		{
			$daTags = ["field" => "tag", "key" => "store_id", "relation" => "!=", "value" => 'NAN'];
		}
		
		$fields = array(
			'app_id' => "b66021b6-480b-492e-99c0-fdd30ca9c9e2",
			'included_segments' => array('All'),	
			'filters' => [$daTags],
			'data' => array("foo" => "bar"),
			'contents' => $content,
			'headings' => $head
		);
        
		
		$fields = json_encode($fields);
        
		$ch = curl_init();
		
		curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json',
		'Authorization: Basic NzMyYjZhOWMtYzAyNC00NmQ2LWFhYTEtMGQ3Y2I1NmRkNmM2'));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_HEADER, FALSE);
		curl_setopt($ch, CURLOPT_POST, TRUE);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

		$response = curl_exec($ch);
		curl_close($ch);
       
	    return $response;
	}

	// Administrador
	function sendPushAdmin($title,$description,$uid = 0)
	{
		$content = ["en" => $description];
		$head 	 = ["en" => $title];

		$daTags = [];

		if($uid > 0)
		{
			$daTags = ["field" => "tag", "key" => "admin_id", "relation" => "=", "value" => $uid];
		}
		else
		{
			$daTags = ["field" => "tag", "key" => "admin_id", "relation" => "!=", "value" => 'NAN'];
		}

		$fields = array(
			'app_id' => "b66021b6-480b-492e-99c0-fdd30ca9c9e2",
			'included_segments' => array('All'),
			'data' => array("foo" => "bar"),
			'filters' => [$daTags],
			'contents' => $content,
			'headings' => $head,
		);


		$fields = json_encode($fields);

		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json',
		'Authorization: Basic NzMyYjZhOWMtYzAyNC00NmQ2LWFhYTEtMGQ3Y2I1NmRkNmM2'));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_HEADER, FALSE);
		curl_setopt($ch, CURLOPT_POST, TRUE);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

		$response = curl_exec($ch);
		curl_close($ch);

	    return $response;
	}

    public function currency()
    {
    	$admin = Admin::find(1);

    	if($admin->currency)
    	{
    		return $admin->currency;
    	}
    	else
    	{
    		return "Rs.";
    	}
    }
  
}