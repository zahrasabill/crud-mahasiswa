@extends("layouts.app")

@section("title")
    Mahasiswa List
@endsection

@section("content")
    <div class="bg-light rounded">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Mahasiswa</h5>
                <h6 class="card-subtitle mb-2 text-muted">List of Mahasiswa</h6>

                <div class="mt-2">
                    @include("layouts.includes.messages")
                </div>

                <div class="mb-3">
                    <input type="text" id="query" class="form-control" placeholder="Cari nama mahasiswa...">
                </div>

                <div class="table-responsive">
                    <table class="table table-striped" id="mahasiswaTable">
                        <thead>
                            <tr>
                                <th scope="col" width="1%">#</th>
                                <th scope="col" width="15%">NIM</th>
                                <th scope="col">Nama</th>
                                <th scope="col">Alamat</th>
                                <th scope="col">Tanggal Lahir</th>
                                <th scope="col">Gender</th>
                                <th scope="col">Usia</th>
                            </tr>
                        </thead>
                        <tbody id="mahasiswa-list">
                            @foreach ($mahasiswas as $mahasiswa)
                                <tr>
                                    <th scope="row">{{ $mahasiswa->id }}</th>
                                    <td>{{ $mahasiswa->nim }}</td>
                                    <td>{{ $mahasiswa->nama }}</td>
                                    <td>{{ $mahasiswa->alamat }}</td>
                                    <td>{{ $mahasiswa->tanggal_lahir }}</td>
                                    <td>{{ $mahasiswa->gender }}</td>
                                    <td>{{ $mahasiswa->usia }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-2">
                    <p>Total Mahasiswa: {{ $totalMahasiswa }}</p>
                </div>

                <div class="mt-2">
                    <h5>Gender Statistics</h5>
                    <div class="chart-wrapper" style="height: 300px;">
                        <canvas id="genderChart"></canvas>
                    </div>
                </div>

                <div class="d-flex justify-content-center">
                    <ul class="pagination">
                        <li class="page-item {{ $mahasiswas->currentPage() == 1 ? " disabled" : "" }}">
                            <a class="page-link" href="{{ $mahasiswas->url(1) }}">Previous</a>
                        </li>
                        @for ($i = 1; $i <= $mahasiswas->lastPage(); $i++)
                            <li class="page-item {{ $mahasiswas->currentPage() == $i ? " active" : "" }}">
                                <a class="page-link" href="{{ $mahasiswas->url($i) }}">{{ $i }}</a>
                            </li>
                        @endfor
                        <li
                            class="page-item {{ $mahasiswas->currentPage() == $mahasiswas->lastPage() ? " disabled" : "" }}">
                            <a class="page-link" href="{{ $mahasiswas->url($mahasiswas->currentPage() + 1) }}">Next</a>
                        </li>
                    </ul>
                </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var ctx = document.getElementById('genderChart').getContext('2d');
            
            Chart.register(ChartDataLabels);
            
            // Data untuk pie chart
            var genderLabels = {!! json_encode($genderStatistics->pluck("gender")) !!};
            var genderData = {!! json_encode($genderStatistics->pluck("total")) !!};
            
            // Warna untuk pie chart dengan tema CoreUI
            var colors = [
                '#20a8d8', // CoreUI primary blue
                '#f86c6b', // CoreUI danger red  
            ];
            
            var genderChart = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: genderLabels,
                    datasets: [{
                        data: genderData,
                        backgroundColor: colors.slice(0, genderLabels.length),
                        borderColor: '#fff',
                        borderWidth: 2,
                        hoverBorderWidth: 3,
                        hoverBorderColor: '#fff'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                padding: 20,
                                usePointStyle: true,
                                font: {
                                    size: 14
                                }
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    var label = context.label || '';
                                    var value = context.parsed;
                                    var total = context.dataset.data.reduce((a, b) => a + b, 0);
                                    var percentage = ((value / total) * 100).toFixed(1);
                                    return label + ': ' + value + ' (' + percentage + '%)';
                                }
                            }
                        },
                        datalabels: {
                            color: '#fff',
                            font: {
                                weight: 'bold',
                                size: 16
                            },
                            formatter: function(value, context) {
                                var total = context.dataset.data.reduce((a, b) => a + b, 0);
                                var percentage = ((value / total) * 100).toFixed(1);
                                return value + '\n(' + percentage + '%)';
                            }
                        }
                    },
                    elements: {
                        arc: {
                            borderAlign: 'center'
                        }
                    },
                    animation: {
                        animateRotate: true,
                        animateScale: true
                    }
                }
            });
        });

        // Search functionality
        $(document).ready(function() {
            $('#query').on('keyup', function() {
                var value = $(this).val().toLowerCase();
                $('#mahasiswa-list tr').filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
        });
    </script>
@endsection