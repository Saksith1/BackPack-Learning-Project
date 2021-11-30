<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Trainer;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\TrainersImport;


class TrainerController extends Controller
{
    public function getTrainer(Request $request)
    {
        $search_term = $request->input('q');

        if ($search_term)
        {
            $results = Trainer::where('name', 'LIKE', '%'.$search_term.'%')->paginate(10);
        }
        else
        {
            $results = Trainer::paginate(2);
        }

        return $results;
    }
    public function import(Request $request){
        // Excel::import(new TrainersImport, $request->file);
        $import = new TrainersImport();
        $import->import($request->file);
        // dd($import->errors());
    }
}
