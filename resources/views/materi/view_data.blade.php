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
        $(document).ready(function () {
            $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
                $.fn.dataTable.tables({ visible: true, api: true }).columns.adjust();
            });
            
            $('#data-table-fixed-tugas').DataTable({
                lengthMenu: [20,50,100],
                searching:true,
                lengthChange:true,
                fixedHeader: {
                    header: true,
                    headerOffset: $('#header').height()
                },
                responsive: true,
                ajax:"{{ url('materi/get_data_tugas')}}?kelas_room_id={{$id}}&kat=1",
                  columns: [
                    { data: 'id', render: function (data, type, row, meta) 
                        {
                          return meta.row + meta.settings._iDisplayStart + 1;
                        } , className: "text-center" 
                    },
                    
                    { data: 'action_tugas' , className: "text-center" },
                    { data: 'soal' },
                    { data: 'kategori_soal' },
                    
                    
                  ],
            });
            $('#data-table-fixed-ujian').DataTable({
                lengthMenu: [20,50,100],
                searching:true,
                lengthChange:true,
                fixedHeader: {
                    header: true,
                    headerOffset: $('#header').height()
                },
                responsive: true,
                ajax:"{{ url('materi/get_data_tugas')}}?kelas_room_id={{$id}}&kat=2",
                  columns: [
                    { data: 'id', render: function (data, type, row, meta) 
                        {
                          return meta.row + meta.settings._iDisplayStart + 1;
                        } , className: "text-center" 
                    },
                    
                    { data: 'action_ujian' , className: "text-center" },
                    { data: 'soal' },
                    { data: 'kategori_soal' },
                    
                    
                  ],
            });
        });
        

        function load_view(){
          $.ajax({ 
            type: 'GET', 
            url: "{{ url('materi/get_data_materi')}}?kelas_room_id={{$id}}", 
            data: { id: 1 }, 
            dataType: 'json',
            beforeSend: function() {
              $('#tampil-materi-load').show()
            },
            success: function (data) {
              $('#tampil-materi-load').hide();
              $.each(data, function(i, result){
                if(result.jenis_materi==1){
                  icon='<i class="fa fa-clone"></i>';
                }else{
                  icon='<i class="fa fa-file-video-o"></i>';
                }
                if(result.jenis_materi==1){
                  tampil_con='<a href="{{url_plug()}}/dokumen/'+result.file_materi+'"  target="_blank"><span class="btn btn-xs btn-primary"><i class="fa fa-file-text-o"></i> Lihat Materi</span></a></li>';
                }else{
                  tampil_con='<a href="'+result.link_video+'" target="_blank"><span class="btn btn-xs btn-primary"><i class="fa fa-file-text-o"></i> Lihat Materi</span></a></li>';
                }
                if(result.jenis_materi==1){
                    tampil_con='<div class="col-md-4">'
                                  +'<div class="info-box bg-green" onclick="window.open(`{{url_plug()}}/dokumen/'+result.file_materi+'`)" style="background-color: #4db183 !important;">'
                                    +'<span class="info-box-icon" onclick="window.open(`{{url_plug()}}/dokumen/'+result.file_materi+'`)" ><i class="fa fa-clone"></i></span>'

                                    +'<div class="info-box-content">'
                                      +'<span class="info-box-text">'+result.nama_room+'</span>'
                                      +'<span class="progress-description">'+result.nama_materi+'</span>'
                                    +'</div>'
                                  +'</div'
                                +'</div>';
                }else{
                  tampil_con='<div class="col-md-4">'
                                  +'<div class="info-box bg-green" onclick="window.open(`'+result.link_video+'`)"  style="background-color: #4db183 !important;">'
                                    +'<span class="info-box-icon"><i class="fa fa-file-video-o"></i></span>'

                                    +'<div class="info-box-content">'
                                      +'<span class="info-box-text">'+result.nama_room+'</span>'
                                      +'<span class="progress-description">'+result.nama_materi+'</span>'
                                    +'</div>'
                                  +'</div'
                                +'</div>';
                }
                $("#tampil-materi").append(tampil_con);
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
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Form Kelas Room
        
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Kelas Room</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- SELECT2 EXAMPLE -->
      <div class="box box-default">
       
        <div class="box-body">
            <form class="form-horizontal" id="mydata" method="post" action="{{ url('materi') }}" enctype="multipart/form-data" >
              @csrf
              <input type="hidden" name="id" value="{{$id}}">
              <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                  <li class="active"><a href="#tab_0" data-toggle="tab">Kelas Room</a></li>
                  <li ><a @if($id>0) href="#tab_1" data-toggle="tab" @else onclick="alert('Buat Kelas Room terlebih dahulu')" @endif >Materi</a></li>
                  <li><a @if($id>0) href="#tab_2" data-toggle="tab" @else onclick="alert('Buat Kelas Room terlebih dahulu')" @endif>Tugas</a></li>
                  <li><a @if($id>0) href="#tab_3" data-toggle="tab" @else onclick="alert('Buat Kelas Room terlebih dahulu')"  @endif >Ujian</a></li>
                </ul>
                <div class="tab-content">
                  <div class="tab-pane active" id="tab_0">
                    <div class="form-group">
                      <label for="inputEmail3" class="col-sm-12 control-label-judul"><<---- Kelas Room ---->></label>
                    </div>
                    <div class="form-group">
                      <label for="inputEmail3" class="col-sm-2 control-label">Nama Kelas Room</label>

                      <div class="col-sm-9">
                        <input type="text" name="nama_room" class="form-control input-sm" value="{{$data->nama_room}}"  placeholder="Ketik...">
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="inputEmail3" class="col-sm-2 control-label">Kelas</label>

                      <div class="col-sm-2">
                        <select name="kelas" class="form-control input-sm"   placeholder="Ketik...">
                          <option value="">Pilih ----</option>
                          <option value="1" @if($data->kelas==1) selected @endif >Kelas 1</option>
                          <option value="2" @if($data->kelas==2) selected @endif >Kelas 2</option>
                          <option value="3" @if($data->kelas==3) selected @endif >Kelas 3</option>
                        
                        </select>
                      </div>
                    </div>
                    
                    <div class="form-group">
                      <label for="inputEmail3" class="col-sm-2 control-label">Deskripsi</label>

                      <div class="col-sm-9">
                        <textarea class="textarea" name="deskripsi_room" placeholder="Ketik disini" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">{!!$data->deskripsi_room!!}</textarea>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="inputEmail3" class="col-sm-2 control-label">Rencana Tugas</label>

                      <div class="col-sm-6">
                        <div class="input-group input-sm">
                          <div class="input-group-addon">
                            <i class="fa fa-clock-o"></i>
                          </div>
                          <input type="text" name="tanggal_tugas" value="@if($id>0) {{$data->start_tugas}} - {{$data->end_tugas}} @endif" class="form-control pull-right" id="tanggal_tugas">
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="inputEmail3" class="col-sm-2 control-label">Rencana Ujian</label>

                      <div class="col-sm-6">
                        <div class="input-group input-sm">
                          <div class="input-group-addon">
                            <i class="fa fa-clock-o"></i>
                          </div>
                          <input type="text" name="tanggal_ujian" value="@if($id>0) {{$data->start_ujian}} - {{$data->end_ujian}} @endif" class="form-control pull-right" id="tanggal_ujian">
                        </div>
                      </div>
                    </div>
                    <div class="box-footer">
        
                        <div class="btn-group">
                          <span class="btn btn-info" onclick="simpan_data()">Simpan</span>
                          <span class="btn btn-danger" onclick="location.assign(`{{url('materi')}}`)">Kembali</span>
                        </div>
                            
                    </div>
                  </div>
                  <div class="tab-pane" id="tab_1">
                    <div class="form-group">
                      <label for="inputEmail3" class="col-sm-12 control-label-judul"><<---- Materi Pembelajaran ---->></label>
                    </div>
                    <div class="form-group">
                      <label for="inputEmail3" class="col-sm-2 control-label">Nama Materi</label>

                      <div class="col-sm-9">
                        <input type="text" name="nama_materi" id="nama_materi" class="form-control input-sm" value="{{$data->nama_materi}}"  placeholder="Ketik...">
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="inputEmail3" class="col-sm-2 control-label">Jenis Materi</label>

                      <div class="col-sm-3">
                        <select name="jenis_materi" id="jenis_materi" onchange="cari_jenis(this.value)" class="form-control input-sm"   placeholder="Ketik...">
                          <option value="">Pilih ----</option>
                          <option value="1" @if($data->jenis_materi==1) selected @endif >Dokumen pdf</option>
                          <option value="2" @if($data->jenis_materi==2) selected @endif >Youtube</option>
                        
                        </select>
                      </div>
                    </div>
                    
                    <div class="form-group jenis_1">
                      <label for="inputEmail3" class="col-sm-2 control-label">Upload Dokumen</label>

                      <div class="col-sm-5">
                        <input type="file" name="file" class="form-control input-sm"  placeholder="Ketik...">
                      </div>
                    </div>
                    <div class="form-group jenis_2">
                      <label for="inputEmail3" class="col-sm-2 control-label">Url Youtube</label>

                      <div class="col-sm-7">
                        <input type="text" name="link_video" class="form-control input-sm" value="{{$data->link_video}}" placeholder="Ketik...">
                      </div>
                    </div>
                   
                    <div class="box-footer">
        
                        <div class="btn-group">
                          <span class="btn btn-sm btn-info" onclick="simpan_data_materi()">Tambah Materi</span>
                          <span class="btn btn-sm btn-danger" onclick="location.assign(`{{url('materi')}}`)">Kembali</span>
                        </div>
                            
                    </div>
                    <div class="row">
                        <div id="tampil-materi"></div>
                    </div>
                  </div>
                  <div class="tab-pane" id="tab_2">
                      <div class="row" style="margin-bottom: 2%;">
                          <div class="col-sm-3">
                            <span class="btn btn-success btn-sm" onclick="tambah()"><i class="fa fa-plus-circle"></i> Buat Materi</span>
                          </div>
                          <div class="col-sm-9">
                            
                          </div>
                      </div>
                      <table id="data-table-fixed-tugas" width="100%" class="table table-bordered table-striped">
                        <thead>
                          <tr role="row">
                            <th class="sorting_asc" width="5%" >NO</th>
                            <th class="sorting_asc" width="3%"></th>
                            <th class="sorting" > Soal</th>
                            <th class="sorting_asc" width="15%">Kategori</th>
                            
                          </tr>
                        </thead>
                      
                      </table>
                    
                    
                  </div>
                  <div class="tab-pane" id="tab_3">
                      <div class="row" style="margin-bottom: 2%;">
                          <div class="col-sm-3">
                            <span class="btn btn-success btn-sm" onclick="tambah_ujian()"><i class="fa fa-plus-circle"></i> Buat Materi</span>
                          </div>
                          <div class="col-sm-9">
                            
                          </div>
                      </div>
                      <table id="data-table-fixed-ujian" width="100%" class="table table-bordered table-striped">
                        <thead>
                          <tr role="row">
                            <th class="sorting_asc" width="5%" >NO</th>
                            <th class="sorting_asc" width="3%"></th>
                            <th class="sorting" > Soal</th>
                            <th class="sorting_asc" width="15%">Kategori</th>
                            
                          </tr>
                        </thead>
                      
                      </table>
                  </div>
            </form>
        </div>
        
        
      </div>
      <!-- /.box -->

    </section>
    <!-- /.content -->
  </div>
  <div class="modal fade" id="modal-tambah" style="display: none;">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span></button>
          <h4 class="modal-title">Soal</h4>
        </div>
        <div class="modal-body">
            <form class="form-horizontal" id="mydata" method="post" action="{{ url('materi/tugas') }}" enctype="multipart/form-data" >
              @csrf
              <div id="form-tambah"></div>
            </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Tutup</button>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <div class="modal fade" id="modal-ujian" style="display: none;">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span></button>
          <h4 class="modal-title">Soal</h4>
        </div>
        <div class="modal-body">
            <form class="form-horizontal" id="mydata" method="post" action="{{ url('materi/ujian') }}" enctype="multipart/form-data" >
              @csrf
              <div id="form-ujian"></div>
            </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Tutup</button>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
@endsection

@push('ajax')
    <link rel="stylesheet" href="{{url_plug()}}/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
    <script src="{{url_plug()}}/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
    <script> 
        $('.textarea').wysihtml5()
        $("#nilai").inputmask({ alias : "currency", prefix: '', 'autoGroup': true, 'digits': 2, 'digitsOptional': false });
        $('#tanggal_tugas').daterangepicker({ timePicker: true, timePickerIncrement: 30, locale: { format: 'YYYY-MM-DD HH:mm:ss' }})
        $('#tanggal_ujian').daterangepicker({ timePicker: true, timePickerIncrement: 30, locale: { format: 'YYYY-MM-DD HH:mm:ss' }})
        $(".jenis_1").hide();
        $(".jenis_2").hide();
        
        function tambah(){
          $('#modal-tambah').modal('show');
          $('#form-tambah').load("{{url('materi/modal')}}?id={{$id}}");
        }
        function tambah_ujian(){
          $('#modal-ujian').modal('show');
          $('#form-ujian').load("{{url('materi/modal_ujian')}}?id={{$id}}");
        }
        function cari_jenis(id){
          if(id==1){
            $(".jenis_1").show();
            $(".jenis_2").hide();
          }else{
            $(".jenis_1").hide();
            $(".jenis_2").show();
          }
        }

        function pilih_tugas(soal_id){
          $.ajax({
              type: 'GET',
              url: "{{url('materi/pilih_tugas')}}",
              data: "kelas_room_id={{$id}}&soal_id="+soal_id,
              success: function(msg){
                  swal("Success! berhasil ditambahkan ketugas!", {
                      icon: "success",
                  });
                  var tables=$('#data-table-fixed-tugas').DataTable();
                      tables.ajax.url("{{ url('materi/get_data_tugas')}}?kelas_room_id={{$id}}&kat=1").load();
              }
          });
        }

        function delete_data_tugas(id){
            
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
                            url: "{{url('materi/delete_data_tugas')}}",
                            data: "kelas_room_id={{$id}}&kat=1&id="+id,
                            success: function(msg){
                                swal("Success! berhasil terhapus!", {
                                    icon: "success",
                                });
                                var tables=$('#data-table-fixed-tugas').DataTable();
                                    tables.ajax.url("{{ url('materi/get_data_tugas')}}?kelas_room_id={{$id}}&kat=1").load();
                            }
                        });
                    
                } else {
                    
                }
            });
            
        }  
        function pilih_ujian(soal_id){
          $.ajax({
              type: 'GET',
              url: "{{url('materi/pilih_ujian')}}",
              data: "kelas_room_id={{$id}}&soal_id="+soal_id,
              success: function(msg){
                  swal("Success! berhasil ditambahkan keujian!", {
                      icon: "success",
                  });
                  var tables=$('#data-table-fixed-ujian').DataTable();
                      tables.ajax.url("{{ url('materi/get_data_tugas')}}?kelas_room_id={{$id}}&kat=2").load();
              }
          });
        }

        function delete_data_ujian(id){
            
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
                            url: "{{url('materi/delete_data_tugas')}}",
                            data: "kelas_room_id={{$id}}&kat=2&id="+id,
                            success: function(msg){
                                swal("Success! berhasil terhapus!", {
                                    icon: "success",
                                });
                                var tables=$('#data-table-fixed-ujian').DataTable();
                                    tables.ajax.url("{{ url('materi/get_data_tugas')}}?kelas_room_id={{$id}}&kat=2").load();
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
                    url: "{{ url('materi') }}",
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
                            location.assign("{{url('materi/view')}}?id="+bat[2]);
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
        function simpan_data_materi(){
            
            var form=document.getElementById('mydata');
            
                
                $.ajax({
                    type: 'POST',
                    url: "{{ url('materi/store_materi') }}",
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
                              title: "Success! berhasil ditambahkan!",
                              icon: "success",
                            });
                            $("#nama_materi").val("");
                            $("#jenis_materi").val("");
                            $(".jenis_1").hide();
                            $(".jenis_2").hide();
                            $("#tampil-materi").html("");
                            load_view()
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
