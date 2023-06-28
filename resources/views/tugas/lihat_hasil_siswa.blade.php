@extends('layouts.app')

@push('style')
  <style>
    label {
        display: inline-block;
        max-width: 100%;
        margin-bottom: 5px;
        font-weight: normal;
    }
    .btn-app {
      border-radius: 3px;
      position: relative;
      padding: 1px 5px;
      margin: 1px;
      min-width: 9%;
      height: auto;
      text-align: center;
      color: #666;
      border: 1px solid #ddd;
      background-color: #f4f4f4;
      font-size: 13px;
    }
  </style>
@endpush
@push('datatable')
      <script type="text/javascript">
        
        function load_view(){
          
          $.ajax({ 
            type: 'GET', 
            url: "{{ url('tugas/get_data_nomor')}}?kelas_room_id={{$id}}&kat=1&kategori_soal_id=1", 
            data: { id: 1 }, 
            dataType: 'json',
            beforeSend: function() {
              $('#tampil-materi-load').show()
            },
            success: function (data) {
              $('#total_soal').html(data.total);
              $('#nilai').html(data.nilai+'%');
              $('#nilai_easy').html(data.nilai_easy+'%');
              $('#total_nilai').html(data.total_nilai+'%');
              $('#total_dikerjakan').html(data.dikerjakan);
              $('#pemeriksaan').html(data.pemeriksaan);
              var no="{{$no}}";
              $.each(data.data, function(i, result){
                $("#tampil-materi-1").append('<tr>'
                                                 +'<td>'+result.no+'</td>'
                                                +'<td>'+result.soal+'</td>'
                                                +'<td>'+result.nilai+'</td>'
                                              +'</tr>');
              });
                
            }
            
          });

          $.ajax({ 
            type: 'GET', 
            url: "{{ url('tugas/get_data_nomor')}}?kelas_room_id={{$id}}&kat=1&kategori_soal_id=2", 
            data: { id: 1 }, 
            dataType: 'json',
            beforeSend: function() {
              $('#tampil-materi-load').show()
            },
            success: function (data) {
              var no="{{$no}}";
              $.each(data.data, function(i, result){
                $("#tampil-materi-2").append('<tr>'
                                                +'<td>'+result.no+'</td>'
                                                +'<td>'+result.soal+'</td>'
                                                +'<td>'+result.nilai+'</td>'
                                              +'</tr>');
              });
                
            }
            
          });
        }
        
        $(document).ready(function() {
            load_view();
           
        });

    </script>   
@endpush
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Tugas
        
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Tugas</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
    <div class="row">
        <!-- left column -->
        <div class="col-md-12">
          <!-- general form elements -->
          <div class="box box-primary">
            
            <div class="box-body" style="text-align:center">
              
              <h3>{{tanggal_indo_lengkap($data->start_tugas)}} S/D {{tanggal_indo_lengkap($data->end_tugas)}}</h3>
              <h3 id="clock" style="color:red" ></h3>
              <table class="table table-bordered" style="width:50%;margin-left:25%">
                <tbody>
                  <tr>
                    <th>Total Soal</th>
                    <th>Sudah Dikerjakan</th>
                    <th>Nilai PG</th>
                    <th>Nilai Esay</th>
                    <th>Pengecekan</th>
                    <th>Nilai</th>
                  </tr>
                  <tr>
                    <td id="total_soal"></td>
                    <td id="total_dikerjakan"></td>
                    <td id="nilai"></td>
                    <td id="nilai_easy"></td>
                    <td id="pemeriksaan"></td>
                    <td id="total_nilai"></td>
                  </tr>
                  
                </tbody>
              </table>
            </div>
            
          </div>
        </div>
        <div class="col-md-12">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">PILIHAN GANDA</h3>
            </div>
           
            <div class="box-body" >
              <table class="table table-bordered" style="width:80%;margin-left:10%">
                <tbody>
                  <tr>
                    <th width="5%">NO</th>
                    <th >Soal</th>
                    <th  width="10%">Nilai</th>
                  </tr>
                  
                </tbody>
                <tbody id="tampil-materi-1" >
                  
                  
                </tbody>
              </table>
            </div>
            
          </div>
          

        
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">PILIHAN EASY / ISIAN</h3>
            </div>
           
            <div class="box-body" >
                <table class="table table-bordered" style="width:80%;margin-left:10%">
                  <tbody>
                    <tr>
                      <th width="5%">NO</th>
                      <th >Soal</th>
                      <th  width="10%">Nilai</th>
                    </tr>
                    
                  </tbody>
                  <tbody id="tampil-materi-2" >
                    
                    
                  </tbody>
                </table>
            </div>
            
          </div>
          

        </div>
        
      </div>
      

    </section>
    <!-- /.content -->
  </div>
@endsection

@push('ajax')
    <link rel="stylesheet" href="{{url_plug()}}/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
    <script src="{{url_plug()}}/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
    <script> 
      function waitAndshow() {
        var systemdate = new Date();
        
        document.getElementById("clock").innerHTML = 'Time '+systemdate.toLocaleDateString()+' '+systemdate.toLocaleTimeString();
        document.getElementById("clockhours").value = systemdate.getHours();
        
      }
		
      $( document ).ready(function() {
        setInterval(waitAndshow, 500);
        
          
      });
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
        function lihat_data_materi(jenis_materi,file){
          if(jenis_materi==1){
              $('#tampil-dokumen').html('<object data="{{url_plug()}}/dokumen/'+file+'" width="100%" height="500"></object>')
          }
          if(jenis_materi==2){
            // alert()
            var xp=file.split('v=');
            $('#tampil-dokumen').html('<iframe width="640" height="360" src="https://www.youtube.com/embed/'+xp[1]+'" title="Killing Me Inside Live Tangerang 2016 Full Show" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>')
          }
        }
        function proses_jawaban(){
            
            var form=document.getElementById('mydata');
            
                
                $.ajax({
                    type: 'POST',
                    url: "{{ url('tugas') }}",
                    data: new FormData(form),
                    contentType: false,
                    cache: false,
                    processData:false,
                    beforeSend: function() {
                        document.getElementById("loadnya").style.width = "100%";
                    },
                    success: function(msg){
                        var bat=msg.split('@');
                        // alert(msg);
                        if(bat[1]=='ok'){
                            document.getElementById("loadnya").style.width = "0px";
                            swal({
                              title: "Success! berhasil diproses!",
                              icon: "success",
                            });
                            location.assign("{{url('tugas/lihat')}}?id={{$data->id}}&no="+bat[2])
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
