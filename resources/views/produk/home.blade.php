@extends("layouts.app")

@section("title")
    Daftar Produk
@endsection

@section("content")
    <div class="bg-light rounded">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Produk</h5>
                <h6 class="card-subtitle mb-2 text-muted">List of Produk</h6>

                <div class="mt-2">
                    @include("layouts.includes.messages")
                </div>

                <div class="mb-3">
                    <input type="text" id="query" class="form-control" placeholder="Cari nama produk...">
                </div>

                <div class="table-responsive">
                    <table class="table table-striped" id="produkTable">
                        <thead>
                            <tr>
                                <th scope="col" width="1%">#</th>
                                <th scope="col">Nama Produk</th>
                                <th scope="col">Deskripsi</th>
                                <th scope="col">Harga</th>
                                <th scope="col">Stok</th>
                                <th scope="col">Tanggal Dibuat</th>
                            </tr>
                        </thead>
                        <tbody id="produk-list">
                            @foreach ($produks as $produk)
                                <tr>
                                    <th scope="row">{{ $produk->id }}</th>
                                    <td>{{ $produk->nama }}</td>
                                    <td>{{ $produk->deskripsi }}</td>
                                    <td>Rp {{ number_format($produk->harga, 2, ',', '.') }}</td>
                                    <td>{{ $produk->stok }}</td>
                                    <td>{{ $produk->created_at->format('d-m-Y') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-2">
                    <p>Total Produk: {{ $totalProduk }}</p>
                </div>

                <div class="mt-2">
                    <h5>Statistik Stok</h5>
                    <div class="chart-wrapper" style="height: 300px;">
                        <canvas id="stokChart"></canvas>
                    </div>
                </div>

                <div class="d-flex justify-content-center">
                    <ul class="pagination">
                        <li class="page-item {{ $produks->currentPage() == 1 ? 'disabled' : '' }}">
                            <a class="page-link" href="{{ $produks->url(1) }}">Previous</a>
                        </li>
                        @for ($i = 1; $i <= $produks->lastPage(); $i++)
                            <li class="page-item {{ $produks->currentPage() == $i ? 'active' : '' }}">
                                <a class="page-link" href="{{ $produks->url($i) }}">{{ $i }}</a>
                            </li>
                        @endfor
                        <li class="page-item {{ $produks->currentPage() == $produks->lastPage() ? 'disabled' : '' }}">
                            <a class="page-link" href="{{ $produks->url($produks->currentPage() + 1) }}">Next</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    {{-- Chart.js & jQuery --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var ctx = document.getElementById('stokChart').getContext('2d');

            Chart.register(ChartDataLabels);

            var stokChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Stok Rendah (<10)', 'Stok Menengah (10-50)', 'Stok Tinggi (>50)'],
                    datasets: [{
                        label: 'Jumlah Produk',
                        data: [
                            {{ $stokStatistics['stok_rendah'] }},
                            {{ $stokStatistics['stok_menengah'] }},
                            {{ $stokStatistics['stok_tinggi'] }}
                        ],
                        backgroundColor: [
                            '#f86c6b',   // red
                            '#ffc107',   // yellow
                            '#20c997'    // green
                        ],
                        borderColor: '#fff',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    var label = context.dataset.label || '';
                                    var value = context.parsed.y;
                                    return label + ': ' + value;
                                }
                            }
                        },
                        datalabels: {
                            color: '#000',
                            font: {
                                weight: 'bold',
                                size: 14
                            },
                            anchor: 'end',
                            align: 'top'
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1
                            }
                        }
                    }
                }
            });
        });

        // Search filtering
        $(document).ready(function () {
            $('#query').on('keyup', function () {
                var value = $(this).val().toLowerCase();
                $('#produk-list tr').filter(function () {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
        });
    </script>
@endsection
