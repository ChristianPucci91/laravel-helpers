<?php

namespace Pucci\LaravelHelpers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\UploadedFile;
use Illuminate\Http\File;
use Exception;

class FileSaver
{
    /**
     * Salva un file sul disco configurato.
     *
     * @param UploadedFile|string $file
     * @param string $path
     * @param string|null $disk
     * @param string|null $filename
     * @param bool $overwrite
     * @return string Percorso del file salvato
     * @throws Exception
     */
    public function save($file, string $path, ?string $disk = 'public', ?string $filename = null, bool $overwrite = false): string
    {
        try {
            // Controllo file valido
            if (!($file instanceof UploadedFile) && !(is_string($file) && file_exists($file))) {
                throw new \InvalidArgumentException('Parametro $file non valido: deve essere path o UploadedFile.');
            }

            // Creazione directory se non esiste
            if (!Storage::disk($disk)->exists($path)) {
                Storage::disk($disk)->makeDirectory($path);
                Log::info("Directory creata: {$path} sul disco {$disk}");
            }

            // Determinazione del nome file
            if ($filename) {
                $targetPath = $path . '/' . $filename;
                if (!$overwrite && Storage::disk($disk)->exists($targetPath)) {
                    throw new Exception("Il file {$targetPath} esiste già sul disco {$disk}");
                }
                if ($file instanceof UploadedFile) {
                    Storage::disk($disk)->putFileAs($path, $file, $filename);
                } else {
                    Storage::disk($disk)->putFileAs($path, new File($file), $filename);
                }
                Log::info("File salvato: {$targetPath} sul disco {$disk}");
                return $targetPath;
            }

            // Salvataggio standard con nome generato automaticamente
            if ($file instanceof UploadedFile) {
                $savedPath = Storage::disk($disk)->putFile($path, $file);
            } else {
                $savedPath = Storage::disk($disk)->putFile($path, new File($file));
            }

            Log::info("File salvato: {$savedPath} sul disco {$disk}");
            return $savedPath;

        } catch (Exception $e) {
            Log::error("Errore salvataggio file: " . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Elimina un file dal disco.
     *
     * @param string $filePath
     * @param string|null $disk
     * @return bool
     */
    public function delete(string $filePath, ?string $disk = 'public'): bool
    {
        try {
            if (!Storage::disk($disk)->exists($filePath)) {
                Log::warning("Tentativo di eliminare file inesistente: {$filePath} sul disco {$disk}");
                return false;
            }
            $deleted = Storage::disk($disk)->delete($filePath);
            Log::info("File eliminato: {$filePath} sul disco {$disk}");
            return $deleted;
        } catch (Exception $e) {
            Log::error("Errore eliminazione file: " . $e->getMessage());
            return false;
        }
    }
}
