<input type="hidden" name="id"  value="{{$data->id}}" placeholder="Ketik...">
    <div class="form-group">
        <label for="inputEmail3" class="col-sm-3 control-label">Kode</label>

        <div class="col-sm-3">
            <input type="text" name="kode_material" class="form-control input-sm" disabled value="{{$data->kode_material}}" placeholder="Ketik...">
        </div>
    </div>
        
    <div class="form-group">
        <label for="inputEmail3" class="col-sm-3 control-label">Nama Material</label>

        <div class="col-sm-9">
            <input type="text" name="nama_material" disabled class="form-control input-sm"  value="{{$data->nama_material}}" placeholder="Ketik...">
        </div>
    </div>
    <div class="form-group">
        <label for="inputEmail3" class="col-sm-3 control-label">Nama Material</label>

        <div class="col-sm-6">
            <input type="text" name="harga_material" id="harga_material" class="form-control input-sm"  value="{{$data->biaya}}" placeholder="Ketik...">
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            
        </div>
    </div>

    <script>
        $("#harga_material").inputmask({ alias : "currency", prefix: '', 'autoGroup': true, 'digits': 0, 'digitsOptional': false });
    </script>