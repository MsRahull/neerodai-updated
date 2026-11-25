@extends('admin.dashboard')

@section('title', 'Payments')

@section('content')
<div class="py-4">
    <div class="na-page-head">
        <div class="na-page-title">
            <span class="na-page-icon"><i class="fas fa-credit-card"></i></span>
            <div>
                <h1>Payments</h1>
                <p>{{ $donations->total() }} record(s)</p>
            </div>
        </div>
        <a href="{{ route('payments.export', request()->query()) }}" class="btn btn-outline-success">
            <i class="fas fa-file-csv me-1"></i> Export CSV
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">
            <form method="GET" class="row g-2 align-items-end">
                <div class="col-12 col-sm-6 col-lg">
                    <label class="form-label small text-muted mb-1">Name</label>
                    <input type="text" name="name" value="{{ request('name') }}" class="form-control" placeholder="Name">
                </div>
                <div class="col-12 col-sm-6 col-lg">
                    <label class="form-label small text-muted mb-1">Email</label>
                    <input type="text" name="email" value="{{ request('email') }}" class="form-control" placeholder="Email">
                </div>
                <div class="col-12 col-sm-4 col-lg-2">
                    <label class="form-label small text-muted mb-1">Status</label>
                    <select name="status" class="form-select">
                        <option value="">All</option>
                        @foreach(['success' => 'Success', 'pending' => 'Pending', 'failed' => 'Failed'] as $v => $l)
                            <option value="{{ $v }}" @selected(request('status') === $v)>{{ $l }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-6 col-sm-4 col-lg-2">
                    <label class="form-label small text-muted mb-1">From</label>
                    <input type="date" name="from_date" value="{{ request('from_date') }}" class="form-control">
                </div>
                <div class="col-6 col-sm-4 col-lg-2">
                    <label class="form-label small text-muted mb-1">To</label>
                    <input type="date" name="to_date" value="{{ request('to_date') }}" class="form-control">
                </div>
                <div class="col-12 col-lg-auto d-flex gap-2">
                    <button class="btn btn-primary flex-fill"><i class="fas fa-filter me-1"></i> Filter</button>
                    @if(request()->query())
                        <a href="{{ route('payments.index') }}" class="btn btn-light" title="Clear"><i class="fas fa-xmark"></i></a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 text-nowrap">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Donor</th>
                            <th>Contact</th>
                            <th class="text-end">Donation</th>
                            <th class="text-end">GST</th>
                            <th class="text-end">Total</th>
                            <th class="text-end">80G</th>
                            <th>PAN / GSTIN</th>
                            <th>Order / Payment ID</th>
                            <th>Status</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($donations as $donation)
                        <tr>
                            <td class="fw-bold text-muted">{{ $donations->firstItem() + $loop->index }}</td>
                            <td class="text-wrap" style="min-width:180px">
                                <strong>{{ $donation->name }}</strong>
                                @if($donation->company_name)<div class="small text-muted">{{ $donation->company_name }}</div>@endif
                                <div class="small text-muted">{{ $donation->address }} {{ $donation->pincode }}</div>
                            </td>
                            <td>
                                <div class="small">{{ $donation->email }}</div>
                                <div class="small text-muted">{{ $donation->phone }}</div>
                            </td>
                            <td class="text-end">₹{{ number_format((float) $donation->base_amount, 2) }}</td>
                            <td class="text-end">{{ (float) $donation->gst_amount > 0 ? '₹' . number_format((float) $donation->gst_amount, 2) : '—' }}</td>
                            <td class="text-end fw-semibold">₹{{ number_format((float) $donation->amount, 2) }}</td>
                            <td class="text-end">₹{{ number_format((float) $donation->eighty_g_amt, 2) }}</td>
                            <td class="small">
                                {{ $donation->pan ?: '—' }}
                                @if($donation->gst_number)<div class="text-muted">{{ $donation->gst_number }}</div>@endif
                            </td>
                            <td class="small">
                                <div>{{ $donation->order_id }}</div>
                                <div class="text-muted">{{ $donation->payment_id ?: '—' }}</div>
                            </td>
                            <td>
                                <span class="badge {{ ['success' => 'bg-success', 'failed' => 'bg-danger'][$donation->status] ?? 'bg-warning text-dark' }}">
                                    {{ ucfirst($donation->status) }}
                                </span>
                                @if($donation->mode === 'test')<span class="badge bg-secondary">Test</span>@endif
                            </td>
                            <td class="small">{{ $donation->created_at->format('d-m-Y H:i') }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="11" class="text-center text-muted py-4">No payment records found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($donations->hasPages())
                <div class="d-flex justify-content-center mt-3">
                    {{ $donations->links('pagination::bootstrap-5') }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
