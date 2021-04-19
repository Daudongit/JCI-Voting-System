<?php

namespace App\Services;
use Illuminate\Support\Facades\Storage;

class ImageProcess 
{   
    public $path = 'public/upload';

    public function upload($fileName,$path=null)
    {   
        if(!is_null($path)) $this->path = $path;
        $file = request()->file($fileName);
        if(request()->hasFile($fileName) && $file->isValid())
        {
            if(config('filesystems.default') == 'local')
            {
                return $this->localUpload($file);
            }

            if(config('filesystems.default') == 's3')
            {
                return $this->s3Upload($file);
            }
        }
        
        return null;
    }

    public function delete($fileName,$path=null)
    {
        if(!is_null($path)) $this->path = $path;
        if(config('filesystems.default') == 'local')
        {
            return $this->localDelete($fileName);
        }
        return null;
    }

    public function localUpload($file)
    {
        return str_replace(
            $this->path.'/','',
            $file->store($this->path)
        );
    }

    public function s3Upload($file)
    {
        return str_replace(
            $this->path.'/','',
            $file->store($this->path,'s3')
        );
    }

    public function localDelete($fileName)
    {
        Storage::delete($this->path.'/'.$fileName);
        return $this;
    }
}