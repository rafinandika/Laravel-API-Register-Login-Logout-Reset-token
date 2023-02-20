<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\IdRequest;
use App\Http\Resources\api\IdDetail;
use App\Models\Idmanager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class IdController extends Controller
{
    public function index(){
        $id= Auth::user()->id;
        $data = Idmanager::where('user_id', $id)->get();
        return response()->json($data);
    }

    public function show(Idmanager $id){

        $data = new IdDetail($id);
        return response()->json($data);
    }

    public function store(Request $request){
       $validation = Validator::make($request->all(), [
            'akun' => 'required',
            'id'=> 'required|numeric',
            'password' => 'required',
            'topup' => 'required',
            'kirim' => 'required'
        ]);
        if($validation->fails()){
            return response()->json([
                'success' => false,
                'massage' => 'Validasi gagal',
                'data' => $validation->errors()
            ]);
        }

        $input = array(
            'user_id' => Auth::user()->id,
            'akun' => $request->akun,
            'akun_id' => $request->id,
            'password'=> $request->password,
            'pertanyaan' => $request->pertanyaan,
            'top_up' => $request->topup,
            'kirim' => $request->kirim
        );
        $user = Idmanager::create($input);
         return response()->json([
                'success' => true,
                'massage' => 'Register success',
                'data' => $user
            ]);

    }
    public function update(IdRequest $request){
      

        $id = Auth::user()->id;
        $input = array(
            'akun' => $request->akun,
            'akun_id' => $request->id,
            'password'=> $request->password,
            'pertanyaan' => $request->pertanyaan,
            'top_up' => $request->topup,
            'kirim' => $request->kirim
        );

        $user = Idmanager::where('id', $id)
                            ->update($input);
        
        return response()->json([
                'success' => true,
                'massage' => 'Id Updated',
        ]);

    }

    public function destroy(Request $request){
        Idmanager::where('id', $request->id)->delete();
         return response()->json([
                'success' => true,
                'massage' => 'Id Deleted'
        ]);
    }
}