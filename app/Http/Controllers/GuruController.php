<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Validator;
use App\Models\Guru;
use App\Models\User;
use App\Models\VGuru;

class GuruController extends Controller
{
    
    public function index(request $request)
    {
        return view('guru.index');
    }
    public function modal(request $request)
    {
        error_reporting(0);
        $template='top';
        $data=Guru::find($request->id);
        $id=$request->id;
        if($request->id==0){
            $disabled='';
        }else{
            $disabled='disabled';
        }
        return view('guru.modal',compact('template','data','disabled','id'));
    }
    public function proses_user(request $request){
        $get=Guru::get();
        foreach($get as $o){
            $data=User::UpdateOrcreate([
                'username'=>$o->nip,
            ],[
                'name'=>$o->nama_guru,
                'email'=>$o->nip.'@gmail.com',
                'password'=>Hash::make($o->nip),
                'role_id'=>2,
            ]);
        }
    }
    public function get_data(request $request)
    {
        error_reporting(0);
        $data = VGuru::where('active',1)->orderBy('id','Asc')->get();

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
        $data = Guru::where('id',$request->id)->update(['active'=>0]);
    }

   
    public function store(request $request){
        error_reporting(0);
        $rules = [];
        $messages = [];
        
        if($request->id==0){
            $rules['nip']= 'required';
            $messages['nip.required']= 'Lengkapi kolom nip';
        }
        
        $rules['nama_guru']= 'required';
        $messages['nama_guru.required']= 'Lengkapi kolom nama Guru';
        $rules['kategori_guru_id']= 'required';
        $messages['kategori_guru_id.required']= 'Lengkapi kolom jurusan';
       
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
                
                $data=Guru::UpdateOrcreate([
                    'nip'=>$request->nip,
                ],[
                    'nama_guru'=>$request->nama_guru,
                    'kategori_guru_id'=>$request->kategori_guru_id,
                    'active'=>1,
                ]);

                echo'@ok';
                
            }else{
                $data=Guru::where('id',$request->id)->update([
                    'nama_guru'=>$request->nama_guru,
                    'kategori_guru_id'=>$request->kategori_guru_id,
                ]);

                echo'@ok';
            }
        }
    }
}
