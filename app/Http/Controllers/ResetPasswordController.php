<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Str;

class ResetPasswordController extends Controller
{
    // Menampilkan halaman reset password
    public function reset_password()
    {
        return view('reset_password');
    }

    // Proses reset password
    public function reset_password_proses(Request $request)
    {
        // Validasi input
        $request->validate([
            'nomer' => 'required|numeric|digits_between:10,15'
        ]);

        // Cek apakah nomor telepon ada dalam database
        $user = User::where('phone_number', $request->nomer)->first();
        if (!$user) { 
            return redirect('/reset-password')->withErrors(['nomer' => 'Nomor telepon tidak terdaftar.']);
        }

        // Membuat password baru
        $str = $this->generateRandomPassword();

        $pesan = 'Halo, ini adalah password baru kamu (Peringatan! ini merupakan ujicoba Webhook "API WHATSAPP TESTING" WEBSITE PAVING) Password: ' . $str;

        // Inisialisasi cURL
        $curl = curl_init();

        $token = "bm6fMBUEfc8865rAhFPZ";
        $url = "https://api.fonnte.com/send";

        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => [
                'target' => $request->nomer,
                'message' => $pesan,
                'countryCode' => '62'
            ],
            CURLOPT_HTTPHEADER => [
                'Authorization: ' . $token
            ],
        ]);

        $response = curl_exec($curl);

        if (curl_errno($curl)) {
            $error_msg = curl_error($curl);
            curl_close($curl);
            return redirect('/reset-password')->withErrors(['error' => $error_msg]);
        }

        curl_close($curl);

        // Simpan password baru
        $user->password = bcrypt($str);
        $user->updated_at = Carbon::now();
        $user->save();

        return redirect('/')->with('status', 'Password berhasil direset dan dikirim ke nomor Anda.');
    }

    // Fungsi untuk menghasilkan password acak
    private function generateRandomPassword()
    {
<<<<<<< HEAD
        return Str::random(8);
=======
        return Str::random(4);
>>>>>>> d76b8a2b8e63c4187c6e59c3e92145e9a9e5c106
    }
}