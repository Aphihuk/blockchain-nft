<?php
require_once __DIR__ . '/auth/auth_guard.php';
$userName  = htmlspecialchars($_SESSION['displayName'] ?? 'User');
$userEmail = htmlspecialchars($_SESSION['email'] ?? '');
$userPhoto = htmlspecialchars($_SESSION['photoUrl'] ?? '');
$initials  = strtoupper(substr($userName, 0, 1));
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificate Pricing - NFT Gallery</title>
    <link
        href="https://fonts.googleapis.com/css2?family=Space+Mono:wght@400;700&family=Syne:wght@400;700;800&family=Outfit:wght@300;400;600;700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="./css/index.css">
    <link rel="stylesheet" href="./css/auth.css">
    <style>
        .pricing-container {
            max-width: 1200px;
            margin: 80px auto 40px;
            padding: 0 20px;
        }

        .pricing-header {
            text-align: center;
            margin-bottom: 60px;
        }

        .pricing-header h1 {
            font-size: 3rem;
            font-weight: 800;
            margin-bottom: 20px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .pricing-header p {
            font-size: 1.2rem;
            color: #64748b;
            max-width: 600px;
            margin: 0 auto;
        }

        .pricing-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 30px;
            margin-bottom: 60px;
        }

        .pricing-card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            padding: 40px 30px;
            position: relative;
            transition: all 0.3s ease;
        }

        .pricing-card:hover {
            transform: translateY(-10px);
            border-color: rgba(167, 139, 250, 0.4);
            box-shadow: 0 20px 40px rgba(167, 139, 250, 0.2);
        }

        .pricing-card.featured {
            border-color: rgba(167, 139, 250, 0.6);
            background: rgba(167, 139, 250, 0.1);
        }

        .pricing-card.featured::before {
            content: "POPULAR";
            position: absolute;
            top: -12px;
            left: 50%;
            transform: translateX(-50%);
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 8px 20px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 700;
        }

        .plan-name {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 10px;
            color: #f8fafc;
        }

        .plan-description {
            color: #94a3b8;
            margin-bottom: 30px;
            font-size: 1rem;
        }

        .plan-price {
            font-size: 3rem;
            font-weight: 800;
            color: #f8fafc;
            margin-bottom: 10px;
        }

        .plan-price span {
            font-size: 1rem;
            color: #94a3b8;
            font-weight: 400;
        }

        .plan-features {
            list-style: none;
            padding: 0;
            margin: 30px 0;
        }

        .plan-features li {
            padding: 12px 0;
            color: #cbd5e1;
            display: flex;
            align-items: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }

        .plan-features li:last-child {
            border-bottom: none;
        }

        .plan-features i {
            color: #10b981;
            margin-right: 12px;
            font-size: 1.1rem;
        }

        .plan-features i.fa-times {
            color: #ef4444;
        }

        .btn-select-plan {
            width: 100%;
            padding: 16px 24px;
            border: none;
            border-radius: 12px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
            text-align: center;
        }

        .btn-select-plan.primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .btn-select-plan.primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(167, 139, 250, 0.3);
        }

        .btn-select-plan.secondary {
            background: rgba(255, 255, 255, 0.1);
            color: #f8fafc;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .btn-select-plan.secondary:hover {
            background: rgba(255, 255, 255, 0.2);
        }

        .comparison-table {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            padding: 40px;
            margin-bottom: 60px;
            overflow-x: auto;
        }

        .comparison-table h2 {
            text-align: center;
            margin-bottom: 40px;
            font-size: 2rem;
            color: #f8fafc;
        }

        .comparison-table table {
            width: 100%;
            border-collapse: collapse;
        }

        .comparison-table th,
        .comparison-table td {
            padding: 16px;
            text-align: left;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            color: #cbd5e1;
        }

        .comparison-table th {
            font-weight: 700;
            color: #f8fafc;
            background: rgba(167, 139, 250, 0.1);
        }

        .comparison-table i {
            font-size: 1.2rem;
        }

        .comparison-table .fa-check {
            color: #10b981;
        }

        .comparison-table .fa-times {
            color: #ef4444;
        }

        .faq-section {
            margin-bottom: 60px;
        }

        .faq-section h2 {
            text-align: center;
            margin-bottom: 40px;
            font-size: 2rem;
            color: #f8fafc;
        }

        .faq-item {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            margin-bottom: 20px;
            overflow: hidden;
        }

        .faq-question {
            padding: 20px 30px;
            cursor: pointer;
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: #f8fafc;
            font-weight: 600;
            transition: background 0.3s ease;
        }

        .faq-question:hover {
            background: rgba(167, 139, 250, 0.1);
        }

        .faq-answer {
            padding: 0 30px 20px;
            color: #94a3b8;
            display: none;
            line-height: 1.6;
        }

        .faq-item.active .faq-answer {
            display: block;
        }

        .faq-item.active .faq-question i {
            transform: rotate(180deg);
        }

        .faq-question i {
            transition: transform 0.3s ease;
        }

        @media (max-width: 768px) {
            .pricing-header h1 {
                font-size: 2rem;
            }
            
            .pricing-cards {
                grid-template-columns: 1fr;
            }
            
            .comparison-table {
                padding: 20px;
            }
        }
    </style>
