<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\TemporaryUser;
use Illuminate\Http\Request;
//use Illuminate\Support\Facade\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\VerificationCodeMail;
use Brick\Math\BigInteger;

use function Laravel\Prompts\password;

class UserController extends Controller
{
  
    public function login(Request $request){
        $request->validate([
          
             'number'=>'required|string|max:10',
            'password'=>'required|string|max:15|min:8'
        ]);
       if (!Auth::attempt($request->only('number','password')))
return response()->json(['message'=>'invaild number or password'],401);
$user= User::where ('number',$request->number)->FirstOrFail();
$token=$user->createToken('myToken')->plainTextToken;

    }
   
  

    public function logout(Request $request){
$request->user()->currentAccessToken()->delete();
return response()->json(['message =>logout Successful'],200);
    }
    public function sendVerificationCode(Request $request)
{
    $validatedData = $request->validate([
        'email' => 'required|string|email|max:30|unique:temporary_users',
        'number' => 'required|string|max:15',
        'password'=>'required|string|max:15|min:8'
    ]);

    $verificationCode = Str::random(4);

    TemporaryUser::create([
        'email' => $validatedData['email'],
        'number' => $validatedData['number'],
        'verification_code' => $verificationCode,
        'expires_at' => now()->addMinutes(30),
    ]);

    Mail::to($validatedData['email'])->send(new VerificationCodeMail($verificationCode));

    return response()->json(['message'=>'Verification code sent.'],201);
}
public function verifyCode(Request $request)
{
    $validatedData = $request->validate([
        'email' => 'required|string|email|max:255',
        'code' => 'required|string|max:4',
    ]);

    $temporaryUser = TemporaryUser::where('email', $validatedData['email'])
        ->where('verification_code', $validatedData['code'])
        ->where('expires_at', '>=', now())
        ->first();

    if ($temporaryUser) {
        return response()->json(['message' => 'Code verified.'],200);
    } else {
        return response()->json(['message' => 'Invalid or expired code.'], 400);
    }
}
public function dataEntry(Request $request)
{
    $validatedData = $request->validate([
        'first_name'=>'required|string|max:15',
        'last_name'=>'required|string|max:15',
         'profile_picture'=>'string|max:255',
         'email'=>'required|string|email|max:30|unique:users,email',
          'location'=>'required|string|max:100',
          'card_number'=>'required|integer|max:20',
          'number'=>'required|int|max:10',
         'password'=>'required|string|max:15|min:8'
    ]);

    User::create([
        'first_name' => $validatedData['first_name'],
        'last_name' => $validatedData['last_name'],
        'password' => Hash::make('default_password'),
        'email' => $validatedData['email'],
        'number' => $validatedData['number'],
        'card_number' => $validatedData['card_number'],
        'profile_picture' => $validatedData['profile_picture'],
        'location' => $validatedData['location']

    ]);

    return response()->json(['message' => 'User registered successfully.'],201);
}


    //
}
