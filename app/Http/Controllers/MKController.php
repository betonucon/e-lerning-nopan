<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Validator;
use App\Models\MK;

class MKController extends Controller
{
    
    public function index(request $request)
    {
        return view('mk.index');
    }
    public function modal(request $request)
    {
        error_reporting(0);
        $template='top';
        $data=MK::find($request->id);
        $id=$request->id;
        if($request->id==0){
            $disabled='';
        }else{
            $disabled='disabled';
        }
        return view('mk.modal',compact('template','data','disabled','id'));
    }
    public function get_data(request $request)
    {
        error_reporting(0);
        $data = MK::where('active',1)->orderBy('id','Asc')->get();

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
        $data = MK::where('id',$request->id)->update(['active'=>0]);
    }

   
    public function store(request $request){
        error_reporting(0);
        $rules = [];
        $messages = [];
        
        if($request->id==0){
            $rules['kode']= 'required';
            $messages['kode.required']= 'Lengkapi kode MK';
        }
        
        $rules['nama_mata_pelajaran']= 'required';
        $messages['nama_mata_pelajaran.required']= 'Lengkapi kolom mata pelajaran';
        
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
                
                $data=MK::UpdateOrcreate([
                    'kode'=>$request->kode,
                ],[
                    'nama_mata_pelajaran'=>$request->nama_mata_pelajaran,
                    'active'=>1,
                ]);

                echo'@ok';
                
            }else{
                $data=MK::where('id',$request->id)->update([
                    'nama_mata_pelajaran'=>$request->nama_mata_pelajaran,
                ]);

                echo'@ok';
            }
        }
    }
}
