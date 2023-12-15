<?php

namespace App\Http\Controllers;
use App\Models\MilkTeaSize;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;

class MilkteaSizeController extends Controller
{
    public function index()

    {
        $milkteaSizes = MilkteaSize::all();
        return view('milktea_price.index', compact('milkteaSizes'));
    }
    public function create()
    {
        return view('milktea_price.addMilkteaSize');
    }
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'price' => 'nullable|int',
        ]);

        MilkteaSize::create($data);

        return redirect()->route('milkteaInSize.index');
    }
    public function show($id)
    {
        $milkteaSize = MilkteaSize::findOrFail($id);
        return view('milktea_price.show', compact('milkteaSize'));
    }
    

    public function edit($id)
    {
    $milkteaSize = MilkteaSize::findOrFail($id);
    return view('milktea_price.edit', compact('milkteaSize'));
    }

    public function update(Request $request, $id)
    {
        $milkteaSize = MilkteaSize::findOrFail($id);
        
        try {
            $request->validate([
                'name' => 'string',
                'price' => 'numeric',
            ]);
            
            $milkteaSize->update([
                'name' => $request->input('name'),
                'price' => $request->input('price'),
            ]);
    
            return redirect()->route('milkteaInSize.index')->with('success', 'Milktea size updated successfully.');
        } catch (QueryException $e) {
            dd($e);
            Log::error('Database error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to update milktea size. Please try again later.');
        }
    }


    public function destroy($id)
    {
        try {
            // Debug statement
            $milkteaSize = MilkteaSize::findOrFail($id);
            
    
            // Check if there are any relationships before deleting
            if ($milkteaSize->milkTeas()->count() > 0) {
                return redirect()->route('milkteaInSize.index')->with('error', 'Cannot delete milktea size. There are connected data.');
            }
    
        
    
            $milkteaSize->delete();
            return redirect()->route('milkteaInSize.index')->with('success', 'Milktea size deleted successfully.');
        } catch (\Exception $e) {
        
            return redirect()->route('milkteaInSize.index')->with('error', 'Cannot delete milktea size. There are connected data.');
            // return redirect()->route('milkteaInSize.index')->with('error', 'Failed to delete milktea size. Error: ' . $e->getMessage());
        }
    }
    
    
    




}
