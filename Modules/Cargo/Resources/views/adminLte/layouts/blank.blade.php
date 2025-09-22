@extends('theme.layout.layout-theme')

@section('content')

<style>
    :root {
        --navy-primary: #001f3f;
        --navy-dark: #001a35;
        --navy-light: #0a2a4a;
        --gold-accent: #d4af37;
        --gold-light: #f4e4a9;
        --text-light: #f8f9fa;
        --text-muted: #a8b2c0;
        --transition: all 0.3s ease;
        --shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        --radius: 8px;
    }

    .bd-content-bg {
        /* background: linear-gradient(rgba(0, 31, 63, 0.85), rgba(0, 26, 53, 0.9)), 
                    url('https://images.pexels.com/photos/3140204/pexels-photo-3140204.jpeg') no-repeat center center; */
        background-size: cover;
        background-attachment: fixed;
        min-height: 100vh;
        width: 100%;
        position: relative;
        display: flex;
        flex-direction: column;
    }

    .bd-content-bg::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0; bottom: 0;
        background: rgba(255,255,255,0.1);
        backdrop-filter: blur(12px);
        z-index: 0;
        pointer-events: none;
    }

    .bd-content-bg > .bd-container-post {
        position: relative;
        z-index: 1;
        overflow-y: auto;
        max-height: 100vh;
        scroll-behavior: smooth;
        scrollbar-width: none;
        -ms-overflow-style: none;
        flex: 1;
        padding: 2rem;
        display: flex;
        flex-direction: column;
    }

    .bd-content-bg > .bd-container-post::-webkit-scrollbar {
        display: none;
    }

    /* Enhanced Content Styling */
    .bd-row {
        display: flex;
        flex-direction: column;
        gap: 2rem;
        max-width: 1200px;
        margin: 0 auto;
        width: 100%;
    }

    /* Hero Section */
    .theme-hero {
        text-align: center;
        padding: 3rem 1rem;
        background: rgba(0, 26, 53, 0.7);
        backdrop-filter: blur(10px);
        border-radius: var(--radius);
        border: 1px solid rgba(212, 175, 55, 0.2);
        margin-bottom: 2rem;
    }

    .theme-hero h1 {
        font-size: 3rem;
        margin-bottom: 1rem;
        background: linear-gradient(to right, var(--gold-accent), var(--gold-light));
        -webkit-background-clip: text;
        background-clip: text;
        color: transparent;
        line-height: 1.2;
    }

    .theme-hero p {
        font-size: 1.2rem;
        max-width: 700px;
        margin: 0 auto 2rem;
        color: var(--text-muted);
    }

    /* Content Grid */
    .theme-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 2rem;
        margin-top: 2rem;
    }

    .theme-card {
        background: rgba(0, 26, 53, 0.7);
        backdrop-filter: blur(10px);
        border-radius: var(--radius);
        padding: 1.5rem;
        box-shadow: var(--shadow);
        border: 1px solid rgba(255, 255, 255, 0.05);
        transition: var(--transition);
    }

    .theme-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        border-color: rgba(212, 175, 55, 0.3);
    }

    .theme-card-icon {
        width: 60px;
        height: 60px;
        background: rgba(212, 175, 55, 0.1);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1rem;
        color: var(--gold-accent);
        font-size: 1.5rem;
    }

    .theme-card h3 {
        margin-bottom: 0.8rem;
        color: var(--gold-light);
    }

    .theme-card p {
        color: var(--text-muted);
        margin-bottom: 1.5rem;
    }

    /* Stats Section */
    .theme-stats {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.5rem;
        margin: 2rem 0;
    }

    .theme-stat {
        text-align: center;
        padding: 1.5rem;
        background: rgba(0, 26, 53, 0.5);
        border-radius: var(--radius);
        border: 1px solid rgba(255, 255, 255, 0.05);
    }

    .theme-stat-number {
        font-size: 2.5rem;
        font-weight: 700;
        color: var(--gold-accent);
        margin-bottom: 0.5rem;
    }

    .theme-stat-label {
        color: var(--text-muted);
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    /* Buttons */
    .theme-btn {
        padding: 0.6rem 1.2rem;
        border-radius: var(--radius);
        font-weight: 600;
        cursor: pointer;
        transition: var(--transition);
        border: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        text-decoration: none;
    }

    .theme-btn-primary {
        background: var(--gold-accent);
        color: var(--navy-dark);
    }

    .theme-btn-primary:hover {
        background: var(--gold-light);
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(212, 175, 55, 0.3);
    }

    .theme-btn-outline {
        background: transparent;
        color: var(--text-light);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .theme-btn-outline:hover {
        background: rgba(255, 255, 255, 0.1);
        border-color: var(--gold-accent);
        color: var(--gold-accent);
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .bd-content-bg > .bd-container-post {
            padding: 1rem;
        }

        .theme-hero h1 {
            font-size: 2.2rem;
        }

        .theme-grid {
            grid-template-columns: 1fr;
        }

        .theme-stats {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    /* Animation for content */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .bd-row > * {
        animation: fadeInUp 0.6s ease forwards;
    }

    .bd-row > *:nth-child(1) { animation-delay: 0.1s; }
    .bd-row > *:nth-child(2) { animation-delay: 0.2s; }
    .bd-row > *:nth-child(3) { animation-delay: 0.3s; }
    .bd-row > *:nth-child(4) { animation-delay: 0.4s; }
</style>

<div class="bd-content-wrap bd-content-bg" style="transform: none;">
    <div class="cfix"></div>
    <div class="clearfix"></div>

    @yield('before-content')

    <!-- Main Content Area -->
    <div class="bd-container-post entry-content-only" style="transform: none;">
        <div class="bd-row" style="transform: none;">
            @yield('page-content')
        </div>
    </div>

    @yield('after-content')

</div>

@endsection