<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>New Order Placed</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #e0e0e0; border-radius: 8px;">
        <h2 style="color: #d4a373; border-bottom: 2px solid #d4a373; padding-bottom: 10px;">🌿 New Order Placed</h2>
        <p>Dear {{ $company->company_name }},</p>
        <p>A new order containing products from your catalog has been placed on the Ayurveda Platform. Below are the details:</p>
        
        <h4 style="color: #2d6a4f; margin-bottom: 5px; border-bottom: 1px solid #eee; padding-bottom: 5px;">Ordered Products:</h4>
        <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">
            <thead>
                <tr style="background-color: #f8f9fa;">
                    <th style="padding: 8px; text-align: left; border-bottom: 1px solid #dee2e6;">Product Name</th>
                    <th style="padding: 8px; text-align: center; border-bottom: 1px solid #dee2e6;">Quantity</th>
                    <th style="padding: 8px; text-align: right; border-bottom: 1px solid #dee2e6;">Unit Price</th>
                    <th style="padding: 8px; text-align: right; border-bottom: 1px solid #dee2e6;">Total</th>
                </tr>
            </thead>
            <tbody>
                @php $companyTotal = 0; @endphp
                @foreach($items as $item)
                    @php 
                        $total = $item->price * $item->quantity; 
                        $companyTotal += $total;
                    @endphp
                    <tr>
                        <td style="padding: 8px; border-bottom: 1px solid #eee;">{{ $item->product->name }}</td>
                        <td style="padding: 8px; text-align: center; border-bottom: 1px solid #eee;">{{ $item->quantity }}</td>
                        <td style="padding: 8px; text-align: right; border-bottom: 1px solid #eee;">₹{{ number_format($item->price, 2) }}</td>
                        <td style="padding: 8px; text-align: right; border-bottom: 1px solid #eee;">₹{{ number_format($total, 2) }}</td>
                    </tr>
                @endforeach
                <tr style="font-weight: bold;">
                    <td colspan="3" style="padding: 8px; text-align: right; border-top: 2px solid #dee2e6;">Subtotal for Your Products:</td>
                    <td style="padding: 8px; text-align: right; border-top: 2px solid #dee2e6;">₹{{ number_format($companyTotal, 2) }}</td>
                </tr>
            </tbody>
        </table>

        <h4 style="color: #2d6a4f; margin-bottom: 5px; border-bottom: 1px solid #eee; padding-bottom: 5px;">Delivery Details:</h4>
        <table style="width: 100%; border-collapse: collapse; margin-bottom: 15px;">
            <tr>
                <td style="padding: 6px 0; font-weight: bold; width: 35%;">Customer Name:</td>
                <td style="padding: 6px 0;">{{ $order->delivery_name }}</td>
            </tr>
            <tr>
                <td style="padding: 6px 0; font-weight: bold;">Contact Phone:</td>
                <td style="padding: 6px 0;">{{ $order->delivery_phone }}</td>
            </tr>
            <tr>
                <td style="padding: 6px 0; font-weight: bold;">Shipping Address:</td>
                <td style="padding: 6px 0;">
                    {{ $order->delivery_address }},<br>
                    {{ $order->delivery_district }} - {{ $order->delivery_pincode }}
                </td>
            </tr>
            <tr>
                <td style="padding: 6px 0; font-weight: bold;">Payment Method:</td>
                <td style="padding: 6px 0;">{{ $order->payment_method }} ({{ $order->payment_status }})</td>
            </tr>
        </table>

        <p>Please log in to your dashboard to view the full details and prepare the order for shipment.</p>
        
        <div style="margin-top: 25px; text-align: center;">
            <a href="{{ route('pharma.dashboard') }}" style="background-color: #d4a373; color: white; padding: 12px 25px; text-decoration: none; border-radius: 5px; font-weight: bold; display: inline-block;">Go to Pharma Dashboard</a>
        </div>
        
        <p style="margin-top: 30px; font-size: 0.9em; color: #777; border-top: 1px solid #e0e0e0; padding-top: 15px;">
            This is an automated notification from the Ayurveda Platform.
        </p>
    </div>
</body>
</html>
