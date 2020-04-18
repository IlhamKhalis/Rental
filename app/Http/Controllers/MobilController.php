<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mobil;
use Auth;
use DB;
use Illuminate\Support\Facades\Validator;

class MobilController extends Controller
{
    public function index($id)
    {
        if(Auth::user()->level=="admin"){
            $mobil=DB::table('mobil')
            ->where('mobil.id',$id)
            ->get();
            return response()->json($mobil);
        }else{
            return response()->json(['status'=>'anda bukan admin']);
        }
    }
    public function store(Request $req)
    {
        if(Auth::user()->level=="admin"){
        $validator=Validator::make($req->all(),
        [
            'id_jenis_mobil'=>'required',
            'plat_mobil'=>'required',
            'biaya_sewa'=>'required',
            'tahun_pembuatan'=>'required'
        ]
        );
        if($validator->fails()){
            return Response()->json($validator->errors());
        }

        $simpan=Mobil::create([
            'id_jenis_mobil'=>$req->id_jenis_mobil,
            'plat_mobil'=>$req->plat_mobil,
            'biaya_sewa'=>$req->biaya_sewa,
            'tahun_pembuatan'=>$req->tahun_pembuatan
        ]);
        $status=1;
        $message="Mobil Berhasil Ditambahkan";
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
                'id_jenis_mobil'=>'required',
                'plat_mobil'=>'required',
                'biaya_sewa'=>'required',
                'tahun_pembuatan'=>'required'
            ]
        );

        if($validator->fails()){
        return Response()->json($validator->errors());
        }

        $ubah=Mobil::where('id',$id)->update([
            'id_jenis_mobil'=>$request->id_jenis_mobil,
            'plat_mobil'=>$request->plat_mobil,
            'biaya_sewa'=>$request->biaya_sewa,
            'tahun_pembuatan'=>$request->tahun_pembuatan
        ]);
        $status=1;
        $message="Mobil Berhasil Diubah";
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
        $hapus=Mobil::where('id',$id)->delete();
        $status=1;
        $message="Jenis Mobil Berhasil Dihapus";
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
            $mobil = DB::table('mobil')->join('jenis','jenis.id','=','mobil.id_jenis_mobil')
            ->select('mobil.*', 'jenis.jenis_mobil')
            ->get();

            if($mobil->count() > 0){
                $data_mobil = array();
                foreach ($mobil as $m){
                    $data_transaksi[] = array(
                        'Plat Nomor' => $m->plat_mobil,
                        'Biaya Sewa' => $m->biaya_sewa,
                        'Tahun Pembuatan' => $m->tahun_pembuatan,
                        'Jenis Mobil' => $m->jenis_mobil,
                    );
                }
                return response()->json(compact('data_mobil'));
            }else{
                $status = 'Tidak ada mobil';
                return response()->json(compact('status'));
            }
        } else {
            return Response()->json(['status'=> 'Tidak bisa, anda bukan admin']);
        }
    }
}
