<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Karyawan;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;


class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            /*
            'no_telp' => ['required', 'string'],
            'jenis_kelamin' => ['required'],
            'tanggal_lahir' => ['required', 'date'],
            'alamat' => ['required', 'string'],
            'tanggal_masuk' => ['required', 'date'],
            */
        ]);

         //blokir kalau ada register dengan email yg sama dgn admin
        if ($request->email === 'tokoh@gmail.com') {
        return back()->withErrors(['email' => 'Email ini tidak bisa digunakan untuk registrasi.']);}


        /*
         User::create([
        'name' => 'Admin',
       // 'email' => 'admin@namatoko.com',
       'email' => 'tokoh@gmail.com',
        'password' => Hash::make('passwordadmin'),
        'role' => 'admin'
    ]);
    */
         
           $user = User::create([  //tmb
        'name' => $request->name,
        'email' => $request->email,
        'no_telp' => $request->no_telp,
        'jenis_kelamin' => $request->jenis_kelamin,
        'tanggal_lahir' => $request->tanggal_lahir,
        'alamat' => $request->alamat,
        'tanggal_masuk' => $request->tanggal_masuk,
        'password' => Hash::make($request->password),
        'role' => 'karyawan' // pastikan role default diisi karyawan
    ]);
        
    /*Karyawan::create([ //tmb
        'user_id' => $user->id,
        'name' => $user->name,
        'email' => $user->email,
        'password' => $user->password // jika perlu, atau hapus jika tidak perlu disimpan lagi
    ]);*/

    Karyawan::create([
        'user_id' => $user->id,
        'name' => $user->name,
        'email' => $user->email,
        /*
        'no_telp' => $request->no_telp,
        'jenis_kelamin' => $request->jenis_kelamin,
        'tanggal_lahir' => $request->tanggal_lahir,
        'alamat' => $request->alamat,
        'tanggal_masuk' => $request->tanggal_masuk,
        */
    // Field lain dibiarkan kosong/null dulu, nanti diisi admin
    ]);

        event(new Registered($user));

        Auth::login($user); 
      

         //return redirect()->route('karyawan.dashboard');  bnr
          // return redirect()->route('dashboard'); // tmb
          return redirect()->route('login')->with('status', 'Registrasi berhasil, silakan login.'); //tmb

    }
}

