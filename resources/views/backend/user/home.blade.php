@extends('backend/item/layout')
@section('content')
<div class="page-wrapper">
    <div class="page-content">
        <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4">
           <div class="col">
             <div class="card radius-10 border-start border-0 border-4 border-info">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <p class="mb-0 text-secondary">Kuliah</p>
                            <h4 class="my-1 text-info">{{ $kuliah }}</h4>
                        </div>
                        <div class="widgets-icons-2 rounded-circle bg-gradient-blues text-white ms-auto"><i class='bx bxs-group'></i>
                        </div>
                    </div>
                </div>
             </div>
           </div>
           <div class="col">
            <div class="card radius-10 border-start border-0 border-4 border-warning">
               <div class="card-body">
                   <div class="d-flex align-items-center">
                       <div>
                           <p class="mb-0 text-secondary">Bekerja</p>
                           <h4 class="my-1 text-warning">{{ $bekerja }}</h4>
                       </div>
                       <div class="widgets-icons-2 rounded-circle bg-gradient-orange text-white ms-auto"><i class='bx bxs-group'></i>
                       </div>
                   </div>
               </div>
            </div>
          </div>

          <div class="col">
            <div class="card radius-10 border-start border-0 border-4 border-success">
               <div class="card-body">
                   <div class="d-flex align-items-center">
                       <div>
                           <p class="mb-0 text-secondary">Jumlah Alumni</p>
                           <h4 class="my-1 text-success">{{ $jumlahAlumni }}</h4>
                       </div>
                       <div class="widgets-icons-2 rounded-circle bg-gradient-ohhappiness text-white ms-auto"><i class='bx bxs-group' ></i>
                       </div>
                   </div>
               </div>
            </div>
          </div>

          <div class="col">
            <div class="card radius-10 border-start border-0 border-4 border-danger">
               <div class="card-body">
                   <div class="d-flex align-items-center">
                       <div>
                           <p class="mb-0 text-secondary">Lainnya</p>
                           <h4 class="my-1 text-danger">{{ $lainnya }}</h4>
                       </div>
                       <div class="widgets-icons-2 rounded-circle bg-gradient-burning text-white ms-auto"><i class='bx bxs-group'></i>
                       </div>
                   </div>
               </div>
            </div>
          </div>
        </div><!--end row-->

        <div class="row">
            <div class="col-7">
                <div class="card radius-10">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <div>
                                <h6 class="mb-0">Bar Chart</h6>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                            <div id="barchart_material" style="width: 850px; height: 500px;"></div>
                    </div>
                </div>
            </div>

            <div class="col-5">
                <div class="card radius-10">
                    <div class="card-header">
                        <h6 class="mb-0">Grafik Pengisian</h6>
                    </div>
                    <div class="card-body">
                        <div id="donutchart" style="width: 600px; height: 500px;"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card radius-10">
        <div class="card-header">
            <div class="d-flex align-items-center">
                <div>
                    <h6 class="mb-0">5 Data alumni terbaru</h6>
                </div>
            </div>
        </div>
            <div class="card-body">
                <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                    <th class="align-middle"><center>NO</center></th>
                    <th class="bg-success text-white"><center>NAMA</center></th>
                    <th class="bg-danger text-white"><center>NISN</center></th>
                    <th class="bg-primary text-white"><center>KELAS</center></th>
                    <th class="bg-warning text-white"><center>ANGKATAN</center></th>
                    <th class="bg-success text-white"><center>ALAMAT</center></th>
                    </tr>
                    </thead>
                    <tbody>
                    @php
                        $no = 1;
                    @endphp
                    @foreach ($data as $d)
                    <tr>
                        <td><center>{{ $no++ }}</center></td>
                        <td><center>{{ $d->nama_alumni }}</center></td>
                        <td><center>{{ $d->nisn }}</center></td>
                        <td><center>{{ $d->kelas }}</center></td>
                        <td><center>{{ $d->angkatan }}</center></td>
                        <td><center>{{ $d->alamat }}</center></td>
                    </tr>
                    @endforeach
                </tbody>
                </table>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

{{-- Bar Chart Alumni --}}
<script type="text/javascript">
  google.charts.load('current', {
    packages: ['bar', 'corechart']
  });

  google.charts.setOnLoadCallback(() => {
    Promise.all([
      drawChart1(),
      drawChartAngkatan()
    ]).then(() => {
      console.log('✅ Semua grafik telah dimuat.');
      document.body.classList.add('charts-loaded');
    });
  });

function drawChart1() {
    var data = google.visualization.arrayToDataTable([
        ['Angkatan', 'Bekerja', 'Kuliah', 'Lainnya'],
        @foreach($chartData as $item)
            ['{{ $item[0] }}', {{ $item[1] }}, {{ $item[2] }}, {{ $item[3] }}],
        @endforeach
    ]);

    var options = {
        chart: {
            title: 'Kegiatan Alumni per Angkatan',
            subtitle: 'Bekerja, Kuliah, dan Lainnya',
        },
        bars: 'horizontal' // Bar horizontal
    };

    var chart = new google.charts.Bar(document.getElementById('barchart_material'));
    chart.draw(data, google.charts.Bar.convertOptions(options));
}

// Grafik Angkatan
    google.charts.load("current", {packages:["corechart"]});
    google.charts.setOnLoadCallback(drawChartAngkatan);

    function drawChartAngkatan() {
        var data = google.visualization.arrayToDataTable([
            ['Angkatan', 'Jumlah Alumni'],
            @foreach ($angkatan as $row)
                ['{{ $row->angkatan }}', {{ $row->jumlah }}],
            @endforeach
        ]);

        var options = {
            title: 'Persentase Pengisian Per-Angkatan',
            pieHole: 0.6,
            chartArea: {
                width: '90%',
                height: '90%'
            }
        };

        var chart = new google.visualization.PieChart(document.getElementById('donutchart'));
        chart.draw(data, options);
    }
</script>
