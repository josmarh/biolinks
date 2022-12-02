<?php

namespace App\Services;

use Illuminate\Support\Facades\File;
use Log;

trait FileHandler
{
    protected function saveFile($folder, $file)
    {
        if (preg_match('/^data:image\/(\w+);base64,/', $file, $type)
            || preg_match('/^data:video\/(\w+);base64,/', $file, $type)
            || preg_match('/^data:audio\/(\w+);base64,/', $file, $type)) {
                // take out the base64 encoded text without mimetype
                $file = substr($file, strpos($file, ',') +1);
                // get file extension 
                $type = strtolower($type[1]);
                $file = str_replace(' ', '+', $file);
                $file = base64_decode($file);

                if($file === false) {
                    throw new Exception("base64_decode failed");
                }
        }else {
            throw new Exception("Did not match data URI with file data");
        }

        $filename = bin2hex(random_bytes(16));

        return $this->saveToPath($folder, $filename, $type, $file);
    }

    protected function saveToPath($folder, $filename, $ext, $file)
    {
        $dir = $folder.'/';
        $fileHash = $filename . '.' . $ext;
        $absolutePath = public_path($dir);
        $relativePath = $dir . $fileHash;
        if (!File::exists($absolutePath)) {
            File::makeDirectory($absolutePath, 0755, true);
        }
        file_put_contents($relativePath, $file);

        return $relativePath;
    }

    protected function deleteFile($filename)
    {
        $absolutePath = public_path().'/'.$filename;

        if (File::exists($absolutePath)) {
            File::delete(public_path().'/'.$filename);
        }

        return true;
    }
}