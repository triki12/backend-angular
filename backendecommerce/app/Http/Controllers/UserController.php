<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    //creation d'un user
    public function register(Request $req){
        $validator=Validator::make($req->all(),[
            'name'=>'required',
            'password'=>'required',
            'email'=>'required|unique:users',
        ]);
        if($validator->fails()){
            return  response()->json(['error'=>$validator->errors()->all()], 409);
        }
        $p=new User();
        $p->name=$req->name;
        $p->email=$req->email;
        $p->password=encrypt($req->password);
        $p->save();
        return  response()->json(['Message'=>'registré avec succés']);

    }

    public function login(Request $req){
        $validator=Validator::make($req->all(),[
            'password'=>'required',
            'email'=>'required|unique:users',
        ]);
        if($validator->fails()){
            return  response()->json(['error'=>$validator->errors()->all()], 409);
        }
        
        $user=User::where('email',$req->email)->get()->first();
        $password=decrypt($user->password);
        if($user && $password ==$req->password){
            return response()->json(['user'=>$user]);
        }
        else{
            return  response()->json(['error'=>'oopos! mail or password unverified'], 409);
 
        }
    }
}
