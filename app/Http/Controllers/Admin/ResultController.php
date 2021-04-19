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
        $results = Result::filter(request('keywords'))->paginate(20);

        return view('admin.votes',compact('results'));
    }


    public function show(Election $election)
    {
        $slots = $election->slots()->paginate(20);

        return view('admin.results',compact('election','slots'));
    }


    public function exportElection(Election $election,Slot $slot,$type = 'xls')
    {
        $nomineesResults = $slot->nomineesWithResultCount($election->id);

        $title = $this->getCleanTitle($slot->position->name,$election->title);
        
        return Excel::create($title, function($excel) use ($slot,$nomineesResults) {

            $excel->sheet(
                str_limit($this->cleanSheetTitle($slot->position->name),26), 
                function($sheet) use ($nomineesResults){
                    $sheet->fromArray(
                        $this->transformCollection($nomineesResults->toArray(),'election')
                    );
            });

        })->download($type);
    }

    
    public function exportVote($type = 'xls')
    {
        $votes = Result::with('signature')->get();

        return Excel::create(
            str_slug(config('app.name', 'JCI Voting System')).'_votes', 
            function($excel) use ($votes) {
                $excel->sheet(
                    'vote sheet', 
                    function($sheet) use ($votes){
                        $sheet->fromArray(
                            $this->transformCollection($votes->toArray(),'vote')
                        );
                    }
                );

            }
        )->download($type);
    }


    //Helper to transform for excel output
    private function transformCollection(array $items,$entity)
    {
        return array_map([$this,$entity], $items);
    }

    private function election($item)
    {
        return [
            'id'=>$item['id'],
            'Nominee'=>$item['first_name'].' '.$item['last_name'],
            'Description'=>$item['description'],
            'Vote Count'=>$item['results_count']
        ];
    }

    private function vote($item)
    {
        return [
            'voter'=>$item['voter'],
            'voter_ip'=>$item['signature']['ip'],
            'post'=>$item['post'],
            'nominee'=>$item['nominee'],
            'election'=>$item['election']
        ];
    }

    private function getCleanTitle($position,$election)
    {   
        $positionName = str_slug($position,'_');

        $electionTitle = str_slug(strtolower($election),'_');

        $title = $electionTitle.'_'.$positionName;

        $title = str_replace('/','-',$title);

        return preg_replace('/[^A-Za-z0-9\-\_]/', '', $title); // only num, letter,- and _
    }

    private function cleanSheetTitle($title)
    {
        $title = str_slug($title,'_');

        $title = str_replace('/','-',$title);

        return preg_replace('/[^A-Za-z0-9\-\_]/', '', $title); // only num, letter,- and _
    }
} 

