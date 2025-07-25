<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Requests\ProcessCheckoutRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use App\Services\OrderService;
use Illuminate\Support\Facades\Auth;
use App\Events\OrderPlaced;


class OrderController extends Controller
{
    protected $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Get all orders for the authenticated user, ordered by most recent
        // You might want to add pagination if a user has many orders
        $orders = Auth::user()->orders()->paginate(10);

        return view('orders.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function checkoutOrder(ProcessCheckoutRequest $request)
    {
        // check if the user is authenticated
        if (!auth()->check()) {
            return redirect()->back()->with('error', 'Please log in to checkout.');
        } else {
            // All validated data is available via $request->validated()
            $validatedData = $request->validated();

            // Retrieve the cart and user/session details
            $cart = Cart::with('items')->find($validatedData['cart_id']);

            if (!$cart || $cart->items->isEmpty()) {
                return redirect()->route('cart.index')->with('error', 'Your cart is empty or invalid.');
            }

            // --- Start Transaction for Atomicity ---
            // This ensures that if any step fails, all changes are rolled back.
            DB::beginTransaction();
            
            try {
                $order = $this->orderService->createOrder($validatedData, $cart);
                $orderIds = $this->orderService->getUserOrderIds(auth()->id());

                OrderPlaced::dispatch($order);

                DB::commit(); // All operations successful, commit the transaction
                // Redirect to order confirmation page
                return redirect()->route('checkout.confirmed', $order->id)
                                ->with([
                                    'success' => 'Your order has been placed successfully!',
                                    'order_ids' => $orderIds,
                                ]);
            } catch (\Exception $e) {
                DB::rollBack();
                Log::error('Checkout failed for cart ID ' . $validatedData['cart_id'] . ': ' . $e->getMessage(), ['exception' => $e]);
                return redirect()->route('cart.index')->with('error', 'There was an error processing your order. Please try again.');
            }
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order) // Using Route Model Binding
    {
        // Ensure the authenticated user owns this order, or it's an admin view
        // If not authenticated, consider how guests might view orders (e.g., via a unique token)
        if ((string)Auth::id() !== (string)$order->user_id) {
            abort(403, 'Unauthorized action.');
        }

        return view('orders.details', compact('order'));
    }

    /**
     * Show the order confirmation page.
     */
    public function confirmed(Order $order)
    {
        return view('checkout.confirmed', compact('order'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }
}
