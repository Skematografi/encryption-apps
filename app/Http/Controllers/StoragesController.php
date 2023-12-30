<?php

namespace App\Http\Controllers;

use App\CaesarChiper;
use App\AppHelper;
use App\Storages;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use RealRashid\SweetAlert\Facades\Alert;

class StoragesController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            $hasAccess = AppHelper::checkAuthorization(Auth::user()->role_id, 'Storages');
            if (!$hasAccess) {
                throw new AuthorizationException('Access Denied You don’t have permission to access');
            }

            return $next($request);
        });

        $path = public_path("storage/uploads/tmp");
        if (is_dir($path)) {
            AppHelper::deleteDir($path);
        }
    }

    public function index()
    {
        $data = [
            'storages' => Storages::fetchData(),
            'access_controls' => AppHelper::getRoleAndPermission(),
            'access' => AppHelper::getRoleAndPermission('Storages', true)
        ];

        return view('storages', $data);
    }

    public function rename(Request $request)
    {
        if (Storages::firstWhere('filename', trim($request->rename))) {
            Alert::error('Gagal', 'Nama file sudah ada');
            return redirect('storages');
        }

        $model = Storages::firstWhere('id', $request->file_id);
        $model->filename = trim($request->rename);
        $model->save();

        Alert::success('Berhasil', 'File berhasil direname');
        return redirect('storages');
    }

    public function store(Request $request)
    {
        if (isset($_FILES['file']['tmp_name'])) {
            for ($i = 0; $i < sizeof($_FILES['file']['tmp_name']); $i++) {
                $getProperti = explode('.', $_FILES['file']['name'][$i]);
                $extension = end($getProperti);
                $size = $_FILES['file']['size'][$i];
                $originalName = $_FILES['file']['name'][$i];
                $imageName = str_replace('.' . $extension, '', $originalName);
                $unique_filename = $imageName . '_' . time() . '.' . $extension;
                $path = "storage/uploads/";
                $checkPath = public_path($path);
                if (!is_dir($checkPath)) {
                    mkdir($checkPath);
                }
                move_uploaded_file($_FILES['file']['tmp_name'][$i], public_path($path . $unique_filename));

                if (Storages::firstWhere('filename', $imageName)) {
                    $imageName = $imageName . '_' . time();
                }

                Storages::create([
                    'user_id' => auth()->user()->id,
                    'filename' => $imageName,
                    'extension' => $extension,
                    'unique_filename' => $unique_filename,
                    'size' => ($size / 1024),
                    'status' => false,
                    'path' => $path . $unique_filename
                ]);
            }

            return response()->json(['success' => $imageName]);
        }

        return response()->json(['error' => "Failed upload file"]);
    }

    public function destroy($id)
    {
        $storages = Storages::firstWhere('id', $id);

        if ($storages->key) {
            Alert::error('Gagal', 'File enkripsi tidak bisa dihapus');
            return redirect('storages');
        }

        if(file_exists(public_path($storages->path))){
            unlink(public_path($storages->path));
        }

        $storages->forceDelete();

        Alert::success('Berhasil', 'File berhasil dihapus');
        return redirect('storages');
    }

    public function download($id)
    {
        $storages = Storages::firstWhere('id', $id);
        $filename = $storages->filename . '.' . $storages->extension;
        $source = public_path($storages->path);
        $dirPath = public_path("/storage/uploads/tmp");
        if (!is_dir($dirPath)) {
            mkdir($dirPath);
        }

        $newFile = $dirPath . "/copy_" . $storages->unique_filename;
        copy($source, $newFile);

        $decrypted = function ($file, $key, $iv) {
            $cipher = 'aes-256-cbc';
            return openssl_decrypt($file, $cipher, $key, OPENSSL_RAW_DATA, $iv);
        };

        $content = file_get_contents($newFile);
        $decrypted = $decrypted($content, $storages->key, $storages->init_vector);
        file_put_contents($newFile, $decrypted);

        return Response::download($newFile, $filename);
    }

    public function encryption(Request $request)
    {
        $storages = Storages::firstWhere('id', $request->file_id);
        $storages->status = true;
        $storages->key = $this->caesarChiper($request->secret_key);
        $source = public_path($storages->path);

        $encrypted = function ($file, $key, $iv) {
            $cipher = 'aes-256-cbc';
            return openssl_encrypt($file, $cipher, $key, OPENSSL_RAW_DATA, $iv);
        };

        $content = file_get_contents($source);
        $random = AppHelper::generateRandomString(16);
        $encrypted = $encrypted($content, $storages->key, $random);
        file_put_contents($source, $encrypted);

        $storages->init_vector = $random;
        $storages->save();

        Alert::success('Berhasil', 'File berhasil dienkripsi');
        return redirect('storages');
    }

    public function decryption($id)
    {
        $storages = Storages::firstWhere('id', $id);
        $source = public_path($storages->path);

        $decrypted = function ($file, $key, $iv) {
            $cipher = 'aes-256-cbc';
            return openssl_decrypt($file, $cipher, $key, OPENSSL_RAW_DATA, $iv);
        };

        $content = file_get_contents($source);
        $decrypted = $decrypted($content, $storages->key, $storages->init_vector);
        file_put_contents($source, $decrypted);

        $storages->status = false;
        $storages->key = null;
        $storages->init_vector = null;
        $storages->save();

        Alert::success('Berhasil', 'File berhasil didekripsi');
        return redirect('storages');
    }

    private function caesarChiper($string)
    {
        $arr_string = str_split($string);
        $keyEncryption = '';
        foreach ($arr_string as $char) {
            $chipers = CaesarChiper::where('key', '=', $char)->get();
            foreach ($chipers as $chiper) {
                if ($char === $chiper->key) {
                    $keyEncryption .= $chiper->value;
                }
            }
        }

        return $keyEncryption;
    }
}
