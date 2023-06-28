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
use App\Models\VMateri;
use App\Models\VSiswa;
use App\Models\Soal;
use App\Models\VForum;
use App\Models\Tugas;
use App\Models\VTugas;
use App\Models\Forum;
use App\Models\DetailMateri;

class MateriController extends Controller
{
    
    public function index(request $request)
    {
        if(Auth::user()->role_id==2){
            return view('materi.index');
        }
        if(Auth::user()->role_id==3){
            return view('materi.index_siswa');
        }
        
    }
    public function modal(request $request)
    {
        error_reporting(0);
        $template='top';
        $data=VKelasRoom::find($request->id);
        $id=$request->id;
        if($request->id==0){
            $disabled='';
        }else{
            $disabled='disabled';
        }
        return view('materi.modal',compact('template','data','disabled','id'));
    }
    public function modal_ujian(request $request)
    {
        error_reporting(0);
        $template='top';
        $data=VKelasRoom::find($request->id);
        $id=$request->id;
        if($request->id==0){
            $disabled='';
        }else{
            $disabled='disabled';
        }
        return view('materi.modal_ujian',compact('template','data','disabled','id'));
    }
    public function view_data(request $request)
    {
        error_reporting(0);
        $template='top';
        $data=VKelasRoom::find($request->id);
        $id=$request->id;
        if($request->id==0){
            $disabled='';
        }else{
            $disabled='disabled';
        }
        return view('materi.view_data',compact('template','data','disabled','id'));
    }
    public function view_forum(request $request)
    {
        error_reporting(0);
        $template='top';
        $data=VKelasRoom::find($request->id);
        $id=$request->id;
        if($request->id==0){
            $disabled='';
        }else{
            $disabled='disabled';
        }
        if(Auth::user()->role_id==2){
            return view('materi.forum_guru',compact('template','data','disabled','id'));
        }
        if(Auth::user()->role_id==3){
            return view('materi.forum',compact('template','data','disabled','id'));
        }
        
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
        if(Auth::user()->role_id==2){
            return view('materi.lihat_data',compact('template','data','disabled','id'));
        }
        if(Auth::user()->role_id==3){
            return view('materi.lihat_data_siswa',compact('template','data','disabled','id'));
        }
        
    }
    public function forum(request $request)
    {
        error_reporting(0);
        $template='top';
        $no=$request->id;
        $data=VSiswa::where('kelas',$request->kelas)->get();
        $retur='<ul class="todo-list ui-sortable">';
        foreach($data as $o){
   
                $retur.='<li onclick="show_forum('.$o->users_id.','.$no.')">
                            <span class="handle ui-sortable-handle">
                                <i class="fa fa-ellipsis-v"></i>
                                <i class="fa fa-ellipsis-v"></i>
                            </span>
                            <span class="text">'.$o->nama_siswa.'</span>
                            <small class="label label-danger">2</small>
                            
                        </li>';
        }
        $retur.='</ul>';
        return $retur;
    }
    public function tampil_forum(request $request)
    {
        error_reporting(0);
        $template='top';
        $no=$request->id;
        $data=VForum::where('materi_id',$no)->where('users_id',$request->users_id)->get();;
        $retur='';
        foreach($data as $o){
            if(Auth::user()->role_id==2){
                if($o->kat==1){
                    $akun='Anda';
                    $color="style='background:#fffedc'";
                }else{
                    $akun=$o->name;
                    $color="";
                }
            }
            if(Auth::user()->role_id==3){
                if($o->kat==2){
                    $akun='Anda';
                    $color="";
                }else{
                    $akun=$o->nama_mentor;
                    $color="style='background:#fffedc'";
                }
            }
                $retur.='<div class="item" '.$color.'>
                            <img src="'.url_plug().'/img/akun.png" alt="user image" class="offline">

                            <p class="message">
                                <a href="#" class="name">
                                    <small class="text-muted pull-right"><i class="fa fa-clock-o"></i> '.$o->created_at.'</small>
                                    '.$akun.'
                                </a>
                                '.$o->chat.'
                            </p>';
                            if($o->file!="" && $o->tipe=='pdf'){
                                $retur.='
                                <div class="attachment" '.$color.'>
                                    <a href="'.url_plug().'/dokumen/'.$o->file.'"  target="_blank"><img src="'.url_plug().'/img/pdf.png" alt="user image" width="5%">'.$o->file.'</a>

                                </div>';
                            }
                            if($o->file!="" && $o->tipe!='pdf'){
                                $retur.='
                                <div class="attachment" '.$color.'>
                                    <a href="'.url_plug().'/dokumen/'.$o->file.'"  target="_blank"><img src="'.url_plug().'/dokumen/'.$o->file.'" alt="user image" width="30%"></a>

                                </div>';
                            }
                            $retur.='    
                        </div>';
        }
       
        return $retur;
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
        $data = $query->where('active',1)->orderBy('id','Asc')->get();
        
        return response()->json($data, 200);
    }
    