</head>

<body>
    <!-- User info strip -->
    <div id="userBar" style="
      position:fixed; top:0; left:0; right:0; z-index:9999;
      background:rgba(10,10,15,0.85); backdrop-filter:blur(16px);
      border-bottom:1px solid rgba(255,255,255,0.07);
      display:flex; align-items:center; justify-content:flex-end;
      gap:.75rem; padding:.55rem 1.5rem;
      font-family:'Inter',sans-serif; font-size:.85rem; color:rgba(241,245,249,.65);
    ">
      <?php if ($userPhoto): ?>
        <img src="<?= $userPhoto ?>" alt="avatar"
             style="width:28px;height:28px;border-radius:50%;object-fit:cover;border:2px solid rgba(167,139,250,.4);">
      <?php else: ?>
        <div class="user-avatar" style="width:28px;height:28px;font-size:.75rem;"><?= $initials ?></div>
      <?php endif; ?>
      <span><?= $userName ?></span>
      <span style="color:rgba(255,255,255,.2);">|</span>
      <a href="/auth/logout.php"
         style="color:#f87171;text-decoration:none;font-weight:600;transition:color .2s;"
         onmouseover="this.style.color='#fca5a5'" onmouseout="this.style.color='#f87171'"
         id="logoutLink">Sign out</a>
    </div>

    <div class="pricing-container">
        <div class="pricing-header">
            <h1>Certificate Pricing Plans</h1>
            <p>Choose the perfect plan for creating professional blockchain-verified certificates and badges</p>
        </div>

        <div class="pricing-cards">
            <!-- Basic Plan -->
            <div class="pricing-card">
                <div class="plan-name">Basic</div>
                <div class="plan-description">Perfect for individuals and small projects</div>
                <div class="plan-price">$5<span>/certificate</span></div>
                <ul class="plan-features">
                    <li><i class="fas fa-check"></i> Standard certificate design</li>
                    <li><i class="fas fa-check"></i> Blockchain verification</li>
                    <li><i class="fas fa-check"></i> IPFS storage</li>
                    <li><i class="fas fa-check"></i> Email delivery</li>
                    <li><i class="fas fa-check"></i> 30-day validity</li>
                    <li><i class="fas fa-times"></i> Custom branding</li>
                    <li><i class="fas fa-times"></i> Priority support</li>
                    <li><i class="fas fa-times"></i> Bulk creation</li>
                </ul>
                <a href="/learnnbadge-ui.php?plan=basic" class="btn-select-plan secondary">Choose Basic</a>
            </div>

            <!-- Professional Plan -->
            <div class="pricing-card featured">
                <div class="plan-name">Professional</div>
                <div class="plan-description">Ideal for educational institutions and businesses</div>
                <div class="plan-price">$15<span>/certificate</span></div>
                <ul class="plan-features">
                    <li><i class="fas fa-check"></i> Premium certificate designs</li>
                    <li><i class="fas fa-check"></i> Blockchain verification</li>
                    <li><i class="fas fa-check"></i> IPFS storage</li>
                    <li><i class="fas fa-check"></i> Email & SMS delivery</li>
                    <li><i class="fas fa-check"></i> Lifetime validity</li>
                    <li><i class="fas fa-check"></i> Custom branding</li>
                    <li><i class="fas fa-check"></i> Priority support</li>
                    <li><i class="fas fa-times"></i> Bulk creation</li>
                </ul>
                <a href="/learnnbadge-ui.php?plan=professional" class="btn-select-plan primary">Choose Professional</a>
            </div>

            <!-- Enterprise Plan -->
            <div class="pricing-card">
                <div class="plan-name">Enterprise</div>
                <div class="plan-description">For large organizations with high volume needs</div>
                <div class="plan-price">$50<span>/certificate</span></div>
                <ul class="plan-features">
                    <li><i class="fas fa-check"></i> Custom certificate designs</li>
                    <li><i class="fas fa-check"></i> Blockchain verification</li>
                    <li><i class="fas fa-check"></i> IPFS storage</li>
                    <li><i class="fas fa-check"></i> Multi-channel delivery</li>
                    <li><i class="fas fa-check"></i> Lifetime validity</li>
                    <li><i class="fas fa-check"></i> Full custom branding</li>
                    <li><i class="fas fa-check"></i> 24/7 dedicated support</li>
                    <li><i class="fas fa-check"></i> Bulk creation tools</li>
                </ul>
                <a href="/learnnbadge-ui.php?plan=enterprise" class="btn-select-plan secondary">Choose Enterprise</a>
            </div>
        </div>

        <!-- Comparison Table -->
        <div class="comparison-table">
            <h2>Detailed Comparison</h2>
            <table>
                <thead>
                    <tr>
                        <th>Feature</th>
                        <th>Basic</th>
                        <th>Professional</th>
                        <th>Enterprise</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Price per Certificate</td>
                        <td>$5</td>
                        <td>$15</td>
                        <td>$50</td>
                    </tr>
                    <tr>
                        <td>Design Templates</td>
                        <td>5 Basic</td>
                        <td>15 Premium</td>
                        <td>Unlimited Custom</td>
                    </tr>
                    <tr>
                        <td>Blockchain Verification</td>
                        <td><i class="fas fa-check"></i></td>
                        <td><i class="fas fa-check"></i></td>
                        <td><i class="fas fa-check"></i></td>
                    </tr>
                    <tr>
                        <td>IPFS Storage</td>
                        <td><i class="fas fa-check"></i></td>
                        <td><i class="fas fa-check"></i></td>
                        <td><i class="fas fa-check"></i></td>
                    </tr>
                    <tr>
                        <td>Custom Branding</td>
                        <td><i class="fas fa-times"></i></td>
                        <td><i class="fas fa-check"></i></td>
                        <td><i class="fas fa-check"></i></td>
                    </tr>
                    <tr>
                        <td>Bulk Creation</td>
                        <td><i class="fas fa-times"></i></td>
                        <td><i class="fas fa-times"></i></td>
                        <td><i class="fas fa-check"></i></td>
                    </tr>
                    <tr>
                        <td>Support Level</td>
                        <td>Email</td>
                        <td>Priority</td>
                        <td>24/7 Dedicated</td>
                    </tr>
                    <tr>
                        <td>Validity Period</td>
                        <td>30 days</td>
                        <td>Lifetime</td>
                        <td>Lifetime</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- FAQ Section -->
        <div class="faq-section">
            <h2>Frequently Asked Questions</h2>
            
            <div class="faq-item">
                <div class="faq-question" onclick="toggleFAQ(this)">
                    <span>What is included in each certificate?</span>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="faq-answer">
                    Each certificate includes blockchain verification, IPFS storage for metadata, and a unique token ID. Higher tiers include additional features like custom branding, premium designs, and enhanced delivery options.
                </div>
            </div>

            <div class="faq-item">
                <div class="faq-question" onclick="toggleFAQ(this)">
                    <span>Can I upgrade my plan later?</span>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="faq-answer">
                    Yes, you can upgrade your plan at any time. When upgrading, you'll only pay the difference in price for certificates created under the new plan.
                </div>
            </div>

            <div class="faq-item">
                <div class="faq-question" onclick="toggleFAQ(this)">
                    <span>How long are certificates valid?</span>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="faq-answer">
                    Basic certificates are valid for 30 days, while Professional and Enterprise certificates have lifetime validity. All certificates remain permanently on the blockchain regardless of plan.
                </div>
            </div>

            <div class="faq-item">
                <div class="faq-question" onclick="toggleFAQ(this)">
                    <span>What payment methods are accepted?</span>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="faq-answer">
                    We accept cryptocurrency payments (ETH, USDC, DAI) and traditional payment methods (credit cards, PayPal) for Professional and Enterprise plans.
                </div>
            </div>

            <div class="faq-item">
                <div class="faq-question" onclick="toggleFAQ(this)">
                    <span>Is there a refund policy?</span>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="faq-answer">
                    We offer a 7-day money-back guarantee for all plans. If you're not satisfied with your certificate, contact our support team for a full refund.
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleFAQ(element) {
            const faqItem = element.parentElement;
            const allItems = document.querySelectorAll('.faq-item');
            
            // Close all other items
            allItems.forEach(item => {
                if (item !== faqItem) {
                    item.classList.remove('active');
                }
            });
            
            // Toggle current item
            faqItem.classList.toggle('active');
        }

        // Add smooth scroll behavior
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth' });
                }
            });
        });
    </script>
</body>

</html>
