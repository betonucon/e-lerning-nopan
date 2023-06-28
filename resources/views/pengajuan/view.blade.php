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
@endpush
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Rencana Rencana
        
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Pengajuan</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- SELECT2 EXAMPLE -->
      <div class="box box-default">
        <div class="box-body">
            <form class="form-horizontal" id="mydata" method="post" action="{{ url('project') }}" enctype="multipart/form-data" >
              @csrf
              <!-- <input type="submit"> -->
              <input type="hidden" name="id" value="{{$id}}">
              <div class="row">
              
                <div class="col-md-12">
                  <!-- <div class="callout callout-success">
                    <h4>Penyusunan RAB</h4>

                    <p>Penyusunan nilai anggaran rencana project yang terdiri dari 4 aspek (Rencana , Biaya Operasional, Material Cos dan Risiko Project)</p>
                  </div> -->
                  <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                      <li class="@if($id==0) active @endif"><a href="#tab_1" data-toggle="tab" aria-expanded="true"><i class="fa fa-check-square-o"></i> Pengajuan</a></li>
                      <li class="@if($id>0) active @endif"><a href="#tab_2"  data-toggle="tab" aria-expanded="false"><i class="fa fa-check-square-o"></i> Dokumen</a></li>
                      @if($data->status>1)
                      <li class=""><a href="#tab_3"  data-toggle="tab" aria-expanded="false"><i class="fa fa-check-square-o"></i> Riwayat</a></li>
                      @endif
                      <li class="pull-right"><a href="#" class="text-muted"><i class="fa fa-gear"></i></a></li>
                    </ul>
                    <div class="tab-content" style="background: #fff3f3;">
                    
                      <div class="tab-pane @if($id==0) active @endif" id="tab_1">
                        <div class="box-body">
                          
                          <div class="form-group">
                            <label for="inputEmail3" class="col-sm-11 control-label" id="header-label"><i class="fa fa-bars"></i> Data Diri (Yang Mengajukan)</label>

                          </div>
                          <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">Nomor Register</label>
                              <div class="col-sm-2">
                              <input  class="form-control input-sm" readonly name="no_register" value="{{$no_register}}" placeholder="Ketik..." >
                            </div>
                          </div>
                          <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">Nomor KTP</label>
                              <div class="col-sm-3">
                              <input  class="form-control input-sm" name="nik" value="{{$data->nik}}" placeholder="Ketik..." >
                            </div>
                          </div>
                          <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">Nama</label>
                              <div class="col-sm-6">
                              <input  class="form-control input-sm" name="nama" value="{{$data->nama}}" placeholder="Ketik..." >
                            </div>
                          </div>
                          <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">Alamat</label>
                              <div class="col-sm-10">
                                <input  class="form-control input-sm" name="alamat" value="{{$data->alamat}}" placeholder="Ketik..." >
                              </div>
                          </div>
                          <div class="form-group">
                            <label for="inputEmail3" class="col-sm-11 control-label" id="header-label"><i class="fa fa-bars"></i> Jaminan Yang dikuasakan</label>

                          </div>
                          <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">Jaminan</label>
                              <div class="col-sm-3">
                                  <select name="kategori_id" onchange="pilih_kategori(this.value)" class="form-control  input-sm" placeholder="0000">
                                      <option value="">Pilih------</option>
                                      @foreach(get_kategori() as $kat)
                                        <option value="{{$kat->id}}" @if($data->kategori_id==$kat->id) selected @endif >{{$kat->kategori}}</option>
                                      @endforeach
                                  </select>
                              </div>
                          </div>
                          
                          <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label" id="labeltext"></label>
                              <div class="col-sm-5">
                              <input  class="form-control input-sm" name="nomor_jaminan" value="{{$data->nomor_jaminan}}" placeholder="Ketik..." >
                            </div>
                          </div>
                          <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">Nomor KTP</label>
                              <div class="col-sm-3">
                              <input  class="form-control input-sm" name="nik_pemilik" value="{{$data->nik_pemilik}}" placeholder="Ketik..." >
                            </div>
                          </div>
                          <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">Nama</label>
                              <div class="col-sm-6">
                              <input  class="form-control input-sm" name="nama_pemilik" value="{{$data->nama_pemilik}}" placeholder="Ketik..." >
                            </div>
                          </div>
                          <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">Alamat</label>
                              <div class="col-sm-10">
                                <input  class="form-control input-sm" name="alamat_pemilik" value="{{$data->alamat_pemilik}}" placeholder="Ketik..." >
                              </div>
                          </div>
                          <div class="form-group">
                            <label for="inputEmail3" class="col-sm-11 control-label" id="header-label"><i class="fa fa-bars"></i> Tujuan Surat Kuasa</label>

                          </div>
                          <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">Nama Mitra Tujuan</label>
                              <div class="col-sm-7">
                              <input  class="form-control input-sm" name="lokasi" value="{{$data->lokasi}}" placeholder="Ketik..." >
                            </div>
                          </div>
                          <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">Nilai (Rp)</label>
                              <div class="col-sm-2">
                              <input  class="form-control input-sm" name="nilai" id="nilai_project" value="{{$data->nilai}}" placeholder="Ketik..." >
                            </div>
                          </div>
                          <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">Waktu Mulai & Sampai</label>
                              <div class="col-sm-2">
                                <div class="input-group">
                                  <span class="input-group-addon" ><i class="fa fa-calendar"></i></span>
                                  <input type="text" id="mulai" name="mulai" readonly value="{{$data->mulai}}" class="form-control  input-sm" placeholder="yyyy-mm-dd">
                                </div>
                              </div>
                              <div class="col-sm-2">
                                <div class="input-group">
                                  <span class="input-group-addon" ><i class="fa fa-calendar"></i></span>
                                  <input type="text" id="sampai" name="sampai" readonly value="{{$data->sampai}}" class="form-control  input-sm" placeholder="yyyy-mm-dd">
                                </div>
                              </div>
                          </div>
                          
                          
                          
                        </div>
                        @if($data->status!=3)
                        <div class="box-footer" style="text-align:center">
                            <div class="btn-group">
                              <span  class="btn btn-sm btn-success" onclick="simpan_data()"><i class="fa fa-arrow-right"></i> Berikutnya</span>
                              <!-- <span  class="btn btn-sm btn-danger" onclick="location.assign(`{{url('project')}}`)"><i class="fa fa-arrow-left"></i> Kembali</span> -->
                            </div>
                                
                        </div>
                        @endif
                      </div>

                      <div class="tab-pane @if($id>0) active @endif" id="tab_2">
                        <div class="form-group">
                          <label for="inputEmail3" class="col-sm-11 control-label" id="header-label"><i class="fa fa-bars"></i> Dokumen Pengajuan</label>

                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-1 control-label" style="width:2%"></label>
                            
                            <div class="col-sm-11">
                              <div class="callout callout-warning" style="background-color: #f9fb87 !important;color: #000 !important;">
                                <p>Harap lengkapi semua isi agar dapat disimpan atau diproses.</p>
                              </div>
                              <table class="table table-bordered" id="">
                                <thead>
                                  <tr style="background:#bcbcc7">
                                    <th style="width: 10px">No</th>
                                    <th>Dokumen</th>
                                    <th width="5%">Status</th>
                                    <th width="8%">Lemari</th>
                                    <th width="8%">Rak</th>
                                    <th width="5%"></th>
                                    <th width="5%">Dokumen</th>
                                  </tr>
                                </thead>
                                <tbody id="tampil-dokumen"></tbody>
                              </table>
                            </div>
                        </div>
                        @if($data->status==1)
                        <div class="box-footer" style="text-align:center">
                            <div class="btn-group">
                              <span  class="btn btn-sm btn-primary" onclick="proses_data()"><i class="fa fa-save"></i> Proses pengajuan</span>
                              <!-- <span  class="btn btn-sm btn-danger" onclick="location.assign(`{{url('project')}}`)"><i class="fa fa-arrow-left"></i> Kembali</span> -->
                            </div>
                                
                        </div>
                        @endif
                      </div>
                      <div class="tab-pane @if($id>0)  @endif" id="tab_3">
                        <div class="form-group">
                          <label for="inputEmail3" class="col-sm-11 control-label" id="header-label"><i class="fa fa-bars"></i> Log Pengajuan</label>

                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-1 control-label" style="width:2%"></label>
                            
                            <div class="col-sm-11">
                              <table class="table table-bordered" id="">
                                <thead>
                                  <tr style="background:#bcbcc7">
                                    <th style="width: 10px">No</th>
                                    <th>Alasan</th>
                                    <th width="8%">Ke</th>
                                    <th width="12%">Sebelumnya</th>
                                    <th width="12%">Berikutnya</th>
                                    <th width="15%">Create</th>
                                  </tr>
                                </thead>
                                <tbody id="tampil-log"></tbody>
                              </table>
                            </div>
                        </div>
                        @if($data->status==1)
                        <div class="box-footer" style="text-align:center">
                            <div class="btn-group">
                              <span  class="btn btn-sm btn-primary" onclick="proses_data()"><i class="fa fa-save"></i> Proses pengajuan</span>
                              <!-- <span  class="btn btn-sm btn-danger" onclick="location.assign(`{{url('project')}}`)"><i class="fa fa-arrow-left"></i> Kembali</span> -->
                            </div>
                                
                        </div>
                        @endif
                      </div>
                      @if($data->status==2)
                        <div class="box-footer" style="text-align:center">
                            <div class="btn-group">
                              <span  class="btn btn-sm btn-success" onclick="show_perpanjang()"><i class="fa fa-save"></i> Perpanjang</span>
                              <span  class="btn btn-sm btn-info" onclick="selesai_data()"><i class="fa fa-save"></i> Selesai</span>
                              <!-- <span  class="btn btn-sm btn-danger" onclick="location.assign(`{{url('project')}}`)"><i class="fa fa-arrow-left"></i> Kembali</span> -->
                            </div>
                                
                        </div>
                      @endif
                    </div>
                    <!-- /.box-body -->
                    
                    <!-- /.box-footer -->
                  
                </div>
                
                
              </div>
          </form>
        </div>
        <div class="box-footer">
          @if($data->tab>4)
            <div class="btn-group">
              <button  class="btn btn-sm btn-info" onclick="kirim_data()"><i class="fa fa-save"></i> Simpan & Publish</button>
              <button  class="btn btn-sm btn-danger" onclick="location.assign(`{{url('project')}}`)"><i class="fa fa-arrow-left"></i> Kembali</button>
            </div>
          @endif      
        </div>
        
      </div>
     

    </section>
    <div class="modal fade" id="modal-draf" style="display: none;">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button  class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span></button>
            <h4 class="modal-title">Upload Dokumen</h4>
          </div>
          <div class="modal-body">
            <form class="form-horizontal" id="mydatadokumen" method="post" action="{{ url('pengajuan/store_dokumen') }}" enctype="multipart/form-data" >
                @csrf
                <div id="tampil-form"></div>
            </form>
              
            
          </div>
          <div class="modal-footer">
            <button  class="btn btn-default pull-left" data-dismiss="modal">Close</button>
            <button  class="btn btn-info pull-right" onclick="upload_data()">Upload</button>
          </div>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>
    <div class="modal fade" id="modal-perpanjang" style="display: none;">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button  class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span></button>
            <h4 class="modal-title">Perpanjangan</h4>
          </div>
          <div class="modal-body">
            <form class="form-horizontal" id="mydataperpanjang" method="post" action="{{ url('pengajuan/store_perpanjang') }}" enctype="multipart/form-data" >
                @csrf
                <div id="tampil-perpanjang"></div>
            </form>
              
            
          </div>
          <div class="modal-footer">
            <button  class="btn btn-default pull-left" data-dismiss="modal">Close</button>
            <button  class="btn btn-info pull-right" onclick="perpanjang_data()">Proses</button>
          </div>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>


  </div>
