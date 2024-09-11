<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoriesController extends Controller
{
    public function showAll()
    {
        return view('admin-quotes.categories', [
            'title' => 'Categories',
            'datas' => Category::all()
        ]);
    }
}
