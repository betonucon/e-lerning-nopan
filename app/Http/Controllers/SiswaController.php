<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Validator;
use App\Models\Siswa;
use App\Models\User;
use App\Models\VSiswa;

class SiswaController extends Controller
{
    
    public function index(request $request)
    {
        return view('siswa.index');
    }
    public function modal(request $request)
    {
        error_reporting(0);
        $template='top';
        $data=Siswa::find($request->id);
        $id=$request->id;
        if($request->id==0){
            $disabled='';
        }else{
            $disabled='disabled';
        }
        return view('siswa.modal',compact('template','data','disabled','id'));
    }
    public function get_data(request $request)
    {
        error_reporting(0);
        $data = VSiswa::where('active',1)->orderBy('id','Asc')->get();

        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $btn='
                    <div class="input-group-btn btn-xs">
                        <span  class="btn btn-success btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="true">Act
                            <span class="fa fa-caret-down"></span>
                        </span>
                        <ul class="dropdown-menu">
                            <li><a href="javascript:;" onclick="tambah('.$row->id.')">Ubah</a></li>
                            <li><a href="javascript:;" onclick="delete_data('.$row->id.')">Hapus</a></li>
                        </ul>
                    </div>
                ';
                return $btn;
            })
            
            ->rawColumns(['action'])
            ->make(true);
    }
    
    

    public function delete_data(request $request){
        $data = Siswa::where('id',$request->id)->update(['active'=>0]);
    }

   
    public function proses_user(request $request){
        $get=Siswa::get();
        foreach($get as $o){
            $data=User::UpdateOrcreate([
                'username'=>$o->nis,
            ],[
                'name'=>$o->nama_siswa,
                'email'=>$o->nis.'@gmail.com',
                'password'=>Hash::make($o->nis),
                'role_id'=>3,
            ]);
        }
    }
    public function store(request $request){
        error_reporting(0);
        $rules = [];
        $messages = [];
        
        if($request->id==0){
            $rules['nis']= 'required';
            $messages['nis.required']= 'Lengkapi kolom NIS';
        }
        
        $rules['nama_siswa']= 'required';
        $messages['nama_siswa.required']= 'Lengkapi kolom nama siswa';
        $rules['jurusan_id']= 'required';
        $messages['jurusan_id.required']= 'Lengkapi kolom jurusan';
       
        $validator = Validator::make($request->all(), $rules, $messages);
        $val=$validator->Errors();


        if ($validator->fails()) {
            echo'<div class="nitof"><b>Oops Error !</b><br><div class="isi-nitof">';
                foreach(parsing_validator($val) as $value){
                    
                    foreach($value as $isi){
                        echo'-&nbsp;'.$isi.'<br>';
                    }
                }
            echo'</div></div>';
        }else{
            if($request->id==0){
                $kelas=explode('-',$request->kelas);
                $data=Siswa::UpdateOrcreate([
                    'nis'=>$request->nis,
                ],[
                    'kelas'=>$kelas[0],
                    'kelas_id'=>$kelas[1],
                    'nama_siswa'=>$request->nama_siswa,
                    'jurusan_id'=>$request->jurusan_id,
                    'active'=>1,
                ]);

                echo'@ok';
                
            }else{
                $kelas=explode('-',$request->kelas);
                $data=Siswa::where('id',$request->id)->update([
                    'nama_siswa'=>$request->nama_siswa,
                    'kelas_id'=>$kelas[1],
                    'jurusan_id'=>$request->jurusan_id,
                ]);

                echo'@ok';
            }
        }
    }
}
