# Laravel Helpers

Pacchetto Laravel per salvare ed eliminare file facilmente tramite Facade.

![PHP Version](https://img.shields.io/badge/php-8.0%2B-brightgreen)
![Laravel Version](https://img.shields.io/badge/laravel-10%2B-blue)

## Installazione

Installa il pacchetto via Composer:

composer require pucci/laravel-helpers

Il pacchetto supporta Laravel 10, 11 e 12 ed è pronto all’uso grazie all’**auto-discovery**.

---

## Facade

Il pacchetto fornisce la Facade **FileSaver**:

use FileSaver;

### Salvare un file

$path = FileSaver::save($request->file('documento'), 'uploads');
// $path contiene il percorso del file salvato

### Eliminare un file

FileSaver::delete($path);

---

## Esempio rapido

### Controller

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use FileSaver;

class FileTestController extends Controller
{
    public function upload(Request $request)
    {
        $path = FileSaver::save($request->file('documento'), 'uploads');
        return back()->with('success', "File salvato in: $path");
    }

    public function delete(Request $request)
    {
        $deleted = FileSaver::delete($request->input('file_path'));
        return back()->with('success', $deleted ? "File eliminato" : "File non trovato");
    }
}

### Route

Route::post('/file-test/upload', [FileTestController::class, 'upload'])->name('file.upload');
Route::post('/file-test/delete', [FileTestController::class, 'delete'])->name('file.delete');

---

## Licenza

MIT © [Christian Pucci](https://github.com/ChristianPucci91)
