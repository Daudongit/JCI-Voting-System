<?php

namespace App\Http\Controllers\Admin;

use App\Nominee;
use Illuminate\Http\Request;
use App\Services\FileUploadService;
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
     * @param \App\Services\FileUploadservice $fileUploadService
     * @return \Illuminate\Http\Response
     */
    public function store(NomineeRequest $request,FileUploadService $fileUploadService)
    {
        $rawNomineee = $request->except(['_token','previousImage','image']);

        if ($request->hasfile('image')) {
            $uploadResponce = $fileUploadService->uploadFile(
                $request->file('image'),
                ["width"=>200, "height"=>200]
            );

            $rawNomineee['image'] = $uploadResponce['secure_url'].'|'.
                $uploadResponce['public_id'];
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
        $fileUploadService = app(FileUploadService::class);

        $rawNomineee = $request->except(['_token','previousImage','image']);

        if($request->hasFile('image')) {
            $uploadResponce = $fileUploadService->uploadFile(
                $request->image,
                ["width"=>200, "height"=>200]
            );

            $this->deleteImage($fileUploadService,$nominee);

            $rawNomineee['image'] = $uploadResponce['secure_url'].'|'.
                $uploadResponce['public_id'];
        }
            
        $nominee->update($rawNomineee);

        return redirect(route('admin.nominees.index'))->withSuccess(
            __('Nominee successfully updated.')
        );
    }

    /**
     * Remove the specified resource from storage.
     * @param \App\Services\FileUploadservice $fileUploadService
     * @param  \App\Nominee  $nominee
     * @return \Illuminate\Http\Response
     */
    public function destroy(FileUploadService $fileUploadService, Nominee $nominee)
    {
        if($nominee->delete())
        {
            $this->deleteImage($fileUploadService,$nominee);

            return redirect(route('admin.nominees.index'))->withSuccess(
                __('Nominee successfully deleted.')
            );
        }
    }

    private function deleteImage($fileUploadService,$nominee)
    {
        if(!is_null($nominee->image)) {
            $fileUploadService->deleteFile(
                isset(explode('|',$nominee->image)[1])?
                explode('|',$nominee->image)[1]:null
            );
        }
    }
}
