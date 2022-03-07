<?php

namespace App\Kernel\UploadCenter\Classes;

use App\Kernel\UploadCenter\Interfaces\FileInterface;

class FileModelCenter
{
    protected bool $pull = false ;

    protected static array $dataUploads = [];

    public function pull()
    {
        $this->pull = true ;
        return $this ;
    }

    /**
     * FINAL UPLOAD FILES
     */
    public function upload()
    {

        if ($this->pull){

            $this->fileable
                ->files()
                ->when(isset($this->tag) , fn($query) => $query->where("tag", $this->tag) )
                ->get()
                ->each
                ->delete();

        }

        if (count(self::$dataUploads)) {

            $files = $this->fileable->files()->createMany(self::$dataUploads);

            self::$dataUploads = [];

            return $files;
        }

        return FALSE;
    }


    /**
     * model delete
     */
    protected function deleteFromDatabase(FileInterface $file)
    {
        return $file->delete();
    }
}
