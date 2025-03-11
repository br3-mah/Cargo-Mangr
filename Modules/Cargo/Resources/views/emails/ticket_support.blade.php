<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Support Ticket</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

        body {
            font-family: 'Poppins', sans-serif;
            line-height: 1.6;
            color: #1a1a2e;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
        }

        .container {
            max-width: 650px;
            margin: 0 auto;
            background: linear-gradient(to bottom right, #ffffff, #f7f7ff);
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            margin-top: 20px;
            margin-bottom: 20px;
        }

        .header {
            background: linear-gradient(135deg, #2b50aa 0%, #1e3a8a 100%);
            padding: 30px;
            text-align: center;
            position: relative;
        }

        .header h2 {
            color: white;
            margin: 0;
            font-weight: 600;
            font-size: 24px;
            letter-spacing: 0.5px;
        }

        .header-accent {
            position: absolute;
            height: 8px;
            width: 100%;
            bottom: 0;
            left: 0;
            background: linear-gradient(90deg, #3b82f6, #1d4ed8, #ffc800);
        }

        .ticket-content {
            padding: 35px;
        }

        .ticket-info {
            background-color: white;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03);
            margin-bottom: 25px;
        }

        .info-row {
            display: flex;
            margin-bottom: 18px;
            align-items: flex-start;
        }

        .info-row:last-child {
            margin-bottom: 0;
        }

        .info-label {
            font-weight: 600;
            color: #475569;
            width: 150px;
            flex-shrink: 0;
        }

        .info-value {
            flex-grow: 1;
            color: #1e293b;
        }

        .priority {
            display: inline-block;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 500;
        }

        .priority-high {
            background-color: #fee2e2;
            color: #b91c1c;
        }

        .priority-medium {
            background-color: #fef3c7;
            color: #b45309;
        }

        .priority-low {
            background-color: #dcfce7;
            color: #166534;
        }

        .message-container {
            background-color: white;
            border-radius: 12px;
            padding: 25px;
            /* box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03); */
            margin-bottom: 25px;
        }

        .message-label {
            font-weight: 600;
            color: #475569;
            margin-bottom: 15px;
        }

        .message-content {
            line-height: 1.7;
            color: #334155;
            padding: 15px;
            background-color: #f8fafc;
            border-radius: 8px;
            border-left: 4px solid #3b82f6;
        }

        .action-button {
            display: block;
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            color: white;
            text-align: center;
            padding: 16px 24px;
            border-radius: 12px;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
        }

        .action-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(59, 130, 246, 0.4);
        }

        .footer {
            text-align: center;
            padding: 20px 35px 35px;
            color: #64748b;
            font-size: 14px;
        }

        .footer p {
            margin: 5px 0;
        }

        .company-name {
            font-weight: 600;
            color: #1e3a8a;
        }

        .divider {
            height: 1px;
            background: linear-gradient(90deg, rgba(219, 234, 254, 0), rgba(219, 234, 254, 1) 50%, rgba(219, 234, 254, 0));
            margin: 20px 0;
        }

        @media (max-width: 600px) {
            .container {
                border-radius: 0;
                margin-top: 0;
                margin-bottom: 0;
            }
            .ticket-content {
                padding: 20px;
            }
            .info-row {
                flex-direction: column;
            }
            .info-label {
                width: 100%;
                margin-bottom: 5px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>New Support Ticket # {{ date('Y').$ticketData['id'] }}</h2>
            <div class="header-accent"></div>
        </div>

        <div class="ticket-content">
            <div class="ticket-info">
                <div class="info-row">
                    <div class="info-label">Subject:</div>
                    <div class="info-value"><strong>{{ $ticketData['subject'] }}</strong></div>
                </div>
                <div class="info-row">
                    <div class="info-label">Category:</div>
                    <div class="info-value">{{ $ticketData['category'] }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Priority:</div>
                    <div class="info-value">
                        <span class="priority priority-{{ strtolower($ticketData['priority']) }}">{{ ucfirst($ticketData['priority']) }}</span>
                    </div>
                </div>
                <div class="info-row">
                    <div class="info-label">Shipment Number:</div>
                    <div class="info-value">{{ $ticketData['shipment_number'] ?? 'N/A' }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Submitted On:</div>
                    <div class="info-value">{{ date('F j, Y, g:i a') }}</div>
                </div>
            </div>

            <div class="message-container">
                <div class="message-label">Message:</div>
                <div class="message-content">
                    {{ $ticketData['message'] }}
                </div>
            </div>

            {{-- <a href="" class="action-button">View in Dashboard</a> --}}
        </div>

        <div class="footer">
            <p>Best regards,</p>
            <p class="company-name">Newworld Cargo Support Team</p>
            <div class="divider"></div>
            <p>This is an automated notification. Please access your dashboard to respond.</p>
        </div>
    </div>
</body>
</html>
