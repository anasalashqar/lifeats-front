<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        footer {
            background-color: rgb(249, 236, 230);
            color: #ff691c;
            padding: 40px 20px;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            
        }
        
        .footer-container {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 30px;
        }
        
        .footer-logo {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 15px;
        }
        
        .footer-description {
            font-size: 14px;
            line-height: 1.5;
            margin-bottom: 20px;
        }
        
        .footer-section h3 {
            font-size: 18px;
            margin-bottom: 15px;
            font-weight: bold;
        }
        
        .footer-section ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        
        .footer-section li {
            margin-bottom: 10px;
        }
        
        .footer-section a {
            color: #ff691c;
            text-decoration: none;
            transition: color 0.3s;
        }
        
        .footer-section a:hover {
            text-decoration: underline;
        }
        
        .newsletter input {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ff691c;
            border-radius: 4px;
        }
        
        .newsletter button {
            background-color: #ff691c;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 4px;
            cursor: pointer;
            font-weight: bold;
        }
        
        .footer-bottom {
            margin-top: 40px;
            text-align: center;
            font-size: 12px;
            padding-top: 20px;
            border-top: 1px solid #ff691c;
        }
        
        .footer-bottom a {
            color: #ff691c;
            margin: 0 10px;
            text-decoration: none;
        }
        
        @media (max-width: 768px) {
            .footer-container {
                grid-template-columns: 1fr;
                gap: 20px;
            }
            
            .footer-section {
                margin-bottom: 20px;
            }
        }
    </style>
</head>
<body>
    <footer>
        <div class="footer-container">
            <div class="footer-about">
                <div class="footer-logo">LifeEats</div>
                <p class="footer-description">Making healthy eating simple and delicious with personalized meal plans and premium ingredients.</p>
            </div>
            
            <div class="footer-section">
                <h3>Menu</h3>
                <ul>
                    <li><a href="#">Home</a></li>
                    <li><a href="#">Blog</a></li>
                    <li><a href="#">FAQ</a></li>
                    <li><a href="#">Contact</a></li>
                </ul>
            </div>
            
            <div class="footer-section">
                <h3>About</h3>
                <ul>
                    <li><a href="#">Our Story</a></li>
                    <li><a href="#">Team</a></li>
                    <li><a href="#">Careers</a></li>
                    <li><a href="#">Press</a></li>
                </ul>
            </div>
            
            <div class="footer-section newsletter">
                <h3>Subscribe to Our Newsletter</h3>
                <p>Get weekly meal inspiration and health tips.</p>
                <input type="email" placeholder="Your email address">
                <button>Subscribe</button>
            </div>
        </div>
        
        <div class="footer-bottom">
            <a href="#">Privacy Policy</a>
            <a href="#">Terms of Service</a>
            <a href="#">Accessibility</a>
        </div>
    </footer>
</body>
</html>