    public function get_data_tugas(request $request)
    {
        error_reporting(0);
        $data = VTugas::where('kelas_room_id',$request->kelas_room_id)->where('kat',$request->kat)->orderBy('id','Asc')->get();

        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('action_tugas', function ($row) {
                $btn='<span  class="btn btn-danger btn-xs " onclick="delete_data_tugas('.$row->id.')">Hapus</span>';
                return $btn;
            })
            ->addColumn('action_ujian', function ($row) {
                $btn='<span  class="btn btn-danger btn-xs " onclick="delete_data_ujian('.$row->id.')">Hapus</span>';
                return $btn;
            })
            
            ->rawColumns(['action_tugas','action_ujian'])
            ->make(true);
    }
    public function get_data_materi(request $request)
    {
        error_reporting(0);
        $query = VMateri::query();
        if($request->jenis_materi>0){
            $data=$query->where('jenis_materi',$request->jenis_materi);   
        }
        $data=$query->where('kelas_room_id',$request->kelas_room_id);    
        $data = $query->where('active',1)->orderBy('id','Asc')->get();
        
        return response()->json($data, 200);
    }
    public function delete_data(request $request){
        $data = Materi::where('id',$request->id)->update(['active'=>0]);
    }
    public function delete_data_tugas(request $request){
        $data = Tugas::where('id',$request->id)->delete();
        $get=VTugas::where('kelas_room_id',$request->kelas_room_id)->where('kat',$request->kat)->orderBy('kategori_soal_id','Asc')->get();
        foreach($get as $no=>$o){
            $save = Tugas::where('id',$o->id)->update([
                'no'=>($no+1),
            ]);
        }
    }
    public function tutup_materi(request $request){
        $data = KelasRoom::where('id',$request->id)->update(['status_publish'=>0]);
    }
    public function buka_materi(request $request){
        $data = KelasRoom::where('id',$request->id)->update(['status_publish'=>1]);
    }
    public function pilih_tugas(request $request){
        $soal=Soal::where('id',$request->soal_id)->first();
        $data = Tugas::create([
            'kelas_room_id'=>$request->kelas_room_id,
            'soal_id'=>$request->soal_id,
            'jawaban_id'=>$soal->jawaban,
            'kat'=>1,
        ]);

        $get=VTugas::where('kelas_room_id',$request->kelas_room_id)->where('kat',1)->orderBy('kategori_soal_id','Asc')->get();
        foreach($get as $no=>$o){
            $save = Tugas::where('id',$o->id)->update([
                'no'=>($no+1),
            ]);
        }
    }
    public function pilih_ujian(request $request){
        $soal=Soal::where('id',$request->soal_id)->first();
        $data = Tugas::create([
            'kelas_room_id'=>$request->kelas_room_id,
            'soal_id'=>$request->soal_id,
            'jawaban_id'=>$soal->jawaban,
            'kat'=>2,
        ]);

        $get=VTugas::where('kelas_room_id',$request->kelas_room_id)->where('kat',2)->orderBy('kategori_soal_id','Asc')->get();
        foreach($get as $no=>$o){
            $save = Tugas::where('id',$o->id)->update([
                'no'=>($no+1),
            ]);
        }
    }
   
