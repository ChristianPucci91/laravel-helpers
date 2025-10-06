<?php

namespace Pucci\LaravelHelpers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Illuminate\Http\File;

class FileSaver
{
    /**
     * Salva un file sul disco configurato.
     *
     * @param UploadedFile|string $file
     * @param string $path
     * @param string $disk
     * @return string
     * @throws \InvalidArgumentException
     */
    public function save($file, string $path, string $disk = 'public'): string
    {
        if (is_string($file) && file_exists($file)) {
            return Storage::disk($disk)->putFile($path, new File($file));
        }

        if ($file instanceof UploadedFile) {
            return Storage::disk($disk)->putFile($path, $file);
        }

        throw new \InvalidArgumentException('Parametro $file non valido: deve essere path o UploadedFile.');
    }

    /**
     * Elimina un file dal disco.
     *
     * @param string $filePath
     * @param string $disk
     * @return bool
     */
    public function delete(string $filePath, string $disk = 'public'): bool
    {
        return Storage::disk($disk)->delete($filePath);
    }
}
