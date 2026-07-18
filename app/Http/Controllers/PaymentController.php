<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

class PaymentController extends Controller
{
    // Tampilkan form upload bukti bayar
    public function show(Request $request, Order $order): Response
    {
        abort_if(
            $order->user_id !== $request->user()->id,
            403,
            'Bukan pesanan Anda.'
        );

        abort_if(
            $order->status !== Order::STATUS_PENDING,
            422,
            'Pesanan ini tidak dapat dibayar (status: ' . $order->status . ').'
        );

        return Inertia::render('Orders/Payment', [
            'order' => $order->load('items'),
        ]);
    }

    // Upload bukti pembayaran
    public function upload(
        Request $request,
        Order $order
    ): RedirectResponse {

        abort_if(
            $order->user_id !== $request->user()->id,
            403
        );

        abort_if(
            $order->status !== Order::STATUS_PENDING,
            422,
            'Pesanan ini tidak dapat dibayar.'
        );

        $request->validate([
            'payment_proof' =>
                'required|image|mimes:jpg,jpeg,png,webp|max:10240',
        ]);

        if ($order->payment_proof) {
            Storage::disk('public')
                ->delete($order->payment_proof);
        }

        $path = $request->file('payment_proof')
            ->store('payments', 'public');

        $order->update([
            'payment_proof' => $path,
            'status' => Order::STATUS_PAID,
            'paid_at' => now(),
        ]);

        return redirect()
            ->route('orders.index')
            ->with(
                'success',
                'Bukti pembayaran berhasil dikirim. Menunggu konfirmasi seller.'
            );
    }
}