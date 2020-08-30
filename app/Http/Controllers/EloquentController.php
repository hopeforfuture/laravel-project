<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\DemoUser;
use App\DemoUserProfile;
use App\NewsCategory;
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
}
