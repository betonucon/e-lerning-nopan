
    <input type="hidden" name="id" value="{{$id}}">
    <div class="form-group">
      <label for="inputEmail3" class="col-sm-3 control-label">Soal</label>

      <div class="col-sm-9">
        <textarea name="soal" rows="4" class="form-control input-sm" placeholder="Ketik...">{{$data->soal}}</textarea>
      </div>
    </div>
    
    <div class="form-group">
      <label for="inputEmail3" class="col-sm-3 control-label">Kelas</label>

      <div class="col-sm-5">
        <select name="kelas" class="form-control input-sm"   placeholder="Ketik...">
          <option value="">Pilih ----</option>
          <option value="1" @if($data->kelas==1) selected @endif >Kelas 1</option>
          <option value="2" @if($data->kelas==2) selected @endif >Kelas 2</option>
          <option value="3" @if($data->kelas==3) selected @endif >Kelas 3</option>
         
        </select>
      </div>
    </div>
    
    <div class="form-group">
      <label for="inputEmail3" class="col-sm-3 control-label">Kategori Soal</label>

      <div class="col-sm-4">
        <select name="kategori_soal_id" onchange="pilih_jawaban(this.value)" class="form-control input-sm"   placeholder="Ketik...">
          <option value="">Pilih ----</option>
          <option value="1" @if($data->kategori_soal_id==1) selected @endif >Pilihan Ganda</option>
          <option value="2" @if($data->kategori_soal_id==2) selected @endif >Easy</option>
         
        </select>
      </div>
    </div>
    <div class="form-group jawaban1" id="">
      <label for="inputEmail3" class="col-sm-3 control-label">Pilihan Jawaban</label>
      <div class="col-sm-3">
        <select name="jawaban_benar"  class="form-control input-sm"   placeholder="Ketik...">
          <option value="">Pilih Jawaban-</option>
          @for($x=1;$x<5;$x++)
            <option value="{{$x}}" @if($data->jawaban==$x) selected @endif>Jawaban {{abjad($x)}}</option>
          @endfor
        </select>
      </div>
    </div>
    @for($x=0;$x<4;$x++)
      <div class="form-group jawaban1" id="">
      
       
         <label for="inputEmail3" class="col-sm-3 control-label">{{abjad($x+1)}}.</label>
         <div class="col-sm-8">
            <input type="text" name="jawaban[]"  class="form-control input-sm" value="{{soal_jawaban($data->id,$x)}}"   placeholder="Ketik...">
         </div>
      
      </div>
    @endfor
    
    

    <script>
      @if($data->id>0)
        @if($data->kategori_soal_id==1)

        @else
          $('.jawaban1').hide();
          $('.jawaban2').hide();
        @endif
      @else
          $('.jawaban1').hide();
          $('.jawaban2').hide();
      @endif
      
      function pilih_jawaban(id){
        if(id==1){
          $('.jawaban1').show();
          $('.jawaban2').hide();
        }else{
          $('.jawaban1').hide();
          $('.jawaban2').show();
        }
        
      }
    </script>