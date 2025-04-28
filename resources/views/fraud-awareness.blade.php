@extends('layouts.web')

@section('content')
<div class="container kt-container mt-5 pt-8">
    <div class="card kt-card shadow-sm border-0">
        <div class="card-body kt-card-body p-5">
            <h2 class="kt-title text-[#012642] fw-bold">Fraud Awareness</h2>
            <p class="kt-text">Thank you for joining our effort to combat online fraud. Newworld Cargo goes to great lengths to protect our customers from fraud. If you suspect fraudulent emails, SMS, or fake websites/social media accounts pretending to be Newworld Cargo, report them promptly so we can take action.</p>

            <p class="kt-text fw-bold">Report suspicious activity to:</p>
            <p class="kt-text text-danger fw-bold">info@newworldcargo.com</p>

            <p class="kt-text">We thoroughly investigate every report but do not respond to personal inquiries. For shipment or invoice queries, please contact customer support.</p>

            <h4 class="kt-title text-dark fw-semibold mt-4">Anti-Spam and Phishing Attacks Awareness</h4>
            <ul class="list-group kt-list-group">
                <li class="list-group-item">Fraudulent Email</li>
                <li class="list-group-item">Fraudulent SMS</li>
                <li class="list-group-item">Fraudulent Social Media Accounts Incl. WhatsApp</li>
                <li class="list-group-item">Hacked Newworld Cargo Accounts</li>
                <li class="list-group-item">Local Alert: Bogus Recruitment Ads & Offers</li>
            </ul>

            <p class="kt-text mt-3">Phishing scams appear legitimate but aim to steal personal data. Click below to learn how to report suspicious emails.</p>
            <a href="{{ route('contact-us') }}" class="btn btn-warning kt-btn fw-bold">Report Suspicious Email</a>

            <h4 class="kt-title text-dark fw-semibold mt-5">Fraudulent Use of the Newworld Cargo Brand</h4>
            <p class="kt-text">Unauthorized use of Newworld Cargo branding has been used in scams involving internet sales, often requesting payment before delivery.</p>

            <p class="kt-text">Newworld Cargo only requests payments for customs duties and taxes via email or SMS, ensuring security through OTP verification.</p>

            <p class="kt-text text-warning fw-bold">Newworld Cargo is not responsible for costs incurred due to fraud.</p>
            {{-- <a href="{{ Storage::url('legal/NWCanti-spam-protection-initiative-en.pdf') }}"
                class="btn btn-danger kt-btn"
                id="downloadAntiSpamPdf"
                download>
                Download Anti-Spam Protection Initiative (PDF - 674.6 KB)
            </a> --}}

        </div>
    </div>
</div>
@endsection
