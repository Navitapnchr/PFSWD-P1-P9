<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class OrderController extends Controller
{
    public function index(Request $request): Response
    {
        $status = $request->get('status');

        $orders = Order::where(
            'user_id',
            auth()->id()
        )

        ->when($status, function ($query) use ($status) {

            $query->where('status', $status);
        })

        ->latest()

        ->paginate(10)

        ->withQueryString();

        return Inertia::render('Orders/Index', [

            'orders' => $orders,

            'filters' => [
                'status' => $status,
            ],
        ]);
    }

    public function cancel(Order $order)
    {
        abort_if(
            $order->user_id !== auth()->id(),
            403
        );

        if ($order->status !== 'pending') {

            return back()->withErrors([
                'order' => 'Pesanan tidak bisa dibatalkan.'
            ]);
        }

        foreach ($order->items as $item) {

            $item->product->increment(
                'stock',
                $item->qty
            );
        }

        $order->update([
            'status' => 'cancelled'
        ]);

        return back()->with(
            'success',
            'Pesanan dibatalkan.'
        );
    }

    public function dashboard(): Response
    {
        $userId = auth()->user()->id;

        $totalOrders = Order::where(
            'user_id',
            $userId
        )->count();

        $pendingOrders = Order::where(
            'user_id',
            $userId
        )
        ->where('status', 'pending')
        ->count();

        $monthlySpending = Order::where(
            'user_id',
            $userId
        )
        ->sum('total_amount');

        return Inertia::render('Buyer/Dashboard', [

            'stats' => [

                'total_orders' => $totalOrders,

                'pending_orders' => $pendingOrders,

                'monthly_spending' => $monthlySpending,
            ],
        ]);
    }
}