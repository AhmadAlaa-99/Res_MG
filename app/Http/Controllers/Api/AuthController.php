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
    public function login(Request $request)
    {
        $customer=Customer::where('phone',$request->phone)->first();
        if($customer->count() > 0)
        {
            if($customer->isVerified=="false"||$customer->is_complete=="false")
            {
                $otp=rand(000000,111111);
                $customer->update(['otp'=>$otp]);
                return response()->json([
                    'message'=>'register not completed - verify number',
                    'status'=>false,
                    'data'=>$customer,
                    'token'=>$token ]
                    ,205);
            }
        }
        $rules = [
            'phone' => 'required|numeric|digits:10|exists:customers,phone', 
            'password'=>'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        // Check if validation fails
        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors(),
                'status' => false,
            ], 403);
        }

        $customer = Customer::where('phone',$request->phone)->first();

          if (!$customer || !Hash::check($request->password, $customer->password)) {
            return response([
                'msg' => 'incorrect phone or password'
            ], 401);
        }
        $token = $customer->createToken('API Token')->accessToken;
        $res = [
            'user' => $user,
            'token' => $token
         ];

        return response()->json([
            'message'=>'sucssefull',
            'status'=>true,
            'data'=>$customer,
            'token'=>$token ]
            ,200);
    }

    public function create(Request $request)
    {   
        $customer=Customer::where('phone',$request->phone)->first();
        if($customer)
        {
            if($customer->isVerified=="false"||$customer->is_complete=="false")
            {
                $otp=rand(000000,111111);
                $customer->update(['otp'=>$otp]);
                return response()->json([
                    'message'=>'register not completed - verify number',
                    'status'=>false,
                    'data'=>$customer,
                    'token'=>$token ]
                    ,205);
            }
        }

            $data = $request->all();
            $otp=rand(000000,111111);
            $rules = [
                'firstname' => 'required|min:3|max:20',
                'lastname' => 'required|min:3|max:20',
                'phone' => 'required|numeric|digits:10|unique:customers,phone', // assuming phone numbers are 10 digits long
                'email' => 'email|unique:customers,email',
                // Add other fields as needed
            ];  
             // Create validator
            $validator = Validator::make($request->all(), $rules);
            // Check if validation fails
            if ($validator->fails()) {
                return response()->json([
                    'message' => $validator->errors(),
                    'status' => false,
                ], 403);
            }
             Customer::create([
            'firstname' => $data['firstname'],  //min:3 max:20  req
            'lastname' => $data['lastname'],  //min:3 max:20  req
            'phone' => $data['phone'],  ////09 : 8numbers numeric  unique req
            'email' => $data['email'],  //email unique  
            'otp'=>$otp,  
        ]); 
        $customer=Customer::latest()->first();
        return response()->json([
           'message'=>'Code Send',
           'status'=>true,
           'data'=>$customer,
           'otp'=>$otp]
           ,200);
    }
    public function verify(Request $request)
    {
        $data = $request->all();
        // ([
        //     'otp' => ['required', 'numeric'],
        //     'phone' => ['required', 'string'],
        // ]);
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
            $customer = Customer::where('phone', $data['phone_number'])->first();
            $customer->update(['isVerified' => true,'otp'=>'-']);
                  //code : required - numeric - num:5
            /* Authenticate user */
           // Auth::login($user->first());
            //return redirect()->route('home')->with(['message' => 'Phone number verified']);
    //    }
    $token = $customer->createToken('API Token')->accessToken;
    return response()->json([
        'message'=>'Successfull',
        'status'=>true,
        'data'=>$customer,
        'token'=>$token
    ],200);    
    }
    public function register_complete(Request $request)
    {

        $customer=Customer::where('phone',$request->phone)->first();
        $rules = [
            'password' => 'required|confirmed|min:8|regex:/[a-zA-Z0-9@!#£$%^&*()_+{}":;\'?\/\\.,`~]+/',
            'gender' => 'required|in:male,female',
            'State' => 'required',
            'profile_pic' => 'sometimes|image|max:500', // max 500KB
            'birth_date'=>'required'
            
        ];
        // Create validator
        $validator = Validator::make($request->all(), $rules);
    
        // Check if validation fails
        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors(),
                'status' => false,
            ], 403);
        }
        // Your existing update logic
        $customer->update([
            'password' => bcrypt($request->password),
            'allow_notify' => $request->allow_notify,
            'gender' => $request->gender,
            'is_complete'=>'1',
            'State' => $request->State,
            'birth_date'=>$request->birth_date,
        ]);
        if ($request->hasfile('profile_pic')) {
            $file = $request->file('profile_pic');
            $name = $file->getClientOriginalName();
            $file->storeAs('Users/profile_pic/'.$customer->phone, $name, 'upload_images');
            $customer->update(['profile_pic' => $name]);
        }
        return response()->json([
            'message' => 'Successful',
            'status' => true,
            'data' => $customer,
        ], 200);
    }
    public function profile(Request $request)
    {
        $customer=Auth::guard('customer-api')->user()->first();
        return $this->sendResponse($customer,'profile'); 
    }
    public function edit_profile(Request $request)
    { 
        $customer=Customer::where('id',Auth::guard('customer-api')->id())->first();
        $rules = [
            'firstname' => 'required|min:3|max:20',
            'lastname' => 'required|min:3|max:20',
            'phone' => 'required|numeric|digits:10|unique:customers,phone', // assuming phone numbers are 10 digits long
            'email' => 'email',
            'state' => 'required',
            'gender' => 'required',
        ];  
         // Create validator
        $validator = Validator::make($request->all(), $rules);
        // Check if validation fails
        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors(),
                'status' => false,
            ], 403);
        }
        $customer->update([
         'firstname'=>$request->firstname,
         'lastname'=>$request->lastname,
         'State'=>$request->location,
         'email'=>$request->email,
         'gender'=>$request->gender,
        ]);
        return $this->sendResponse($customer,'update successfully');
     }
     public function resetPassword(Request $request)
     {
         $validator=Validator::make(
             $request->all(),
             [
                 'oldpassword'=>'required',
                 'newpassword'=>'required',
                 'c_newpassword'=>'required|same:password'
             ]);
             $customer=Auth::guard('customer-api')->first();
             if ($request->oldpassword=$customer->password)
             {
              $customer->password=bcrypt($request->newpassword);
              $customer->save();  
              return $this->sendResponse($customer,'reset password Successfully!'); 
             }
             return 'old password incorrect';
         }
         public function sendVerify_password(Request $request)
         {
            $validator=Validator::make(
                $request->all(),
                [
                    'phone'=>'required|exists:customers,phone',
                 ]);
                if ($validator->fails())
                {
                    return $this->sendError($validator->errors()->first());
                }
            $customer=Customer::where('phone',$request->phone)->first();
            if($customer)
            {
                $code=random_int(1000,9999);
                $customer->update([
                    'otp'=>$code
                ]);
             return $this->sendResponse($code, 'send code');
            }
            else
            {
                return $this->sendError(' Error', ['error', 'Unauthorized']);
            }
         }
         public function new_password(Request $request)
         {
            $customer=Customer::where('phone',$request->phone)->first();
            $validator=Validator::make(
                $request->all(),
                [
                    'newpassword'=>'required|min:8|max:60',
                    'c_newpassword'=>'required|same:password',
                ]);
                $customer=Auth::guard('customer-api')->first();
             $customer->password=bcrypt($request->newpassword);
             $token = $customer->createToken('API Token')->accessToken;
             return response()->json([
                 'message'=>'Successfull update_password',
                 'status'=>true,
                 'data'=>$customer,
                 'token'=>$token
             ],200);    
    
         }
         

   


}
