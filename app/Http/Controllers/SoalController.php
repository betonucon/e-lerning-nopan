<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Validator;
use App\Models\Soal;
use App\Models\VSoal;
use App\Models\DetailSoal;

class SoalController extends Controller
{
    
    public function index(request $request)
    {
        return view('soal.index');
    }
    public function modal(request $request)
    {
        error_reporting(0);
        $template='top';
        $data=Soal::find($request->id);
        $id=$request->id;
        if($request->id==0){
            $disabled='';
        }else{
            $disabled='disabled';
        }
        return view('soal.modal',compact('template','data','disabled','id'));
    }
    public function get_data(request $request)
    {
        error_reporting(0);
        $data = VSoal::where('active',1)->orderBy('id','Asc')->get();

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
            ->addColumn('click_tugas', function ($row) {
                $btn='<span  class="btn btn-success btn-xs" onclick="pilih_tugas('.$row->id.')">Pilih</span>';
                return $btn;
            })
            ->addColumn('click_ujian', function ($row) {
                $btn='<span  class="btn btn-success btn-xs" onclick="pilih_ujian('.$row->id.')">Pilih</span>';
                return $btn;
            })
            
            ->rawColumns(['action','click_tugas','click_ujian'])
            ->make(true);
    }

    public function delete_data(request $request){
        $data = Soal::where('id',$request->id)->update(['active'=>0]);
    }
    

   
    public function store(request $request){
        error_reporting(0);
        $rules = [];
        $messages = [];
        $count=count($request->jawaban);
        $sum=0;
        // $rules['mata_pelajaran_id']= 'required';
        // $messages['mata_pelajaran_id.required']= 'Lengkapi kolom mata pelajaran';
        $rules['kelas']= 'required';
        $messages['kelas.required']= 'Lengkapi kolom kelas';
        $rules['kategori_soal_id']= 'required';
        $messages['kategori_soal_id.required']= 'Lengkapi kolom kategori soal ';
        if($request->kategori_soal_id==1){
            $rules['jawaban_benar']= 'required';
            $messages['jawaban_benar.required']= 'Pilih jawaban yang benar ';
            for($x=0;$x<$count;$x++){
                if($request->jawaban[$x]==""){
                    $sum+=0;
                }else{
                    $sum+=1;
                }
            }

            if($count!=$sum){
                $rules['notif']= 'required';
                $messages['notif.required']= 'Lengkapi kolom jawaban A s/d D';
            }
        }
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
                
                $data=Soal::create([
                    // 'mata_pelajaran_id'=>$request->mata_pelajaran_id,
                    'soal'=>$request->soal,
                    'kelas'=>$request->kelas,
                    'jawaban'=>$request->jawaban_benar,
                    'kategori_soal_id'=>$request->kategori_soal_id,
                    'users_id'=>Auth::user()->id,
                    'active'=>1,
                ]);
                if($request->kategori_soal_id==1){
                    for($x=0;$x<$count;$x++){
                        $datadetail=DetailSoal::UpdateOrcreate([
                            'soal_id'=>$data->id,
                            'no'=>($x+1),
                        ],[
                            'jawaban_soal'=>$request->jawaban[$x],
                        ]);
                    }
                }
                echo'@ok';
                
            }else{
                $data=Soal::where('id',$request->id)->update([
                    // 'mata_pelajaran_id'=>$request->mata_pelajaran_id,
                    'kelas'=>$request->kelas,
                    'soal'=>$request->soal,
                    'jawaban'=>$request->jawaban_benar,
                        
                    'kategori_soal_id'=>$request->kategori_soal_id,
                ]);
                if($request->kategori_soal_id==1){
                    for($x=0;$x<$count;$x++){
                        $datadetail=DetailSoal::UpdateOrcreate([
                            'soal_id'=>$request->id,
                            'no'=>($x+1),
                        ],[
                            'jawaban_soal'=>$request->jawaban[$x],
                        ]);
                    }
                }
                echo'@ok';
            }
        }
    }
}
