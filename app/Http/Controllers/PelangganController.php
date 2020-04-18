<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pelanggan;
use Auth;
use DB;
use Illuminate\Support\Facades\Validator;

class PelangganController extends Controller
{
    public function index($id)
    {
        if(Auth::user()->level=="admin"){
            $pelanggan=DB::table('pelanggan')
            ->where('pelanggan.id',$id)
            ->get();
            return response()->json($pelanggan);
        }else{
            return response()->json(['status'=>'anda bukan admin']);
        }
    }
    public function store(Request $req)
    {
        if(Auth::user()->level=="admin"){
        $validator=Validator::make($req->all(),
        [
            'nama_pelanggan'=>'required',
            'no_ktp'=>'required',
            'alamat'=>'required',
            'no_telp'=>'required'
        ]
        );
        if($validator->fails()){
            return Response()->json($validator->errors());
        }

        $simpan=Pelanggan::create([
            'nama_pelanggan'=>$req->nama_pelanggan,
            'no_ktp'=>$req->no_ktp,
            'alamat'=>$req->alamat,
            'no_telp'=>$req->no_telp
        ]);
        $status=1;
        $message="Pelanggan Berhasil Ditambahkan";
        if($simpan){
          return Response()->json(compact('status','message'));
        }else {
          return Response()->json(['status'=>0]);
        }
      }
      else {
          return response()->json(['status'=>'anda bukan admin']);
      }
  }
    public function update($id,Request $request){
        if(Auth::user()->level=="admin"){
        $validator=Validator::make($request->all(),
            [
                'nama_pelanggan'=>'required',
                'no_ktp'=>'required',
                'alamat'=>'required',
                'no_telp'=>'required'
            ]
        );

        if($validator->fails()){
        return Response()->json($validator->errors());
        }

        $ubah=Pelanggan::where('id',$id)->update([
            'nama_pelanggan'=>$request->nama_pelanggan,
            'no_ktp'=>$request->no_ktp,
            'alamat'=>$request->alamat,
            'no_telp'=>$request->no_telp
        ]);
        $status=1;
        $message="Pelanggan Berhasil Diubah";
        if($ubah){
        return Response()->json(compact('status','message'));
        }else {
        return Response()->json(['status'=>0]);
        }
        }
    else {
    return response()->json(['status'=>'anda bukan admin']);
    }
}
    public function destroy($id){
        if(Auth::user()->level=="admin"){
        $hapus=Pelanggan::where('id',$id)->delete();
        $status=1;
        $message="Pelanggan Berhasil Dihapus";
        if($hapus){
        return Response()->json(compact('status','message'));
        }else {
        return Response()->json(['status'=>0]);
        }
    }
    else {
        return response()->json(['status'=>'anda bukan admin']);
        }
    }
  
    public function tampil(){
        if(Auth::user()->level=="admin"){
            $datas = Pelanggan::get();
            $count = $datas->count();
            $pelanggan = array();
            $status = 1;
            foreach ($datas as $dt_pl){
                $pelanggan[] = array(
                    'id' => $dt_pl->id,
                    'nama_pelanggan' => $dt_pl->nama_pelanggan,
                    'no_ktp' => $dt_pl->no_ktp,
                    'alamat' => $dt_pl->alamat,
                    'no_telp' => $dt_pl->no_telp
                );
            }
            return Response()->json(compact('count','pelanggan'));
        } else {
            return Response()->json(['status'=> 'Tidak bisa, anda bukan admin']);
        }
    }
}
