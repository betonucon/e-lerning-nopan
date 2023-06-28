    <input type="text" name="pengajuan_id" value="{{$id}}">
    <input type="text" name="dokumen_id" value="{{$dokumen_id}}">
    <div class="form-group">
        <label for="inputEmail3" class="col-sm-11 control-label" id="header-label"><i class="fa fa-bars"></i> Dokumen</label>

    </div>
    <div class="form-group">
        <label for="inputEmail3" class="col-sm-3 control-label">Nama Dokumen</label>
        <div class="col-sm-8">
            <input  class="form-control input-sm" readonly name="dokumen" value="{{$data->dokumen}}" placeholder="Ketik..." >
        </div>
    </div>
    <div class="form-group">
        <label for="inputEmail3" class="col-sm-3 control-label">Lokasi</label>
        <div class="col-sm-3">
            <select name="lemari_id" onchange="pilih_lemari(this.value)" class="form-control  input-sm" placeholder="0000">
                <option value="">Pilih------</option>
                @foreach(get_lemari() as $kat)
                <option value="{{$kat->id}}" @if($mst->lemari_id==$kat->id) selected @endif >{{$kat->lemari}}</option>
                @endforeach
            </select>
        </div>
        <div class="col-sm-2">
            <select name="rak_id" id="rak_id" class="form-control  input-sm" placeholder="0000">
                <option value="">Pilih------</option>
                
            </select>
        </div>
    </div>
    <div class="form-group">
        <label for="inputEmail3" class="col-sm-3 control-label">Attachment</label>
        <div class="col-sm-5">
            <input type="file" class="form-control input-sm"  name="file" value="{{$data->file}}" placeholder="Ketik..." >
        </div>
    </div>
    <script>
        function pilih_lemari(id){
            $('#rak_id').load("{{url('pengajuan/rak')}}?id="+id)
        }
    </script>