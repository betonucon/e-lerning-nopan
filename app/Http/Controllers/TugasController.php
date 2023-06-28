<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Validator;
use App\Models\Materi;
use App\Models\KelasRoom;
use App\Models\VKelasRoom;
use App\Models\Hasil;
use App\Models\VMateri;
use App\Models\VSiswa;
use App\Models\Soal;
use App\Models\VForum;
use App\Models\Tugas;
use App\Models\VTugas;
use App\Models\Forum;
use App\Models\DetailMateri;

class TugasController extends Controller
{
    
    public function index(request $request)
    {
        if(Auth::user()->role_id==2){
            return view('tugas.index');
        }
        if(Auth::user()->role_id==3){
            return view('tugas.index_siswa');
        }
        
    }
    public function modal(request $request)
    {
        error_reporting(0);
        $template='top';
        $data=Materi::find($request->id);
        $id=$request->id;
        if($request->id==0){
            $disabled='';
        }else{
            $disabled='disabled';
        }
        return view('tugas.modal',compact('template','data','disabled','id'));
    }
    public function lihat_data(request $request)
    {
        error_reporting(0);
        // dd(Auth::user()->siswa['kelas']);
        $template='top';
        $data=VKelasRoom::find($request->id);
        $id=$request->id;
        if($request->id==0){
            $disabled='';
        }else{
            $disabled='disabled';
        }
        if($request->no==""){
            $no=1;
        }else{
            $no=$request->no;
        }
        $query = VTugas::query();
        $soal = $query->where('no',$no)->where('kat',1)->where('kelas_room_id',$request->id)->first();
     
        if(Auth::user()->role_id==2){
            return view('tugas.lihat_data',compact('template','data','disabled','id'));
        }
        if(Auth::user()->role_id==3){
            if($data->selesai_tugas>0){
                return view('tugas.lihat_data_siswa',compact('template','data','disabled','id','no','soal'));
            }else{
                return view('tugas.lihat_hasil_siswa',compact('template','data','disabled','id','no','soal'));
            }
            
        }
        
    }