    public function store(request $request){
        error_reporting(0);
        $rules = [];
        $messages = [];
        
        $rules['nama_room']= 'required';
        $messages['nama_room.required']= 'Lengkapi kolom Nama Room';
        $rules['kelas']= 'required';
        $messages['kelas.required']= 'Lengkapi kolom kelas';
        $rules['deskripsi_room']= 'required';
        $messages['deskripsi_room.required']= 'Lengkapi kolom deskripsi ';
        $rules['tanggal_tugas']= 'required';
        $messages['tanggal_tugas.required']= 'Lengkapi kolom waktu ujian ';
        $rules['tanggal_ujian']= 'required';
        $messages['tanggal_ujian.required']= 'Lengkapi kolom waktu ujian ';
        
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
            $exp=explode(' - ',$request->tanggal_tugas);
            $expuj=explode(' - ',$request->tanggal_ujian);
            if($request->id==0){
                
                $data=KelasRoom::create([
                    'kelas'=>$request->kelas,
                    'nama_room'=>$request->nama_room,
                    'deskripsi_room'=>$request->deskripsi_room,
                    'start_tugas'=>$exp[0],
                    'end_tugas'=>$exp[1],
                    'start_ujian'=>$expuj[0],
                    'end_ujian'=>$expuj[1],
                    'users_id'=>Auth::user()->id,
                    'active'=>1,
                    'created_at'=>date('Y-m-d H:i:s'),
                    'status_publish'=>0,
                ]);
               
                echo'@ok@'.$data->id;
                
            }else{
                $data=KelasRoom::where('id',$request->id)->update([
                    'kelas'=>$request->kelas,
                    'start_tugas'=>$exp[0],
                    'end_tugas'=>$exp[1],
                    'start_ujian'=>$expuj[0],
                    'end_ujian'=>$expuj[1],
                    'nama_room'=>$request->nama_room,
                    'deskripsi_room'=>$request->deskripsi_room,
                ]);
                
                echo'@ok@'.$request->id;
            }
        }
    }
    public function store_materi(request $request){
        error_reporting(0);
        $rules = [];
        $messages = [];
        
        $rules['nama_materi']= 'required';
        $messages['nama_materi.required']= 'Lengkapi kolom judul materi';
        $rules['jenis_materi']= 'required';
        $messages['jenis_materi.required']= 'Lengkapi kolom jenis materi ';
        if($request->jenis_materi==1){
            if($request->id>0){
                if($request->file!=""){
                    $rules['file']= 'required|mimes:pdf';
                    $messages['file.required']= 'Upload dokumen materi dengan fomat pdf ';
                }
            }else{
                $rules['file']= 'required|mimes:pdf';
                $messages['file.required']= 'Upload dokumen materi dengan fomat pdf ';
            }
            
        }
        if($request->jenis_materi==2){
            $rules['link_video']= 'required';
            $messages['link_video.required']= 'Masukan link/url youtube ';
            
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
           
                
                $data=Materi::create([
                    'kelas_room_id'=>$request->id,
                    'nama_materi'=>$request->nama_materi,
                    'jenis_materi'=>$request->jenis_materi,
                    'link_video'=>$request->link_video,
                    'users_id'=>Auth::user()->id,
                    'active'=>1,
                    'created_at'=>date('Y-m-d H:i:s'),
                    'status_publish'=>1,
                ]);
                if($request->jenis_materi==1){
                    $thumbnail = $request->file('file');
                    $thumbnailFileName =date('Ymdhis').'.'. $thumbnail->getClientOriginalExtension();
                    $filename =$thumbnailFileName;
                    $file = \Storage::disk('public_dokumen');
                    
                    if($file->put($filename, file_get_contents($thumbnail))){
                        $data=Materi::where('id',$data->id)->update([
                            'file_materi'=>$filename,
                        ]);

                      
                    }
                }
                
                echo'@ok';
                
            
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
