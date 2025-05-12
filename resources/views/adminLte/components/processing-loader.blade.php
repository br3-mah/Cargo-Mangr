 <style>
    .btnclicky {
      background-color: #ffd903;
      color: white;
      border: none;
      padding: 12px 24px;
      font-size: 16px;
      font-weight: 500;
      border-radius: 8px;
      cursor: pointer;
      transition: background-color 0.3s, transform 0.2s;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .btnclicky:hover {
      background-color: #e0bf04;
      transform: translateY(-2px);
    }

    .btnclicky:active {
      transform: translateY(0);
    }

    /* Overlay Loader Styles */
    .overlay-loader {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(255, 255, 255, 0.95);
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      z-index: 99999;
      opacity: 0;
      visibility: hidden;
      transition: opacity 0.3s, visibility 0.3s;
    }

    .overlay-loader.active {
      opacity: 1;
      visibility: visible;
    }

    .top-nav-progress {
      position: absolute;
      top: 0;
      left: 0;
      height: 4px;
      width: 0%;
      background: linear-gradient(to right, #fcf824, #ffd903, #ffd9039f);
      z-index: 99999;
      box-shadow: 0 1px 5px rgba(37, 99, 235, 0.5);
      transition: width 0.2s ease-out;
    }

    .loader-content {
      display: flex;
      flex-direction: column;
      align-items: center;
    }

    .loader-spinner {
      width: 40px;
      height: 40px;
      border: 3px solid rgba(37, 99, 235, 0.2);
      border-radius: 50%;
      border-top-color: #ffd903;
      animation: spin 1s ease-in-out infinite;
      margin-bottom: 20px;
    }

    .loader-text {
      color: #334155;
      font-size: 16px;
      font-weight: 500;
      letter-spacing: 0.5px;
    }

    @keyframes spin {
      to {
        transform: rotate(360deg);
      }
    }
  </style>
  <!-- Overlay Loader -->
  <div class="overlay-loader">
    <div class="top-nav-progress"></div>
    <div class="loader-content">
      <div class="loader-spinner"></div>
    </div>
  </div>
