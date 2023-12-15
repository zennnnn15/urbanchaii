<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MilkTea;
use App\Models\MilkTeaCategory;

class MilkTeaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $milkteas = MilkTea::all();
        return view('milktea.index', compact('milkteas'));
    }

    public function create()
    {
        $category = MilkTeaCategory::all();
        return view('milktea.create',compact('category'));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        // Check if an image file was uploaded
        if ($request->hasFile('image')) {
            // Get the uploaded file content
            $imageContent = file_get_contents($request->file('image')->getRealPath());
        } else {
            // If no image was uploaded, set $imageContent to null or a default image binary data
            $imageContent = null;
        }
    
        // Create a new MilkTea record with the image binary data
        MilkTea::create([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'milktea_category_id' => $request->input('category'),
            'image' => $imageContent, // Store the image binary data in the 'image' column
        ]);
    
        // Redirect to the MilkTea index page with a success message
        return redirect()->route('milktea.index')->with('success', 'Milk Tea created successfully.');
    }
    


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(MilkTea $milktea)
    {
    
        return view('milktea.show', compact('milktea'));
    }

    public function edit(MilkTea $milktea)
    {
        
        $category = MilkTeaCategory::all();
        return view('milktea.edit', compact('milktea','category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MilkTea $milktea)
{
    // Validate the request data
    $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'category' => 'required',
        'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

     // Check if an image file was uploaded
     if ($request->hasFile('image')) {
        // Get the uploaded file content
        $imageContent = file_get_contents($request->file('image')->getRealPath());
    } else {
        // If no image was uploaded, set $imageContent to null or a default image binary data
        $imageContent = null;
    }

    // Update the MilkTea record
    $milktea->update([
        'name' => $request->input('name'),
        'description' => $request->input('description'),
        'milktea_category_id' => $request->input('category'),
        'image' => $imageContent, // Store the image binary data in the 'image' column
    ]);

    // Redirect to the MilkTea details page
    return redirect()->route('milktea.index', $milktea)->with('success', 'Milk Tea updated successfully.');
}

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
