<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Terms of Service – Smart Parking</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <style>
                body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f3f4f6; /* bg-gray-100 */
            color: #111827; /* text-gray-900 */
            margin: 0;
            padding: 40px 20px;
            line-height: 1.5;
        }

        .container {
            max-width: 768px; /* max-w-3xl */
            margin: 0 auto;
        }

        .back-button {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
            color: #6b7280; /* text-gray-500 */
            text-decoration: none;
            margin-bottom: 24px;
            transition: color 0.2s;
        }

        .back-button:hover {
            color: #f97316; /* hover:text-orange-600 */
        }

        .back-button i {
            transition: transform 0.2s;
        }

        .back-button:hover i {
            transform: translateX(-4px); /* group-hover:-translate-x-1 */
        }

        .card {
            background-color: #ffffff;
            border-radius: 16px; /* rounded-2xl */
            border: 1px solid #e5e7eb; /* border-gray-200 */
            padding: 32px; /* p-8 */
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1); /* shadow-sm */
        }

        header {
            border-bottom: 1px solid #f3f4f6;
            padding-bottom: 24px;
            margin-bottom: 32px;
        }

        h1 {
            margin: 0;
            font-size: 30px;
            font-weight: 700;
        }

        .last-updated {
            font-size: 14px;
            color: #6b7280;
            margin-top: 8px;
        }

        .section-stack {
            display: flex;
            flex-direction: column;
            gap: 32px; /* space-y-8 */
        }

        h3 {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 18px;
            font-weight: 700;
            margin: 0 0 16px 0;
        }

        .grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }

        /* Mobile responsive grid */
        @media (max-width: 640px) {
            .grid {
                grid-template-columns: 1fr;
            }
        }

        .info-box {
            background-color: #f9fafb; /* bg-gray-50 */
            border: 1px solid #f3f4f6;
            border-radius: 8px;
            padding: 16px;
        }

        .info-title {
            font-weight: 600;
            font-size: 14px;
            margin: 0 0 4px 0;
        }

        .info-text {
            font-size: 12px;
            color: #4b5563; /* text-gray-600 */
            margin: 0;
        }

        .description {
            font-size: 14px;
            color: #4b5563;
            margin: 0;
        }

        .list-item {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            margin-bottom: 12px;
        }

        .dot {
            width: 6px;
            height: 6px;
            background-color: #f97316; /* bg-orange-500 */
            border-radius: 50%;
            margin-top: 7px;
            flex-shrink: 0;
        }

        footer {
            margin-top: 48px;
            padding-top: 32px;
            border-top: 1px solid #f3f4f6;
            text-align: center;
        }

        footer p {
            font-size: 14px;
            color: #6b7280;
        }

        footer a {
            color: #ea580c; /* text-orange-600 */
            text-decoration: none;
        }

        footer a:hover {
            text-decoration: underline;
        }
    </style>

</head>
<body>

    <div class="container">
        <a href="javascript:history.back()" class="back-button">
            <i class="fa-solid fa-person-walking-arrow-loop-left"></i>
            Go Back
        </a>

        <div class="card">
            <header>
                <h1>Terms of Service</h1>
                <p class="last-updated">Last updated: February 2026</p>
            </header>

            <div class="content-stack">
                <section>
                    <h3><span>🚗</span> 1. Use of Service</h3>
                    <p>
                        By using Smart Parking, you agree to provide accurate vehicle information. 
                        Multiple vehicles may be registered, but only one may occupy a reserved slot at a time.
                    </p>
                </section>

                <section>
                    <h3><span>⏳</span> 2. Reservations & Cancellations</h3>
                    <ul class="term-list">
                        <li class="term-list-item">
                            <span class="bullet">•</span>
                            <span><strong>Grace Period:</strong> Reservations are held for 15 minutes past the start time. If you do not arrive, the slot may be released.</span>
                        </li>
                        <li class="term-list-item">
                            <span class="bullet">•</span>
                            <span><strong>Refunds:</strong> Cancellations made at least 1 hour before the start time are eligible for a full refund.</span>
                        </li>
                    </ul>
                </section>

                <section>
                    <h3><span>⚖️</span> 3. Liability & Security</h3>
                    <div class="liability-box">
                        <p>
                            <strong>Owner’s Risk:</strong> Smart Parking provides a platform for reservations but is not responsible for theft, fire, or damage to any vehicle or its contents while parked in a partner facility.
                        </p>
                        <p>
                            <strong>Compliance:</strong> Users must follow the specific physical rules and signage of the parking facility they are entering.
                        </p>
                    </div>
                </section>

                <section>
                    <h3><span>🚫</span> 4. Account Termination</h3>
                    <p>
                        We reserve the right to suspend accounts that engage in fraudulent bookings or repeated "no-shows" that disrupt the system for other drivers.
                    </p>
                </section>
            </div>

            <footer>
                <p>Have questions? <a href="mailto:support@smartparking.com">Contact Support</a></p>
            </footer>
        </div>
    </div>

</body>
</html>