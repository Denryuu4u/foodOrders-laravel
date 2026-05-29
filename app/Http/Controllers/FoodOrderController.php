<?php

namespace App\Http\Controllers;

use App\Models\FoodOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FoodOrderController extends Controller
{
    // ─── LIST (own orders only) ──────────────────────────────────
    public function index()
    {
        $orders = FoodOrder::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('food-orders.index', compact('orders'));
    }

    // ─── STORE ───────────────────────────────────────────────────
    public function store(Request $request)
    {
        $request->validate([
            'item_name' => 'required|string|max:255',
            'quantity'  => 'required|integer|min:1',
            'price'     => 'required|numeric|min:0',
            'status'    => 'required|in:Pending,Preparing,Delivered,Cancelled',
            'notes'     => 'nullable|string|max:500',
        ]);

        FoodOrder::create([
            'user_id'   => Auth::id(),
            'item_name' => $request->item_name,
            'quantity'  => $request->quantity,
            'price'     => $request->price,
            'status'    => $request->status,
            'notes'     => $request->notes,
        ]);

        return redirect()->route('food-orders.index')
            ->with('success', 'Food order added successfully!');
    }

    // ─── UPDATE ──────────────────────────────────────────────────
    public function update(Request $request, FoodOrder $foodOrder)
    {
        // Ensure the order belongs to the logged-in user
        if ($foodOrder->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'item_name' => 'required|string|max:255',
            'quantity'  => 'required|integer|min:1',
            'price'     => 'required|numeric|min:0',
            'status'    => 'required|in:Pending,Preparing,Delivered,Cancelled',
            'notes'     => 'nullable|string|max:500',
        ]);

        $foodOrder->update($request->only('item_name', 'quantity', 'price', 'status', 'notes'));

        return redirect()->route('food-orders.index')
            ->with('success', 'Food order updated successfully!');
    }

    // ─── DELETE ──────────────────────────────────────────────────
    public function destroy(FoodOrder $foodOrder)
    {
        if ($foodOrder->user_id !== Auth::id()) {
            abort(403);
        }

        $foodOrder->delete();

        return redirect()->route('food-orders.index')
            ->with('success', 'Food order deleted successfully!');
    }
}
