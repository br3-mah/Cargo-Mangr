
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap');
        
        :root {
            --primary: #ffc400;
            --accent: #3a0ca3;
            --text: #2b2d42;
            --light-text: #565973;
            --background: #ffffff;
            --card-bg: #f8f9fa;
            --border-radius: 12px;
            --shadow: 0 10px 25px rgba(238, 221, 67, 0.1);
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', sans-serif;
        }
        
        #cookie-banner {
            position: fixed;
            bottom: 24px;
            left: 50%;
            transform: translateX(-50%);
            width: 100%;
            max-width: 50%;
            background: var(--background);
            color: var(--text);
            border-radius: var(--border-radius);
            padding: 0;
            display: none;
            z-index: 9999;
            box-shadow: var(--shadow);
            overflow: hidden;
            animation: slide-up 0.5s ease-out;
        }
        
        @keyframes slide-up {
            from {
                transform: translate(-50%, 100px);
                opacity: 0;
            }
            to {
                transform: translate(-50%, 0);
                opacity: 1;
            }
        }
        
        .cookie-header {
            padding: 20px 24px 0;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        
        .cookie-title {
            font-size: 18px;
            font-weight: 600;
            color: var(--text);
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .cookie-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(67, 97, 238, 0.1);
            width: 36px;
            height: 36px;
            border-radius: 50%;
        }
        
        .cookie-content {
            padding: 16px 24px;
            font-size: 14px;
            line-height: 1.5;
            color: var(--light-text);
        }
        
        .cookie-links {
            padding: 0 24px 16px;
            display: flex;
            gap: 16px;
        }
        
        .cookie-link {
            font-size: 13px;
            color: var(--primary);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 4px;
        }
        
        .cookie-link:hover {
            text-decoration: underline;
        }
        
        .cookie-actions {
            padding: 16px 24px;
            display: flex;
            justify-content: space-between;
            gap: 12px;
            border-top: 1px solid rgba(0, 0, 0, 0.06);
        }
        
        .btn {
            flex: 1;
            font-family: 'Inter', sans-serif;
            font-size: 14px;
            font-weight: 500;
            padding: 12px 16px;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }
        
        .btn-outline {
            background: transparent;
            color: var(--light-text);
            border: 1px solid rgba(0, 0, 0, 0.1);
        }
        
        .btn-outline:hover {
            background: rgba(0, 0, 0, 0.05);
        }
        
        .btn-primary {
            background: var(--primary);
            color: white;
        }
        
        .btn-primary:hover {
            background: var(--accent);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(67, 97, 238, 0.2);
        }
        
        /* For smaller screens */
        @media (max-width: 480px) {
            #cookie-banner {
                bottom: 0;
                width: 100%;
                max-width: 100%;
                border-radius: var(--border-radius) var(--border-radius) 0 0;
            }
            
            .cookie-actions {
                flex-direction: column;
            }
        }
    </style>
    <div id="cookie-banner">
        <div class="cookie-header">
            <div class="cookie-title">
                <div class="cookie-icon">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 2C6.48 2 2 6.48 2 12C2 17.52 6.48 22 12 22C17.52 22 22 17.52 22 12C22 6.48 17.52 2 12 2ZM12 20C7.59 20 4 16.41 4 12C4 7.59 7.59 4 12 4C16.41 4 20 7.59 20 12C20 16.41 16.41 20 12 20Z" fill="#4361ee"/>
                        <path d="M7 13.5C7.82843 13.5 8.5 12.8284 8.5 12C8.5 11.1716 7.82843 10.5 7 10.5C6.17157 10.5 5.5 11.1716 5.5 12C5.5 12.8284 6.17157 13.5 7 13.5Z" fill="#4361ee"/>
                        <path d="M12 13.5C12.8284 13.5 13.5 12.8284 13.5 12C13.5 11.1716 12.8284 10.5 12 10.5C11.1716 10.5 10.5 11.1716 10.5 12C10.5 12.8284 11.1716 13.5 12 13.5Z" fill="#4361ee"/>
                        <path d="M17 13.5C17.8284 13.5 18.5 12.8284 18.5 12C18.5 11.1716 17.8284 10.5 17 10.5C16.1716 10.5 15.5 11.1716 15.5 12C15.5 12.8284 16.1716 13.5 17 13.5Z" fill="#4361ee"/>
                    </svg>
                </div>
                Cookie Preferences
            </div>
        </div>
        
        <div class="cookie-content">
            Consent for Data ProcessingThis website uses cookies and similar technologies (hereinafter "Technologies") that 
            enable us to provide an optimized online experience and tailor content to your interests. By clicking "Accept all", 
            you consent that these Technologies may be stored and read on your device. This includes the creation of profiles to 
            make our services as easy to use and as customer-specific as possible and to support our marketing activities. 
            Your consent includes the transfer of data to countries with a level of data protection not equivalent to the 
            European Union. For more information and the option to withdraw or adjust your consent, please refer to 
            "Consent Settings" at the bottom of the website. 
            Privacy notice Legal Notice
        </div>
        
        <div class="cookie-links">
            <a href="#" class="cookie-link">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 2C6.48 2 2 6.48 2 12C2 17.52 6.48 22 12 22C17.52 22 22 17.52 22 12C22 6.48 17.52 2 12 2ZM12 20C7.59 20 4 16.41 4 12C4 7.59 7.59 4 12 4C16.41 4 20 7.59 20 12C20 16.41 16.41 20 12 20Z" fill="#4361ee"/>
                    <path d="M11 17H13V11H11V17ZM12 9C12.55 9 13 8.55 13 8C13 7.45 12.55 7 12 7C11.45 7 11 7.45 11 8C11 8.55 11.45 9 12 9Z" fill="#4361ee"/>
                </svg>
                Privacy Policy
            </a>
            <a href="#" class="cookie-link">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 2C6.48 2 2 6.48 2 12C2 17.52 6.48 22 12 22C17.52 22 22 17.52 22 12C22 6.48 17.52 2 12 2ZM13 17H11V15H13V17ZM13 13H11V7H13V13Z" fill="#4361ee"/>
                </svg>
                Cookie Policy
            </a>
        </div>
        
        <div class="cookie-actions">
            <button class="btn btn-outline" onclick="declineCookies()">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M19 6.41L17.59 5L12 10.59L6.41 5L5 6.41L10.59 12L5 17.59L6.41 19L12 13.41L17.59 19L19 17.59L13.41 12L19 6.41Z" fill="currentColor"/>
                </svg>
                Decline
            </button>
            <button class="btn btn-primary" onclick="acceptCookies()">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M9 16.17L4.83 12L3.41 13.41L9 19L21 7L19.59 5.59L9 16.17Z" fill="white"/>
                </svg>
                Accept All
            </button>
        </div>
    </div>
    
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            if (!localStorage.getItem("cookieConsent")) {
                document.getElementById("cookie-banner").style.display = "block";
            }
        });
        
        function acceptCookies() {
            localStorage.setItem("cookieConsent", "accepted");
            document.getElementById("cookie-banner").style.display = "none";
        }
        
        function declineCookies() {
            localStorage.setItem("cookieConsent", "declined");
            document.getElementById("cookie-banner").style.display = "none";
        }
    </script>