@extends('layouts.web')

@section('content')
<style>
    :root {
        --primary-color: #fc0;
        --secondary-color: #04012c;
        --text-color: #333;
        --light-gray: #f5f5f5;
        --border-color: #e0e0e0;
        --link-color: #05022f;
    }

    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
    }

    header {
        background-color: #fff;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        position: sticky;
        top: 0;
        z-index: 100;
    }

    .header-content {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 20px 0;
    }

    .logo {
        font-size: 24px;
        font-weight: bold;
        color: var(--secondary-color);
        display: flex;
        align-items: center;
    }

    .logo-text {
        margin-left: 10px;
    }

    .logo-box {
        background-color: var(--primary-color);
        padding: 5px;
        color: var(--secondary-color);
        font-weight: bold;
        font-size: 18px;
    }

    .contact-btn {
        background-color: var(--primary-color);
        color: var(--text-color);
        padding: 10px 15px;
        border: none;
        border-radius: 4px;
        font-weight: bold;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .contact-btn:hover {
        background-color: #e6b800;
    }

    .banner {
        background-color: var(--light-gray);
        padding: 40px 0;
        margin-bottom: 40px;
    }

    .banner h1 {
        font-size: 36px;
        margin-bottom: 15px;
    }

    .privacy-intro {
        margin-bottom: 30px;
        max-width: 800px;
    }

    .quick-links {
        background-color: #fff;
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 40px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
    }

    .quick-links h3 {
        margin-bottom: 15px;
        border-bottom: 2px solid var(--primary-color);
        padding-bottom: 8px;
        display: inline-block;
    }

    .quick-links-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 15px;
    }

    .quick-link {
        padding: 10px;
        border-radius: 4px;
        background-color: var(--light-gray);
        text-decoration: none;
        color: var(--text-color);
        font-weight: 500;
        transition: background-color 0.3s;
    }

    .quick-link:hover {
        background-color: var(--primary-color);
    }

    .section {
        margin-bottom: 40px;
    }

    .section h2 {
        font-size: 28px;
        margin-bottom: 20px;
        color: var(--secondary-color);
        padding-bottom: 8px;
        border-bottom: 3px solid var(--primary-color);
        display: inline-block;
    }

    .subsection {
        margin-bottom: 30px;
    }

    .subsection h3 {
        font-size: 22px;
        margin-bottom: 15px;
        color: var(--text-color);
    }

    p {
        margin-bottom: 15px;
    }

    ul, ol {
        margin-bottom: 15px;
        padding-left: 20px;
    }

    li {
        margin-bottom: 8px;
    }

    a {
        color: var(--link-color);
        text-decoration: none;
    }

    a:hover {
        text-decoration: underline;
    }

    .card {
        background-color: #fff;
        border-radius: 8px;
        padding: 25px;
        margin-bottom: 30px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        transition: transform 0.3s;
    }

    .card:hover {
        transform: translateY(-5px);
    }

    .accordion {
        background-color: #fff;
        border: 1px solid var(--border-color);
        border-radius: 8px;
        margin-bottom: 15px;
        overflow: hidden;
    }

    .accordion-header {
        padding: 15px 20px;
        background-color: var(--light-gray);
        cursor: pointer;
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-weight: 600;
    }

    .accordion-content {
        padding: 0 20px;
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.3s ease-out;
    }

    .accordion.active .accordion-content {
        max-height: 1000px;
        padding: 20px;
    }

    .icon {
        transition: transform 0.3s;
    }

    .accordion.active .icon {
        transform: rotate(180deg);
    }

    footer {
        background-color: var(--light-gray);
        padding: 40px 0;
        margin-top: 60px;
    }

    .footer-content {
        display: flex;
        justify-content: space-between;
        flex-wrap: wrap;
    }

    .footer-section {
        flex: 1;
        min-width: 200px;
        margin-bottom: 20px;
    }

    .footer-section h4 {
        margin-bottom: 15px;
        font-size: 18px;
    }

    .cookie-settings {
        margin-top: 20px;
        background-color: var(--primary-color);
        color: var(--text-color);
        border: none;
        padding: 10px 15px;
        border-radius: 4px;
        cursor: pointer;
        font-weight: 500;
    }

    .last-updated {
        margin-top: 20px;
        font-style: italic;
        color: #777;
    }

    @media (max-width: 768px) {
        .quick-links-grid {
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
        }

        .footer-content {
            flex-direction: column;
        }

        .banner h1 {
            font-size: 28px;
        }
    }
</style>


<header>
    <div class="container">
        <div class="header-content">
            <div class="logo">
                <div class="logo-box">Newworld Cargo</div>
                <div class="logo-text">Privacy Center</div>
            </div>
            <button class="contact-btn">
                <a href="{{ route('contact-us') }}">Contact Data Protection</a>
            </button>
        </div>
    </div>
