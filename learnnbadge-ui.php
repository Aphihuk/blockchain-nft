<!DOCTYPE html>
<html lang="lo">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ອອກໃບຢັ້ງຢືນ FNT</title>
  <link
    href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700;800&family=Space+Mono:wght@400;700&display=swap"
    rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
  <link rel="stylesheet" href="./css/Contract.css">
  <style>

  </style>
</head>

<body>
  <div class="wrap">

    <header>
      <div class="logo">
        <span class="badge-icon">ອອກໃບຢັ້ງຢືນ</span>FNT<span class="accent"></span>
        <button id="pinataBtn" onclick="openPinataModal()">Connect Pinata API</button>
      </div>
      <button id="walletBtn" onclick="connectWallet()">🦊 Connect Wallet</button>
    </header>

    <div id="heroSection">
      <div class="hero">
        <h1>ອອກໃບຢັ້ງຢືນ<br><span class="grad">NFT</span></h1>
        <p>ຍົກລະດັບຄວາມປອດພັຍອອກໃບຢັ້ງຢືນໃນໂລກ blockchain</p>
        <button class="btn-primary" onclick="connectWallet()">🦊 Connect MetaMask</button>
        <!-- <button class="btn-secondary" onclick="scrollToDemo()">ເບີ່ງຕົວຢາງ
        </button> -->
      </div>
    </div>


    <div id="appSection" style="display:none;">


      <div style="padding:2rem 2rem 0;max-width:1100px;margin:0 auto;">
        <div class="tabs">
          <button class="tab active" onclick="switchTab('my')">ໃບຍັນຍືນ</button>
          <button class="tab" onclick="switchTab('mint')" id="mintTab">⚡ ອອກໃບຢັ້ງຢືນ</button>
        </div>
      </div>


      <div id="tabMy" class="section">
        <div class="section-title">ໃບຢັ້ງຢືນທັງໝົດ</div>
        <div class="section-sub">NFT on LabChain</div>

        <div class="stats-bar">
          <div class="stat-card">
            <div class="num" id="myBadgeCount">0</div>
            <div class="lbl">ໃບຢັ້ງຢືນທີ່ມີຢູ່</div>
          </div>
          <div class="stat-card">
            <div class="num" style="color:var(--accent2)" id="totalMinted">—</div>
            <div class="lbl">ໃບຢັ້ງຢືນທັງໝົດທີ່ອອກ</div>
          </div>
          <div class="stat-card">
            <div class="num" style="color:var(--gold)">LabChain</div>
            <div class="lbl">Network</div>
          </div>
        </div>

        <div id="status"></div>
        <div id="badgeGrid" class="badge-grid"></div>
      </div>


      <div id="tabMint" class="section" style="display:none;">
        <div class="section-title">ອອກໃບຢັ້ງຢືນໃໝ່</div>
        <div class="section-sub"> ສະເພາະ admin/owner ເທົ່ານັ້ນທີ່ມີສິດ</div>
        
        <!-- Pricing Plan Display -->
        <div id="selectedPlan" style="display:none; background: rgba(167, 139, 250, 0.1); border: 1px solid rgba(167, 139, 250, 0.3); border-radius: 12px; padding: 20px; margin-bottom: 2rem;">
          <div style="display: flex; justify-content: space-between; align-items: center;">
            <div>
              <div style="font-size: 1.2rem; font-weight: 600; color: #f8fafc; margin-bottom: 5px;">
                <i class="fas fa-crown" style="color: #fbbf24;"></i> 
                <span id="planName">Selected Plan</span>
              </div>
              <div style="color: #94a3b8; font-size: 0.9rem;" id="planDescription">Plan description</div>
            </div>
            <div style="text-align: right;">
              <div style="font-size: 2rem; font-weight: 700; color: #f8fafc;" id="planPrice">$0</div>
              <div style="color: #94a3b8; font-size: 0.8rem;">per certificate</div>
            </div>
          </div>
        </div>

        <div class="mint-form">

          <div style="margin-bottom:1.4rem;">
            <div class="badge-presets-title">
              ຕົວເລືອກໃບຢັ້ງຢືນ (Quick Presets)
            </div>
            <div class="badge-presets">
              <button class="preset-btn" onclick="fillPreset('Blockchain Beginner','ຜ່ານການຮຽນຮູ້ Blockchain')">🔗
                Blockchain Beginner</button>
              <button class="preset-btn" onclick="fillPreset('Smart Contract Dev','ຂຽນ Smart Contract ສຳເລັດ')">⚡
                Smart Contract</button>
              <button class="preset-btn" onclick="fillPreset('Web3 Explorer','ຮຽນຮູ້ Web3 ຄົບທຸກດ້ານ')">🌐 Web3
                Explorer</button>
              <button class="preset-btn" onclick="fillPreset('Hackathon Winner','ຊະນະການແຂ່ງຂັນ Blockchain')">🏆
                Hackathon Winner</button>
            </div>
          </div>

          <div class="form-group">
            <label>Wallet Address</label>
            <input type="text" id="mintTo" placeholder="0x..." />
          </div>
          <div class="form-group">
            <label>Name ໃບຍັນຍືນ</label>
            <input type="text" id="mintName" placeholder="ຕົວຢ່າງ Blockchain Beginner" />
          </div>
          <div class="form-group">
            <label>ຄຳອະທິບາຍ</label>
            <textarea id="mintActivity" placeholder="ຕົວຢ່າງ ຜ່ານການຮຽນຮູ້ Blockchain "></textarea>
          </div>

          <div class="form-group">
            <label>Upload Image</label>
            <input type="file" name="file" id="file" class="inputfile" accept="image/*" />
            <label for="file"><i class="fas fa-upload"></i> <span>Choose a file</span></label>
            <button onclick="uploadAll()" style="margin-left:0.5rem;">⬆ Upload Image</button>
            <div id="uploadProgress">⏳ Uploading...</div>
            <div id="uploadResult"></div>
            <button id="copyUriBtn" onclick="copyUri()">📋 Copy URL</button>
          </div>

          <div class="form-group">
            <label>Image/Metadata URI (IPFS ro URL)</label>
            <input type="text" id="mintURI" placeholder="ipfs://... ro https://... (auto-fill on upload)" />
          </div>

          <button class="submit-btn" id="mintBtn" onclick="mintBadge()">
            Mint ຢັ້ງຢືນ
          </button>

          <div id="mintStatus"></div>


        </div>
      </div>

    </div>

    <div id="modal" onclick="closeModal(event)">
      <div class="modal-inner">
        <div class="modal-img" id="modalImgWrap">🎓</div>
        <div class="modal-body">
          <div class="modal-badge-name" id="modalName"></div>
          <div class="modal-activity" id="modalActivity"></div>
          <div class="modal-meta" id="modalMeta"></div>
          <button class="modal-close" onclick="document.getElementById('modal').classList.remove('open')">✕
            close</button>
        </div>
      </div>
    </div>


    <div id="pinataModal" onclick="closePinataModalOutside(event)">
      <div class="pinata-inner">
        <h3>🔑 Pinata API JWT</h3>
        <p>ໃສ່ JWT ສໍາລັບ upload ຮູບຂຶ້ນ IPFS ຜ່ານ Pinata</p>
        <input type="text" id="jwtInput" placeholder="eyJhbGciOi..." />
        <div id="pinataStatus"></div>
        <div class="pinata-row">
          <button class="btn-save" onclick="saveJWT()">Save JWT</button>
          <button class="btn-clear" onclick="clearJWT()">Clear</button>
        </div>
        <button class="btn-cancel" onclick="closePinataModal()" style="padding:0.5rem;">✕ close</button>
      </div>
    </div>

    <div class="toast" id="toast"></div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/ethers/6.7.0/ethers.umd.min.js"></script>
    <script src="./script/index_LABChain.js"></script>
    <script src="./script/contract_address_LABChain.js"></script>
    
    <script>
        // Pricing plan configuration
        const pricingPlans = {
            basic: {
                name: 'Basic Plan',
                description: 'Perfect for individuals and small projects',
                price: '$5',
                features: ['Standard designs', 'Blockchain verification', 'IPFS storage', 'Email delivery']
            },
            professional: {
                name: 'Professional Plan',
                description: 'Ideal for educational institutions and businesses',
                price: '$15',
                features: ['Premium designs', 'Custom branding', 'Priority support', 'Lifetime validity']
            },
            enterprise: {
                name: 'Enterprise Plan',
                description: 'For large organizations with high volume needs',
                price: '$50',
                features: ['Custom designs', 'Bulk creation', '24/7 support', 'Full customization']
            }
        };

        // Detect and display selected plan from URL
        function detectSelectedPlan() {
            const urlParams = new URLSearchParams(window.location.search);
            const plan = urlParams.get('plan');
            
            if (plan && pricingPlans[plan]) {
                const planInfo = pricingPlans[plan];
                const planDisplay = document.getElementById('selectedPlan');
                const planName = document.getElementById('planName');
                const planDescription = document.getElementById('planDescription');
                const planPrice = document.getElementById('planPrice');
                
                planDisplay.style.display = 'block';
                planName.textContent = planInfo.name;
                planDescription.textContent = planInfo.description;
                planPrice.textContent = planInfo.price;
                
                // Show notification
                showToast(`${planInfo.name} selected - ${planInfo.price} per certificate`, 'success');
                
                // Auto-switch to mint tab
                setTimeout(() => {
                    switchTab('mint');
                }, 1000);
            }
        }

        // Enhanced mint function with pricing integration
        function mintBadge() {
            const urlParams = new URLSearchParams(window.location.search);
            const plan = urlParams.get('plan');
            
            if (!plan) {
                showToast('Please select a pricing plan first', 'warning');
                window.location.href = '/pricing.php';
                return;
            }
            
            // Call original mint function
            if (typeof originalMintBadge === 'function') {
                originalMintBadge();
            } else {
                // Fallback mint logic
                const mintTo = document.getElementById('mintTo').value;
                const mintName = document.getElementById('mintName').value;
                const mintActivity = document.getElementById('mintActivity').value;
                const mintURI = document.getElementById('mintURI').value;
                
                if (!mintTo || !mintName || !mintURI) {
                    showToast('Please fill in all required fields', 'error');
                    return;
                }
                
                // Proceed with minting
                console.log('Minting with plan:', plan);
                // Add your original minting logic here
            }
        }

        // Initialize plan detection on page load
        document.addEventListener('DOMContentLoaded', function() {
            detectSelectedPlan();
            
            // Store original mint function if it exists
            if (typeof window.mintBadge === 'function') {
                window.originalMintBadge = window.mintBadge;
            }
            
            // Override mint function
            window.mintBadge = mintBadge;
        });

        // Toast notification function (if not already defined)
        function showToast(message, type = 'info') {
            const toast = document.getElementById('toast');
            if (toast) {
                toast.textContent = message;
                toast.className = `toast show ${type}`;
                setTimeout(() => {
                    toast.className = 'toast';
                }, 3000);
            }
        }
    </script>

  </div>
</body>

</html>