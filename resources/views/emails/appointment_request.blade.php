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
        .details-card { background-color: #f9fbf9; border-left: 4px solid #1a4d2e; padding: 20px; border-radius: 8px; margin: 20px 0; }
        .details-row { display: flex; margin-bottom: 10px; font-size: 15px; }
        .details-label { font-weight: bold; width: 160px; color: #7a8a7a; flex-shrink: 0; }
        .details-value { color: #2e3b2e; }
        .badge-online { background-color: #0d6efd; color: #fff; padding: 4px 14px; border-radius: 30px; font-size: 13px; font-weight: bold; display: inline-block; }
        .badge-offline { background-color: #6c757d; color: #fff; padding: 4px 14px; border-radius: 30px; font-size: 13px; font-weight: bold; display: inline-block; }
        .meet-box { background: #e8f4fd; border: 1px solid #b8d9f7; padding: 16px 20px; border-radius: 10px; margin: 14px 0; }
        .meet-box a { color: #0d6efd; font-weight: bold; word-break: break-all; }
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
            <h2>New Appointment Request</h2>
            <p>Dear Dr. {{ $booking->doctor->name }},</p>
            <p>You have received a new appointment request. Below are the details:</p>
            
            <div class="details-card">
                <div class="details-row">
                    <span class="details-label">Patient:</span>
                    <span class="details-value">{{ $booking->user->name }}</span>
                </div>
                <div class="details-row">
                    <span class="details-label">Phone:</span>
                    <span class="details-value">{{ $booking->user->phone ?? 'N/A' }}</span>
                </div>
                <div class="details-row">
                    <span class="details-label">Date:</span>
                    <span class="details-value">{{ \Carbon\Carbon::parse($booking->booking_date)->format('l, d M Y') }}</span>
                </div>
                <div class="details-row">
                    <span class="details-label">Time:</span>
                    <span class="details-value">{{ \Carbon\Carbon::parse($booking->booking_time)->format('h:i A') }}</span>
                </div>
                <div class="details-row">
                    <span class="details-label">Consultation Type:</span>
                    <span class="details-value">
                        @if($booking->consultation_type === 'Online')
                            <span class="badge-online">Video Online Consultation</span>
                        @else
                            <span class="badge-offline">In-Person / Offline</span>
                        @endif
                    </span>
                </div>
            </div>

            @if($booking->consultation_type === 'Online' && $booking->doctor->google_meet_link)
            <div class="meet-box">
                <strong>Google Meet Link (share with patient after approving):</strong><br>
                <a href="{{ $booking->doctor->google_meet_link }}">{{ $booking->doctor->google_meet_link }}</a>
            </div>
            @endif

            <p>Please log in to your doctor dashboard to review, accept, or reject this appointment request.</p>
            <center>
                <a href="{{ route('doctor.dashboard') }}" class="btn">Go to Dashboard</a>
            </center>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} Ayurveda App. All rights reserved.
        </div>
    </div>
</body>
</html>

