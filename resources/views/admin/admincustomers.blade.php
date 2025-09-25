@extends('admin.dashboard')

@section('title', 'Customer Contacts')

@section('content')
<div class="container-fluid mt-4">
    <h1 class="mb-4">Customer Contacts</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-dark text-center">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Mobile</th>
                        <th>Address</th>
                        <th>Message</th>
                        <th>Submitted At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($contacts as $contact)
                    <tr>
                        <!-- <td class="text-center fw-bold">{{ $contact->id }}</td> -->
                         <td class="text-center fw-bold">
                            {{ $loop->iteration + ($contacts->firstItem() - 1) }}
                        </td>
                        <td>{{ $contact->name }}</td>
                        <td>{{ $contact->email }}</td>
                        <td>{{ $contact->mobile }}</td>
                        <td>{{ $contact->address }}</td>
                        <td>{{ $contact->message }}</td>
                        <td>{{ $contact->created_at->format('d-m-Y H:i') }}</td>
                        <td class="text-center">
                            <form action="{{ route('contacts.destroy', $contact->id) }}" method="POST"
                                  onsubmit="return confirm('Delete this record?')" class="m-0">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted">No contact records found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="d-flex justify-content-center mt-3">
                {{ $contacts->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>
@endsection
