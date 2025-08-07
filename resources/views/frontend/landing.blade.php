@extends('frontend.item.template')
@section('content')
<style>
@keyframes blink {
  0% { opacity: 1; }
  50% { opacity: 0; }
  100% { opacity: 1; }
}

.blink {
  animation: blink 2s infinite;
}
</style>

    <section id="hero" class="hero section">
      <div class="container">
        <div class="row gy-4">
          <div class="col-lg-6 order-2 order-lg-1 d-flex flex-column justify-content-center" data-aos="fade-up">
            <h1>Tracer Study</h1>
            <p>Sistem Pendataan Alumni untuk Acuan Akreditasi dan Evaluasi Mutu Pendidikan.</p>
            <div class="d-flex">
              <a href="{{ url('auth') }}" class="btn-get-started">Login</a>
            </div>
          </div>
          <div class="col-lg-6 order-1 order-lg-2 hero-img" data-aos="zoom-out" data-aos-delay="100">
            <img src="{{ asset('assets/frontend/assets/img/hero-img.png') }}" class="img-fluid animated" alt="">
          </div>
        </div>
      </div>
    </section>

    <section id="featured-services" class="featured-services section">
      <div class="container">
        <div class="row gy-4">
          <div class="col-lg-4 d-flex" data-aos="fade-up" data-aos-delay="100">
            <div class="service-item position-relative">
              <div class="icon"><i class="bi bi-door-open"></i></div>
              <h4><a href="{{ url('auth') }}" class="stretched-link">Login/Register</a></h4>
              <p>Silahkan registrasi lalu login untuk melakukan pengisian kuisioner.</p>
            </div>
          </div>
          <div class="col-lg-4 d-flex" data-aos="fade-up" data-aos-delay="200">
            <div class="service-item position-relative">
              <div class="icon"><i class="bi bi-bar-chart-steps"></i></div>
              <h4><a href="#caraPengisian" class="stretched-link">Cara Pengisian</a></h4>
              <p>Informasi Cara Pengisian kuisioner Tracer Study SMAIT AL-ITTIHAD</p>
            </div>
          </div>
          <div class="col-lg-4 d-flex" data-aos="fade-up" data-aos-delay="300">
            <div class="service-item position-relative">
              <div class="icon"><i class="bi bi-list-task"></i></div>
              <h4><a href="{{ url('auth') }}" class="stretched-link">Pengisian Kuisioner</a></h4>
              <p>Pengisian dilakukan dengan melengkapi data terkini alumni.</p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section id="stats" class="stats section">
      <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="row gy-4">
          <div class="col-lg-3 col-md-6">
            <div class="stats-item text-center w-100 h-100">
              <span data-purecounter-start="0" data-purecounter-end="{{ $kuliah }}" data-purecounter-duration="1" class="purecounter"></span>
              <p>Kuliah</p>
            </div>
          </div>
          <div class="col-lg-3 col-md-6">
            <div class="stats-item text-center w-100 h-100">
              <span data-purecounter-start="0" data-purecounter-end="{{ $bekerja }}" data-purecounter-duration="1" class="purecounter"></span>
              <p>Bekerja</p>
            </div>
          </div>
          <div class="col-lg-3 col-md-6">
            <div class="stats-item text-center w-100 h-100">
              <span data-purecounter-start="0" data-purecounter-end="{{ $jumlahAlumni }}" data-purecounter-duration="1" class="purecounter"></span>
              <p>Jumlah Alumni Terdaftar</p>
            </div>
          </div>
          <div class="col-lg-3 col-md-6">
            <div class="stats-item text-center w-100 h-100">
              <span data-purecounter-start="0" data-purecounter-end="{{ $lainnya }}" data-purecounter-duration="1" class="purecounter"></span>
              <p>Lainnya</p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section id="jadwal" class="services section light-background">
        <div class="container section-title pb-1" data-aos="fade-up" style="margin-bottom: 10px">
            <h2 class="mb-1">Jadwal</h2>
        </div>
        <div class="container">
            <div class="row gy-4">
            <div class="col-lg-12 col-md-6" data-aos="fade-up" data-aos-delay="200">
                <div class="service-item position-relative">
                <a href="#" class="stretched-link">
                    <h3 class="mb-4 blink">Jadwal Pengisian Tracer Study SMAIT AL-ITTIHAD</h3>
                </a>

                @php
                    $aktif = $jadwal->where('status', 1)->count();
                @endphp

                @if ($aktif > 0)
                <table class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th width="5%">NO</th>
                            <th width="30%">Tanggal Buka</th>
                            <th width="30%">Tanggal Tutup</th>
                            <th width="20%">Periode</th>
                            <th width="15%">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $no = 0; @endphp
                        @foreach ($jadwal as $j)
                            @if ($j->status == 1)
                            <tr>
                                <td><center>{{ ++$no }}</center></td>
                                <td>{{ $j->tgl_buka }}</td>
                                <td>{{ $j->tgl_tutup }}</td>
                                <td>{{ $j->periode }}</td>
                                <td>
                                    <center>
                                        <span class="badge bg-success fs-7 py-2 px-3">Aktif</span>
                                    </center>
                                </td>
                            </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
                @else
                <div class="alert" style="background-color: #fffbe6; border: 1px solid #ffe58f; color: #664d03; padding: 15px; border-radius: 5px;">
                    Jadwal belum dibuka !
                </div>
                @endif

                </div>
            </div>
            </div>
        </div>
    </section>


    <section id="grafik" class="about section">
      <div class="container section-title" data-aos="fade-up">
        <h2>Grafik Alumni</h2>
      </div>
      <div class="container">
        <div class="row gy-4">
          <div class="col-lg-12 text-center" data-aos="fade-up" data-aos-delay="100">
            <div id="grafik_alumni" style="width: 1200px; height: 500px;"></div>
          </div>
        </div>
      </div>
    </section>
    <section id="about" class="about section">
      <div class="container section-title" data-aos="fade-up">
      </div>
      <div class="container">
        <div class="row gy-4">
          <div class="col-lg-12 text-center" data-aos="fade-up" data-aos-delay="100">
            <div id="donutchart" style="width: 1200px; height: 700px;"></div>
          </div>
        </div>
      </div>
    </section>

    <section id="caraPengisian" class="testimonials section light-background">
      <div class="container section-title" data-aos="fade-up">
        <h2>Tata Cara Pengisian</h2>
      </div>
          <div class="container">
            <div class="row gy-4">
              <div class="col-lg-8 content " data-aos="fade-up" data-aos-delay="200">
                <h3>Informasi Tata Cara yang harus di ikuti</h3>
                <p class="fst-italic">
                  LANGKAH-LANGKAH PENGISIAN KUISIONER
                </p>
                <ul>
                  <li><i class="bi bi-check2-all"></i> <span>Lakukan registrasi akun terlebih dahulu dengan email aktif yang digunakan.</span></li>
                  <li><i class="bi bi-check2-all"></i> <span>Login/Masuk menggunakan akun yang sudah terdaftar.</span></li>
                  <li><i class="bi bi-check2-all"></i> <span>Lengkapi terlebih dahulu data diri sebelum mengisi kuisioner.</span></li>
                  <li><i class="bi bi-check2-all"></i> <span>Isilah kuisioner dengan data yang sebenar-benarnya.</span></li>
                </ul>
              </div>
            </div>
          </div>
    </section>

    <section id="contact" class="contact section">
      <div class="container section-title" data-aos="fade-up">
        <h2>Contact</h2>
        <p>Necessitatibus eius consequatur ex aliquid fuga eum quidem sint consectetur velit</p>
      </div>
      <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="row gy-4">
          <div class="col-lg-12 justify-content-center">
            <div class="info-wrap">
              <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="300">
                <i class="bi bi-geo-alt flex-shrink-0"></i>
                <div class="col-lg-3">
                  <h3>Alamat</h3>
                  <p>Jl. Yos Sudarso, Lembah Damai, Kec. Rumbai Pesisir, Kota Pekanbaru, Riau 28266</p>
                </div>
                <i class="bi bi-telephone flex-shrink-0"></i>
                <div class="col-lg-3">
                  <h3>Telepon</h3>
                  <p>(0461) 946314</p>
                </div>
                <i class="bi bi-envelope flex-shrink-0"></i>
                <div class="col-lg-3">
                  <h3>Email</h3>
                  <p>ittihad@gmail.com</p>
                </div>
              </div>
              <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3989.6164733067326!2d101.43208687496472!3d0.5763337994180355!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31d5aca7589c2e5b%3A0x698cc6d1da79f552!2sSMAIT%20Al-Ittihad!5e0!3m2!1sen!2sid!4v1749290456409!5m2!1sen!2sid" width="1200" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
          </div>
        </div>
      </div>
    </section>
@endsection

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

{{-- Bar Chart Alumni --}}
<script type="text/javascript">
  google.charts.load('current', {
    packages: ['bar', 'corechart']
  });

  google.charts.setOnLoadCallback(() => {
    Promise.all([
      grafik(),
      drawChartAngkatan()
    ]).then(() => {
      console.log('✅ Semua grafik telah dimuat.');
      document.body.classList.add('charts-loaded');
    });
  });

function grafik() {
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

    var chart = new google.charts.Bar(document.getElementById('grafik_alumni'));
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
