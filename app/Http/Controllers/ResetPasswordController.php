<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon; // Perbaiki penulisan 'carbon' menjadi 'Carbon'
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

        // Membuat password baru
        $str = $this->generateRandomPassword();

        // Siapkan pesan untuk dikirimkan
        $pesan = 'Halo, ini adalah password baru kamu (Peringatan! ini merupakan ujicoba Webhook "API WHATSAPP TESTING" WEBSITE PAVING) Password: ' . $str;

        // Inisialisasi cURL
        $curl = curl_init();
        $token = "bm6fMBUEfc8865rAhFPZ"; // Gantilah dengan token yang sesuai
        $url = "https://api.fonnte.com/send"; // Gantilah URL dengan yang sesuai

        // Setel opsi cURL untuk mengirim pesan ke API
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
                'target' => $request->nomer, // Mengambil nomor telepon dari input user
                'message' => $pesan, // Pesan yang akan dikirim
                'countryCode' => '62' // Kode negara Indonesia
            ],
            CURLOPT_HTTPHEADER => [
                'Authorization: ' . $token // Menambahkan header otorisasi dengan token
            ],
        ]);

        // Eksekusi cURL dan ambil respons
        $response = curl_exec($curl);

        // Tangani error jika ada masalah dengan cURL
        if (curl_errno($curl)) {
            $error_msg = curl_error($curl);
            curl_close($curl);
            return redirect('/reset-password')->withErrors(['error' => $error_msg]); // Kembalikan error jika gagal
        }

        // Menutup koneksi cURL setelah permintaan selesai
        curl_close($curl);

        // Cek apakah nomor telepon ada dalam database
        $user = User::where('phone', $request->nomer)->first();
        if ($user) {
            // Jika user ditemukan, reset password
            $user->password = bcrypt($str); // Enkripsi password baru
            $user->updated_at = Carbon::now(); // Update timestamp
            $user->save();

            // Redirect ke halaman beranda setelah berhasil
            return redirect('/')->with('status', 'Password berhasil direset dan dikirim ke nomor Anda.');
        } else { 
            // Jika nomor telepon tidak ditemukan
            return redirect('/reset-password')->withErrors(['nomer' => 'Nomor telepon tidak terdaftar.']);
        }
    }

    // Fungsi untuk menghasilkan password acak
    private function generateRandomPassword()
    {
        return Str::random(4); // Membuat password acak dengan panjang 12 karakter
    }
}