@endsection

@push('ajax')
    <script> 
       
        $('#labeltext').html("Nomor Sertifikat");

        function pilih_kategori(id){
          if(id==3){
            $('#labeltext').html("Nomor BPKB");
          }else{
            $('#labeltext').html("Nomor Sertifikat");
          }
        }
        $('#mulai').datepicker({
          autoclose: true,
          format:'yyyy-mm-dd'
        });
        $('#sampai').datepicker({
          autoclose: true,
          format:'yyyy-mm-dd'
        });

        $('#end_date').datepicker({
          autoclose: true,
          format:'yyyy-mm-dd'
        });
        $('#tampil-dokumen').load("{{url('pengajuan/tampil_dokumen')}}?id={{$data->id}}");
        $('#tampil-log').load("{{url('pengajuan/tampil_log')}}?id={{$data->id}}");
        $("#nilai_project").inputmask({ alias : "currency", prefix: '', 'autoGroup': true, 'digits': 0, 'digitsOptional': false });
        

        
        $("#nilai").inputmask({ alias : "currency", prefix: '', 'autoGroup': true, 'digits': 2, 'digitsOptional': false });
        $(document).ready(function(){

          $("#nilai").keyup(function(){
            var angkane=$("#nilai").val();
            var nil = angkane.replace(/[.](?=.*?\.)/g, '');
            var nilai=parseFloat(nil.replace(/[^0-9.]/g,''))
            $("#out").val(terbilang(nilai));

          });

        });


        function update_dokumen(id){
          @if($data->status!=3)
            $('#modal-draf').modal('show');
            $('#tampil-form').load("{{url('pengajuan/tampil_form')}}?id={{$data->id}}&dokumen_id="+id);
          @else
            alert('Pengajuan sudah close / Selesai')
          @endif
        }  
        function show_perpanjang(){
           
            $('#modal-perpanjang').modal('show');
            $('#tampil-perpanjang').load("{{url('pengajuan/tampil_perpanjang')}}?id={{$data->id}}");
        }  
        function pilih_customer(customer_code,customer){
           
           $('#modal-draf').modal('hide');
           $('#customer_code').val(customer_code);
           $('#customer').val(customer);
           
        }  
       
        function proses_data(){
           
           swal({
               title: "Yakin melakukan proses data ?",
               text: "",
               type: "warning",
               icon: "info",
               showCancelButton: true,
               align:"center",
               confirmButtonClass: "btn-info",
               confirmButtonText: "Yes, publish it!",
               closeOnConfirm: false
           }).then((willDelete) => {
               if (willDelete) {
                var form=document.getElementById('mydata');
                $.ajax({
                    type: 'POST',
                    url: "{{ url('pengajuan/proses_data') }}",
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
                                title: 'Berhasil diproses',
                                text:'',
                                icon: 'success',
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
                            location.assign("{{url('pengajuan')}}");
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
                   
               } else {
                   
               }
           });
           
        }
        function selesai_data(){
           
           swal({
               title: "Yakin melakukan close / Selesai ?",
               text: "",
               type: "warning",
               icon: "info",
               showCancelButton: true,
               align:"center",
               confirmButtonClass: "btn-info",
               confirmButtonText: "Yes, publish it!",
               closeOnConfirm: false
           }).then((willDelete) => {
               if (willDelete) {
                var form=document.getElementById('mydata');
                $.ajax({
                    type: 'POST',
                    url: "{{ url('pengajuan/selesai_data') }}",
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
                                title: 'Berhasil diproses',
                                text:'',
                                icon: 'success',
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
                            location.assign("{{url('pengajuan')}}");
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
                   
               } else {
                   
               }
           });
           
        }
        function perpanjang_data(){
           
           swal({
               title: "Yakin melakukan proses perpanjang ?",
               text: "",
               type: "warning",
               icon: "info",
               showCancelButton: true,
               align:"center",
               confirmButtonClass: "btn-info",
               confirmButtonText: "Yes, publish it!",
               closeOnConfirm: false
           }).then((willDelete) => {
               if (willDelete) {
                var form=document.getElementById('mydataperpanjang');
                $.ajax({
                    type: 'POST',
                    url: "{{ url('pengajuan/perpanjang_data') }}",
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
                                title: 'Berhasil diproses',
                                text:'',
                                icon: 'success',
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
                            location.assign("{{url('pengajuan')}}");
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
                   
               } else {
                   
               }
           });
           
        }
        function simpan_data(){
            
                var form=document.getElementById('mydata');
                $.ajax({
                    type: 'POST',
                    url: "{{ url('pengajuan/store') }}",
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
                            location.assign("{{url('pengajuan/view')}}?id="+bat[2]+"&tab=2");
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
        }

        function upload_data(){
          
            
          var form=document.getElementById('mydatadokumen');
          
              
              $.ajax({
                  type: 'POST',
                  url: "{{ url('pengajuan/store_dokumen') }}",
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
                          $('#modal-draf').modal('hide');
                          $('#tampil-dokumen').load("{{url('pengajuan/tampil_dokumen')}}?id={{$data->id}}");
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
        }
        function simpan_risiko(){
          
            
          var form=document.getElementById('mydata');
          
              
              $.ajax({
                  type: 'POST',
                  url: "{{ url('project/store_risiko') }}",
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
                          location.assign("{{url('project/view')}}?id={{encoder($id)}}&tab=1");
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
        }
        function simpan_material(){
          
            
          var form=document.getElementById('mydata');
          
              
              $.ajax({
                  type: 'POST',
                  url: "{{ url('project/store_material') }}",
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
                          location.assign("{{url('project/view')}}?id={{encoder($id)}}&tab=4");
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
        }
        
    </script> 
@endpush
