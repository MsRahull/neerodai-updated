{{-- DASHBOARD PAGE – resources/views/admin/main.blade.php
     Route: /admin/dashboard  →  view('admin.main') --}}
@extends('admin.dashboard')

@section('title', 'Admin Dashboard')

@section('content')

    {{-- ===== Page header ===== --}}
    <div class="na-page-head">
        <div class="na-page-title">
            <span class="na-page-icon"><i class="fas fa-house"></i></span>
            <div>
                <h1>Dashboard</h1>
                <p>Welcome back, Admin! <span aria-hidden="true">👋</span></p>
            </div>
        </div>

        <div class="na-date-pill">
            <i class="far fa-calendar"></i>
            <span>{{ now()->format('F j, Y') }}</span>
        </div>
    </div>

    {{-- ===== Row 1: stat cards (replace the numbers with your real values) ===== --}}
    <div class="row g-4 mb-4">
        <div class="col-xl-4 col-md-6">
            <div class="na-stat na-stat--blue">
                <div class="na-stat-top">
                    <span class="na-stat-icon"><i class="fas fa-users"></i></span>
                    <div>
                        <div class="na-stat-value">{{ number_format($stats['contacts']) }}</div>
                        <div class="na-stat-label">Contact Messages</div>
                    </div>
                </div>
                <div class="na-stat-bottom">
                    <span class="na-trend"><i class="fas fa-plus"></i> {{ $stats['contacts_month'] }} this month</span>
                    <svg class="na-spark" viewBox="0 0 160 36" preserveAspectRatio="none" aria-hidden="true">
                        <path d="M0 28 C20 20 32 30 52 22 S84 10 104 18 S136 6 160 10" />
                    </svg>
                    <a class="na-stat-go stretched-link" href="{{ url('admin/customers') }}" aria-label="View customers">
                        <i class="fas fa-chevron-right"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6">
            <div class="na-stat na-stat--green">
                <div class="na-stat-top">
                    <span class="na-stat-icon"><i class="fas fa-wallet"></i></span>
                    <div>
                        <div class="na-stat-value">{{ number_format($stats['payments']) }}</div>
                        <div class="na-stat-label">Successful Donations</div>
                    </div>
                </div>
                <div class="na-stat-bottom">
                    <span class="na-trend">₹{{ number_format($stats['payments_total']) }} total</span>
                    <svg class="na-spark" viewBox="0 0 160 36" preserveAspectRatio="none" aria-hidden="true">
                        <path d="M0 30 C18 26 30 18 48 24 S78 30 98 18 S132 14 160 8" />
                    </svg>
                    <a class="na-stat-go stretched-link" href="{{ url('admin/payments') }}" aria-label="View payments">
                        <i class="fas fa-chevron-right"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-12">
            <div class="na-stat na-stat--orange">
                <div class="na-stat-top">
                    <span class="na-stat-icon"><i class="far fa-calendar-days"></i></span>
                    <div>
                        <div class="na-stat-value">{{ $stats['last_month_count'] }}</div>
                        <div class="na-stat-label">Last Month Donations (₹{{ number_format($stats['last_month_total']) }})</div>
                    </div>
                </div>
                <div class="na-stat-bottom">
                    @if(is_null($stats['month_change']))
                        <span class="na-trend">This month vs last: —</span>
                    @else
                        <span class="na-trend"><i class="fas fa-arrow-{{ $stats['month_change'] >= 0 ? 'up' : 'down' }}"></i> {{ abs($stats['month_change']) }}% this month</span>
                    @endif
                    <svg class="na-spark" viewBox="0 0 160 36" preserveAspectRatio="none" aria-hidden="true">
                        <path d="M0 26 C22 32 36 16 58 20 S90 28 112 16 S140 12 160 8" />
                    </svg>
                    <a class="na-stat-go stretched-link" href="{{ url('admin/payments') }}" aria-label="View last month payments">
                        <i class="fas fa-chevron-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- ===== Row 2: chart ===== --}}
    <div class="na-card mb-4">
        <div class="na-card-head">
            <h2><i class="fas fa-chart-line"></i> Payment Overview</h2>

            <div class="na-card-tools">
                <div class="na-pills" role="tablist" aria-label="Chart period">
                    <button type="button" class="na-pill active" data-range="year">This Year</button>
                    <button type="button" class="na-pill" data-range="month">This Month</button>
                    <button type="button" class="na-pill" data-range="six">Last 6 Months</button>
                    <button type="button" class="na-pill" data-range="last">Last Year</button>
                </div>
                <button type="button" class="na-icon-btn na-icon-btn--soft" id="chartDownload" aria-label="Download chart">
                    <i class="fas fa-download"></i>
                </button>
            </div>
        </div>
        <div class="na-card-body">
            <div class="na-chart-wrap">
                <canvas id="salesChart"></canvas>
            </div>
        </div>
    </div>

    {{-- ===== Row 3: recent payments ===== --}}
    <div class="na-card mb-4">
        <div class="na-card-head">
            <h2><i class="fas fa-credit-card"></i> Recent Payment</h2>
            <a href="{{ url('admin/payments') }}" class="na-btn">View All <i class="fas fa-arrow-right"></i></a>
        </div>
        <div class="na-card-body">
            <div class="table-responsive">
                <table class="table na-table mb-0">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Customer</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recent as $d)
                        <tr>
                            <td class="text-nowrap">{{ $d->order_id ?: '#' . $d->id }}</td>
                            <td>{{ $d->name }}</td>
                            <td class="text-nowrap">₹{{ number_format((float) $d->amount) }}</td>
                            <td>
                                @if($d->status === 'success')
                                    <span class="na-status na-status--done"><i class="fas fa-circle-check"></i> Completed</span>
                                @elseif($d->status === 'pending')
                                    <span class="na-status na-status--pending"><i class="fas fa-clock"></i> Pending</span>
                                @else
                                    <span class="na-status na-status--cancel"><i class="fas fa-circle-xmark"></i> Failed</span>
                                @endif
                            </td>
                            <td class="text-nowrap">{{ $d->created_at?->format('M d, Y') }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="5" class="text-center text-muted">No payments yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const canvas = document.getElementById('salesChart');
    if (!canvas || typeof Chart === 'undefined') return;

  
    // Real totals of successful donations, built in AdminDashboardController
    const ranges = @json($chartData);

    const ctx = canvas.getContext('2d');
    const fill = ctx.createLinearGradient(0, 0, 0, 320);
    fill.addColorStop(0, 'rgba(37, 99, 235, 0.28)');
    fill.addColorStop(1, 'rgba(37, 99, 235, 0.02)');

    const chart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ranges.year.labels,
            datasets: [{
                label: ranges.year.label,
                data: ranges.year.data,
                backgroundColor: fill,
                borderColor: '#2563eb',
                borderWidth: 3,
                pointBackgroundColor: '#ffffff',
                pointBorderColor: '#2563eb',
                pointBorderWidth: 2,
                pointRadius: 4,
                pointHoverRadius: 6,
                fill: true,
                tension: 0.35
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { labels: { font: { family: 'Poppins' }, boxWidth: 30, color: '#334155' } },
                tooltip: {
                    backgroundColor: '#0b1f4d',
                    padding: 10,
                    callbacks: { label: (c) => ' ₹' + Number(c.parsed.y).toLocaleString('en-IN') }
                }
            },
            scales: {
                x: { grid: { display: false }, ticks: { color: '#64748b', font: { family: 'Poppins' } } },
                y: {
                    beginAtZero: true,
                    grid: { color: '#e8edf5' },
                    border: { display: false },
                    ticks: { color: '#64748b', font: { family: 'Poppins' }, callback: (v) => '₹' + v }
                }
            }
        }
    });

    // Period buttons
    document.querySelectorAll('.na-pill[data-range]').forEach(function (btn) {
        btn.addEventListener('click', function () {
            document.querySelectorAll('.na-pill[data-range]').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            const r = ranges[btn.dataset.range];
            chart.data.labels = r.labels;
            chart.data.datasets[0].label = r.label;
            chart.data.datasets[0].data = r.data;
            chart.update();
        });
    });

    // Download chart as PNG
    document.getElementById('chartDownload')?.addEventListener('click', function () {
        const a = document.createElement('a');
        a.href = chart.toBase64Image('image/png', 1);
        a.download = 'payment-overview.png';
        a.click();
    });
});
</script>
@endpush