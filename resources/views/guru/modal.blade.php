
    <input type="hidden" name="id" value="{{$id}}">
    <div class="form-group">
      <label for="inputEmail3" class="col-sm-2 control-label">NIP</label>

      <div class="col-sm-4">
        <input type="text" name="nip" class="form-control input-sm"  value="{{$data->nip}}" placeholder="Ketik...">
      </div>
    </div>
    <div class="form-group">
      <label for="inputEmail3" class="col-sm-2 control-label">Nama guru</label>

      <div class="col-sm-8">
        <input type="text" name="nama_guru" class="form-control input-sm"  value="{{$data->nama_guru}}" placeholder="Ketik...">
      </div>
    </div>
    <div class="form-group">
      <label for="inputEmail3" class="col-sm-2 control-label">Kategori</label>

      <div class="col-sm-4">
        <select name="kategori_guru_id" class="form-control input-sm"  value="{{$data->nis}}" placeholder="Ketik...">
          <option value="">Pilih ----</option>
          @foreach(get_kategori_guru() as $kat)
            <option value="{{$kat->id}}" @if($data->kategori_guru_id==$kat->id) selected @endif >{{$kat->kategori_guru}}</option>
          @endforeach
        </select>
      </div>
    </div>