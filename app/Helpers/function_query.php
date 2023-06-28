<?php

function get_kategori_guru(){
    $data=App\Models\Kategoriguru::orderBy('id','Asc')->get();
    return $data;
}
function get_mata_pelajaran(){
    $data=App\Models\MK::orderBy('id','Asc')->get();
    return $data;
}
function get_jurusan(){
    $data=App\Models\Jurusan::orderBy('id','Asc')->get();
    return $data;
}
function get_MK(){
    $data=App\Models\MK::orderBy('id','Asc')->get();
    return $data;
}
function get_kelas(){
    $data=App\Models\Kelas::orderBy('id','Asc')->get();
    return $data;
}
function soal_jawaban($soal_id,$no){
    $cek=App\Models\DetailSoal::where('soal_id',$soal_id)->where('no',$no)->count();
    $data=App\Models\DetailSoal::where('soal_id',$soal_id)->where('no',$no)->first();
    if($cek>0){
        return $data->jawaban_soal;
    }else{
        return "";
    }
    
}
function detail_soal($soal_id){
    $data=App\Models\DetailSoal::where('soal_id',$soal_id)->orderBy('id','Asc')->get();
    return $data;
    
}
function dikerjakan($kelas_room_id,$kat,$users_id){
    $data=App\Models\Hasil::where('kelas_room_id',$kelas_room_id)->where('kat',$kat)->where('users_id',$users_id)->count();
    return $data;
    
}
function cek_dikerjakan($kelas_room_id,$no,$kat,$users_id){
    $data=App\Models\Hasil::where('kelas_room_id',$kelas_room_id)->where('kat',$kat)->where('no',$no)->where('users_id',$users_id)->count();
    return $data;
    
}
function cek_pemeriksaan($kelas_room_id,$kat,$users_id){
    $data=App\Models\Hasil::where('kelas_room_id',$kelas_room_id)->where('kat',$kat)->where('users_id',$users_id)->where('sts',0)->count();
    return $data;
    
}
function nilai($kelas_room_id,$kategori_soal_id,$kat,$users_id){
    $total=App\Models\VTugas::where('kelas_room_id',$kelas_room_id)->where('kat',$kat)->where('kategori_soal_id',$kategori_soal_id)->count();
    $data=App\Models\Hasil::where('kelas_room_id',$kelas_room_id)->where('kat',$kat)->where('kategori_soal_id',$kategori_soal_id)->where('users_id',$users_id)->sum('nilai');
    return round($data/$total);
    
}
function total_nilai($kelas_room_id,$kat,$users_id){
    $total=App\Models\VTugas::where('kelas_room_id',$kelas_room_id)->where('kat',$kat)->count();
    $data=App\Models\Hasil::where('kelas_room_id',$kelas_room_id)->where('kat',$kat)->where('users_id',$users_id)->sum('nilai');
    return round($data/$total);
    
}
function cek_nilai($kelas_room_id,$no,$kat,$users_id){
    $cek=App\Models\Hasil::where('kelas_room_id',$kelas_room_id)->where('kat',$kat)->where('no',$no)->where('users_id',$users_id)->where('sts',1)->count();
    $data=App\Models\Hasil::where('kelas_room_id',$kelas_room_id)->where('kat',$kat)->where('no',$no)->where('users_id',$users_id)->where('sts',1)->first();
    if($cek>0){
        return $data->nilai;
    }else{
        return 0;
    }
    
    
}


?>