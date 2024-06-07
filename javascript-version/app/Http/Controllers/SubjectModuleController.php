<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SubjectModule; // Make sure you have the model defined
use Illuminate\Support\Facades\Validator;

class SubjectModuleController extends Controller
{
    public function index()
    {
        $subjectmodules = SubjectModule::all();
        return $subjectmodules;
    }

    public function store(Request $request)
    {
        $subjectmodule = new SubjectModule([
            'subject_id' => $request->input('subject_id'),
            'module_id' => $request->input('module_id'),
            'nbHours' => $request->input('nbHours'),
        ]);
        $subjectmodule->save();
        return response()->json($subjectmodule, 201);
    }


    public function show($id)
    {
        $subjectmodule = SubjectModule::find($id);
        return response()->json($subjectmodule);
    }


    public function update(Request $request, $id)
    {
        $subjectmodule = SubjectModule::find($id);
        $subjectmodule->update($request->all());
        return response()->json($subjectmodule, 200);
    }


    public function destroy($id)
    {
        $subjectmodule = SubjectModule::find($id);
        $subjectmodule->delete();
        return response()->json('Subject deleted from module !');
    }
}
