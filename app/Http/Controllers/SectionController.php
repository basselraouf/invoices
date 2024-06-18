<?php

namespace App\Http\Controllers;

use App\Models\Section;
use Illuminate\Http\Request;
use Auth;

class SectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sections= Section::all();
        return view('sections.sections',compact('sections'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'section_name' => 'required|unique:sections|max:255',
            'description' => 'nullable|string'
        ]);

            Section::create([
                'section_name'=>$request->section_name,
                'description' =>$request->description,
                'Created_by' =>Auth::user()->name,
            ]);
            session()->flash('Add','!تم اضافة القسم بنجاح');
            return redirect('/sections');

    }

    /**
     * Display the specified resource.
     */
    public function show(Section $section)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Section $section)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $this->validate($request,[
            'section_name' => 'required|unique:sections|max:255',
            'description' => 'nullable|string'
        ]);
        Section::where('id',$request->id)->update([
            'section_name'=>$request->section_name,
            'description' =>$request->description,
        ]);
        return redirect('/sections')->with(['edit'=>'تم تعديل القسم بنجاح']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        Section::where('id',$request->id)->delete();
        return redirect('/sections')->with(['delete'=>'تم الحذف بنجاح']);
    }
}
