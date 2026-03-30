<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Miksusu - Susunya siapa? Ya Miksusu!</title>
    <meta name="description" content="Miksusu - Fresh milk specialist. Nikmati kelezatan susu murni racikan spesial dengan bahan premium dan gula asli. Pesan sekarang via WhatsApp!">
    <link rel="icon" type="image/png" href="{{ asset('storage/logo.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('storage/logo.png') }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('storage/logo.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,400;0,500;0,600;0,700;0,800;1,400;1,700;1,800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        [x-cloak] { display: none !important; }

        * { font-family: 'Plus Jakarta Sans', sans-serif; }

        /* ========== ANIMATED BACKGROUND ========== */
        .hero-bg {
            background: linear-gradient(135deg, #fff5f5 0%, #fee2e2 25%, #fef2f2 50%, #fff5f5 75%, #fecaca33 100%);
            position: relative;
            overflow: hidden;
        }
        .hero-bg::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle at 30% 40%, rgba(239, 68, 68, 0.06) 0%, transparent 50%),
                        radial-gradient(circle at 70% 60%, rgba(220, 38, 38, 0.04) 0%, transparent 50%),
                        radial-gradient(circle at 50% 80%, rgba(248, 113, 113, 0.05) 0%, transparent 50%);
            animation: floatBg 20s ease-in-out infinite;
        }
        @keyframes floatBg {
            0%, 100% { transform: translate(0, 0) rotate(0deg); }
            33% { transform: translate(30px, -20px) rotate(1deg); }
            66% { transform: translate(-20px, 20px) rotate(-1deg); }
        }

        /* ========== FLOATING EMOJIS ========== */
        .float-emoji {
            position: absolute;
            animation: floatUp 6s ease-in-out infinite;
            opacity: 0.15;
            font-size: 2rem;
            pointer-events: none;
            z-index: 1;
        }
        .float-emoji:nth-child(1) { left: 5%; top: 20%; animation-delay: 0s; animation-duration: 7s; }
        .float-emoji:nth-child(2) { left: 15%; top: 60%; animation-delay: 1s; animation-duration: 5s; }
        .float-emoji:nth-child(3) { right: 10%; top: 30%; animation-delay: 2s; animation-duration: 8s; }
        .float-emoji:nth-child(4) { right: 20%; top: 70%; animation-delay: 0.5s; animation-duration: 6s; }
        .float-emoji:nth-child(5) { left: 40%; top: 15%; animation-delay: 3s; animation-duration: 9s; }
        .float-emoji:nth-child(6) { right: 35%; top: 80%; animation-delay: 1.5s; animation-duration: 7s; }
        @keyframes floatUp {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-25px) rotate(10deg); }
        }

        /* ========== GLASSMORPHISM CARD ========== */
        .glass-card {
            background: rgba(255, 255, 255, 0.75);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.5);
            transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
        }
        .glass-card:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: 0 25px 50px -12px rgba(220, 38, 38, 0.15),
                        0 0 0 1px rgba(220, 38, 38, 0.08);
        }

        /* ========== IMAGE SHINE EFFECT ========== */
        .img-shine {
            position: relative;
            overflow: hidden;
        }
        .img-shine::after {
            content: '';
            position: absolute;
            top: -50%;
            left: -60%;
            width: 50%;
            height: 200%;
            background: linear-gradient(to right, transparent, rgba(255,255,255,0.25), transparent);
            transform: rotate(25deg);
            transition: 0.6s;
            pointer-events: none;
        }
        .glass-card:hover .img-shine::after {
            left: 130%;
        }

        /* ========== PRICE TAG ========== */
        .price-tag {
            background: linear-gradient(135deg, #ef4444, #dc2626);
            color: white;
            padding: 4px 12px;
            border-radius: 20px;
            font-weight: 800;
            font-size: 0.85rem;
            display: inline-block;
            box-shadow: 0 4px 12px rgba(220, 38, 38, 0.3);
        }

        /* ========== CART BUTTON BOUNCE ========== */
        @keyframes cartBounce {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.15); }
        }
        .cart-bounce {
            animation: cartBounce 0.4s ease;
        }

        /* ========== BOTTOM BAR ========== */
        .bottom-bar {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            box-shadow: 0 -8px 30px rgba(220, 38, 38, 0.3);
        }

        /* ========== SCROLLBAR ========== */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: #fef2f2; }
        ::-webkit-scrollbar-thumb { background: #fca5a5; border-radius: 50px; }
        ::-webkit-scrollbar-thumb:hover { background: #f87171; }

        /* ========== PULSE DOT ========== */
        @keyframes pulseDot {
            0% { box-shadow: 0 0 0 0 rgba(220, 38, 38, 0.5); }
            70% { box-shadow: 0 0 0 10px rgba(220, 38, 38, 0); }
            100% { box-shadow: 0 0 0 0 rgba(220, 38, 38, 0); }
        }
        .pulse-dot { animation: pulseDot 2s infinite; }

        /* ========== HERO LOGO FLOAT ========== */
        @keyframes logoFloat {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-12px); }
        }
        .logo-float { animation: logoFloat 4s ease-in-out infinite; }

        /* ========== ORBIT RINGS ========== */
        @keyframes orbitSpin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        .orbit-ring { animation: orbitSpin 20s linear infinite; }
        .orbit-ring-reverse { animation: orbitSpin 25s linear infinite reverse; }

        /* ========== WAVE SEPARATOR ========== */
        .wave-sep {
            position: absolute;
            bottom: -1px;
            left: 0;
            width: 100%;
            overflow: hidden;
            line-height: 0;
        }
        .wave-sep svg {
            display: block;
            width: 100%;
            height: 60px;
        }

        /* ========== HEADER GLASS ========== */
        .header-glass {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(220, 38, 38, 0.08);
        }

        /* ========== SPARKLE ========== */
        @keyframes sparkle {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.5; transform: scale(0.8); }
        }
        .sparkle { animation: sparkle 2s ease-in-out infinite; }

        /* ========== ADD TO CART BUTTON ========= */
        .btn-add {
            background: linear-gradient(135deg, #1e1b4b, #312e81);
            transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
        }
        .btn-add:hover {
            background: linear-gradient(135deg, #ef4444, #dc2626);
            transform: scale(1.05);
            box-shadow: 0 8px 25px rgba(220, 38, 38, 0.3);
        }
        .btn-add:active {
            transform: scale(0.95);
        }

        /* ========== QTY CONTROLS ========== */
        .qty-controls {
            background: linear-gradient(135deg, #fef2f2, #fee2e2);
            border: 2px solid #fca5a5;
        }

        /* ========== CHECKOUT BUTTON ========== */
        .btn-checkout {
            background: linear-gradient(135deg, #22c55e, #16a34a);
            transition: all 0.3s ease;
        }
        .btn-checkout:hover {
            background: linear-gradient(135deg, #16a34a, #15803d);
            box-shadow: 0 10px 30px rgba(34, 197, 94, 0.3);
        }
        .btn-checkout:active { transform: scale(0.97); }
        .btn-checkout.disabled-btn {
            background: linear-gradient(135deg, #d1d5db, #9ca3af);
            cursor: not-allowed;
            opacity: 0.7;
        }

        /* ========== BADGE ANIMATION ========== */
        @keyframes badgePop {
            0% { transform: translate(33%, -33%) scale(0.5); }
            50% { transform: translate(33%, -33%) scale(1.2); }
            100% { transform: translate(33%, -33%) scale(1); }
        }
        .badge-pop { animation: badgePop 0.3s ease-out; }

        /* ========== SECTION PATTERN ========== */
        .section-pattern {
            background-color: #fffbf9;
            background-image:
                radial-gradient(circle at 25% 25%, rgba(239, 68, 68, 0.03) 0%, transparent 50%),
                radial-gradient(circle at 75% 75%, rgba(220, 38, 38, 0.03) 0%, transparent 50%);
        }
    </style>
</head>
<body class="section-pattern antialiased text-gray-900 pb-20 md:pb-0"
      x-data="{
          cart: [],
          isCartOpen: false,
          isCheckoutOpen: false,
          customerName: '',
          selectedAdmin: '',
          paymentMethod: '',
          deliveryMethod: '',
          adminList: [
              { nama: 'Admin 1 - Sari', wa: '6289617377022' },
              { nama: 'Admin 2 - Dewi', wa: '6281234567891' },
              { nama: 'Admin 3 - Rina', wa: '6281234567892' },
              { nama: 'Admin 4 - Ayu', wa: '6281234567893' },
              { nama: 'Admin 5 - Fitri', wa: '6281234567894' },
              { nama: 'Admin 6 - Lina', wa: '6281234567895' },
          ],

          formatRupiah(angka) {
              return 'Rp ' + new Intl.NumberFormat('id-ID').format(angka);
          },

          getItemQty(id) {
              let item = this.cart.find(i => i.id === id);
              return item ? item.qty : 0;
          },

          addToCart(id, nama, harga, foto) {
              let item = this.cart.find(i => i.id === id);
              if (item) {
                  item.qty++;
              } else {
                  this.cart.push({ id, nama, harga, foto, qty: 1 });
              }
          },
          minQty(id) {
              let item = this.cart.find(i => i.id === id);
              if (item) {
                  if (item.qty > 1) {
                      item.qty--;
                  } else {
                      this.cart = this.cart.filter(i => i.id !== id);
                  }
              }
          },
          get totalItem() {
              return this.cart.reduce((total, item) => total + item.qty, 0);
          },
          get totalPrice() {
              return this.cart.reduce((total, item) => total + (item.harga * item.qty), 0);
          },
          checkoutWA() {
              if(this.cart.length === 0) return;
              if(this.customerName.trim() === '') {
                  $dispatch('notify', 'Boleh isi nama panggilan kamu dulu ya \ud83d\ude0a');
                  document.getElementById('customerName').focus();
                  return;
              }
              this.isCheckoutOpen = true;
          },
          sendToWA() {
              if (!this.selectedAdmin) {
                  $dispatch('notify', 'Pilih admin yang ingin dihubungi ya \ud83d\ude0a');
                  return;
              }
              if (!this.paymentMethod) {
                  $dispatch('notify', 'Pilih metode pembayaran dulu ya \ud83d\udcb3');
                  return;
              }
              if (!this.deliveryMethod) {
                  $dispatch('notify', 'Pilih metode pengambilan dulu ya \ud83d\udce6');
                  return;
              }

              let payLabel = this.paymentMethod === 'qris' ? 'QRIS' : 'Cash';
              let delivLabel = {'cod': 'COD (Bayar di Tempat)', 'ambil': 'Ambil di Tempat', 'antar': 'Antar ke Rumah'}[this.deliveryMethod];

              let text = `Halo Admin *Miksusu*! \nSaya *${this.customerName}* mau pesan:\n\n`;
              this.cart.forEach((item, index) => {
                  text += `${index+1}. ${item.nama} (${item.qty} botol)\n    ${this.formatRupiah(item.harga * item.qty)}\n`;
              });
              text += `\n*Total: ${this.formatRupiah(this.totalPrice)}*\n`;
              text += `\ud83d\udcb3 Pembayaran: *${payLabel}*\n`;
              text += `\ud83d\udce6 Pengambilan: *${delivLabel}*\n\n`;
              text += 'Terima kasih!';

              let url = `https://wa.me/${this.selectedAdmin}?text=${encodeURIComponent(text)}`;
              window.open(url, '_blank');
              this.isCheckoutOpen = false;
          }
      }">

    {{-- ============ TOAST NOTIFICATION ============ --}}
    <div x-data="{ show: false, message: '' }"
         @notify.window="show = true; message = $event.detail; setTimeout(() => show = false, 3000)"
         x-show="show"
         x-transition:enter="transform ease-out duration-300 transition"
         x-transition:enter-start="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
         x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0"
         x-transition:leave="transition ease-in duration-100"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 flex items-end justify-center px-4 py-6 pointer-events-none sm:p-6 sm:items-start sm:justify-end z-[100]" x-cloak>
        <div class="max-w-sm w-full bg-gradient-to-r from-red-500 to-red-600 shadow-2xl rounded-2xl pointer-events-auto ring-1 ring-red-400/30 overflow-hidden">
            <div class="p-4 flex items-center">
                <div class="flex-shrink-0 text-2xl mr-3">🥛</div>
                <p x-text="message" class="text-sm font-bold text-white"></p>
            </div>
        </div>
    </div>

    {{-- ============ HEADER ============ --}}
    <header class="header-glass sticky top-0 z-40 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <div class="relative">
                    <div class="absolute inset-0 bg-gradient-to-br from-red-400 to-red-600 rounded-2xl blur-md opacity-40"></div>
                    <img src="{{ asset('storage/logo.png') }}" alt="Logo Miksusu"
                         class="relative h-12 w-12 object-contain rounded-2xl p-1.5 bg-white shadow-lg ring-2 ring-red-100"
                         onerror="this.src='https://ui-avatars.com/api/?name=M&color=ef4444&background=fee2e2&bold=true'">
                </div>
                <div>
                    <h1 class="font-extrabold text-2xl md:text-3xl tracking-tight leading-none">
                        <span class="bg-gradient-to-r from-red-500 to-red-600 bg-clip-text text-transparent">MIKSUSU</span><span class="text-red-300">.</span>
                    </h1>
                    <p class="text-[9px] text-red-400 font-bold uppercase tracking-[0.2em] mt-0.5">Fresh Milk Specialist 🥛</p>
                </div>
            </div>

            <button @click="isCartOpen = true" id="header-cart-button"
                    class="relative group p-3 bg-white rounded-2xl transition-all hover:shadow-lg hover:shadow-red-100 active:scale-95 border border-red-100">
                <svg class="w-6 h-6 text-red-500 transition-transform group-hover:rotate-[-12deg] group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                </svg>
                <span x-show="totalItem > 0" x-text="totalItem" x-cloak
                      class="badge-pop absolute top-0 right-0 inline-flex items-center justify-center w-5 h-5 text-[10px] font-black leading-none text-white transform translate-x-1/3 -translate-y-1/3 bg-gradient-to-br from-red-500 to-red-600 rounded-full shadow-md pulse-dot"></span>
            </button>
        </div>
    </header>

    {{-- ============ HERO SECTION ============ --}}
    <section class="hero-bg relative pb-28 pt-16 md:pt-20">
        {{-- Floating emojis --}}
        <span class="float-emoji">🥛</span>
        <span class="float-emoji">🍓</span>
        <span class="float-emoji">❤️</span>
        <span class="float-emoji">🧋</span>
        <span class="float-emoji">✨</span>
        <span class="float-emoji">🍫</span>

        <div class="max-w-7xl mx-auto px-4 relative z-10 grid md:grid-cols-5 items-center gap-8 md:gap-12">
            <div class="md:col-span-3 text-center md:text-left">
                <div class="inline-flex items-center px-4 py-2 rounded-full bg-white/70 backdrop-blur-sm text-red-600 text-sm font-bold mb-6 shadow-sm border border-red-100">
                    <span class="sparkle mr-2">✨</span> Fresh dari Peternakan
                    <span class="ml-2 inline-flex items-center justify-center w-5 h-5 bg-green-400 rounded-full">
                        <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                    </span>
                </div>
                <h2 class="text-5xl md:text-7xl font-extrabold mb-6 tracking-tight text-gray-900 leading-[0.95]">
                    Susunya siapa?<br>
                    Ya <span class="bg-gradient-to-r from-red-500 to-red-600 bg-clip-text text-transparent italic">Miksusu</span>! 🥛
                </h2>
                <p class="text-gray-500 text-lg md:text-xl font-medium mb-10 max-w-xl mx-auto md:mx-0 leading-relaxed">
                    Nikmati kelezatan susu murni racikan spesial dengan bahan premium dan gula asli. <span class="text-red-500 font-bold">Segar, lezat, bikin nagih!</span> ❤️
                </p>
                <a href="#katalog"
                   class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-red-500 to-red-600 text-white rounded-2xl font-bold text-lg shadow-lg shadow-red-200 hover:shadow-xl hover:shadow-red-300 transition-all hover:scale-105 active:scale-95">
                    <span class="mr-2">🛒</span> Pesan Sekarang
                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path></svg>
                </a>
            </div>

            {{-- Hero Visual: Logo with decorative circles --}}
            <div class="md:col-span-2 flex justify-center relative">
                <div class="relative w-[280px] h-[280px] md:w-[320px] md:h-[320px]">
                    {{-- Decorative orbit rings --}}
                    <div class="orbit-ring absolute inset-0">
                        <svg class="w-full h-full" viewBox="0 0 320 320" fill="none">
                            <circle cx="160" cy="160" r="155" stroke="#fecaca" stroke-width="1" stroke-dasharray="8 8" opacity="0.6"/>
                            <circle cx="270" cy="80" r="8" fill="#ef4444" opacity="0.3"/>
                            <circle cx="50" cy="240" r="6" fill="#fca5a5" opacity="0.4"/>
                        </svg>
                    </div>
                    <div class="orbit-ring-reverse absolute inset-[-20px]">
                        <svg class="w-full h-full" viewBox="0 0 360 360" fill="none">
                            <circle cx="180" cy="180" r="175" stroke="#fee2e2" stroke-width="1" stroke-dasharray="4 12" opacity="0.5"/>
                            <circle cx="320" cy="180" r="5" fill="#f87171" opacity="0.3"/>
                            <circle cx="40" cy="120" r="7" fill="#fecdd3" opacity="0.5"/>
                        </svg>
                    </div>

                    {{-- Glow background --}}
                    <div class="absolute inset-[15%] bg-gradient-to-br from-red-200 to-red-100 rounded-full blur-2xl opacity-60"></div>

                    {{-- Main circle with logo --}}
                    <div class="logo-float absolute inset-[10%] bg-white rounded-full shadow-2xl shadow-red-200/50 flex items-center justify-center border-4 border-red-100 overflow-hidden">
                        <img src="{{ asset('storage/logo.png') }}" alt="Miksusu Logo"
                             class="w-[65%] h-[65%] object-contain drop-shadow-lg"
                             onerror="this.parentElement.innerHTML='<span class=\'text-7xl\'>🥛</span>'">
                    </div>

                    {{-- Floating decorative elements --}}
                    <div class="absolute top-2 right-8 text-3xl sparkle" style="animation-delay: 0.5s;">🍓</div>
                    <div class="absolute bottom-6 left-4 text-2xl sparkle" style="animation-delay: 1s;">🧋</div>
                    <div class="absolute top-1/2 right-0 text-xl sparkle" style="animation-delay: 1.5s;">✨</div>
                    <div class="absolute bottom-12 right-2 text-2xl sparkle" style="animation-delay: 0.8s;">🥛</div>
                </div>
            </div>
        </div>

        {{-- Wave Separator --}}
        <div class="wave-sep">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 120" preserveAspectRatio="none">
                <path fill="#fffbf9" d="M0,64L48,58.7C96,53,192,43,288,48C384,53,480,75,576,80C672,85,768,75,864,64C960,53,1056,43,1152,42.7C1248,43,1344,53,1392,58.7L1440,64L1440,120L1392,120C1344,120,1248,120,1152,120C1056,120,960,120,864,120C768,120,672,120,576,120C480,120,384,120,288,120C192,120,96,120,48,120L0,120Z"/>
            </svg>
        </div>
    </section>

    {{-- ============ PRODUCT CATALOG ============ --}}
    <main id="katalog" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 md:py-20">
        <div class="text-center mb-14 relative">
            <div class="inline-block">
                <span class="text-sm font-bold text-red-400 uppercase tracking-widest block mb-2">🍓 Our Menu</span>
                <h3 class="text-4xl md:text-5xl font-extrabold text-gray-900 tracking-tight">
                    Menu <span class="bg-gradient-to-r from-red-500 to-red-600 bg-clip-text text-transparent">Istimewa</span>
                </h3>
                <div class="mt-3 mx-auto h-1 w-16 bg-gradient-to-r from-red-400 to-red-500 rounded-full"></div>
            </div>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-6 pb-10">
            @forelse($products as $item)
            <div class="glass-card rounded-3xl overflow-hidden flex flex-col group">
                <div class="h-44 md:h-52 bg-gradient-to-br from-red-50 to-orange-50 relative img-shine">
                    @if($item->foto_url)
                        <img src="{{ asset('storage/' . $item->foto_url) }}" alt="{{ $item->nama }}"
                             class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                    @else
                        <div class="w-full h-full flex flex-col items-center justify-center text-red-300 p-4">
                            <span class="text-4xl mb-2">🥛</span>
                            <span class="text-[10px] font-bold uppercase tracking-wider text-center">No Photo</span>
                        </div>
                    @endif

                    {{-- Floating price tag --}}
                    <div class="absolute top-3 right-3">
                        <div class="price-tag text-xs md:text-sm">
                            Rp {{ number_format($item->harga_saat_ini, 0, ',', '.') }}
                        </div>
                    </div>
                </div>

                <div class="p-4 md:p-5 flex-grow flex flex-col justify-between">
                    <div class="mb-3">
                        <h4 class="font-bold text-gray-800 text-sm md:text-base leading-tight group-hover:text-red-500 transition-colors duration-300">{{ $item->nama }}</h4>
                    </div>

                    <div class="mt-auto pt-3 border-t border-red-100/50 h-[48px] flex items-center justify-end">

                        <button x-show="getItemQty({{ $item->id }}) === 0"
                                @click="addToCart({{ $item->id }}, '{{ addslashes($item->nama) }}', {{ $item->harga_saat_ini }}, '{{ $item->foto_url ? asset('storage/'.$item->foto_url) : '' }}')"
                                class="btn-add w-full py-2.5 text-white rounded-xl font-bold text-xs md:text-sm flex items-center justify-center gap-1.5 cursor-pointer">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                            Tambah
                        </button>

                        <div x-show="getItemQty({{ $item->id }}) > 0" x-cloak
                             class="qty-controls flex items-center justify-between w-full rounded-xl overflow-hidden h-full">
                            <button @click="minQty({{ $item->id }})"
                                    class="h-full px-4 text-red-500 hover:bg-red-200/50 font-black transition-colors active:scale-90 flex items-center justify-center cursor-pointer">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M20 12H4"></path></svg>
                            </button>
                            <span class="font-extrabold text-red-600 text-base flex-1 text-center" x-text="getItemQty({{ $item->id }})"></span>
                            <button @click="addToCart({{ $item->id }}, '{{ addslashes($item->nama) }}', {{ $item->harga_saat_ini }}, '{{ $item->foto_url ? asset('storage/'.$item->foto_url) : '' }}')"
                                    class="h-full px-4 text-white bg-gradient-to-br from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 font-black transition-all active:scale-90 flex items-center justify-center cursor-pointer">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"></path></svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-full text-center py-20">
                <span class="text-6xl block mb-4">🥛</span>
                <p class="text-gray-400 font-bold text-lg">Katalog menu sedang kosong.</p>
                <p class="text-gray-300 text-sm mt-1">Nantikan menu baru dari Miksusu ya!</p>
            </div>
            @endforelse
        </div>
    </main>

    {{-- ============ FLOATING CART BAR (BOTTOM) ============ --}}
    <div x-show="totalItem > 0"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="transform translate-y-full opacity-0"
         x-transition:enter-end="transform translate-y-0 opacity-100"
         x-transition:leave="transition ease-in duration-300"
         x-transition:leave-start="transform translate-y-0 opacity-100"
         x-transition:leave-end="transform translate-y-full opacity-0"
         x-cloak
         class="fixed bottom-4 left-0 right-0 z-40 flex justify-center px-4 pointer-events-none">

        <button @click="isCartOpen = true" id="floating-cart-button"
                class="pointer-events-auto w-full max-w-lg bottom-bar text-white rounded-2xl shadow-2xl p-4 flex items-center justify-between transition-transform active:scale-95 ring-4 ring-white/30 cursor-pointer">
            <div class="flex items-center space-x-4">
                <div class="bg-white/20 backdrop-blur-sm rounded-full w-11 h-11 flex items-center justify-center font-black text-lg border border-white/20">
                    <span x-text="totalItem"></span>
                </div>
                <div class="text-left">
                    <p class="text-[10px] text-red-200 font-bold uppercase tracking-wider mb-0.5">Total Belanja</p>
                    <p class="font-extrabold text-xl leading-none" x-text="formatRupiah(totalPrice)"></p>
                </div>
            </div>
            <div class="flex items-center font-bold bg-white/15 backdrop-blur-sm px-5 py-2.5 rounded-xl border border-white/20">
                Buka 🛒
                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path></svg>
            </div>
        </button>
    </div>

    {{-- ============ FOOTER ============ --}}
    <footer class="bg-gray-950 text-white border-t-4 border-red-500 relative overflow-hidden">
        {{-- Background decorations --}}
        <div class="absolute inset-0 opacity-[0.03]">
            <div class="absolute top-8 left-12 text-6xl">🥛</div>
            <div class="absolute top-16 right-16 text-5xl">💻</div>
            <div class="absolute bottom-12 left-1/4 text-4xl">☁️</div>
            <div class="absolute bottom-8 right-1/4 text-5xl">🍓</div>
        </div>

        <div class="relative z-10 max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- Top: Miksusu × SAT Project --}}
            <div class="py-10 text-center border-b border-gray-800/60">
                <div class="flex items-center justify-center gap-3 md:gap-4 mb-3 flex-wrap">
                    <span class="font-extrabold text-xl md:text-2xl tracking-tight">
                        <span class="bg-gradient-to-r from-red-400 to-red-500 bg-clip-text text-transparent">MIKSUSU</span><span class="text-red-600">.</span>
                    </span>
                    <span class="text-gray-600 text-lg font-light">×</span>
                    <a href="https://satcloud.tech" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 hover:opacity-80 transition-opacity">
                        <img src="{{ asset('storage/logosatcolor.svg') }}" alt="SAT Project" class="h-6 md:h-7 w-auto">
                    </a>
                </div>
                <p class="text-gray-500 text-sm font-medium">Website ini dikembangkan oleh <a href="https://satcloud.tech" target="_blank" class="text-red-400 hover:text-red-300 font-bold transition-colors">SAT Project</a></p>
            </div>

            {{-- Middle: SAT Project Services --}}
            <div class="py-10">
                <div class="text-center mb-8">
                    <p class="text-gray-400 text-xs font-bold uppercase tracking-[0.2em] mb-1">Layanan Kami</p>
                    <h3 class="text-lg md:text-xl font-extrabold text-white">Solusi Digital untuk Bisnis Anda</h3>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    {{-- 1. Software Development --}}
                    <div class="bg-gray-900/60 border border-gray-800/60 rounded-2xl p-5 hover:border-red-500/30 hover:bg-gray-900/80 transition-all group">
                        <div class="w-10 h-10 rounded-xl bg-red-500/10 flex items-center justify-center mb-3 group-hover:bg-red-500/20 transition-colors">
                            <svg class="w-5 h-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path></svg>
                        </div>
                        <h4 class="text-white font-bold text-sm mb-1.5">Software Development</h4>
                        <p class="text-gray-500 text-xs leading-relaxed">Website modern, Web Apps, aplikasi Mobile, dan solusi IoT siap pakai.</p>
                    </div>

                    {{-- 2. IT Support --}}
                    <div class="bg-gray-900/60 border border-gray-800/60 rounded-2xl p-5 hover:border-red-500/30 hover:bg-gray-900/80 transition-all group">
                        <div class="w-10 h-10 rounded-xl bg-red-500/10 flex items-center justify-center mb-3 group-hover:bg-red-500/20 transition-colors">
                            <svg class="w-5 h-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        </div>
                        <h4 class="text-white font-bold text-sm mb-1.5">IT Support & Joki Coding</h4>
                        <p class="text-gray-500 text-xs leading-relaxed">Bantuan tugas kuliah, skripsi, debugging, dan mentoring privat.</p>
                    </div>

                    {{-- 3. Infrastruktur Jaringan --}}
                    <div class="bg-gray-900/60 border border-gray-800/60 rounded-2xl p-5 hover:border-red-500/30 hover:bg-gray-900/80 transition-all group">
                        <div class="w-10 h-10 rounded-xl bg-red-500/10 flex items-center justify-center mb-3 group-hover:bg-red-500/20 transition-colors">
                            <svg class="w-5 h-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"></path></svg>
                        </div>
                        <h4 class="text-white font-bold text-sm mb-1.5">Infrastruktur Jaringan</h4>
                        <p class="text-gray-500 text-xs leading-relaxed">Instalasi CCTV, MikroTik, kabel LAN/Fiber Optic, IPTV & VoIP.</p>
                    </div>

                    {{-- 4. Cloud & Server --}}
                    <div class="bg-gray-900/60 border border-gray-800/60 rounded-2xl p-5 hover:border-red-500/30 hover:bg-gray-900/80 transition-all group">
                        <div class="w-10 h-10 rounded-xl bg-red-500/10 flex items-center justify-center mb-3 group-hover:bg-red-500/20 transition-colors">
                            <svg class="w-5 h-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z"></path></svg>
                        </div>
                        <h4 class="text-white font-bold text-sm mb-1.5">Cloud & Server</h4>
                        <p class="text-gray-500 text-xs leading-relaxed">Hosting, VPS, konfigurasi server, deployment, dan sysadmin.</p>
                    </div>
                </div>

                {{-- CTA Button --}}
                <div class="text-center mt-8">
                    <a href="https://satcloud.tech" target="_blank" rel="noopener noreferrer"
                       class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-red-500 to-red-600 text-white rounded-xl font-bold text-sm shadow-lg shadow-red-500/20 hover:shadow-xl hover:shadow-red-500/30 transition-all hover:scale-105 active:scale-95">
                        <img src="{{ asset('storage/logosatcolor.svg') }}" alt="SAT Project" class="h-4 w-auto brightness-200">
                        Kunjungi SAT Project
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </a>
                </div>
            </div>

            {{-- Bottom: Copyright --}}
            <div class="py-5 border-t border-gray-800/60 text-center pb-20 md:pb-5">
                <p class="text-gray-600 text-xs font-medium">&copy; {{ date('Y') }} Miksusu Store · Tulungagung · Developed by <a href="https://satcloud.tech" target="_blank" class="text-gray-500 hover:text-red-400 transition-colors">SAT Project</a></p>
            </div>
        </div>
    </footer>

    {{-- ============ CART DRAWER (SLIDE-IN) ============ --}}
    <div x-show="isCartOpen" class="relative z-50" x-cloak>
        <div x-show="isCartOpen"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 bg-gray-950/60 backdrop-blur-md" @click="isCartOpen = false"></div>

        <div class="fixed inset-0 overflow-hidden">
            <div class="absolute inset-0 overflow-hidden">
                <div class="pointer-events-none fixed inset-y-0 right-0 flex max-w-full pl-10">
                    <div x-show="isCartOpen"
                         x-transition:enter="transform transition ease-in-out duration-300"
                         x-transition:enter-start="translate-x-full"
                         x-transition:enter-end="translate-x-0"
                         x-transition:leave="transform transition ease-in-out duration-300"
                         x-transition:leave-start="translate-x-0"
                         x-transition:leave-end="translate-x-full"
                         class="pointer-events-auto w-screen max-w-md">
                        <div class="flex h-full flex-col overflow-y-scroll bg-white shadow-2xl rounded-l-[2rem]">

                            {{-- Cart Header --}}
                            <div class="flex-shrink-0 px-6 pt-8 pb-5 border-b border-red-100/50">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h2 class="text-2xl font-extrabold text-gray-900 tracking-tight">Pesanan Kamu</h2>
                                        <p class="text-red-400 text-xs font-bold mt-1" x-show="cart.length > 0">
                                            <span x-text="totalItem"></span> item di keranjang 🛒
                                        </p>
                                    </div>
                                    <button @click="isCartOpen = false" id="close-cart-button"
                                            class="p-2.5 -m-2 text-gray-400 hover:text-red-500 rounded-xl hover:bg-red-50 transition-colors cursor-pointer">
                                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                                    </button>
                                </div>
                            </div>

                            {{-- Cart Items --}}
                            <div class="flex-1 overflow-y-auto px-6 py-6">
                                <div x-show="cart.length === 0" class="text-center py-16">
                                    <span class="text-6xl block mb-4">🛒</span>
                                    <p class="text-gray-400 font-bold">Keranjang masih kosong nih~</p>
                                    <p class="text-gray-300 text-sm mt-1">Yuk pilih menu favorit kamu!</p>
                                </div>

                                <ul role="list" class="space-y-4">
                                    <template x-for="item in cart" :key="item.id">
                                        <li class="flex p-3 bg-gradient-to-r from-red-50/50 to-orange-50/30 rounded-2xl border border-red-100/30 hover:shadow-md transition-shadow">
                                            <div class="h-18 w-18 flex-shrink-0 overflow-hidden rounded-xl bg-white shadow-sm p-1 border border-red-100/50">
                                                <img :src="item.foto || 'https://ui-avatars.com/api/?name=M&color=ef4444&background=fee2e2&bold=true'" class="h-16 w-16 object-cover rounded-lg">
                                            </div>

                                            <div class="ml-4 flex flex-1 flex-col justify-between">
                                                <div class="flex justify-between">
                                                    <h3 x-text="item.nama" class="font-bold text-gray-800 text-sm leading-tight"></h3>
                                                    <p class="ml-3 font-extrabold text-red-500 text-sm whitespace-nowrap" x-text="formatRupiah(item.harga * item.qty)"></p>
                                                </div>
                                                <div class="flex items-center justify-between mt-2">
                                                    <div class="flex items-center bg-white rounded-full border border-red-200 shadow-sm overflow-hidden">
                                                        <button @click="minQty(item.id)" class="px-3 py-1.5 text-red-400 hover:text-red-600 hover:bg-red-50 font-black text-sm transition-colors cursor-pointer">−</button>
                                                        <span class="px-3 font-extrabold text-gray-800 text-sm bg-red-50/50" x-text="item.qty"></span>
                                                        <button @click="addToCart(item.id, item.nama, item.harga, item.foto)" class="px-3 py-1.5 text-red-400 hover:text-red-600 hover:bg-red-50 font-black text-sm transition-colors cursor-pointer">+</button>
                                                    </div>
                                                    <button @click="cart = cart.filter(i => i.id !== item.id)"
                                                            class="font-bold text-red-400 hover:text-red-600 text-[11px] py-1.5 px-3 bg-white hover:bg-red-50 rounded-full border border-red-100 transition-all cursor-pointer">
                                                        Hapus
                                                    </button>
                                                </div>
                                            </div>
                                        </li>
                                    </template>
                                </ul>
                            </div>

                            {{-- Cart Footer --}}
                            <div class="border-t border-red-100 px-6 py-7 bg-gradient-to-b from-red-50/50 to-white rounded-bl-[2rem] flex-shrink-0">
                                <div class="mb-5 p-4 bg-white rounded-2xl border border-red-100 shadow-sm" x-show="cart.length > 0">
                                    <label for="customerName" class="block text-xs font-bold text-gray-700 mb-2">
                                        Nama Pemesan <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" id="customerName" x-model="customerName" placeholder="Panggil kamu siapa nih? 😊"
                                           class="w-full border-red-200 rounded-xl focus:ring-2 focus:ring-red-200 focus:border-red-400 bg-red-50/30 px-4 py-3.5 text-base font-medium placeholder-red-300"
                                           :class="{'border-red-300 ring-2 ring-red-100': cart.length > 0 && customerName.trim() === ''}">
                                </div>

                                <div class="flex justify-between items-end text-base font-medium text-gray-900 mb-5">
                                    <p class="font-bold text-gray-600">Total Tagihan</p>
                                    <p class="text-2xl md:text-3xl font-extrabold bg-gradient-to-r from-red-500 to-red-600 bg-clip-text text-transparent" x-text="formatRupiah(totalPrice)"></p>
                                </div>

                                <button @click="checkoutWA()" id="checkout-button"
                                        :class="(cart.length === 0 || customerName.trim() === '') ? 'disabled-btn' : ''"
                                        class="btn-checkout flex w-full items-center justify-center rounded-2xl px-6 py-4 text-lg font-extrabold text-white cursor-pointer">
                                    <svg class="w-6 h-6 mr-3" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 00-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                                    Lanjut Pesan →
                                </button>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- ============ CHECKOUT MODAL ============ --}}
    <div x-show="isCheckoutOpen" class="fixed inset-0 z-[60]" x-cloak>
        <div x-show="isCheckoutOpen"
             x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
             class="fixed inset-0 bg-gray-950/70 backdrop-blur-md" @click="isCheckoutOpen = false"></div>

        <div class="fixed inset-0 flex items-center justify-center p-4">
            <div x-show="isCheckoutOpen"
                 x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-90"
                 class="bg-white rounded-3xl shadow-2xl w-full max-w-lg max-h-[90vh] overflow-y-auto" @click.away="isCheckoutOpen = false">

                <div class="px-6 pt-6 pb-4 border-b border-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-xl font-extrabold text-gray-900">Konfirmasi Pesanan</h3>
                            <p class="text-sm text-gray-400 font-medium mt-0.5">Lengkapi data sebelum kirim ke WhatsApp</p>
                        </div>
                        <button @click="isCheckoutOpen = false" class="p-2 text-gray-400 hover:text-red-500 hover:bg-red-50 rounded-xl transition-colors cursor-pointer">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>
                </div>

                <div class="px-6 py-5 space-y-6">
                    <div class="bg-red-50/60 rounded-2xl p-4 border border-red-100/60">
                        <div class="flex justify-between items-center">
                            <span class="text-sm font-bold text-gray-600">Total Pesanan</span>
                            <span class="text-xl font-extrabold text-red-600" x-text="formatRupiah(totalPrice)"></span>
                        </div>
                        <p class="text-xs text-gray-400 mt-1">Atas nama: <span class="font-bold text-gray-600" x-text="customerName"></span> &middot; <span x-text="totalItem"></span> item</p>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2.5">📱 Pilih Admin WhatsApp</label>
                        <div class="grid grid-cols-2 gap-2">
                            <template x-for="admin in adminList" :key="admin.wa">
                                <button @click="selectedAdmin = admin.wa" type="button"
                                        :class="selectedAdmin === admin.wa ? 'border-red-500 bg-red-50 ring-2 ring-red-200 text-red-700' : 'border-gray-200 bg-white text-gray-700 hover:border-red-300 hover:bg-red-50/50'"
                                        class="px-3 py-3 rounded-xl border-2 text-sm font-semibold transition-all text-center cursor-pointer">
                                    <span x-text="admin.nama"></span>
                                </button>
                            </template>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2.5">💳 Metode Pembayaran</label>
                        <div class="grid grid-cols-2 gap-2">
                            <button @click="paymentMethod = 'qris'" type="button"
                                    :class="paymentMethod === 'qris' ? 'border-red-500 bg-red-50 ring-2 ring-red-200 text-red-700' : 'border-gray-200 bg-white text-gray-700 hover:border-red-300 hover:bg-red-50/50'"
                                    class="px-4 py-3.5 rounded-xl border-2 font-semibold transition-all flex items-center justify-center gap-2 cursor-pointer">
                                <span class="text-lg">📲</span> <span>QRIS</span>
                            </button>
                            <button @click="paymentMethod = 'cash'" type="button"
                                    :class="paymentMethod === 'cash' ? 'border-red-500 bg-red-50 ring-2 ring-red-200 text-red-700' : 'border-gray-200 bg-white text-gray-700 hover:border-red-300 hover:bg-red-50/50'"
                                    class="px-4 py-3.5 rounded-xl border-2 font-semibold transition-all flex items-center justify-center gap-2 cursor-pointer">
                                <span class="text-lg">💵</span> <span>Cash</span>
                            </button>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2.5">📦 Metode Pengambilan</label>
                        <div class="grid grid-cols-1 gap-2">
                            <button @click="deliveryMethod = 'cod'" type="button"
                                    :class="deliveryMethod === 'cod' ? 'border-red-500 bg-red-50 ring-2 ring-red-200 text-red-700' : 'border-gray-200 bg-white text-gray-700 hover:border-red-300 hover:bg-red-50/50'"
                                    class="px-4 py-3 rounded-xl border-2 font-semibold transition-all flex items-center gap-3 cursor-pointer">
                                <span class="text-lg">🤝</span>
                                <div class="text-left">
                                    <span class="block text-sm">COD (Bayar di Tempat)</span>
                                    <span class="block text-xs font-normal text-gray-400">Bayar saat barang diterima</span>
                                </div>
                            </button>
                            <button @click="deliveryMethod = 'ambil'" type="button"
                                    :class="deliveryMethod === 'ambil' ? 'border-red-500 bg-red-50 ring-2 ring-red-200 text-red-700' : 'border-gray-200 bg-white text-gray-700 hover:border-red-300 hover:bg-red-50/50'"
                                    class="px-4 py-3 rounded-xl border-2 font-semibold transition-all flex items-center gap-3 cursor-pointer">
                                <span class="text-lg">🏪</span>
                                <div class="text-left">
                                    <span class="block text-sm">Ambil di Tempat</span>
                                    <span class="block text-xs font-normal text-gray-400">Ambil langsung di lapak Miksusu</span>
                                </div>
                            </button>
                            <button @click="deliveryMethod = 'antar'" type="button"
                                    :class="deliveryMethod === 'antar' ? 'border-red-500 bg-red-50 ring-2 ring-red-200 text-red-700' : 'border-gray-200 bg-white text-gray-700 hover:border-red-300 hover:bg-red-50/50'"
                                    class="px-4 py-3 rounded-xl border-2 font-semibold transition-all flex items-center gap-3 cursor-pointer">
                                <span class="text-lg">🚚</span>
                                <div class="text-left">
                                    <span class="block text-sm">Antar ke Rumah</span>
                                    <span class="block text-xs font-normal text-gray-400">Diantar langsung ke alamat kamu</span>
                                </div>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="px-6 py-5 border-t border-gray-100 bg-gradient-to-b from-gray-50/50">
                    <button @click="sendToWA()" class="btn-checkout flex w-full items-center justify-center rounded-2xl px-6 py-4 text-base font-extrabold text-white cursor-pointer"
                            :class="(!selectedAdmin || !paymentMethod || !deliveryMethod) ? 'disabled-btn' : ''">
                        <svg class="w-6 h-6 mr-2" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 00-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                        Kirim Pesanan via WhatsApp
                    </button>
                </div>
            </div>
        </div>
    </div>

</body>
</html>