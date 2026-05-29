@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')
<h2 class="mb-4 fw-bold">DASHBOARD</h2>

{{-- ─── STAT CARDS ────────────────────────────────────────────── --}}
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card-dark p-3 rounded">
            <div class="d-flex align-items-center gap-3">
                <div class="fs-2 text-primary"><i class="bi bi-people-fill"></i></div>
                <div>
                    <div class="text-secondary small">Total Users</div>
                    <div class="fs-4 fw-bold">{{ $totalUsers }}</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card-dark p-3 rounded">
            <div class="d-flex align-items-center gap-3">
                <div class="fs-2 text-success"><i class="bi bi-bag-fill"></i></div>
                <div>
                    <div class="text-secondary small">Total Orders</div>
                    <div class="fs-4 fw-bold">{{ $totalOrders }}</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card-dark p-3 rounded">
            <div class="d-flex align-items-center gap-3">
                <div class="fs-2 text-warning"><i class="bi bi-clock-fill"></i></div>
                <div>
                    <div class="text-secondary small">Pending Orders</div>
                    <div class="fs-4 fw-bold">{{ $pendingOrders }}</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card-dark p-3 rounded">
            <div class="d-flex align-items-center gap-3">
                <div class="fs-2 text-info"><i class="bi bi-check-circle-fill"></i></div>
                <div>
                    <div class="text-secondary small">Delivered</div>
                    <div class="fs-4 fw-bold">{{ $deliveredOrders }}</div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ─── CHARTS ROW 1 ──────────────────────────────────────────── --}}
<div class="row g-3 mb-4">
    <div class="col-md-8">
        <div class="card-dark p-4 rounded h-100">
            <h6 class="text-secondary mb-3">New Users Per Month ({{ now()->year }})</h6>
            <canvas id="usersChart" height="120"></canvas>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card-dark p-4 rounded h-100">
            <h6 class="text-secondary mb-3">Orders by Status</h6>
            <canvas id="statusChart"></canvas>
        </div>
    </div>
</div>

{{-- ─── CHARTS ROW 2 ──────────────────────────────────────────── --}}
<div class="row g-3">
    <div class="col-md-12">
        <div class="card-dark p-4 rounded">
            <h6 class="text-secondary mb-3">Food Orders Per Month ({{ now()->year }})</h6>
            <canvas id="ordersChart" height="80"></canvas>
        </div>
    </div>
</div>

{{-- Pass PHP variables to JS here, inside @section not @push --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const monthlyUsers  = JSON.parse(`{!! addslashes(json_encode($monthlyUsers)) !!}`);
const monthlyOrders = JSON.parse(`{!! addslashes(json_encode($monthlyOrders)) !!}`);
const statusData    = JSON.parse(`{!! addslashes(json_encode($ordersByStatus)) !!}`);
const months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];

Chart.defaults.color = '#adb5bd';

// ── Bar: Users per month
new Chart(document.getElementById('usersChart'), {
    type: 'bar',
    data: {
        labels: months,
        datasets: [{
            label: 'New Users',
            data: monthlyUsers,
            backgroundColor: 'rgba(13,110,253,0.7)',
            borderColor: '#0d6efd',
            borderWidth: 1,
            borderRadius: 4,
        }]
    },
    options: {
        plugins: { legend: { display: false } },
        scales: {
            x: { grid: { color: '#343a40' }, ticks: { color: '#adb5bd' } },
            y: { grid: { color: '#343a40' }, ticks: { color: '#adb5bd', stepSize: 1 } }
        }
    }
});

// ── Doughnut: Orders by status
new Chart(document.getElementById('statusChart'), {
    type: 'doughnut',
    data: {
        labels: Object.keys(statusData).length ? Object.keys(statusData) : ['No Data'],
        datasets: [{
            data: Object.keys(statusData).length ? Object.values(statusData) : [1],
            backgroundColor: ['#ffc107','#0dcaf0','#198754','#dc3545'],
            borderColor: '#2b3035',
            borderWidth: 3,
        }]
    },
    options: {
        plugins: {
            legend: { position: 'bottom', labels: { color: '#adb5bd' } }
        }
    }
});

// ── Line: Orders per month
new Chart(document.getElementById('ordersChart'), {
    type: 'line',
    data: {
        labels: months,
        datasets: [{
            label: 'Food Orders',
            data: monthlyOrders,
            borderColor: '#198754',
            backgroundColor: 'rgba(25,135,84,0.15)',
            tension: 0.4,
            fill: true,
            pointBackgroundColor: '#198754',
        }]
    },
    options: {
        plugins: { legend: { display: false } },
        scales: {
            x: { grid: { color: '#343a40' }, ticks: { color: '#adb5bd' } },
            y: { grid: { color: '#343a40' }, ticks: { color: '#adb5bd', stepSize: 1 } }
        }
    }
});
</script>
@endsection
