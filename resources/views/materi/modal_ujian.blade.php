  
  
  <table id="data-table-fixed-soal" class="table table-bordered table-striped dataTable" >
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
  <script type="text/javascript">
        $(document).ready(function () {
            $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
                $.fn.dataTable.tables({ visible: true, api: true }).columns.adjust();
            });

            $('#data-table-fixed-soal').DataTable({
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
                    
                    { data: 'click_ujian' , className: "text-center" },
                    { data: 'soal' },
                    { data: 'kelas' , className: "text-center" },
                    { data: 'kategori_soal' },
                    
                    
                  ],
            });
        });

        
    </script>   
