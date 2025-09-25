@extends('admin.dashboard')

@section('title', 'Payments')

@section('content')
<div class="container-fluid mt-4">
    <h1 class="mb-4">Payments</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="GET" class="row g-2 mb-4">
    <div class="col-md-2">
        <input type="text" name="name" value="{{ request('name') }}" class="form-control" placeholder="Name">
    </div>
    <div class="col-md-2">
        <input type="text" name="email" value="{{ request('email') }}" class="form-control" placeholder="Email">
    </div>
    <div class="col-md-2">
        <select name="status" class="form-select">
            <option value="">All Status</option>
            <option value="success" {{ request('status')=='success'?'selected':'' }}>Success</option>
            <option value="pending" {{ request('status')=='pending'?'selected':'' }}>Pending</option>
            <option value="failed" {{ request('status')=='failed'?'selected':'' }}>Failed</option>
        </select>
    </div>
    <div class="col-md-2">
        <input type="date" name="from_date" value="{{ request('from_date') }}" class="form-control">
    </div>
    <div class="col-md-2">
        <input type="date" name="to_date" value="{{ request('to_date') }}" class="form-control">
    </div>
    <div class="col-md-2 d-flex">
        <button class="btn btn-primary me-2">Filter</button>
    </div>
</form>

    <div class="card shadow-sm">
        <div class="card-body">

            {{-- ✅ Responsive scrollable table --}}
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-dark text-center">
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Amount</th>
                            <th>Email</th>
                            <th>Mobile</th>
                            <th>Address</th>
                            <th>Pincode</th>
                            <th>Order Id</th>
                            <th>Payment Id</th>
                            <th>Status</th>
                            <th>Response</th>
                            <th>Submitted At</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($donations as $donation)
                        <tr>
                            <td class="text-center fw-bold">
                                {{ $loop->iteration + ($donations->firstItem() - 1) }}
                            </td>
                            <td>{{ $donation->name }}</td>
                            <td>₹{{ number_format($donation->amount, 2) }}</td>
                            <td>{{ $donation->email }}</td>
                            <td>{{ $donation->phone }}</td>
                            <td>{{ $donation->address }}</td>
                            <td>{{ $donation->pincode }}</td>
                            <td>{{ $donation->order_id }}</td>
                            <td>{{ $donation->payment_id }}</td>
                            <td>
                                <span class="badge 
                                    @if($donation->status=='success') bg-success 
                                    @elseif($donation->status=='failed') bg-danger 
                                    @else bg-warning text-dark @endif">
                                    {{ ucfirst($donation->status) }}
                                </span>
                            </td>
                            <td style="max-width: 200px; word-wrap: break-word; white-space: pre-wrap;">
                                {{ $donation->response }}
                            </td>
                            <td>{{ $donation->created_at->format('d-m-Y H:i') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="12" class="text-center text-muted">No Payments records found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-center mt-3">
                {{ $donations->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>
@endsection
