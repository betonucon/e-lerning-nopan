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
            url: "{{ url('materi/get_data_materi')}}?kelas_room_id={{$id}}&jenis_materi=1", 
            data: { id: 1 }, 
            dataType: 'json',
            beforeSend: function() {
              $('#tampil-materi-load').show()
            },
            success: function (data) {
              $('#tampil-materi-load').hide();
              $.each(data, function(i, result){
                
                
                tampil_con='<li>'
              
                            +'<span class="handle ui-sortable-handle" onclick="window.open(`{{url_plug()}}/dokumen/'+result.file_materi+'`)"><i class="fa fa-file-pdf-o"></i></span>'
                            +'<span class="text" onclick="window.open(`{{url_plug()}}/dokumen/'+result.file_materi+'`)" >'+result.nama_materi+'</span><small class="label label-danger"><i class="fa fa-clock-o"></i> 2 mins</small>'
                            +'<div class="tools">'
                              +'<i class="fa fa-edit"></i> Buka'
                            +'</div>'
                          +'</li>';
          
              
                // tampil_con='<li>'
              
                //             +'<span class="handle ui-sortable-handle" onclick="window.open(`'+result.link_video+'`)"><i class="fa fa-ellipsis-v"></i><i class="fa fa-ellipsis-v"></i></span>'
                //             +'<span class="text" onclick="window.open(`'+result.link_video+'`)" >'+result.nama_materi+'</span><small class="label label-danger"><i class="fa fa-clock-o"></i> 2 mins</small>'
                //             +'<div class="tools">'
                //               +'<i class="fa fa-edit"></i> Buka'
                //             +'</div>'
                //           +'</li>';
                
                $("#tampil-materi").append(tampil_con);
              });
                
            }
            
          });
        }
        function load_view2(){
          $.ajax({ 
            type: 'GET', 
            url: "{{ url('materi/get_data_materi')}}?kelas_room_id={{$id}}&jenis_materi=2", 
            data: { id: 1 }, 
            dataType: 'json',
            beforeSend: function() {
              $('#tampil-materi-load').show()
            },
            success: function (data) {
              $('#tampil-materi-load').hide();
              $.each(data, function(i, result){
                
                tampil_con='<li>'
              
                            +'<span class="handle ui-sortable-handle" onclick="window.open(`'+result.link_video+'`)"><i class="fa fa-youtube-play"></i></span>'
                            +'<span class="text" onclick="window.open(`'+result.link_video+'`)" >'+result.nama_materi+'</span><small class="label label-danger"><i class="fa fa-clock-o"></i> 2 mins</small>'
                            +'<div class="tools">'
                              +'<i class="fa fa-edit"></i> Buka'
                            +'</div>'
                          +'</li>';
                
                $("#tampil-materi-2").append(tampil_con);
              });
                
            }
            
          });
        }
        $(document).ready(function() {
            load_view();
            load_view2();
           
        });

    </script>   
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
    <div class="row">
        <!-- left column -->
        <div class="col-md-4">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">DOKUMEN MATERI</h3>
            </div>
           
            <div class="box-body">
              <ul class="todo-list ui-sortable" id="tampil-materi">
              </ul>
            </div>
            
          </div>
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">VIDEO PEMBELAJARAN</h3>
            </div>
           
            <div class="box-body">
              <ul class="todo-list ui-sortable" id="tampil-materi-2">
              </ul>
            </div>
            
          </div>
          

        </div>
        <!--/.col (left) -->
        <!-- right column -->
        <div class="col-md-8">
          <!-- Horizontal Form -->
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">View</h3>
            </div>
            <div class="box-body">
            </div>
          </div>
          
        </div>
        <!--/.col (right) -->
      </div>
      

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
          $("#chat-box").load("{{url('materi/tampil_forum')}}?id={{$data->id}}&users_id={{Auth::user()->id}}");
        }
        function cari_jenis(id){
         
                          <object data="{{url_plug()}}/dokumen/{{$data->file_materi}}" width="100%" height="500"></object>
                       
                           
                            <iframe width="640" height="360" src="https://www.youtube.com/embed/{{$xp[1]}}" title="Killing Me Inside Live Tangerang 2016 Full Show" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                       
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
                            $("#chat-box").load("{{url('materi/tampil_forum')}}?id={{$data->id}}&users_id={{Auth::user()->id}}");
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
