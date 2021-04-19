<?php

namespace App\Http\Controllers\Admin;

use App\Nominee;
use Illuminate\Http\Request;
use App\Services\ImageProcess;
use App\Http\Controllers\Controller;
use App\Http\Requests\NomineeRequest;

class NomineeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $nominees = Nominee::filter(request('keywords'))->paginate(20);

        return view('admin.nominee.index',compact('nominees'));
    }

    /**
     * Store a newly created resource in storage.
     *  
     * @param  \App\Http\Requests\NomineeRequest  $request
     * @param \App\Services\ImageProcess $fileUploadService
     * @return \Illuminate\Http\Response
     */
    public function store(NomineeRequest $request,ImageProcess $fileUploadService)
    {
        $rawNomineee = $request->except(['_token','previousImage','image']);

        if ($request->hasfile('image')) {

            $rawNomineee['image'] = $fileUploadService->upload('image');
        }

        Nominee::create($rawNomineee);

        return redirect(route('admin.nominees.index'))->withSuccess(
            __('Nominee successfully created.')
        );
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\NomineeRequest  $request
     * @param  \App\Nominee  $nominee
     * @return \Illuminate\Http\Response
     */
    public function update(NomineeRequest $request, Nominee $nominee)
    {  
        $fileUploadService = app(ImageProcess::class);

        $rawNomineee = $request->except(['_token','previousImage','image']);
        
        if(!$request->has('previousImage'))
        {
            $fileUploadService->delete($nominee->image);

            $rawNomineee['image'] = $fileUploadService->upload('image');
        }

        $nominee->fill($rawNomineee)->save();

        return redirect(route('admin.nominees.index'))->withSuccess(
            __('Nominee successfully updated.')
        );
    }

    /**
     * Remove the specified resource from storage.
     * @param \App\Services\ImageProcess $fileUploadService
     * @param  \App\Nominee  $nominee
     * @return \Illuminate\Http\Response
     */
    public function destroy(ImageProcess $fileUploadService, Nominee $nominee)
    {
        $fileUploadService->delete($nominee->image);
        if($nominee->delete())
        {
            return redirect(route('admin.nominees.index'))->withSuccess(
                __('Nominee successfully deleted.')
            );
        }
    }
}
