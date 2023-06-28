    <ul class="sidebar-menu" data-widget="tree">
        <li class="@if(Request::is('home')==1 || Request::is('/')==1) active @endif"><a href="{{url('home')}}"><i class="fa fa-home text-white"></i> <span>Home</span></a></li>
        @if(Auth::user()->role_id==1)
          <li class="treeview  @if(Request::is('master')==1 || Request::is('master/*')==1) menu-open @endif">
            <a href="#">
              <i class="fa fa-database text-white"></i> <span>Master</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu" style="display:@if(Request::is('master')==1 || Request::is('master/*')==1) block @endif">
              <li ><a href="{{url('master/mk')}}">&nbsp;<i class="fa  fa-sort-down"></i> Mata Pelajaran</a></li>
              <li ><a href="{{url('master/siswa')}}">&nbsp;<i class="fa  fa-sort-down"></i> Siswa</a></li>
              <li ><a href="{{url('master/guru')}}">&nbsp;<i class="fa  fa-sort-down"></i> Guru</a></li>
              
            </ul>
          </li>
          <li class="@if(Request::is('pengajuan')==1 || Request::is('pengajuan/view')==1 ) active @endif"><a href="{{url('pengajuan')}}"><i class="fa  fa-file-text-o text-white"></i> <span>SKMHT</span></a></li>
          <li class="@if(Request::is('pengajuan/riwayat')==1 ) active @endif"><a href="{{url('pengajuan/riwayat')}}"><i class="fa fa-history text-white"></i> <span>Riwayat SKMHT</span></a></li>
          <li class="treeview  @if(Request::is('arsip')==1 || Request::is('arsip/*')==1) menu-open @endif">
            <a href="#">
              <i class="fa fa-paperclip text-white"></i> <span>Arsip</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu" style="display:@if(Request::is('arsip')==1 || Request::is('arsip/*')==1) block @endif">
              <li ><a href="{{url('arsip')}}">&nbsp;<i class="fa  fa-sort-down"></i> Arsip Masuk</a></li>
              <li ><a href="{{url('arsip/out')}}">&nbsp;<i class="fa  fa-sort-down"></i> Arsip Keluar</a></li>
              
            </ul>
          </li>
        @endif
        @if(Auth::user()->role_id==2)
          <li class="treeview  @if(Request::is('master')==1 || Request::is('master/*')==1) menu-open @endif">
            <a href="#">
              <i class="fa fa-database text-white"></i> <span>Master</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu" style="display:@if(Request::is('master')==1 || Request::is('master/*')==1) block @endif">
              <li ><a href="{{url('master/siswa')}}">&nbsp;<i class="fa  fa-sort-down"></i> Siswa</a></li>
              <li ><a href="{{url('master/guru')}}">&nbsp;<i class="fa  fa-sort-down"></i> Guru</a></li>
              
            </ul>
          </li>
          <li class="@if(Request::is('soal')==1 || Request::is('soal/*')==1 ) active @endif"><a href="{{url('soal')}}"><i class="fa  fa-newspaper-o text-white"></i> <span>Database Soal</span></a></li>
          <li class="@if(Request::is('materi')==1 || Request::is('materi/view')==1 ) active @endif"><a href="{{url('materi')}}"><i class="fa  fa-mortar-board text-white"></i> <span>Kelas Room</span></a></li>
          
        @endif
        @if(Auth::user()->role_id==3)
          
          <li class="@if(Request::is('materi')==1 || Request::is('materi/*')==1 ) active @endif"><a href="{{url('materi')}}"><i class="fa  fa-newspaper-o text-white"></i> <span>Materi</span></a></li>
          <li class="@if(Request::is('tugas')==1 || Request::is('tugas/*')==1 ) active @endif"><a href="{{url('tugas')}}"><i class="fa  fa-navicon text-white"></i> <span>Tugas</span></a></li>
          <li class="@if(Request::is('ujian')==1 || Request::is('ujian/*')==1 ) active @endif"><a href="{{url('ujian')}}"><i class="fa  fa-clone text-white"></i> <span>Ujian</span></a></li>
          
        @endif

      </ul>