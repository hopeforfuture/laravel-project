<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\DemoUser;
use App\DemoUserProfile;
use App\NewsCategory;
use App\Mechanic;
use App\Car;
use Session;


class EloquentController extends Controller
{
    public function getUserData($id='') {
        $userData = DemoUser::find($id);
        if(!empty($userData)) {
            echo "<pre>";
            print_r(json_decode($userData->profile, TRUE));
        } else {
            return 'No data found.';
        }
    }
    
    public function getPosts($id='') {
        $categoryData = NewsCategory::find($id);
        if(!empty($categoryData)) {
            echo $categoryData->category_name."<br/>";
            if(!empty($categoryData->articles)) {
                foreach ($categoryData->articles as $article) {
                    echo $article->title."--------".$article->title."<br/>";
                }
            }
        } else {
            return 'No data found.';
        }
    }
    
    public function getRoles($id='') {
        $user = DemoUser::find($id);
        if(!empty($user)) {
            if(!empty($user->roles->toArray())) {
                foreach($user->roles as $role) {
                    echo $role->name."------".$role->pivot->created_at."<br/>";
                }
            } 
            else {
                echo 'No role found for this user.';
            }
        } else {
            return 'No data found.';
        }
    }
    
    public function getOwner($id='') {
        $mechanic_data = Mechanic::find($id);
        $results = Mechanic::find($id)->carOwner->toArray();
        $car_id = $results['car_id'];
        $car_data = Car::find($car_id);
        echo "Mechanic Name:- ".$mechanic_data->name."<br/><br/>";
        echo "Car Model:- ".$car_data->model."<br/><br/>";
        //echo "<pre>";
        //print_r($results);
        echo "Owner Name:- ".$results['name'];
    }
}
