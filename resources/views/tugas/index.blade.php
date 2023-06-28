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
                  status_publish='<span class="btn btn-xs btn-warning" onclick="tutup_materi('+result.id+')">Tutup Materi</span>';
                  warna_publish='yellow';
                }else{
                  status_publish='<span class="btn btn-xs btn-warning" onclick="buka_materi('+result.id+')">Buka Materi</span>';
                  warna_publish='info';
                }
                if(result.jenis_materi==1){
                  tampil_con='<ul class="nav nav-stacked">'
                              +'<li><a href="#"><i class="fa fa-users"></i> Siswa <span class="pull-right badge bg-blue">'+result.total_siswa+'</span></a></li>'
                              +'<li><a href="{{url_plug()}}/dokumen/'+result.file_materi+'"  target="_blank"><i class="fa fa-file-text-o"></i> Download Materi <span class="pull-right badge bg-aqua">'+result.file_materi+'</span></a></li>'
                            +'</ul>';
                }else{
                  tampil_con='<ul class="nav nav-stacked">'
                              +'<li><a href="#"><i class="fa fa-users"></i> Siswa <span class="pull-right badge bg-blue">'+result.total_siswa+'</span></a></li>'
                              +'<li><a href="'+result.link_video+'" target="_blank"><i class="fa fa-file-text-o"></i> Jumlah Materi <span class="pull-right badge bg-aqua">'+result.link_video+'</span></a></li>'
                            +'</ul>';
                }
                $("#tampil-project").append('<div class="col-md-6">'
                        +'<div class="box box-widget widget-user-2" style="border: solid 1px #a2a2af;">'
                          +'<div class="widget-user-header bg-'+warna_publish+'">'
                            +'<div class="widget-user-image">'
                            +'<img class="img-circle" src="{{url_plug()}}/img/materi.png?v={{date('ymdhis')}}" alt="User Avatar">'
                            +'</div>'
                            +'<h3 class="widget-user-username">'+result.singkatan+''+result.tanda+'</h3>'
                            +'<h5 class="widget-user-desc">'+result.nama_materi+'</h5>'
                          +'</div>'
                          +'<div class="user-block" style="text-align: center;">'
                            +'<span class="username" style="margin-left: 0px;"><a href="#">'+result.name+'</a></span>'
                            +'<span class="description" style="margin-left: 0px;">Shared publicly '+result.created_at+'</span>'
                          +'</div>'
                          +'<div class="box-footer no-padding">'+tampil_con+'</div>'
                          +'<div class="box-footer">'
                            
                              +'<span class="btn btn-xs btn-info"  onclick="tambah('+result.id+')">Ubah Materi</span>&nbsp;&nbsp;'
                              +'<span class="btn btn-xs btn-success" onclick="lihat('+result.id+')">Baca Materi</span>&nbsp;&nbsp;'
                              +'<span class="btn btn-xs btn-danger"  onclick="delete_data('+result.id+')">Hapus Materi</span>&nbsp;&nbsp;'
                              +status_publish
                           
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
        Materi
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Materi</li>
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
