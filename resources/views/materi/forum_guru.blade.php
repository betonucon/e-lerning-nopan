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
        Lihat Materi
        
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Materi</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- SELECT2 EXAMPLE -->
      
      
            <div class="row">
              
              <div class="col-sm-12">
                <div class="nav-tabs-custom">
                  <ul class="nav nav-tabs">
                    <li class="active"><a href="#tab_3" data-toggle="tab">Forum Diskusi</a></li>
                  </ul>
                  <div class="tab-content">
                    <div class="tab-pane active" id="tab_3" style="background: #eeeefd;">
                        
                        
                            <div class="row">
                              <div class="col-sm-4" >
                                <h3 class="box-title">Peserta</h3>
                                <div class="box box-default" style="margin-top:2%;margin-left:2%">
                                    <div class="box-header with-border">
                                      <h3 class="box-title"></h3>

                                      <div class="box-tools pull-right">
                                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
                                      </div>
                                    </div>
                                    
                                    <div class="box-body" id="daftar_siswa">
                                    </div>
                                </div>
                              </div>
                              
                              <div class="col-sm-8" style="padding-left:2%" >
                              <h3 class="box-title">{{$data->nama_room}}</h3>
                                <div class="box box-default" style="margin-top:2%">
                                    <div class="box-header with-border">
                                      <h3 class="box-title">Chat Forum</h3>

                                      <div class="box-tools pull-right">
                                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
                                      </div>
                                    </div>
                                    
                                    <div class="box-body chat" id="chat-box" style="background: #f3f3ff;">

                                    </div>
                                    <div class="box-footer">
                                      <form  id="mydatachat" method="post" action="{{ url('materi/forum') }}" enctype="multipart/form-data" >
                                        @csrf
                                        <input type="hidden" name="users_id" id="users_id">
                                        <input type="hidden" name="mentor_id" value="{{$data->users_id}}">
                                        <input type="hidden" name="materi_id" value="{{$data->id}}">
                                        <div class="form-group">
                                          <input type="text" name="chat" id="chat" class="form-control" id="exampleInputPassword1" placeholder="Ketik.........">
                                        </div>
                                        <div class="form-group">
                                          <input type="file" name="file" id="file">
                                        </div>
                                        <div class="form-group">
                                          <span class="pull-right btn btn-primary" onclick="sendEmail()">Send
                                          <i class="fa fa-arrow-circle-right"></i></span>
                                        </div>
                                      </form>
                                    </div>
              
                                </div>
                              </div>
                              
                            </div>
                       
                        
                      
                    </div>
                  </div>
                </div>
                

                
                
              </div>
              <div class="col-sm-1">
                
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
        $('.textarea').wysihtml5();
        $('#chat-box').slimScroll({
          height: '450px'
        })
        $("#nilai").inputmask({ alias : "currency", prefix: '', 'autoGroup': true, 'digits': 2, 'digitsOptional': false });
        $("#daftar_siswa").load("{{url('materi/forum')}}?kelas={{$data->kelas}}");
        $("#chat-box").load("{{url('materi/tampil_forum')}}?id={{$data->id}}&users_id={{Auth::user()->id}}");
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
        
        function show_forum(users_id){
          $('#users_id').val(users_id);
          $("#chat-box").load("{{url('materi/tampil_forum')}}?id={{$data->id}}&users_id="+users_id);
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
        function sendEmail(){
            
            var form=document.getElementById('mydatachat');
            
                
                $.ajax({
                    type: 'POST',
                    url: "{{ url('materi/forum') }}",
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
                              title: "Success! berhasil dikirim!",
                              icon: "success",
                            });
                            $('#chat').val("");
                            $('#file').val("");
                            $("#chat-box").load("{{url('materi/tampil_forum')}}?id={{$data->id}}&users_id="+bat[2]);
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
