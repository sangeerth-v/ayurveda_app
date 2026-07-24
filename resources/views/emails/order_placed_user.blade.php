<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; background-color: #f7f9f6; color: #2e3b2e; margin: 0; padding: 40px 20px; }
        .container { max-width: 600px; background-color: #ffffff; margin: 0 auto; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.05); border: 1px solid #e1e8e1; }
        .header { background-color: #1a4d2e; padding: 40px 20px; text-align: center; color: #ffffff; }
        .header h1 { margin: 0; font-size: 28px; font-weight: 700; }
        .content { padding: 40px 30px; line-height: 1.6; }
        .content h2 { color: #1a4d2e; font-size: 20px; margin-top: 0; }
        .table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        .table th, .table td { border-bottom: 1px solid #e1e8e1; padding: 12px; text-align: left; font-size: 14px; }
        .table th { background-color: #f9fbf9; color: #1a4d2e; font-weight: bold; }
        .total { font-size: 16px; font-weight: bold; color: #1a4d2e; text-align: right; margin-top: 10px; }
        .details-card { background-color: #f9fbf9; border-left: 4px solid #1a4d2e; padding: 20px; border-radius: 8px; margin: 20px 0; font-size: 14px; }
        .details-title { font-weight: bold; margin-bottom: 10px; color: #1a4d2e; }
        .footer { background-color: #f1f5f1; text-align: center; padding: 20px; font-size: 12px; color: #7a8a7a; border-top: 1px solid #e1e8e1; }
        .btn { display: inline-block; background-color: #1a4d2e; color: #ffffff !important; padding: 12px 30px; text-decoration: none; border-radius: 30px; font-weight: bold; margin-top: 20px; box-shadow: 0 4px 6px rgba(26,77,46,0.2); }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Ayurveda</h1>
        </div>
        <div class="content">
            <h2>Order Placed Successfully!</h2>
            <p>Dear {{ $order->delivery_name }},</p>
            <p>Thank you for shopping with us! Your order <strong>#{{ $order->id }}</strong> has been placed successfully. Below are your order details:</p>
            
            <table class="table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Qty</th>
                        <th>Price</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->items as $item)
                        <tr>
                            <td>{{ $item->product->name ?? 'Product' }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>₹{{ number_format($item->price, 2) }}</td>
                            <td>₹{{ number_format($item->price * $item->quantity, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="total">
                Total Price: ₹{{ number_format($order->total_price, 2) }}
            </div>

            <div class="details-card">
                <div class="details-title">Delivery Address</div>
                <div>{{ $order->delivery_name }}</div>
                <div>{{ $order->delivery_address }}</div>
                <div>District: {{ $order->delivery_district }} - {{ $order->delivery_pincode }}</div>
                <div>Phone: {{ $order->delivery_phone }}</div>
                <div style="margin-top: 10px;"><strong>Payment Method:</strong> {{ $order->payment_method }} ({{ $order->payment_status }})</div>
            </div>

            <center>
                <a href="{{ route('orders.show', $order->id) }}" class="btn">Track Order</a>
            </center>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} Ayurveda App. All rights reserved.
        </div>
    </div>
</body>
</html>
