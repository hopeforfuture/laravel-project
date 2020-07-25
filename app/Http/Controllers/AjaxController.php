<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Student;

class AjaxController extends Controller
{
    public function studentrollduplicate(Request $request)
	{
		if(!($request->ajax()))
		{
			die('Not a http ajax request.');
		}
		$flag = true;
		$postdata = $request->all();
		$rollarr = explode(",", $postdata['roll_str']);
		$stdarr = array();
		$stdroll = '';
		$stdclass = '';
		$count = 0;
		if(!empty($rollarr))
		{
			foreach($rollarr as $ra)
			{
				$stdarr = explode("#", $ra);
				$stdroll = $stdarr[0];
				$stdclass = $stdarr[1];
				
				$count = Student::where([
						    ['roll_no', "=", $stdroll],
						    ['student_class', "=", $stdclass],
						])->count();
						
				if($count > 0)
				{
					$flag = false;
					break;
				}
			}
		}
		
		if($flag)
		{
			echo 'success';
		}
		else
		{
			echo 'failed';
		}
		die;
	}
}