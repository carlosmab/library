<?php

namespace App\Http\Controllers;

use App\Author;
use Illuminate\Http\Request;

class AuthorsController extends Controller
{
    public function store()
    {	
    	$data = request()->only([
    		'name',
    		'dob'
    	]);

    	Author::create($data);
    }
}
