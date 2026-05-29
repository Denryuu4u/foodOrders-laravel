@extends('layouts.app')
@section('title', 'Food Orders')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold mb-0">FOOD ORDERS</h2>
    <button type="button" class="btn btn-outline-light" data-bs-toggle="modal" data-bs-target="#addOrderModal">
        <i class="bi bi-plus-circle-fill me-1"></i> Add New Order
    </button>
</div>

{{-- ─── ORDERS TABLE ─────────────────────────────────────────── --}}
<div class="card-dark p-3 rounded">
    <table class="table table-dark table-bordered table-hover mb-0">
        <thead class="table-light text-dark">
            <tr>
                <th>#</th>
                <th>Item Name</th>
                <th>Qty</th>
                <th>Price</th>
                <th>Total</th>
                <th>Status</th>
                <th>Notes</th>
                <th>Date</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($orders as $order)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $order->item_name }}</td>
                <td>{{ $order->quantity }}</td>
                <td>₱{{ number_format($order->price, 2) }}</td>
                <td>₱{{ number_format($order->total, 2) }}</td>
                <td>
                    <span class="badge bg-{{ $order->status_badge }}">
                        {{ $order->status }}
                    </span>
                </td>
                <td>{{ $order->notes ?? '—' }}</td>
                <td>{{ $order->created_at->format('M d, Y') }}</td>
                <td>
                    <button class="btn btn-warning btn-sm"
                            data-bs-toggle="modal"
                            data-bs-target="#editOrderModal{{ $order->id }}">
                        <i class="bi bi-pencil-fill"></i> Edit
                    </button>
                    <button class="btn btn-danger btn-sm"
                            data-bs-toggle="modal"
                            data-bs-target="#deleteOrderModal{{ $order->id }}">
                        <i class="bi bi-trash-fill"></i> Delete
                    </button>
                </td>
            </tr>

            {{-- Edit Modal --}}
            <div class="modal fade" id="editOrderModal{{ $order->id }}" data-bs-backdrop="static" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content bg-dark text-white">
                        <form method="POST" action="{{ route('food-orders.update', $order) }}">
                            @csrf @method('PUT')
                            <div class="modal-header border-secondary">
                                <h5 class="modal-title">Edit Order</h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label class="form-label">Item Name:</label>
                                    <input type="text" class="form-control" name="item_name"
                                           value="{{ $order->item_name }}" required>
                                </div>
                                <div class="row">
                                    <div class="col-6 mb-3">
                                        <label class="form-label">Quantity:</label>
                                        <input type="number" class="form-control" name="quantity"
                                               value="{{ $order->quantity }}" min="1" required>
                                    </div>
                                    <div class="col-6 mb-3">
                                        <label class="form-label">Price (₱):</label>
                                        <input type="number" class="form-control" name="price"
                                               value="{{ $order->price }}" min="0" step="0.01" required>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Status:</label>
                                    <select class="form-select" name="status">
                                        @foreach(['Pending','Preparing','Delivered','Cancelled'] as $s)
                                        <option value="{{ $s }}" {{ $order->status === $s ? 'selected' : '' }}>
                                            {{ $s }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Notes:</label>
                                    <textarea class="form-control" name="notes" rows="2">{{ $order->notes }}</textarea>
                                </div>
                            </div>
                            <div class="modal-footer border-secondary">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-warning">
                                    <i class="bi bi-save-fill me-1"></i> Update
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Delete Modal --}}
            <div class="modal fade" id="deleteOrderModal{{ $order->id }}" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content bg-dark text-white">
                        <form method="POST" action="{{ route('food-orders.destroy', $order) }}">
                            @csrf @method('DELETE')
                            <div class="modal-header border-secondary">
                                <h5 class="modal-title">Delete Order</h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <p>Are you sure you want to delete order for <strong>{{ $order->item_name }}</strong>?</p>
                            </div>
                            <div class="modal-footer border-secondary">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-danger">
                                    <i class="bi bi-trash-fill me-1"></i> Confirm Delete
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            @empty
            <tr>
                <td colspan="9" class="text-center text-secondary py-4">No food orders yet.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- ─── ADD ORDER MODAL ─────────────────────────────────────────── --}}
<div class="modal fade" id="addOrderModal" data-bs-backdrop="static" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content bg-dark text-white">
            <form method="POST" action="{{ route('food-orders.store') }}">
                @csrf
                <div class="modal-header border-secondary">
                    <h5 class="modal-title">Add New Food Order</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Item Name:</label>
                        <input type="text" class="form-control" name="item_name"
                               placeholder="e.g. Burger, Pizza..." required>
                    </div>
                    <div class="row">
                        <div class="col-6 mb-3">
                            <label class="form-label">Quantity:</label>
                            <input type="number" class="form-control" name="quantity"
                                   value="1" min="1" required>
                        </div>
                        <div class="col-6 mb-3">
                            <label class="form-label">Price (₱):</label>
                            <input type="number" class="form-control" name="price"
                                   placeholder="0.00" min="0" step="0.01" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status:</label>
                        <select class="form-select" name="status">
                            <option value="Pending">Pending</option>
                            <option value="Preparing">Preparing</option>
                            <option value="Delivered">Delivered</option>
                            <option value="Cancelled">Cancelled</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Notes (optional):</label>
                        <textarea class="form-control" name="notes" rows="2"
                                  placeholder="Special instructions..."></textarea>
                    </div>
                </div>
                <div class="modal-footer border-secondary">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-plus-circle-fill me-1"></i> Save Order
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
