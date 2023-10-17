<?php

namespace App\Http\Controllers\Api;
 
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use App\Models\activatetokens;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Customer;
use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;

class AuthController extends BaseController
{
    protected function create(Request $request)
    {
        $data = $request->validate([
            'firstname' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'numeric', 'unique:users'],
            'phone' => ['required', 'string'],
            'email' => ['required', 'string'],
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        if (auth()->attempt($validator) || Customer::where('email','=',$request->email)->first())
        {
            return response()->json([
               'status'=>false,
                 'message'=>'هذا الايميل موجود مسبقاً'
            ]);    
       }
        /* Get credentials from .env
        $token = getenv("TWILIO_AUTH_TOKEN");
        $twilio_sid = getenv("TWILIO_SID");
        $twilio_verify_sid = getenv("TWILIO_VERIFY_SID");
        $twilio = new Client($twilio_sid, $token);
        $twilio->verify->v2->services($twilio_verify_sid)
            ->verifications
            ->create($data['phone_number'], "sms");
             */
        User::create([
            'firstname' => $data['firstname'],
            'lastname' => $data['lastname'],
            'phone' => $data['phone'],
            'email' => $data['email'],
        ]);
        $credentials = request(['email', 'password']);
        if (!Auth::guard('customer-api')->attempt(['email' => request('email'), 'password' => request('password')])) {
            return response()->json(['error' => 'Unauthorized'], 401);
       }  
       return response()->json([
           'message'=>'تم إنشاء الحساب بنجاح',
           'status'=>true,
           'data'=>$user,
           'code'=>$code
       ],200);
        
       // return redirect()->route('verify')->with(['phone_number' => $data['phone_number']]);
    }
    protected function verify(Request $request)
    {
        $data = $request->validate([
            'verification_code' => ['required', 'numeric'],
            'phone_number' => ['required', 'string'],
        ]);
        /* Get credentials from .env 
        $token = getenv("TWILIO_AUTH_TOKEN");
        $twilio_sid = getenv("TWILIO_SID");
        $twilio_verify_sid = getenv("TWILIO_VERIFY_SID");
        $twilio = new Client($twilio_sid, $token);
        $verification = $twilio->verify->v2->services($twilio_verify_sid)
            ->verificationChecks
            ->create($data['verification_code'], array('to' => $data['phone_number']));
            */
        //if ($verification->valid) {
            $user = User::where('phone_number', $data['phone_number'])->update(['isVerified' => true]);
            /* Authenticate user */
           // Auth::login($user->first());
            //return redirect()->route('home')->with(['message' => 'Phone number verified']);
    //    }
      //  return back()->with(['phone_number' => $data['phone_number'], 'error' => 'Invalid verification code entered!']);
    }
    public function requestRegisterOTP(Request $request)
    {
        $validatedData = $request->validate([
            'phone' => 'required|string|unique:users,phone', // Ensure the phone number is unique
        ]);

        $otp = rand(100000, 999999); // Generate a 6-digit OTP

        $twilio_sid = env('TWILIO_SID');
        $twilio_token = env('TWILIO_TOKEN');
        $twilio_phone = env('TWILIO_PHONE');
        $client = new Client($twilio_sid, $twilio_token);

        $client->messages->create(
            $validatedData['phone'],
            [
                'from' => $twilio_phone,
                'body' => "Your OTP for registration is: {$otp}"
            ]
        );

        // Store the OTP in the cache or a dedicated table with a timestamp to check its validity during registration.
        // For this example, we'll use Laravel's Cache facade.
        \Cache::put('otp_' . $validatedData['phone'], $otp, now()->addMinutes(10)); // OTP expires in 10 minutes

        return response()->json(['message' => 'OTP sent for registration!']);
    }
    
    public function registerWithOTP(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'required|string',
            'otp' => 'required|string',
        ]);

        // Verify if the OTP is correct
        $validOtp = \Cache::get('otp_' . $validatedData['phone']);

        if ($validatedData['otp'] !== $validOtp) {
            return response()->json(['message' => 'Invalid OTP'], 401);
        }

        // Invalidate the used OTP
        \Cache::forget('otp_' . $validatedData['phone']);

        // Create the new user
        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'phone' => $validatedData['phone'],
            'password' => Hash::make($validatedData['password']), // Make sure to hash the password
        ]);

        // Generate an access token for the authenticated user
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user
        ]);
    }

















    public function profile(Request $request)
    {
        Auth::user()->update([
            'Password'=>$request->password,
            'allow_notify'=>$request->password,
            'gender'=>$request->password,
            'State'=>$request->password,
        ]);
    }
    public function edit_profile(Request $request)
    { 
        $customer=Customer::where('id',Auth::guard('customer-api')->id())->first();
        $customer->update([
         'name'=>$request->name,
         'email'=>$request->email,
         'phone'=>$request->phone,
        ]);
        return $customer;
     }
     public function requestOTP(Request $request)
     {
         $validatedData = $request->validate([
             'phone' => 'required|string',
         ]);
         $user = User::firstOrCreate(['phone' => $validatedData['phone']]);
         $user->otp = rand(100000, 999999);
         $user->save();
 
         $twilio_sid = env('TWILIO_SID');
         $twilio_token = env('TWILIO_TOKEN');
         $twilio_phone = env('TWILIO_PHONE');
         $client = new Client($twilio_sid, $twilio_token);
 
         $client->messages->create(
             $validatedData['phone'],
             [
                 'from' => $twilio_phone,
                 'body' => "Your OTP for login is: {$user->otp}"
             ]
         );
 
         return response()->json(['message' => 'OTP sent!']);
     }
 
     public function loginWithOTP(Request $request)
     {
         $validatedData = $request->validate([
             'phone' => 'required|string',
             'otp' => 'required|string',
         ]);
 
         $user = User::where('phone', $validatedData['phone'])->where('otp', $validatedData['otp'])->first();
 
         if (!$user)
          {
             return response()->json(['message' => 'Invalid OTP'], 401);
           }
 
         $user->otp = null; // Invalidate the OTP
         $user->save();
 
         // Assuming you're using Laravel Sanctum for API token authentication
         $token = $user->createToken('auth_token')->plainTextToken;
         return response()->json(['access_token' => $token, 'token_type' => 'Bearer']);
     }


}
