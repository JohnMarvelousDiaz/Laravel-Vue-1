<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\VerificationOTP;
use Illuminate\Support\Str;
use App\Models\Verification;


class AuthController extends Controller
{
    /**
     * check email exist
     */

    public function limitEmail($email)
    {
        return User::where('email',$email)->exists();
    }



    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function checkAuth(Request $req)
    {
        $user = $req->user();
        if($user)
        {
            if(!$user->email_verified_at)
            {
                return response()->json([
                    'messaged'=>'unauthorized',
                    'url'=>'verify.html',
                ],401);
            }

            return response()->json([
                'user'=>$user
            ],200);
        }

        return response()->json([
            'url'=>'unauthenticated.html',
            'message'=>'unauthenticated',

        ],401);


    }

    public function checkGuest(Request $req)
    {
        $user = $req->user();

        if($user)
        {
            return response()->json([
                'message'=>'User is authenticated',
                'status'=>401,
            ],200);
        }

        return response()->json([
            'message'=>'User is guest'
        ],200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }
    /**
     for Login
    */
    public function auth(Request $req)
    {
        // $validate = Validator::make($req->all(),[
        //     'email'=>'required|string',
        //     'password'=>'required|string|min:8|max:16'
        // ]);


        // if($validate->fails())
        // {
        //     return response()->json([
        //         'errors'=>$validate->messages()
        //     ],422);
        // }

        if(Auth::check())
        {
            $user = Auth::user();
            $user->tokens()->delete();
        }

        $attempt = Auth::attempt(['email'=>$req->email,'password'=>$req->password]);

        if($attempt)
        {

            $user = Auth::user();
            $token = $user->createToken('auth-token')->plainTextToken;
            if($user->email_verified_at)
            {
                return response()->json([
                    'message'=>'User logged in',
                    'auth'=>$token,
                    'redirect'=>'home.html',
                    'user'=>$user->name
                ],200);
            }else{
                return response()->json([
                    'message'=>'User logged in',
                    'auth'=>$token,
                    'redirect'=>'verify.html',
                    'user'=>$user->name
                ],200);
            }

        }

        return response([
            'message'=>"wrong credentials"
        ],201);


    }

    /**
     * used to verify the registration !!
     * @param $token
     * @return \Illuminate\Http\RedirectResponse
     *
     *
     */

    public function verifyRegistration($token)
    {


        $verify = Verification::where('code',$token)->where('is_used',false)->first();

        if(!$verify)
        {
            return redirect()->to('http://127.0.0.1:5500/Pages/error.html');
        }

        $verify->is_used = true;
        $verify->save();

        $user = $verify->user;
        if(!$user)
        {
            return redirect()->to('http://127.0.0.1:5500/Pages/error.html');
        }
        $user->email_verified_at = Carbon::now();
        $user->save();

        return redirect()->to('http://127.0.0.1:5500/Pages/login.html');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // $validator = Validator::make($request->all(),[
        //     'email'=>'required|string',
        //     'name'=>'required|string|min:5|max:50',
        //     'password'=>'required|string|confirmed|min:8|max:16',
        //     'password_confirmation'=>'required|string|min:8|max:16'
        // ]);

        // if($validator->fails())
        // {
        //     return response()->json([
        //         'errors'=>$validator->messages()
        //     ],422);
        // }

        if($this->limitEmail($request->email))
        {
            return response()->json([
                'message'=>'Email already used'
            ],409);
        }




        $user = new User();
        $user->email = $request->email;
        $user->name = $request->name;
        $user->password = Hash::make($request->password);
        $result = $user->save();


        if($result)
        {

            $otp = Str::random(64);
            $verification = new Verification(['code'=>$otp]);
            $user->verifications()->save($verification);

            Mail::to($request->email)->send(new VerificationOTP($otp));
            return response()->json([
                'message'=>'User has been created'
            ],200);
        }

        return response()->json([
            'message'=>'Please contact the system admin'
        ],500);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $req)
    {
        $req->user()->tokens()->delete();
        return response()->json([
            'user'=>$req->user(),
            'message'=>'User has been logged out'
        ],200);

    }
}