</header>

<div class="banner">
    <div class="container">
        <h1>Privacy Notice</h1>
        <div class="privacy-intro">
            <p>Newworld Cargo (hereinafter called 'Newworld Cargo') is pleased that you have visited our website and are interested in our company, products and services. It is important to us to protect your personal data during handling throughout the entire business process.</p>
            <p>In the following, we explain what information Newworld Cargo collects when you visit our website and how this information is used.</p>
        </div>
    </div>
</div>

<div class="container">
    <div class="quick-links">
        <h3>Jump To</h3>
        <div class="quick-links-grid">
            <a href="#personal-data" class="quick-link">Personal Data</a>
            <a href="#how-we-use" class="quick-link">How We Use Your Data</a>
            <a href="#who-processes" class="quick-link">Who Processes Your Data</a>
            <a href="#data-rights" class="quick-link">What Are My Data Rights?</a>
            <a href="#divisional" class="quick-link">Divisional Privacy Notices</a>
            <a href="#scope" class="quick-link">Scope of this Privacy Notice</a>
        </div>
    </div>

    <div id="scope" class="section">
        <h2>Scope of this Privacy Notice</h2>
        <div class="card">
            <p>This Privacy Notice applies to all users of our services, websites, applications, features or other services anywhere in the world, unless covered by a separate Privacy Notice. This Privacy Notice applies to the following categories of individuals:</p>
            <ul>
                <li><strong>Shippers:</strong> shippers, including their employees, or individuals who send a shipment</li>
                <li><strong>Shipment receivers:</strong> any individual who receives a shipment</li>
                <li><strong>Persons showing interest in us and our services</strong></li>
                <li><strong>Business partners:</strong> business partners, including their employees</li>
                <li><strong>Employment candidates:</strong> individuals that apply for a job with us</li>
            </ul>
            <p>All the above subjects are referred to as "you" or "your".</p>
        </div>
    </div>

    <div id="personal-data" class="section">
        <h2>Personal Data</h2>

        <div class="subsection">
            <h3>What is Personal Data?</h3>
            <div class="card">
                <p>Personal data means any information relating to an identified or identifiable natural person ('data subject'); an identifiable natural person is one who can be identified, directly or indirectly, in particular by reference to an identifier such as a name, an identification number, location data, an online identifier or to one or more factors specific to the physical, physiological, genetic, mental, economic, cultural or social identity of that natural person.</p>
                <p>This includes information such as your real name, address, telephone number and date of birth. Information which cannot be linked to your real identity - such as favorite websites or number of users of a site - is not considered personal data.</p>
            </div>
        </div>

        <div class="subsection">
            <h3>Who is Responsible?</h3>
            <div class="card">
                <p>This Privacy Notice applies for the data processing carried out by:</p>
                <p>
                    Newworld Cargo<br>
                    Lusaka Office<br>
                    Plot 12500, Carousel Shopping Center Shop 62/a
                    <br>
                    Zambia
                </p>
                {{-- <p>Data Protection Officer of controller, contact details:</p>
                <p>
                    Deutsche Post AG<br>
                    Global Data Protection<br>
                    53250 Bonn
                </p> --}}
                <p>If you have queries with regard to the processing of your personal data, please contact the Data Protection Officer.</p>
                <p>If you have any further queries regarding data protection in connection with our website or services offered there, please contact Newworld Cargo data protection.</p>
            </div>
        </div>

        <div class="subsection">
            <h3>Types of Data We Process</h3>
            <div class="card">
                <p>We only process your personal data when required for a specific and allowed purpose.</p>
                <table style="width:100%; border-collapse: collapse; margin-top: 15px;">
                    <tr style="background-color: var(--light-gray);">
                        <th style="padding: 12px; text-align: left; border-bottom: 1px solid var(--border-color);">Data Type</th>
                        <th style="padding: 12px; text-align: left; border-bottom: 1px solid var(--border-color);">Description</th>
                        <th style="padding: 12px; text-align: left; border-bottom: 1px solid var(--border-color);">Examples</th>
                    </tr>
                    <tr>
                        <td style="padding: 12px; border-bottom: 1px solid var(--border-color);"><strong>Contact Data</strong></td>
                        <td style="padding: 12px; border-bottom: 1px solid var(--border-color);">Information to contact you</td>
                        <td style="padding: 12px; border-bottom: 1px solid var(--border-color);">Name, phone number, address, email address</td>
                    </tr>
                    <tr>
                        <td style="padding: 12px; border-bottom: 1px solid var(--border-color);"><strong>Profile Data</strong></td>
                        <td style="padding: 12px; border-bottom: 1px solid var(--border-color);">Information on your Newworld Cargo profile</td>
                        <td style="padding: 12px; border-bottom: 1px solid var(--border-color);">Delivery preferences, order history</td>
                    </tr>
                    <tr>
                        <td style="padding: 12px; border-bottom: 1px solid var(--border-color);"><strong>Shipment Data</strong></td>
                        <td style="padding: 12px; border-bottom: 1px solid var(--border-color);">Information enabling pick-up and delivery</td>
                        <td style="padding: 12px; border-bottom: 1px solid var(--border-color);">Address, shipment documents, tracking numbers</td>
                    </tr>
                    <tr>
                        <td style="padding: 12px; border-bottom: 1px solid var(--border-color);"><strong>Survey Data</strong></td>
                        <td style="padding: 12px; border-bottom: 1px solid var(--border-color);">Information communicated to us</td>
                        <td style="padding: 12px; border-bottom: 1px solid var(--border-color);">Feedback, responses to surveys</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <div id="how-we-use" class="section">
        <h2>How We Use Your Data</h2>

        <div class="accordion">
            <div class="accordion-header">
                Visiting our Website
                <span class="icon">▼</span>
            </div>
            <div class="accordion-content">
                <p>Newworld Cargo is committed to preserving the privacy of users of our websites. When you visit our web pages, The following data are collected: IP address, hostname of the accessing computer, website from which you accessed this website, a list of the sites you visited within the scope of our overall Internet presence, the date and duration of your visit, notification of whether the visit was successful, volume of data transferred, information about the identification data of the browser type and operating system used by you.</p>
                <p>Temporary storage of this data is necessary during your visit to the website in order to allow the website to be delivered to you. Further storage in log files is performed to ensure the functionality of the website and the security of our IT systems. The legal basis for the processing of the aforementioned data categories is therefore Art. 6 (1) (f) of the European General Data Protection Regulation (GDPR).</p>
            </div>
        </div>

        <div class="accordion">
            <div class="accordion-header">
                Use of Cookies
                <span class="icon">▼</span>
            </div>
            <div class="accordion-content">
                <p>This website uses cookies and similar technologies, (hereafter "technologies"), which enable us, for example, to determine how frequently our internet pages are visited, the number of visitors, to configure our offers for maximum convenience and efficiency and to support our marketing efforts.</p>
                <p>When you access our website, a Privacy Preference Center will inform you that technically necessary cookies are set and, in addition, that your consent is required to the use of certain technologies, such as analytical cookies or similar technologies.</p>
            </div>
        </div>

        <div class="accordion">
            <div class="accordion-header">
                Social Media
                <span class="icon">▼</span>
            </div>
            <div class="accordion-content">
                <ol>
                    <li>Introduction</li>
                    <li>Contacting the data controller and data protection officer</li>
                    <li>Purpose and legal basis of processing</li>
                    <li>Rights of the data subject</li>
                    <li>Storage periods</li>
                </ol>
            </div>
        </div>

        <div class="accordion">
            <div class="accordion-header">
                Performance of a Contract
                <span class="icon">▼</span>
            </div>
            <div class="accordion-content">
                <p>For pre-contractual and contractual reasons, we also need personal data to provide our services and comply with the obligations arising from contractual agreements concluded with you.</p>
                <p>On newworldcargo.com we offer the following services:</p>
                <ol>
                    <li><strong>Get a Quote</strong> - To provide accurate shipping quotes based on your requirements</li>
                    <li><strong>Newworld Cargo for Business</strong> - To connect businesses with appropriate Newworld Cargo services</li>
                    <li><strong>Track and Trace</strong> - To allow tracking of shipments and delivery status</li>
                    <li><strong>Ship Now</strong> - To facilitate immediate shipping through our customer portals</li>
                    <li><strong>Customer Service</strong> - To address your questions and provide support</li>
                    <li><strong>Duty and Tax Prepayment</strong> - To offer optional prepayment for import duties and taxes</li>
                </ol>
            </div>
        </div>
    </div>

    <div id="who-processes" class="section">
        <h2>Who Processes Your Data</h2>

        <div class="subsection">
            <h3>Processing for Advertising Purposes</h3>
            <div class="card">
                <p>When you visit our web page we offer you a broad variety of information about Newworld Cargo, about our products, services and events. In particular you can get information about our:</p>
                <ol>
                    <li><strong>Events and Webinars</strong> - When you register, we collect necessary information to facilitate your participation</li>
                    <li><strong>Delivered.</strong> - Our content platform that provides industry insights and updates</li>
                    <li><strong>Spotlight</strong> - Our email notification service for new articles and updates</li>
                    <li><strong>Newsletters</strong> - Regular communications about our services and industry news</li>
                </ol>
            </div>
        </div>

        <div class="subsection">
            <h3>Data Retention and Third Parties</h3>
            <div class="card">
                <h4>How Long We Keep Your Data</h4>
                <p>We will keep your data for as long as necessary to fulfill our purposes, to execute our contracts and to comply with any legal obligation. The retention period may differ per country based on applicable country laws.</p>
                <p>We continuously strive to minimize the retention period of data where the purpose, the law or contracts allows us to do so. The data that we collect based on your consent will be kept until you withdraw your consent.</p>

                <h4>Will My Data Be Passed On?</h4>
                <p>Newworld Cargo does not share, sell, transfer or otherwise disseminate your personal data to third parties and will not do so in future, unless required by law, unless required for the purpose of the contract or unless you have given explicit consent to do so.</p>
                <p>In the context of the data processing as described in this Privacy Notice and the respective legal basis given, Newworld Cargo will transfer your data to the following categories of recipients:</p>
                <ul>
                    <li><strong>Newworld Cargo Group companies</strong></li>
                    <li><strong>Third party business partners</strong></li>
                    <li><strong>Third party processors</strong></li>
                    <li><strong>Public authorities</strong></li>
                </ul>
            </div>
        </div>
    </div>

    <div id="data-rights" class="section">
        <h2>What Are My Data Rights?</h2>
        <div class="card">
            <p>You have the following rights:</p>
            <ul>
                <li>You can request information as to what personal data is stored</li>
                <li>You can request that we correct, delete or block your personal data provided these actions are permitted by law and in compliance with existing contractual conditions.</li>
                <li>You can request to receive personal data you have provided in a structured, commonly used and machine-readable format.</li>
                <li>You may lodge a complaint with the supervisory authority</li>
            </ul>

            <h4>Right to Obtain</h4>
            <p>You can obtain your information by contacting data protection here: <a href="#">Newworld Cargo Data Protection</a>.</p>

            <h4>Right to Object</h4>
            <p>The right to object applies for all processing of personal data which is based on Art. 6 (1) f) GDPR.</p>

            <h4>Right to Withdraw Your Consent</h4>
            <p>You have the right to withdraw your consent with effect for the future at any time.</p>
        </div>

        <div class="subsection">
            <h3>How About Data Security?</h3>
            <div class="card">
                <p>Newworld Cargo takes the security of your data very seriously. We have implemented various strategies, controls, policies and measures to keep your data secure. We keep our security measures under close review. We use safeguards such as:</p>
                <ul>
                    <li>Firewalls and network intrusion systems</li>
                    <li>Application monitoring</li>
                    <li>Pseudonymization and encryption techniques</li>
                    <li>Secure operating environments</li>
                    <li>SSL technology for data transmission</li>
                    <li>Strict physical access controls</li>
                    <li>Regular security audits in compliance with ISO 27001</li>
                    <li>Employee training and incident simulation exercises</li>
                </ul>
            </div>
        </div>
    </div>

    <div id="divisional" class="section">
        <h2>Divisional Privacy Notices</h2>
        <div class="card">
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 20px;">
                <div style="padding: 15px; border: 1px solid var(--border-color); border-radius: 6px;">
                    <h4>Newworld Cargo Express</h4>
                    <p><a href="#">Newworld Cargo Express CCPA Privacy Policy</a></p>
                </div>
                <div style="padding: 15px; border: 1px solid var(--border-color); border-radius: 6px;">
                    <h4>Newworld Cargo Supply Chain</h4>
                    <p><a href="#">Newworld Cargo Supply Chain CCPA Notice to Employees</a></p>
                    <p><a href="#">Newworld Cargo Supply Chain CCPA Notice to Job Applicants</a></p>
                    <p><a href="#">Newworld Cargo Supply Chain CCPA Notice to Independent Contractors</a></p>
                </div>
                <div style="padding: 15px; border: 1px solid var(--border-color); border-radius: 6px;">
                    <h4>Newworld Cargo eCommerce</h4>
                    <p><a href="#">Visit Newworld Cargo eCommerce Americas CCPA Privacy Policy</a></p>
                </div>
            </div>
        </div>

        <div class="subsection">
            <h3>Changes to Privacy Notice</h3>
            <div class="card">
                <p>Newworld Cargo reserves the right to change its Privacy Notice at any time with or without prior notice. Please check back frequently to be informed of any changes. By using Newworld Cargo's websites you agree to this Privacy Notice.</p>
                <p class="last-updated">This statement was last updated on: 13/03/2025</p>
            </div>
        </div>
    </div>
</div>



<script>
    // Simple accordion functionality
    document.querySelectorAll('.accordion-header').forEach(button => {
        button.addEventListener('click', () => {
            const accordion = button.parentElement;
            accordion.classList.toggle('active');
        });
    });
</script>

@endsection
