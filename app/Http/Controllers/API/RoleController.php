<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Role;

class RoleController extends Controller
{
    public function listRoles()
    {
        $role = Role::where('id', '!=', 1)->where('id', '!=', 1)->orderBy('id')->get();
        return response()->json([
            'roles'=>$role
            ]);      
    }
    public function create(Request $request){
        // validation
        $validator = Validator::make($request->all(),[
            'role' => 'required'
        ]);

        if($validator->fails()){
            $response = [
                'success' => false,
                'message' => $validator->errors()
            ];
            return response()->json($response, 400);
        }

        $input = $request->all();
        $role = Role::create($input);
        
        $response = [
            'success' => true,
            'message' => 'Role Added Successfully'
        ];

        return response()->json($response,200);

    }
}
