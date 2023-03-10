<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;

class ApiProjectController extends Controller
{
    public function index() {

        $projects = Project::with('type', 'technologies')->paginate(4);

        return response()->json([
            'success' => true,
            'result' => $projects
        ]);
    }

    public function show($slug) {

        $project = Project::with('type', 'technologies')->where('slug', $slug)->first();

        if($project) {
            return response()->json([
                'success' => true,
                'result' => $project
            ]);
        }
        else {
            return response()->json([
                'success' => false,
                'error' => 'Nessun progetto trovato'
            ]);
        }
    }
}