    public function get_data_siswa(request $request)
    {
        error_reporting(0);
        $kelas_room_id=$request->kelas_room_id;
        $kat=$request->kat;
        $data = VSiswa::where('active',1)->where('kelas',$request->kelas)->orderBy('id','Asc')->get();
        $success['nilai']=nilai($kelas_room_id,1,$kat,Auth::user()->id);
        $success['nilai_easy']=nilai($kelas_room_id,2,$kat,Auth::user()->id);
        $success['total_nilai']=total_nilai($kelas_room_id,$kat,Auth::user()->id);
        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('nilai_pg', function ($row) use ($kelas_room_id,$kat) {
                return nilai($kelas_room_id,1,$kat,$row->users_id);
            })
            ->addColumn('nilai_esay', function ($row) use ($kelas_room_id,$kat) {
                return nilai($kelas_room_id,2,$kat,$row->users_id);
            })
            ->addColumn('total_nilai', function ($row) use ($kelas_room_id,$kat) {
                return total_nilai($kelas_room_id,$kat,$row->users_id);
            })
            ->addColumn('action', function ($row) use ($kelas_room_id,$kat) {
                if(cek_pemeriksaan($kelas_room_id,$kat,$row->users_id)>0){
                    $btn='<span  class="btn btn-success btn-xs" >Cek</span>';
                }else{
                    $btn="0";
                }
                return $btn;
            })
            
            ->rawColumns(['action'])
            ->make(true);
    }
    public function view_data(request $request)
    {
        error_reporting(0);
        $template='top';
        $data=Materi::find($request->id);
        $id=$request->id;
        if($request->id==0){
            $disabled='';
        }else{
            $disabled='disabled';
        }
        return view('tugas.view_data',compact('template','data','disabled','id'));
    }
    
    
    public function get_data(request $request)
    {
        error_reporting(0);
        $query = VKelasRoom::query();

        if($request->search!=""){
            // $data=$query->where('name','LIKE','%'.$request->search.'%');    
        }
        if(Auth::user()->role_id==3){
            $data=$query->where('kelas',Auth::user()->siswa['kelas'])->where('status_publish',1);    
        }
        if(Auth::user()->role_id==2){
            $data=$query->where('users_id',Auth::user()->id);    
        }
        $data = $query->where('active',1)->where('mulai_tugas','>',0)->orderBy('id','Asc')->get();
        
        return response()->json($data, 200);
    }
    public function get_data_nomor(request $request)
    {
        error_reporting(0);
        $query = VTugas::query();
        $count = $query->where('kat',$request->kat)->where('kelas_room_id',$request->kelas_room_id)->count();
        
        $data = $query->where('kat',$request->kat)->where('kategori_soal_id',$request->kategori_soal_id)->where('kelas_room_id',$request->kelas_room_id)->orderBy('no','Asc')->get();
        $success=[];
        $success['total']=$count;
        $success['nilai']=nilai($request->kelas_room_id,1,$request->kat,Auth::user()->id);
        $success['nilai_easy']=nilai($request->kelas_room_id,2,$request->kat,Auth::user()->id);
        $success['total_nilai']=total_nilai($request->kelas_room_id,$request->kat,Auth::user()->id);
        $success['dikerjakan']=dikerjakan($request->kelas_room_id,$request->kat,Auth::user()->id);
        $success['pemeriksaan']=cek_pemeriksaan($request->kelas_room_id,$request->kat,Auth::user()->id);
        $detail=[];
        foreach($data as $o){
            $det=[];
            $det['no']=$o->no;
            $det['soal']=$o->soal;
            $det['nilai']=cek_nilai($request->kelas_room_id,$o->no,$request->kat,Auth::user()->id);
            $det['cek_count']=cek_dikerjakan($request->kelas_room_id,$o->no,$request->kat,Auth::user()->id);
            $det['cek_benar']=cek_nilai($request->kelas_room_id,$o->no,$request->kat,Auth::user()->id);
            $detail[]=$det;
        }
        $success['data']=$detail;
        return response()->json($success, 200);
    }
    public function delete_data(request $request){
        $data = Materi::where('id',$request->id)->update(['active'=>0]);
    }
    public function tutup_materi(request $request){
        $data = Materi::where('id',$request->id)->update(['status_publish'=>0]);
    }
    public function buka_materi(request $request){
        $data = Materi::where('id',$request->id)->update(['status_publish'=>1]);
    }

   
    public function store(request $request){
        error_reporting(0);
        $mst=VKelasRoom::where('id',$request->kelas_room_id)->first();
        if($request->kat==1){
            $cekwaktu=$mst->selesai_tugas;
        }else{
            $cekwaktu=$mst->selesai_ujian;
        }
        $rules = [];
        $messages = [];
        
        $rules['jawaban']= 'required';
        $messages['jawaban.required']= 'Lengkapi jawaban';
        
        if($cekwaktu>0){
            
        }else{
            $rules['cekwaktu']= 'required';
            $messages['cekwaktu.required']= 'Mohon maaf waktu pengisian sudah ditutup';
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
            
                
                $count=VTugas::where('kelas_room_id',$request->kelas_room_id)->where('kat',$request->kat)->count();
                $data=VTugas::where('kelas_room_id',$request->kelas_room_id)->where('no',$request->no)->where('kat',$request->kat)->first();
                if($data->kategori_soal_id==1){
                    $sts=1;
                }else{
                    $sts=0;
                }
                if($data->jawaban_id==$request->jawaban){
                    $nilai=100;
                }else{
                    $nilai=0;
                }
                $save = Hasil::UpdateOrcreate([
                    'kelas_room_id'=>$request->kelas_room_id,
                    'no'=>$request->no,
                    'kat'=>$request->kat,
                    'users_id'=>Auth::user()->id,
                ],[
                    'jawaban_id'=>$data->jawaban_id,
                    'soal_id'=>$data->soal_id,
                    'jawaban'=>$request->jawaban,
                    'kategori_soal_id'=>$data->kategori_soal_id,
                    'sts'=>$sts,
                    'nilai'=>$nilai,
                    
                ]);
                
                if($count==$request->no){
                    echo'@ok@1';
                }else{
                    echo'@ok@'.($request->no+1);
                }
                
                
           
        }
    }
    public function store_forum(request $request){
        error_reporting(0);
        $rules = [];
        $messages = [];
        
        $rules['users_id']= 'required';
        $messages['users_id.required']= 'Tujuan comment';
        $rules['chat']= 'required';
        $messages['chat.required']= 'Ketikan text forum';
        if($request->file!=""){
            $rules['file']= 'required|mimes:pdf,png,jpg,jpeg';
            $messages['file.required']= 'Upload attach dengan fomat (pdf,png,jpg,jpeg) ';
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
            
                if(Auth::user()->role_id==2){
                    $kat=1;
                }else{
                    $kat=2;
                }
                $data=Forum::create([
                    'mentor_id'=>$request->mentor_id,
                    'users_id'=>$request->users_id,
                    'materi_id'=>$request->materi_id,
                    'chat'=>$request->chat,
                    'kat'=>$kat,
                    'sts'=>1,
                    'created_at'=>date('Y-m-d H:i:s'),
                ]);
                if($request->file!=""){
                    $thumbnail = $request->file('file');
                    $thumbnailFileName ='forum'.date('Ymdhis').'.'. $thumbnail->getClientOriginalExtension();
                    $filename =$thumbnailFileName;
                    $file = \Storage::disk('public_dokumen');
                    
                    if($file->put($filename, file_get_contents($thumbnail))){
                        $data=Forum::where('id',$data->id)->update([
                            'file'=>$filename,
                            'tipe'=>$thumbnail->getClientOriginalExtension(),
                        ]);

                      
                    }
                }
                
                echo'@ok@'.$request->users_id;
                
            
        }
    }
}
