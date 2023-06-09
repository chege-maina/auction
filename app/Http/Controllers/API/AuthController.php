<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Validator;
use App\Models\User;
use App\Mail\RegEmail;
use Illuminate\Support\Facades\Mail;

use App\Events\UserEvent;

class AuthController extends Controller
{
    public function listUsers()
    {
        $user = User::with('roles')->where('role_id', '!=', 1)->orderBy('id')->get();
       
        return response()->json([
            'user' => $user
        ]);
    }
    public function listClients()
    {
        
        $user = User::with('roles')->where('role_id', '=', 5)->orderBy('id')->get();
        return response()->json([
            'user' => $user
        ]);
    }
    public function getEmail(Request $request, $email)
    {
        if ($request->isMethod('post')) {

            $user = User::where('email', '=', $email)->orderBy('id')->get();
            return response()->json([
                'user' => $user
            ]);
        }
    }
    public function forgotPassword(Request $request)
    {
        if ($request->isMethod('post')) {
            // validation
            $validator = Validator::make($request->all(), [
                'email' => 'required|email'
            ]);

            if ($validator->fails()) {
                $response = [
                    'success' => false,
                    'message' => "Invalid email entered. Please Enter fields correctly"
                ];
                return response()->json($response);
            }
            $user = User::where('email', $request->email)->first();
            if ($user) {

                $status = $user->status;
                if ($status < 2) {
                    $response = [
                        'success' => false,
                        'message' => "User is Not Active. Contact Support"
                    ];
                    return response()->json($response);
                } else {

                    $date = date('Y/m/d H:i:s');

                    $mailData = [
                        'email' => $user->email,
                        'name' => $user->name,
                        'title' => "Password Change Request",
                        'subject' => "Change Password",
                        'message' => "We received a request to change your password.",
                        'bold' => "If you have submitted this request, click link below to change your password.",
                        'linktext' => "Click here to change your password...",
                        'link' => env('APP_URL') ."/changepsw/" . base64_encode($user->email . " old " . $date)
                    ];


                    Mail::to($user->email)->send(new RegEmail($mailData));

                    $response = [
                        'success' => true,
                        'data' => $user,
                        'message' => 'Reset Password Link Sent to Your Email.'
                    ];
                    return response()->json($response, 200);
                }
            } else {
                $response = [
                    'success' => false,
                    'message' => "Email Not Registered"
                ];
                return response()->json($response);
            }
        }
    }
    public function changePassword(Request $request, $id)
    {
        if ($request->isMethod('post')) {
            // validation
            $validator = Validator::make($request->all(), [
                'password' => [
                    'required',
                    'min:8',
                    //'regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$#%]).*$/',
                ],
                'c_password' => 'required|same:password'
            ]);

            if ($validator->fails()) {
                $response = [
                    'success' => false,
                    'message' => "Two password must match and be 8 or more characters"
                ];
                return response()->json($response, 400);
            }

            //$user = User::where('email', '=', $email)->orderBy('id')->get();
            $user  = User::findOrfail($id);
            $user->password = bcrypt($request->get('password'));
            $user->status = 2;
            $user->save();
            $response = [
                'success' => true,
                'message' => 'User registered successfully'
            ];

            return response()->json($response, 200);
        }
    }
    public function editUser(Request $request)
    {
        if ($request->isMethod('post')) {
            // validation
            $validator = Validator::make($request->all(), [
                'id' => 'required',
                'name' => 'required',
                'email' => 'required|email',
                'role_id' => 'required'
            ]);

            if ($validator->fails()) {
                $response = [
                    'success' => false,
                    'message' => "Fill in all the Fields Below Properly"
                ];
                return response()->json($response, 400);
            }

            //$user = User::where('email', '=', $email)->orderBy('id')->get();
            $user = User::where('id', $request->id)->first();
            $user->email = $request->get('email');
            $user->name = $request->get('name');
            $user->role_id = $request->get('role_id');
            $user->save();
            $response = [
                'success' => true,
                'message' => 'User registered successfully'
            ];

            return response()->json($response, 200);
        }
    }
    public function changeStatus(Request $request)
    {

        $user = User::where('id', $request->id)->first();
        $user->status = $request->get('status');
        $user->save();
        $response = [
            'success' => true,
            'message' => 'User registered successfully'
        ];

        return response()->json($response, 200);
    }
    public function deleteUser(Request $request, $id)
    {
        if ($request->isMethod('post')) {

            $user = User::findOrfail($id);

            $user->delete();
            $response = [
                'success' => true,
                'message' => 'User registered successfully'
            ];

            return response()->json($response, 200);
        }
    }
    public function register(Request $request)
    {
        // validation
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'role_id' => 'required'
        ]);

        if ($validator->fails()) {
            $response = [
                'success' => false,
                //'message' => $validator->errors()
                'message' => "Fill in all the Fields Below Properly"
            ];
            return response()->json($response, 400);
        }

        $password = $this->generateRandomString();


        $mailData = [
            'email' => $request->email,
            'name' => $request->name,
            'title' => " Welcome to Log & Bid system",
            'subject' => "Account Activation",
            'message' => "This message is to let you know that your account at Log & Bid
            System is ready to be used.",
            'bold' => "You are required to use the link below to create your password and
            activate your account.",
            'linktext' => "Click here to activate your account...",
            'link' => env('APP_URL') . "/changepsw/" . base64_encode($request->email . " new")
        ];



        $input = $request->all();
        $input['password'] = $password;

        $input['password'] = bcrypt($input['password']);
        try {

            try {
               User::create($input);
               $user = User::with('roles')->where('role_id', '!=', 1)->orderBy('id')->get();
               //die($user);
               broadcast(new UserEvent($user))->toOthers();
            } catch (\Throwable $th) {
                $response = [
                    'success' => false,
                    'message' => "User Email Already Exists".$th
                ];
                return response()->json($response);
            }
            Mail::to($request->email)->send(new RegEmail($mailData));


            $response = [
                'success' => true,
                'message' => 'User registered successfully'
            ];

            return response()->json($response, 200);
        } catch (\Throwable $th) {
            $response = [
                'success' => false,
                'message' => "User registered but Verification Email Not Sent"
            ];
            return response()->json($response);
        }
    }
    public function login(Request $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            $success['token'] = $user->createToken('Auction-' . $user->name)->plainTextToken;
            $success['name'] = $user->name;
            $success['id'] = $user->id;
            $success['role'] = $user->role_id;
            $success['email'] = $user->email;
            $status = $user->status;
            if ($status < 2) {
                $response = [
                    'success' => false,
                    'message' => "User is Not Active. Contact Support"
                ];
                return response()->json($response);
            } else {
                $response = [
                    'success' => true,
                    'data' => $success,
                    'message' => 'User login successfully'
                ];
                return response()->json($response, 200);
            }
        } else {
            $response = [
                'success' => false,
                'message' => 'User Login Failed!'
            ];
            return response()->json($response);
        }
    }
    function generateRandomString($length = 10)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
    function CurrentDate()
    {
        $date = date('Y/m/d H:i:s');
        return response()->json([
            'date' => $date
        ]);
    }
}
