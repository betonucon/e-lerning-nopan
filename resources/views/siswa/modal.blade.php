
    <input type="hidden" name="id" value="{{$id}}">
    <div class="form-group">
      <label for="inputEmail3" class="col-sm-2 control-label">NIS</label>

      <div class="col-sm-4">
        <input type="text" name="nis" class="form-control input-sm"  value="{{$data->nis}}" placeholder="Ketik...">
      </div>
    </div>
    <div class="form-group">
      <label for="inputEmail3" class="col-sm-2 control-label">Nama Siswa</label>

      <div class="col-sm-8">
        <input type="text" name="nama_siswa" class="form-control input-sm"  value="{{$data->nama_siswa}}" placeholder="Ketik...">
      </div>
    </div>
    <div class="form-group">
      <label for="inputEmail3" class="col-sm-2 control-label">Kategori</label>

      <div class="col-sm-4">
        <select name="jurusan_id" class="form-control input-sm"  value="{{$data->nis}}" placeholder="Ketik...">
          <option value="">Pilih ----</option>
          @foreach(get_jurusan() as $kat)
            <option value="{{$kat->id}}" @if($data->jurusan_id==$kat->id) selected @endif >{{$kat->jurusan}}</option>
          @endforeach
        </select>
      </div>
    </div>
    <div class="form-group">
      <label for="inputEmail3" class="col-sm-2 control-label">Kelas</label>

      <div class="col-sm-4">
        <select name="kelas" class="form-control input-sm"  value="{{$data->nis}}" placeholder="Ketik...">
          <option value="">Pilih ----</option>
          @foreach(get_kelas() as $kat)
            <option value="{{$kat->kelas}}-{{$kat->id}}" @if($data->kelas_id==$kat->id) selected @endif >{{$kat->nama_kelas}}</option>
          @endforeach
        </select>
      </div>
    </div>