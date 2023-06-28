@extends('layouts.app')

@push('style')
  <style>
    label {
        display: inline-block;
        max-width: 100%;
        margin-bottom: 5px;
        font-weight: normal;
    }
  </style>
@endpush
@push('datatable')
<script type="text/javascript">
        

        function load_view(){
          $.ajax({ 
            type: 'GET', 
            url: "{{ url('materi/get_data')}}", 
            data: { id: 1 }, 
            dataType: 'json',
            beforeSend: function() {
              $('#tampil-project-load').show()
            },
            success: function (data) {
              $('#tampil-project-load').hide();
              $.each(data, function(i, result){
                if(result.status_publish==1){
                  status_publish='<span class="btn btn-sm btn-default" title="unpublish materi" onclick="tutup_materi('+result.id+')"><i class="fa fa-share-alt-square"></i></span> '
                                +'<span class="btn btn-sm btn-primary" title="Diskusi Forum" onclick="location.assign(`{{url('materi/view_forum')}}?id='+result.id+'`)"><i class="fa fa-share-alt-square"></i> Diskusi</span>';
                  warna_publish='#73d173';
                }else{
                  status_publish='<span class="btn btn-sm btn-primary" title="publish materi" onclick="buka_materi('+result.id+')"><i class="fa fa-share-alt-square"></i></span>';
                  warna_publish='#d9e7d9';
                }
                
                $("#tampil-project").append('<div class="col-md-6">'
                        +'<div class="box box-widget widget-user-2" style="border: solid 1px #d4d4eb">'
                          +'<div class="row" style="display: contents;">'
                            +'<div class="col-md-1 " style="color:#fff;background:'+warna_publish+';border-radius: 0px 50px 50px 50px;text-align: center; vertical-align: middle; font-size: 30px; padding: 0px;"><i class="fa fa-star-o"></i></div>'
                            +'<div class="col-md-11">'
                              +'<div class="user-block" style="text-align: center;padding-top:2%">'
                                +'<span class="username" style="margin-left: 0px;"><a href="#" style="font-weight: initial; color: #284c6c;">'+result.nama_room+'</a></span>'
                                +'<span class="description" style="margin-left: 0px;">Shared publicly '+result.created_at+'</span>'
                              +'</div>'
                            +'</div>'
                          +'</div>'
                          +'<div class="box-footer no-padding">'
                            +'<ul class="nav nav-stacked">'
                              +'<li><a href="#" onclick="tambah('+result.id+')"><i class="fa fa-clone"></i> Jumlah Materi <span class="pull-right badge bg-blue">'+result.total_materi+'</span></a></li>'
                              +'<li><a href="#" onclick="tambah('+result.id+')"><i class="fa fa-clone"></i> Soal Tugas ('+result.start_tugas+' s/d '+result.end_tugas+')<span class="pull-right badge bg-blue">Soal '+result.total_tugas+'</span></a></li>'
                              +'<li><a href="#" onclick="tambah('+result.id+')"><i class="fa fa-clone"></i> Soal Ujian ('+result.start_ujian+' s/d '+result.end_ujian+')<span class="pull-right badge bg-blue">Soal '+result.total_ujian+'</span></a></li>'
                            +'</ul>'
                          +'</div>'
                          +'<div class="box-footer">'
                            
                              +'<span class="btn btn-sm btn-info"  onclick="tambah('+result.id+')"  title="Ubah Materi"><i class="fa fa-pencil-square-o"></i></span>&nbsp;&nbsp;'
                              +'<span class="btn btn-sm btn-success" onclick="tambah('+result.id+')"  title="Lihat Materi"><i class="fa fa-book"></i></span>&nbsp;&nbsp;'
                              +'<span class="btn btn-sm btn-danger"  onclick="delete_data('+result.id+')" title="Hapus"><i class="fa fa-trash-o"></i></span>&nbsp;&nbsp;'
                              +status_publish
                              +'<span class="btn btn-sm btn-primary" title="Tugas" onclick="location.assign(`{{url('tugas/lihat')}}?id='+result.id+'`)"><i class="fa fa-clone"></i> Tugas</span>'
                              +'<span class="btn btn-sm btn-primary" title="Tugas" onclick="location.assign(`{{url('ujian/lihat')}}?id='+result.id+'`)"><i class="fa fa-clone"></i> Ujian</span>'
                              
                          +'</div>'
                        +'</div>'
                      +'</div>');
                });
                
              }
            
          });
        }
        $(document).ready(function() {
            load_view()
           
        });

        // function show_hide(){
        //     var tables=$('#data-table-fixed-header').DataTable();
        //         tables.ajax.url("{{ url('material/getdata')}}?hide=1").load();
        // }
        // function refresh_data(){
        //     var tables=$('#data-table-fixed-header').DataTable();
        //         tables.ajax.url("{{ url('material/getdata')}}").load();
        // }
        
    </script>   
