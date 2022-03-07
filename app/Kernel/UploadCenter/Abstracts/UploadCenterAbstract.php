<?php

namespace App\Kernel\UploadCenter\Abstracts;

use Illuminate\Http\UploadedFile;
use App\Kernel\UploadCenter\Classes\FileActionCenter;
use Illuminate\Support\Str;

abstract class UploadCenterAbstract extends FileActionCenter
{

    const BASE_PATH = "uploads";

    private string $originalName;
    private UploadedFile|string  $file;

    abstract public function servicePathName(): string|array;

    /**
     * @param UploadedFile|string $file
     */
    public function setFile(UploadedFile|string $file)
    {
        $this->file = $file;

        return $this;
    }

    /**
     * @param string $originalName
     */
    public function setOriginalName(string $originalName)
    {
        $this->originalName = $originalName;

        return $this;
    }


    /**
     * upload file to server and save to database
     * @param UploadedFile $file
     * @param string|null $parentDirectoryId
     */
    public function append(): self
    {

        parent::store(
            $this->file,
            $uploadPath = $this->getUploadPath(),
            $fileName = $this->getClientOriginalName()
        );

        static::$dataUploads[] = [
            "disk" => $this->disk,
            "name" => $fileName,
            "path" => implode(DIRECTORY_SEPARATOR, [$uploadPath, $fileName]),
        ];

        return $this;
    }



    /**
     * get user base folder
     * @return string
     */
    private function getUploadPath(): string
    {

        $basePath[] = SELF::BASE_PATH;

        $servicePathName = $this->servicePathName();

        is_string($servicePathName) ?
            $basePath[] = $servicePathName :
            $basePath   = array_merge(
                $basePath,
                $servicePathName
            );

        $path = implode(DIRECTORY_SEPARATOR, $basePath);
        $path = strtolower($path);

        $this->createPathIfNotExists($path);

        return $path;
    }

    /**
     * create new path if not exists
     * @return void
     */
    public function createPathIfNotExists(string $path): void
    {
        $this->makeDirectory($path);
    }


    /**
     * @return string
     */
    private function getClientOriginalName(): string
    {
        $name = is_string($this->file) ?
            $this->originalName :
            $this->file->getClientOriginalName();

        $ext  = pathinfo( $name , PATHINFO_EXTENSION ) ;
        $name = pathinfo( $name , PATHINFO_FILENAME ) ;
        $name = Str::slug($name);
        $name = strtolower($name);
        $name = sprintf("%s.%s", $name, $ext);

        return $name;
    }
}
