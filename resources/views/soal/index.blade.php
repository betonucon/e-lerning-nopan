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
        /*
        Template Name: Color Admin - Responsive Admin Dashboard Template build with Twitter Bootstrap 4
        Version: 4.6.0
        Author: Sean Ngu
        Website: http://www.seantheme.com/color-admin/admin/
        */
        
        var handleDataTableFixedHeader = function() {
            "use strict";
            
            if ($('#data-table-fixed-header').length !== 0) {
                var table=$('#data-table-fixed-header').DataTable({
                    lengthMenu: [20,50,100],
                    searching:true,
                    lengthChange:true,
                    fixedHeader: {
                        header: true,
                        headerOffset: $('#header').height()
                    },
                    responsive: true,
                    ajax:"{{ url('soal/get_data')}}",
                      columns: [
                        { data: 'id', render: function (data, type, row, meta) 
                            {
                              return meta.row + meta.settings._iDisplayStart + 1;
                            } , className: "text-center" 
                        },
                        
                        { data: 'action' , className: "text-center" },
                        { data: 'soal' },
                        { data: 'kelas' , className: "text-center" },
                        { data: 'kategori_soal' },
                        
                        
                      ],
                      
                });
                $('#cari_datatable').keyup(function(){
                  table.search($(this).val()).draw() ;
                })

                
            }
        };

        var TableManageFixedHeader = function () {
            "use strict";
            return {
                //main function
                init: function () {
                    handleDataTableFixedHeader();
                }
            };
        }();

        
        $(document).ready(function() {
          TableManageFixedHeader.init();
           
        });

        function show_hide(){
            var tables=$('#data-table-fixed-header').DataTable();
                tables.ajax.url("{{ url('material/getdata')}}?hide=1").load();
        }
        function refresh_data(){
            var tables=$('#data-table-fixed-header').DataTable();
                tables.ajax.url("{{ url('material/getdata')}}").load();
        }
        
    </script>   
@endpush
@section('content')
<div class="content-wrapper" style="min-height: 926.281px;">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Bank Soal
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Bank Soal</li>
      </ol>
    </section>

    
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          
          <div class="box">
            <div class="box-header">
              <div class="row">
                <div class="col-sm-6">
                  <span class="btn btn-success btn-sm" onclick="tambah(`0`)"><i class="fa fa-plus-circle"></i> Tambah</span>
                </div>
                <div class="col-sm-6">
                  
                </div>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              
              <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                
                <div class="row">
                  <div class="col-sm-12">
                    <table id="data-table-fixed-header" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
                      <thead>
                        <tr role="row">
                          <th class="sorting_asc" width="5%" >NO</th>
                          <th class="sorting_asc" width="3%"></th>
                          <th class="sorting" > Soal</th>
                          <th class="sorting_asc" width="7%">Kelas</th>
                          <th class="sorting_asc" width="15%">Kategori</th>
                          
                        </tr>
                      </thead>
                    
                    </table>
                  </div>
                </div>
                
              </div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
    <!-- /.row -->
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
          <form class="form-horizontal" id="mydata" method="post" action="{{ url('soal') }}" enctype="multipart/form-data" >
            @csrf
            <!-- <input type="submit"> -->
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
        $('#modal-tambah').modal('show');
        $('#form-tambah').load("{{url('soal/modal')}}?id="+id);
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
                   
                       $.ajax({
                           type: 'GET',
                           url: "{{url('soal/delete_data')}}",
                           data: "id="+id,
                           success: function(msg){
                               swal("Success! berhasil terhapus!", {
                                   icon: "success",
                               });
                               var tables=$('#data-table-fixed-header').DataTable();
                                  tables.ajax.url("{{ url('soal/get_data')}}").load();
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
                    url: "{{ url('soal') }}",
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
                                tables.ajax.url("{{ url('soal/get_data')}}").load();
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
