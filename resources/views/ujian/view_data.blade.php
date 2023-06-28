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

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Form Materi
        
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Materi</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- SELECT2 EXAMPLE -->
      <div class="box box-default">
        <div class="box-header with-border">
          <h3 class="box-title"></h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
          </div>
        </div>
        
        <div class="box-body">
            <form class="form-horizontal" id="mydata" method="post" action="{{ url('materi') }}" enctype="multipart/form-data" >
              @csrf
              <input type="hidden" name="id" value="{{$id}}">
              <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">Judul Materi</label>

                <div class="col-sm-9">
                  <input type="text" name="nama_materi" class="form-control input-sm" value="{{$data->nama_materi}}"  placeholder="Ketik...">
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
                <label for="inputEmail3" class="col-sm-2 control-label">Jenis Materi</label>

                <div class="col-sm-3">
                  <select name="jenis_materi" onchange="cari_jenis(this.value)" class="form-control input-sm"   placeholder="Ketik...">
                    <option value="">Pilih ----</option>
                    <option value="1" @if($data->jenis_materi==1) selected @endif >Dokumen pdf</option>
                    <option value="2" @if($data->jenis_materi==2) selected @endif >Youtube</option>
                  
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">Deskripsi</label>

                <div class="col-sm-9">
                  <textarea class="textarea" name="deskripsi_materi" placeholder="Ketik disini" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">{!!$data->deskripsi_materi!!}</textarea>
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
            </form>
        </div>
        <div class="box-footer">
        
            <div class="btn-group">
              <button type="button" class="btn btn-info" onclick="simpan_data()">Simpan</button>
              <button type="button" class="btn btn-danger" onclick="location.assign(`{{url('materi')}}`)">Kembali</button>
            </div>
                 
        </div>
        
      </div>
      <!-- /.box -->

    </section>
    <!-- /.content -->
  </div>
@endsection

@push('ajax')
    <link rel="stylesheet" href="{{url_plug()}}/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
    <script src="{{url_plug()}}/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
    <script> 
        $('.textarea').wysihtml5()
        $("#nilai").inputmask({ alias : "currency", prefix: '', 'autoGroup': true, 'digits': 2, 'digitsOptional': false });
        @if($data->id>0)
          @if($data->jenis_materi==1)
            $(".jenis_1").show();
            $(".jenis_2").hide();
          @else
            $(".jenis_1").hide();
            $(".jenis_2").show();
          @endif

        @else
          $(".jenis_1").hide();
          $(".jenis_2").hide();
        @endif
        
        function cari_jenis(id){
          if(id==1){
            $(".jenis_1").show();
            $(".jenis_2").hide();
          }else{
            $(".jenis_1").hide();
            $(".jenis_2").show();
          }
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
                            location.assign("{{url('materi')}}");
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
