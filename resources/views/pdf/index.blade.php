<html>
    <head>
        <title></title>
        <style>

            .html{

            }
            table{
                border-collapse:collapse;
            }
            .ttd{
                border:solid 1px #000;
                font-size:13px;
                padding-left:4px;
            }
            .td-head{
                
            }
            .td-center{
                text-align:center
            }
        </style>
    </head>
    <body>
        @foreach($get as $data)
            <main>
            <table width="100%">
                <tr>
                    <td class="td-head"></td>
                    <td class="td-head"></td>
                </tr>
                <tr>
                    <td class="td-head td-center" colspan="2"><br><br></br>DAFTAR RIWAYAT HIDUP</td>
                </tr>
            </table>
            <table width="100%">
                <tr>
                    <td class="ttd" width="5%">1.</td>
                    <td class="ttd" colspan="2" >Posisi yang diusulkan</td>
                    <td class="ttd"  width="3%">:</td>
                    <td class="ttd" ><b>{{$data->Jabatan}}</b> </td>
                </tr>
                <tr>
                    <td class="ttd">2.</td>
                    <td class="ttd" colspan="2">Nama Perusahaan</td>
                    <td class="ttd">:</td>
                    <td class="ttd">PT Krakatau Information Technology</td>
                </tr>
                <tr>
                    <td class="ttd">3.</td>
                    <td class="ttd" colspan="2">Nama Personel</td>
                    <td class="ttd">:</td>
                    <td class="ttd">{{$data->Nama}}</td>
                </tr>
                <tr>
                    <td class="ttd">4.</td>
                    <td class="ttd" colspan="2">Tempat/Tanggal Lahir</td>
                    <td class="ttd">:</td>
                    <td class="ttd">{{$data->Tempat_Lahir}}, {{$data->Tanggal_Lahir}}</td>
                </tr>
                <tr>
                    <td class="ttd">5.</td>
                    <td class="ttd" colspan="2">Pendidikan</td>
                    <td class="ttd">:</td>
                    <td class="ttd">{{$data->Pendidikan}}</td>
                </tr>
                <tr>
                    <td class="ttd"></td>
                    <td class="ttd" colspan="2">Alamat</td>
                    <td class="ttd">:</td>
                    <td class="ttd">{{$data->Alamat}}</td>
                </tr>
                <tr>
                    <td class="ttd"></td>
                    <td class="ttd" colspan="2">Email</td>
                    <td class="ttd">:</td>
                    <td class="ttd">{{$data->Email}}</td>
                </tr>
                <tr>
                    <td class="ttd"></td>
                    <td class="ttd" colspan="2">Tahun tamat</td>
                    <td class="ttd">:</td>
                    <td class="ttd">{{$data->Tahun_Ijazah}}</td>
                </tr>
                <tr>
                    <td class="ttd">6.</td>
                    <td class="ttd" colspan="2">Penguasaan Bahasa</td>
                    <td class="ttd">:</td>
                    <td class="ttd"></td>
                </tr>
                <tr>
                    <td class="ttd"></td>
                    <td class="ttd" width="5%">a.</td>
                    <td class="ttd" width="17%">Bahasa Indonesia</td>
                    <td class="ttd">:</td>
                    <td class="ttd">Baik</td>
                </tr>
                <tr>
                    <td class="ttd"></td>
                    <td class="ttd" width="5%">b.</td>
                    <td class="ttd">Bahasa Inggris</td>
                    <td class="ttd">:</td>
                    <td class="ttd">Baik</td>
                </tr>
                <tr>
                    <td class="ttd"></td>
                    <td class="ttd" width="5%">c.</td>
                    <td class="ttd">Bahasa Setempat</td>
                    <td class="ttd">:</td>
                    <td class="ttd">Baik</td>
                </tr>
                <tr>
                    <td class="ttd">7.</td>
                    <td class="ttd" colspan="2">Pengalaman Kerja</td>
                    <td class="ttd">:</td>
                    <td class="ttd"></td>
                </tr>
                @foreach(get_example($data->Nama) as $no=>$o)
                <tr>
                    <td class="ttd"></td>
                    <td class="ttd">a.</td>
                    <td class="ttd">Judul Pekerjaan</td>
                    <td class="ttd">:</td>
                    <td class="ttd"><b>{{$o->Deskripsi}}</b></td>
                </tr>
                <tr>
                    <td class="ttd"></td>
                    <td class="ttd">b.</td>
                    <td class="ttd">Lokasi Kegiatan</td>
                    <td class="ttd">:</td>
                    <td class="ttd">Cilegon</td>
                </tr>
                <tr>
                    <td class="ttd"></td>
                    <td class="ttd">c.</td>
                    <td class="ttd">Pengguna Jasa</td>
                    <td class="ttd">:</td>
                    <td class="ttd">{{$o->Nama_Klien}}</td>
                </tr>
                <tr>
                    <td class="ttd"></td>
                    <td class="ttd">d.</td>
                    <td class="ttd">Nama Perusahaan</td>
                    <td class="ttd">:</td>
                    <td class="ttd">PT Krakatau Information Technology</td>
                </tr>
                <tr>
                    <td class="ttd"></td>
                    <td class="ttd">e.</td>
                    <td class="ttd">Tahun</td>
                    <td class="ttd">:</td>
                    <td class="ttd">{{$o->Tahun}}</td>
                </tr>
                <tr>
                    <td class="ttd"></td>
                    <td class="ttd">f.</td>
                    <td class="ttd">Posisi Penugasan</td>
                    <td class="ttd">:</td>
                    <td class="ttd"><b>{{$o->Jabatan}}</b></td>
                </tr>
                <tr>
                    <td class="ttd"></td>
                    <td class="ttd">g.</td>
                    <td class="ttd">Uraian Tugas</td>
                    <td class="ttd">:</td>
                    <td class="ttd"></td>
                </tr>
                <tr>
                    <td class="ttd">&nbsp;</td>
                    <td class="ttd"></td>
                    <td class="ttd"></td>
                    <td class="ttd"></td>
                    <td class="ttd"></td>
                </tr>
                @endforeach
            </table>
        </main>
        @endforeach
    </body>
</html>