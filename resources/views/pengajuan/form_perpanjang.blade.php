    <input type="text" name="id" value="{{$id}}">
    <div class="form-group">
        <label for="inputEmail3" class="col-sm-11 control-label" id="header-label"><i class="fa fa-bars"></i> Perpanjangan</label>

    </div>
    <div class="form-group">
        <label for="inputEmail3" class="col-sm-3 control-label">No Register</label>
        <div class="col-sm-4">
            <input  class="form-control input-sm" readonly name="no_register" value="{{$data->no_register}}" placeholder="Ketik..." >
        </div>
    </div>
    <div class="form-group">
        <label for="inputEmail3" class="col-sm-3 control-label">Yang Mengajukan</label>
        <div class="col-sm-8">
            <input  class="form-control input-sm" readonly name="nama" value="{{$data->nama}}" placeholder="Ketik..." >
        </div>
    </div>
    <div class="form-group">
        <label for="inputEmail3" class="col-sm-3 control-label">Perpanjangan</label>
        <div class="col-sm-4">
            <div class="input-group">
                <span class="input-group-addon" ><i class="fa fa-calendar"></i></span>
                <input type="text" id="mulai" name="mulai" readonly value="{{$data->mulai}}" class="form-control  input-sm" placeholder="yyyy-mm-dd">
            </div>
        </div>
        <div class="col-sm-4">
            <div class="input-group">
                <span class="input-group-addon" ><i class="fa fa-calendar"></i></span>
                <input type="hidden" name="sebelumnya"  value="{{$data->sampai}}" class="form-control  input-sm" placeholder="yyyy-mm-dd">
                <input type="text" id="sampainya" name="sampai"  value="{{$data->sampai}}" class="form-control  input-sm" placeholder="yyyy-mm-dd">
            </div>
        </div>
    </div>
    <div class="form-group">
        <label for="inputEmail3" class="col-sm-3 control-label">Alasan</label>
        <div class="col-sm-8">
            <textarea  rows="4" class="form-control input-sm" name="alasan"  placeholder="Ketik..." ></textarea>
        </div>
    </div>
    <script>
        function pilih_lemari(id){
            $('#rak_id').load("{{url('pengajuan/rak')}}?id="+id)
        }
        $('#sampainya').datepicker({
          autoclose: true,
          format:'yyyy-mm-dd'
        });
    </script>