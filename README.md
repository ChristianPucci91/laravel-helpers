
# Laravel Helpers

Pacchetto Laravel per gestire file e mail in modo semplice e dinamico tramite Facade.

![PHP Version](https://img.shields.io/badge/php-8.0%2B-brightgreen)
![Laravel Version](https://img.shields.io/badge/laravel-10%2B-blue)

## Installazione

Installa il pacchetto via Composer:

```bash
composer require pucci/laravel-helpers
```

Il pacchetto supporta Laravel 10, 11 e 12 ed è pronto all’uso grazie all’**auto-discovery**.

## FileSaver

La Facade **FileSaver** permette di salvare ed eliminare file con molte opzioni dinamiche.

```php
use FileSaver;
```

### Salvare un file (UploadedFile da request)

```php
$uploadedFile = $request->file('documento');

$path = FileSaver::save(
    $uploadedFile,
    'uploads',
    'public',
    null,
    true
);
```

### Salvare un file (file locale sul server)

```php
$localPath = storage_path('app/example.txt');

$path = FileSaver::save(
    $localPath,
    'backups',
    'local',
    'example_backup.txt',
    false
);
```

### Eliminare un file

```php
$deleted = FileSaver::delete('uploads/nome-file.txt', 'public');
```

## Esempio rapido di Controller

```php
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use FileSaver;

class FileTestController extends Controller
{
    public function upload(Request $request)
    {
        $path = FileSaver::save(
            $request->file('documento'),
            'uploads',
            'public',
            null,
            true
        );

        return back()->with('success', "File salvato in: $path");
    }

    public function delete(Request $request)
    {
        $deleted = FileSaver::delete($request->input('file_path'));
        return back()->with('success', $deleted ? "File eliminato" : "File non trovato");
    }
}
```

## Esempio Route

```php
Route::post('/file-test/upload', [FileTestController::class, 'upload'])->name('file.upload');
Route::post('/file-test/delete', [FileTestController::class, 'delete'])->name('file.delete');
```

## Vista Blade di esempio

```blade
<form action="{{ route('file.upload') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="file" name="documento" required>
    <button type="submit">Carica file</button>
</form>

<form action="{{ route('file.delete') }}" method="POST">
    @csrf
    <input type="text" name="file_path" placeholder="Percorso file da eliminare" required>
    <button type="submit">Elimina file</button>
</form>
```

## Licenza

MIT © [Christian Pucci](https://github.com/ChristianPucci91)
