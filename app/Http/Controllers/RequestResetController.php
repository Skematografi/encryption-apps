<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ResetPasswordEmail;
use Illuminate\Support\Facades\URL;

class RequestResetController extends Controller
{
    public function request()
    {
        $data = [
            'message' => ''
        ];

        return view('auth.request', $data);
    }

    public function requestReset(Request $request)
    {
        $word = $request->email_or_username;

        $user = User::where('username', $word)
            ->orWhere('email', $word)
            ->first();

        if (!$user) {
            $message = "Email atau Username tidak ditemukan.";
        } else {
            $user_id = $user->id;
            $getEmail = $user->email;
            $explode = explode("@", $getEmail);
            $splitChar = str_split($explode[0]);
            $email_encrypt = $splitChar[0] . str_repeat('*', (sizeof($splitChar) - 1)) . '@' . $explode[1];

            $message = "Instruksi pengaturan ulang kata sandi telah dikirim ke $email_encrypt. Anda dapat memeriksa email Anda sekarang!";

            $admin = User::where('role_id', 1)->get();
            foreach ($admin as $item) {
                $url = URL::to("/users/$user_id/reset");

                $details = [
                    'name' => $item->name,
                    'username' => $user->username,
                    'full_name' => $user->name,
                    'email' => $user->email,
                    'message' => 'Permintaan untuk reset password.',
                    'sub_message' => 'Dengan detail user dibawah ini.',
                    'url' => $url,
                    'label_url' => 'Klik link untuk reset password user',
                    'type' => 0
                ];

                $subject = 'Password Reset Request';

                Mail::to($item->email)->send(new ResetPasswordEmail($details, $subject));
            }
        }

        $data = [
            'message' => $message
        ];

        return view('auth.request', $data);
    }
}
