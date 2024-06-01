<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Theme;

class ThemeController extends Controller
{
    public function __construct()
    {
        $this->middleware('verified');
    }
    
    public function index()
    {
        return Theme::all();
    }
    
    public function store(Request $request)
    {
        $theme = Theme::create($request->validate([
            'color' => 'required|in:red,blue,yellow,green,pink,blue-gray',
            'user_id' => 'required|exists:users,id',
        ]));

        return $theme;
    }
    
    public function update(Request $request, Theme $theme){
        $validated = $request->validate([
            'color' => 'required|in:red,blue,yellow,green,pink,blue-gray',
            'user_id' => 'required|exists:users,id',
        ]);
        
        $theme->update($validated);
        
        return $theme;
    }
}