@endpush
@section('content')
<div class="content-wrapper" style="min-height: 926.281px;">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Kelas Room
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Kelas Room</li>
      </ol>
    </section>

    
    <section class="content">
      <div class="row" style="margin-bottom: 2%;">
          <div class="col-sm-3">
            <span class="btn btn-success btn-sm" onclick="tambah(`0`)"><i class="fa fa-plus-circle"></i> Buat Materi</span>
          </div>
          <div class="col-sm-9">
            
          </div>
      </div>
      <div class="row">
        
        <div id="tampil-project"></div>
        
      </div>
    </section>
</div>

<div class="modal fade" id="modal-tambah" style="display: none;">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span></button>
        <h4 class="modal-title">Tambah / Ubah</h4>
      </div>
      <div class="modal-body">
          <form class="form-horizontal" id="mydata" method="post" action="{{ url('siswa') }}" enctype="multipart/form-data" >
            @csrf
            <div id="form-tambah"></div>
          </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Tutup</button>
        <button type="button" class="btn btn-primary" onclick="simpan_data()"><i class="fa fa-plus-circle"></i> Simpan</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
@endsection

@push('ajax')
<script> 

      function tambah(id){
        location.assign("{{url('materi/view')}}?id="+id);
      }
      function lihat(id){
        location.assign("{{url('materi/lihat')}}?id="+id);
      }

      function delete_data(id){
           
           swal({
               title: "Yakin menghapus data ini ?",
               text: "data akan hilang dari data  ini",
               type: "warning",
               icon: "error",
               showCancelButton: true,
               align:"center",
               confirmButtonClass: "btn-danger",
               confirmButtonText: "Yes, delete it!",
               closeOnConfirm: false
           }).then((willDelete) => {
               if (willDelete) {
                $('#tampil-project').html("");
                       $.ajax({
                           type: 'GET',
                           url: "{{url('materi/delete_data')}}",
                           data: "id="+id,
                           success: function(msg){
                               swal("Success! berhasil terhapus!", {
                                   icon: "success",
                               });
                               load_view()
                           }
                       });
                   
               } else {
                   
               }
           });
           
      }  
      function tutup_materi(id){
           
           swal({
               title: "Yakin menutup materi ini  ini ?",
               text: "data tidak akan tampil disiswa",
               type: "warning",
               icon: "info",
               showCancelButton: true,
               align:"center",
               confirmButtonClass: "btn-danger",
               confirmButtonText: "Yes, delete it!",
               closeOnConfirm: false
           }).then((willDelete) => {
               if (willDelete) {
                      $('#tampil-project').html("");
                       $.ajax({
                           type: 'GET',
                           url: "{{url('materi/tutup_materi')}}",
                           data: "id="+id,
                           success: function(msg){
                               swal("Success! berhasil diproses!", {
                                   icon: "success",
                               });
                               load_view()
                           }
                       });
                   
               } else {
                   
               }
           });
           
      }  
      function buka_materi(id){
           
           swal({
               title: "Yakin publish materi ini  ini ?",
               text: "data akan publish disiswa",
               type: "warning",
               icon: "info",
               showCancelButton: true,
               align:"center",
               confirmButtonClass: "btn-danger",
               confirmButtonText: "Yes, delete it!",
               closeOnConfirm: false
           }).then((willDelete) => {
               if (willDelete) {
                    $('#tampil-project').html("");
                       $.ajax({
                           type: 'GET',
                           url: "{{url('materi/buka_materi')}}",
                           data: "id="+id,
                           success: function(msg){
                               swal("Success! berhasil diproses!", {
                                   icon: "success",
                               });
                               load_view()
                           }
                       });
                   
               } else {
                   
               }
           });
           
      }  
      
      function simpan_data(){
            
            var form=document.getElementById('mydata');
            
                
                $.ajax({
                    type: 'POST',
                    url: "{{ url('master/mk') }}",
                    data: new FormData(form),
                    contentType: false,
                    cache: false,
                    processData:false,
                    beforeSend: function() {
                        document.getElementById("loadnya").style.width = "100%";
                    },
                    success: function(msg){
                        var bat=msg.split('@');
                        if(bat[1]=='ok'){
                            document.getElementById("loadnya").style.width = "0px";
                            swal({
                              title: "Success! berhasil disimpan!",
                              icon: "success",
                            });
                            $('#modal-tambah').modal('hide');
                            $('#form-tambah').html("");
                            var tables=$('#data-table-fixed-header').DataTable();
                                tables.ajax.url("{{ url('master/mk/get_data')}}").load();
                        }else{
                            document.getElementById("loadnya").style.width = "0px";
                            swal({
                                title: 'Notifikasi',
                               
                                html:true,
                                text:'ss',
                                icon: 'error',
                                buttons: {
                                    cancel: {
                                        text: 'Tutup',
                                        value: null,
                                        visible: true,
                                        className: 'btn btn-dangers',
                                        closeModal: true,
                                    },
                                    
                                }
                            });
                            $('.swal-text').html('<div style="width:100%;background:#f2f2f5;padding:1%;text-align:left;font-size:13px">'+msg+'</div>')
                        }
                        
                        
                    }
                });
      };
    </script>
@endpush
