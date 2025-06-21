@extends("layouts.app")

@section("title")
    Daftar Produk
@endsection

@section("content")
    <div class="bg-light rounded">
        <div class="card">
            <div class="card-body">

                <div class="mt-2">
                    <p>Total Produk: {{ $totalProduk }}</p>
                </div>

                <div class="mt-2">
                    <h5>Statistik Stok Produk</h5>
                    <canvas id="stokChart" width="300" height="100"></canvas>
                </div>

            </div>
        </div>
    </div>

    {{-- Chart.js & jQuery --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var ctx = document.getElementById('stokChart').getContext('2d');
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
                            'rgba(255, 99, 132, 0.6)',
                            'rgba(255, 206, 86, 0.6)',
                            'rgba(75, 192, 192, 0.6)'
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
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
    </script>
@endsection
