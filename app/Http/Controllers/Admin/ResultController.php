<?php

namespace App\Http\Controllers\Admin;

use App\Slot;
use App\Result;
use App\Election;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class ResultController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $results = Result::paginate(20);

        return view('admin.votes',compact('results'));
    }


    public function show(Election $election)
    {
        $slots = $election->slots()->paginate(20);

        return view('admin.results',compact('election','slots'));
    }


    public function export(Election $election,Slot $slot,$type = 'xls')
    {
        $nomineesResults = $slot->nomineesWithResultCount($election->id);

        $positionName = str_slug($slot->position->name,'_');

        $electionTitle = str_slug(strtolower($election->title),'_');

        $title = $electionTitle.'_'.$positionName;
        
        return Excel::create($title, function($excel) use ($slot,$nomineesResults) {

            $excel->sheet(str_limit($slot->position->name,26), function($sheet) use ($nomineesResults)
            {
                $sheet->fromArray(
                    $this->transformCollection($nomineesResults->toArray())
                );
            });

        })->download($type);
    }

    
    //Helper to transform for excel output
    private function transformCollection(array $items)
    {
        return array_map([$this,'transform'], $items);
    }

    private function transform($item)
    {
        return [
            'id'=>$item['id'],
            'Nominee'=>$item['first_name'].' '.$item['last_name'],
            'Description'=>$item['description'],
            'Vote Count'=>$item['results_count']
        ];
    }
} 

