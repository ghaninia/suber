<?php

namespace App\Kernel\UploadCenter\Classes;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\Filesystem\Filesystem;
use App\Kernel\UploadCenter\Interfaces\FileInterface;
use App\Kernel\UploadCenter\Interfaces\FileableInterface;
use App\Kernel\UploadCenter\Interfaces\UploadDriverInterface;

class FileActionCenter extends FileModelCenter
{
    protected FileableInterface $fileable;
    protected string $disk;

    public function __construct()
    {
        $this->disk = config("filesystems.default");
    }

    /**
     * @param FileableInterface $fileable
     */
    public function setFileable(FileableInterface $fileable)
    {
        $this->fileable = $fileable;

        return $this;
    }

    /**
     * @param string $disk
     */
    public function setDisk(UploadDriverInterface $uploadDriver)
    {
        $this->disk = $uploadDriver->disk();
        return $this;
    }

    /**
     * @param string $disk
     * @return Filesystem
     */
    private static function storage(string $disk)
    {
        return Storage::disk($disk);
    }


    /**
     * exists file or folder
     * @return boolean
     */
    public function exists($path, $disk = null): bool
    {
        return self::storage($disk ?? $this->disk)->exists($path);
    }

    /**
     * delete file or folder
     * @return boolean
     */
    public function delete(FileInterface $file): bool
    {
        return self::storage($file->disk)->delete($file->path) && $this->deleteFromDatabase($file);
    }


    /**
     * store file in local
     * @param string $uploadPath
     * @param string $fileName
     *
     */
    public function store(UploadedFile|string $file, string $uploadPath, string $fileName)
    {

        if (is_string($file)) {
            ### when use raw contents
            $pathWithName = $uploadPath . DIRECTORY_SEPARATOR . $fileName;
            $result = self::storage($this->disk)->put($pathWithName, $file);
        } else {
            ### when instance of UploadedFile
            $result = $file->storeAs($uploadPath, $fileName, [
                "disk" => $this->disk
            ]);
        }

        return $result;
    }

    /**
     * get url file
     * @param string $path
     * @return string
     */
    public static function url(FileInterface $file): string
    {

        $path = str_replace(DIRECTORY_SEPARATOR, "/", $file->path);

        $path = trim($path, "/");

        return self::storage($file->disk)->url($path);
    }

    /**
     * create new folder
     */
    public function makeDirectory($path)
    {

        if (!$this->exists($path))
            return self::storage($this->disk)->makeDirectory($path);

        return false;
    }

}
