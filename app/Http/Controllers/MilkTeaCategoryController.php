<?php

namespace App\Http\Controllers;
use App\Models\MilkTeaCategory;
use Illuminate\Http\Request;

class MilkTeaCategoryController extends Controller
{
    public function index()
    {
        $categories = MilkTeaCategory::all();
    
        return view('milktea.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('milktea.categories.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'description' => 'nullable|string',
        ]);

        MilkTeaCategory::create($data);

        return redirect()->route('milktea.categories.index');
    }

    public function edit(MilkTeaCategory $category)
    {
        return view('milktea.categories.edit', compact('category'));
    }

    public function update(Request $request, MilkTeaCategory $category)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'description' => 'nullable|string',
        ]);

        $category->update($data);

        return redirect()->route('milktea.categories.index');
    }

    public function destroy(MilkTeaCategory $category)
    {
        $category->delete();
        return redirect()->route('milktea.categories.index');
    }

    
}
