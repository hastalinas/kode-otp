<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Str;
use App\Model\FirebaseController;
use Kreait\Laravel\Firebase\Facades\Firebase;

class OtpController extends Controller

{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function login(Request $request)
    {
        $this->validate($request, [
            'number' => 'required',
            'email' => 'required|email:dns'
        ]);
        
        $user = User::where('number', $request->number)->first();
        if ($user) {
            return response()->json([
                'status' => true,
                'message' => 'Berhasil Login',
                'data' => $user
            ], 200);
        }

        return response()->json([
            'status' => false,
            'message' => 'Email atau Nomor tidak sesuai',
            'data' => '',
        ], 404);
    }

    public function register(Request $request)
    {
        $this->validate($request, [
            'number' => 'required|unique:user',
            'email' => 'required|email:dns|unique:user',
            'name' => 'required',
        ]);

        $user = User::create([
            'number' => $request->number,
            'email' => $request -> email,
            'name' => $request->name
        ]);

        if ($user) {
            return response()->json([
                'status' => true,
                'message' => 'User created !',
                'data' => $user
            ], 201);
        }

        return response()->json([
            'status' => false,
            'message' => 'Error',
            'data' => ''
        ], 402);
    }

    public function updateuser(Request $request, $id)
    {
        $this->validate($request, [
            'number' => $request->number ? 'required' : '',
            'email' => $request->email ? 'required|email:dns' : '',
            'name' => $request->name ? 'required' : '',
        ]);

        $user = User::find($id);
        $user->number = $request->number ? $request->number : $user->number;
        $user->email = $request->email ? $request->email : $user->email;
        $user->name = $request->name ? $request->name : $user->name;
        $user->save();
        return response()->json([
            'status' => true,
            'Message' => 'Profile Updated',
            'data' => $user
        ], 200);
    }

    public function send(Request $request)
    {
        $otp = mt_rand(1000, 10000);
        $request->session()->put('otp', $otp);
        $basic  = new \Vonage\Client\Credentials\Basic("8e2ecf10", "KMMxNlp7rXRyL93F");
        $client = new \Vonage\Client($basic);
        $response = $client->sms()->send(
            new \Vonage\SMS\Message\SMS($request->phone_number, 'Programmer Lokal', "Kode Otp " . $request->session()->get('otp') . " jangan kasih kode ini kepada siapapun ")
        );

        $message = $response->current();

        if ($message->getStatus() == 0) {
            return response()->json([
                'status' => true,
                'message' => 'The message was sent successfully',
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => "The message failed with status: " . $message->getStatus() . "\n"
            ], 400);
        }
    }

    public function verify(Request $request)
    {
        if ($request->otp == $request->session()->get('otp')) {
            $request->session()->forget('otp');
            return response()->json([
                'status' => true,
                'message' => 'Verfikasi Berhasil'
            ], 200);
        }
        return response()->json([
            'status' => false,
            'message' => 'Kode Otp tidak valid'
        ], 404);
    }
}
