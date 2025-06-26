<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Penjualan - Admin Plakat Indonesia</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ url('/') }}">Plakat Indonesia - Admin</a>
            <div class="navbar-nav ms-auto">
                <span class="navbar-text me-3">Admin: {{ Auth::user()->name }}</span>
                <form method="POST" action="{{ route('logout') }}" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-outline-light btn-sm">Logout</button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-md-2">
                <div class="card">
                    <div class="card-header">Menu Admin</div>
                    <div class="list-group list-group-flush">
                        <a href="{{ route('admin.dashboard') }}" class="list-group-item list-group-item-action">
                            <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                        </a>
                        <a href="{{ route('admin.transactions') }}" class="list-group-item list-group-item-action">
                            <i class="fas fa-shopping-cart me-2"></i>Transaksi
                        </a>
                        <a href="{{ route('admin.sales.report') }}" class="list-group-item list-group-item-action active">
                            <i class="fas fa-chart-bar me-2"></i>Laporan Penjualan
                        </a>
                        <a href="/admin" class="list-group-item list-group-item-action">
                            <i class="fas fa-cogs me-2"></i>Filament Admin
                        </a>
                        <a href="{{ url('/') }}" class="list-group-item list-group-item-action">
                            <i class="fas fa-home me-2"></i>Beranda
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Laporan Penjualan</h5>
                    </div>
                    <div class="card-body">
                        <!-- Filter Form -->
                        <form method="GET" action="{{ route('admin.sales.report') }}" class="row g-3 mb-4">
                            <div class="col-md-3">
                                <label for="period" class="form-label">Periode</label>
                                <select class="form-select" id="period" name="period">
                                    <option value="daily" {{ $period === 'daily' ? 'selected' : '' }}>Harian</option>
                                    <option value="weekly" {{ $period === 'weekly' ? 'selected' : '' }}>Mingguan</option>
                                    <option value="monthly" {{ $period === 'monthly' ? 'selected' : '' }}>Bulanan</option>
                                    <option value="yearly" {{ $period === 'yearly' ? 'selected' : '' }}>Tahunan</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="start_date" class="form-label">Tanggal Mulai</label>
                                <input type="date" class="form-control" id="start_date" name="start_date" value="{{ $startDate }}">
                            </div>
                            <div class="col-md-3">
                                <label for="end_date" class="form-label">Tanggal Akhir</label>
                                <input type="date" class="form-control" id="end_date" name="end_date" value="{{ $endDate }}">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">&nbsp;</label>
                                <div>
                                    <button type="submit" class="btn btn-primary">Filter</button>
                                    <a href="{{ route('admin.sales.report') }}" class="btn btn-secondary">Reset</a>
                                </div>
                            </div>
                        </form>

                        <!-- Summary Cards -->
                        <div class="row mb-4">
                            <div class="col-md-4">
                                <div class="card bg-info text-white">
                                    <div class="card-body">
                                        <h5>{{ $salesData->sum('total_orders') }}</h5>
                                        <p class="mb-0">Total Pesanan</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card bg-success text-white">
                                    <div class="card-body">
                                        <h5>Rp {{ number_format($salesData->sum('total_revenue'), 0, ',', '.') }}</h5>
                                        <p class="mb-0">Total Pendapatan</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card bg-warning text-white">
                                    <div class="card-body">
                                        <h5>Rp {{ $salesData->count() > 0 ? number_format($salesData->sum('total_revenue') / $salesData->sum('total_orders'), 0, ',', '.') : 0 }}</h5>
                                        <p class="mb-0">Rata-rata per Pesanan</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Chart -->
                        @if($salesData->count() > 0)
                        <div class="row mb-4">
                            <div class="col-12">
                                <canvas id="salesChart" width="400" height="100"></canvas>
                            </div>
                        </div>
                        @endif

                        <!-- Data Table -->
                        @if($salesData->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            @if($period === 'daily')
                                                <th>Tanggal</th>
                                            @elseif($period === 'weekly')
                                                <th>Tahun</th>
                                                <th>Minggu</th>
                                            @elseif($period === 'monthly')
                                                <th>Tahun</th>
                                                <th>Bulan</th>
                                            @else
                                                <th>Tahun</th>
                                            @endif
                                            <th>Total Pesanan</th>
                                            <th>Total Pendapatan</th>
                                            <th>Rata-rata per Pesanan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($salesData as $data)
                                        <tr>
                                            @if($period === 'daily')
                                                <td>{{ \Carbon\Carbon::parse($data->date)->format('d/m/Y') }}</td>
                                            @elseif($period === 'weekly')
                                                <td>{{ $data->year }}</td>
                                                <td>Minggu {{ $data->week }}</td>
                                            @elseif($period === 'monthly')
                                                <td>{{ $data->year }}</td>
                                                <td>{{ \Carbon\Carbon::create()->month($data->month)->format('F') }}</td>
                                            @else
                                                <td>{{ $data->year }}</td>
                                            @endif
                                            <td>{{ $data->total_orders }}</td>
                                            <td>Rp {{ number_format($data->total_revenue, 0, ',', '.') }}</td>
                                            <td>Rp {{ number_format($data->total_revenue / $data->total_orders, 0, ',', '.') }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center">
                                <p class="text-muted">Tidak ada data penjualan untuk periode yang dipilih.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    
    @if($salesData->count() > 0)
    <script>
        const ctx = document.getElementById('salesChart').getContext('2d');
        const salesChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: [
                    @foreach($salesData as $data)
                        @if($period === 'daily')
                            '{{ \Carbon\Carbon::parse($data->date)->format("d/m") }}',
                        @elseif($period === 'weekly')
                            '{{ $data->year }}-W{{ $data->week }}',
                        @elseif($period === 'monthly')
                            '{{ \Carbon\Carbon::create()->month($data->month)->format("M") }} {{ $data->year }}',
                        @else
                            '{{ $data->year }}',
                        @endif
                    @endforeach
                ],
                datasets: [{
                    label: 'Pendapatan',
                    data: [
                        @foreach($salesData as $data)
                            {{ $data->total_revenue }},
                        @endforeach
                    ],
                    borderColor: 'rgb(75, 192, 192)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    tension: 0.1
                }, {
                    label: 'Jumlah Pesanan',
                    data: [
                        @foreach($salesData as $data)
                            {{ $data->total_orders }},
                        @endforeach
                    ],
                    borderColor: 'rgb(255, 99, 132)',
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    tension: 0.1,
                    yAxisID: 'y1'
                }]
            },
            options: {
                responsive: true,
                interaction: {
                    mode: 'index',
                    intersect: false,
                },
                scales: {
                    y: {
                        type: 'linear',
                        display: true,
                        position: 'left',
                        title: {
                            display: true,
                            text: 'Pendapatan (Rp)'
                        }
                    },
                    y1: {
                        type: 'linear',
                        display: true,
                        position: 'right',
                        title: {
                            display: true,
                            text: 'Jumlah Pesanan'
                        },
                        grid: {
                            drawOnChartArea: false,
                        },
                    }
                }
            }
        });
    </script>
    @endif
</body>
</html>