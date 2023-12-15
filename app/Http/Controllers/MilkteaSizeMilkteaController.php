<?php

namespace App\Http\Controllers;
use App\Models\MilkTeaCategory;
use Illuminate\Http\Request;
use App\Models\MilkteaSizeMilktea;
use App\Models\MilkTeaSize;
use App\Models\MilkTea;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Facade;
use Illuminate\Support\Facades\Log;

class MilkteaSizeMilkteaController extends Controller
{
    
    public function index()
    {
        $milkteaSizeMilkteas = MilkteaSizeMilktea::all();
        return view('milktea.milkteasize.milktea_size', compact('milkteaSizeMilkteas'));
    }

    public function manage($milkteaSize)
    {
        // Find the MilkTea based on the given ID
        $milkteaName = MilkTea::findOrFail($milkteaSize);
        
        // Retrieve milk tea sizes with the same ID as the selected MilkTea
        $milkteaSizeMilkteas = MilkteaSizeMilktea::where('milktea_id', $milkteaName->id)->get();
    
        return view('milktea.milkteasize.filtered_milktea_size', compact('milkteaSizeMilkteas'));
    }
    



    public function create($milktea)
    {
        $milkteaName =  MilkTea::findOrFail($milktea);
        $milkteaSize =  MilkTeaSize::all();
        return view('milktea.milkteasize.newsize', compact('milkteaName','milkteaSize'));
    }

    public function store(Request $request)
    {
        
        $data = $request->validate([
            'milktea_id_hidden' => 'required',
            'milktea_size_id' => 'required',
        ]);
        MilkteaSizeMilktea::create([
            'milktea_id' => $request->input('milktea_id_hidden'),
            'milktea_size_id' => $request->input('milktea_size_id'),
        ]);

   

        return redirect()->route('milkteasize.index');
    }

    public function edit(MilkteaSizeMilktea $milkteaSizeMilktea)
    {
        // Logic to show form for editing the relationship
        // For example:
        // return view('milktea-size-milktea.edit', compact('milkteaSizeMilktea'));
    }

    public function update(Request $request, MilkteaSizeMilktea $milkteaSizeMilktea)
    {
        // Logic to update the relationship
        // For example:
        // $milkteaSizeMilktea->update($request->all());
        // return redirect()->route('milktea-size-milktea.index');
    }

    public function destroy($id)
    {
       
        try {
            // Debug statement
            $milkteaSize = MilkteaSizeMilktea::findOrFail($id);
    
            $milkteaSize->delete();
            return redirect()->route('milkteasize.index')->with('success', 'Milktea size deleted successfully.');
        }  catch (\Exception $e) {
            dd($e);
            return redirect()->route('milkteasize.index')->with('error', 'Cannot delete milktea size. There was an error.');
        }
    }
    
    


}
