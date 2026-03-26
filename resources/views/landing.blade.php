<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Miksusu - Susunya siapa? Ya Miksusu</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        [x-cloak] { display: none !important; }
        .cow-spots {
            background-color: #f9fafb;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='88' height='24' viewBox='0 0 88 24'%3E%3Cg fill-rule='evenodd'%3E%3Cg id='repeated-bg' fill='%3C#ef4444' fill-opacity='0.03'%3E%3Cpath d='M10 0c3 0 6 2 6 5s-3 5-6 5-6-2-6-5 3-5 6-5zm34 0c3 0 6 2 6 5s-3 5-6 5-6-2-6-5 3-5 6-5zm34 0c3 0 6 2 6 5s-3 5-6 5-6-2-6-5 3-5 6-5zM10 15c3 0 6 2 6 5s-3 5-6 5-6-2-6-5 3-5 6-5zm34 0c3 0 6 2 6 5s-3 5-6 5-6-2-6-5 3-5 6-5zm34 0c3 0 6 2 6 5s-3 5-6 5-6-2-6-5 3-5 6-5z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }
    </style>
</head>
<body class="cow-spots font-sans antialiased text-gray-900 pb-20 md:pb-0" 
      x-data="{
          cart: [],
          isCartOpen: false,
          customerName: '',
          adminWa: '6281234567890', // GANTI DENGAN NOMOR WA ADMIN
          
          formatRupiah(angka) {
              return 'Rp ' + new Intl.NumberFormat('id-ID').format(angka);
          },
          
          // FUNGSI BARU: Mengambil jumlah qty item spesifik
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
              // isCartOpen = true DIHAPUS agar tidak mengganggu saat ngeklik tombol +
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
                  $dispatch('notify', 'Boleh isi nama panggilan kamu dulu ya 😊');
                  document.getElementById('customerName').focus();
                  return;
              }
              
              let text = `Halo Admin *Miksusu*! 👋\nSaya *${this.customerName}* mau pesan orderan berikut:\n\n`;
              this.cart.forEach((item, index) => {
                  text += `${index+1}. ${item.nama} (${item.qty} cup)\n    ${this.formatRupiah(item.harga * item.qty)}\n`;
              });
              text += `\n*Total Pesanan: ${this.formatRupiah(this.totalPrice)}*\n\n`;
              text += 'Mohon info total harganya ya kak. Terima kasih!';
              
              let url = `https://wa.me/${this.adminWa}?text=${encodeURIComponent(text)}`;
              window.open(url, '_blank');
          }
      }">

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
        <div class="max-w-sm w-full bg-red-600 shadow-lg rounded-xl pointer-events-auto ring-1 ring-black ring-opacity-5 overflow-hidden">
            <div class="p-4 flex items-start">
                <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                <div class="ml-3 w-0 flex-1 pt-0.5"><p x-text="message" class="text-sm font-bold text-white"></p></div>
            </div>
        </div>
    </div>

    <header class="bg-white/95 backdrop-blur-sm shadow-sm sticky top-0 z-40 border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <img src="{{ asset('storage/logo.png') }}" alt="Logo Miksusu" class="h-14 w-14 object-contain rounded-full p-1 bg-red-50" onerror="this.src='https://ui-avatars.com/api/?name=M&color=ef4444&background=fee2e2'">
                <div>
                    <h1 class="font-black text-3xl text-red-600 italic tracking-tighter leading-none">MIKSUSU.</h1>
                    <p class="text-[10px] text-gray-500 font-bold uppercase tracking-widest mt-1">Fresh Milk Specialist</p>
                </div>
            </div>
            
            <button @click="isCartOpen = true" class="relative group p-3 bg-red-50 rounded-full transition-all hover:bg-red-100 active:scale-95">
                <svg class="w-7 h-7 text-red-600 transition-transform group-hover:rotate-[-10deg]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                <span x-show="totalItem > 0" x-text="totalItem" x-cloak class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-black leading-none text-white transform translate-x-1/3 -translate-y-1/3 bg-red-600 rounded-full shadow-md"></span>
            </button>
        </div>
    </header>

    <section class="relative bg-white border-b border-gray-100 overflow-hidden">
        <svg class="absolute right-[-50px] bottom-[-20px] h-[120%] opacity-[0.04] text-red-600 hidden md:block" viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg"><path fill="currentColor" d="M156.6,63.1C164.3,77.8,162,99.8,154.6,118.8C147.2,137.9,134.7,154,116.8,161.9C98.9,169.8,75.7,169.6,56.6,159.9C37.5,150.2,22.6,131.1,16.8,110.8C11,90.6,14.4,69.2,25.4,52.9C36.4,36.5,55,25.2,73.8,19.2C92.7,13.2,111.7,12.5,129.5,21C147.2,29.6,148.9,48.4,156.6,63.1Z" transform="translate(100 100)" /></svg>
        
        <div class="max-w-7xl mx-auto px-4 py-20 relative z-10 grid md:grid-cols-5 items-center gap-12">
            <div class="md:col-span-3 text-center md:text-left">
                <span class="inline-flex items-center px-4 py-1.5 rounded-full bg-red-100 text-red-700 text-sm font-bold mb-6">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Fresh dari Peternakan
                </span>
                <h2 class="text-5xl md:text-6xl font-black mb-5 tracking-tighter text-gray-900 leading-[0.95]">Susunya siapa?<br>Ya <span class="text-red-600 italic">Miksusu</span>! 🥛</h2>
                <p class="text-gray-600 text-lg md:text-xl font-medium mb-10 max-w-xl mx-auto md:mx-0">Nikmati kelezatan susu murni racikan spesial dengan bahan premium dan gula asli.</p>
            </div>
            <div class="md:col-span-2 flex justify-center relative">
                <div class="absolute inset-0 bg-red-100 rounded-full scale-110 blur-2xl opacity-60"></div>
                <svg class="w-full max-w-[280px] relative text-red-500" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="50" cy="50" r="48" fill="#fee2e2" stroke="#fecaca" stroke-width="2"/>
                    <path d="M70,40 C75,30 85,35 85,45 C85,55 75,60 70,55 Z" fill="#333"/>
                    <path d="M30,40 C25,30 15,35 15,45 C15,55 25,60 30,55 Z" fill="#333"/>
                    <ellipse cx="50" cy="55" rx="35" ry="30" fill="white" stroke="#333" stroke-width="3"/>
                    <ellipse cx="50" cy="70" rx="20" ry="15" fill="#fecaca" stroke="#333" stroke-width="2"/>
                    <circle cx="43" cy="70" r="3" fill="#333"/><circle cx="57" cy="70" r="3" fill="#333"/>
                    <circle cx="35" cy="50" r="4" fill="#333"/><circle cx="65" cy="50" r="4" fill="#333"/>
                    <path d="M35,25 C38,15 45,15 45,20 L40,30 Z" fill="#e5e7eb" stroke="#333" stroke-width="2"/>
                    <path d="M65,25 C62,15 55,15 55,20 L60,30 Z" fill="#e5e7eb" stroke="#333" stroke-width="2"/>
                </svg>
            </div>
        </div>
        <div class="absolute bottom-0 left-0 w-full leading-none z-10 text-gray-50">
            <svg class="relative block w-full h-[60px]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none"><path d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V120H0V0C49.64,19.91,130.64,50.48,223.71,59.26A665.55,665.55,0,0,0,321.39,56.44Z" fill="currentColor"></path></svg>
        </div>
    </section>

    <main id="katalog" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
        <div class="text-center mb-16 relative">
            <h3 class="text-4xl md:text-5xl font-black text-gray-950 tracking-tight relative inline-block">
                Menu Istimewa
                <svg class="absolute bottom-[-15px] left-0 w-full text-red-300" viewBox="0 0 100 10" xmlns="http://www.w3.org/2000/svg"><path d="M0,5 Q25,0 50,5 T100,5" stroke="currentColor" stroke-width="2" fill="none"/></svg>
            </h3>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-5 md:gap-8 pb-10">
            @forelse($products as $item)
            <div class="bg-white rounded-3xl shadow-sm hover:shadow-2xl border border-gray-100 overflow-hidden transition-all duration-300 group flex flex-col">
                <div class="h-44 md:h-56 bg-gray-50 relative overflow-hidden">
                    @if($item->foto_url)
                        <img src="{{ asset('storage/' . $item->foto_url) }}" alt="{{ $item->nama }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                    @else
                        <div class="w-full h-full flex flex-col items-center justify-center text-red-200 bg-red-50 p-4">
                            <svg class="w-10 h-10 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            <span class="text-[10px] font-bold uppercase tracking-wider text-center">No Photo</span>
                        </div>
                    @endif
                </div>
                
                <div class="p-4 md:p-5 flex-grow flex flex-col justify-between">
                    <div class="mb-4">
                        <h4 class="font-bold text-gray-900 text-base md:text-lg leading-tight mb-1 group-hover:text-red-600 transition-colors">{{ $item->nama }}</h4>
                        <p class="text-xl font-black text-red-600 tracking-tight">Rp {{ number_format($item->harga_saat_ini, 0, ',', '.') }}</p>
                    </div>
                    
                    <div class="mt-auto pt-4 border-t border-gray-100 h-[52px] flex items-center justify-end">
                        
                        <button x-show="getItemQty({{ $item->id }}) === 0" 
                                @click="addToCart({{ $item->id }}, '{{ addslashes($item->nama) }}', {{ $item->harga_saat_ini }}, '{{ $item->foto_url ? asset('storage/'.$item->foto_url) : '' }}')"
                                class="w-full py-2 bg-gray-900 text-white hover:bg-red-600 rounded-xl font-bold text-sm transition-colors shadow-md active:scale-95 flex items-center justify-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                            Tambah
                        </button>

                        <div x-show="getItemQty({{ $item->id }}) > 0" x-cloak
                             class="flex items-center justify-between w-full bg-red-50 border border-red-200 rounded-xl shadow-inner overflow-hidden h-full">
                            <button @click="minQty({{ $item->id }})" class="h-full px-4 text-red-600 hover:bg-red-200 font-black transition-colors active:scale-90 flex items-center justify-center">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M20 12H4"></path></svg>
                            </button>
                            <span class="font-black text-red-700 text-base flex-1 text-center" x-text="getItemQty({{ $item->id }})"></span>
                            <button @click="addToCart({{ $item->id }}, '{{ addslashes($item->nama) }}', {{ $item->harga_saat_ini }}, '{{ $item->foto_url ? asset('storage/'.$item->foto_url) : '' }}')" class="h-full px-4 text-white bg-red-600 hover:bg-red-700 font-black transition-colors active:scale-90 flex items-center justify-center">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"></path></svg>
                            </button>
                        </div>
                    </div>

                </div>
            </div>
            @empty
            <div class="col-span-full text-center py-16">
                <p class="text-gray-500 font-bold">Katalog menu sedang kosong.</p>
            </div>
            @endforelse
        </div>
    </main>

    <div x-show="totalItem > 0" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="transform translate-y-full opacity-0" x-transition:enter-end="transform translate-y-0 opacity-100" x-transition:leave="transition ease-in duration-300" x-transition:leave-start="transform translate-y-0 opacity-100" x-transition:leave-end="transform translate-y-full opacity-0" x-cloak
         class="fixed bottom-4 left-0 right-0 z-40 flex justify-center px-4 pointer-events-none">
        
        <button @click="isCartOpen = true"
                class="pointer-events-auto w-full max-w-lg bg-red-600 hover:bg-red-700 text-white rounded-2xl shadow-2xl p-4 flex items-center justify-between transition-transform active:scale-95 ring-4 ring-white/50">
            <div class="flex items-center space-x-4">
                <div class="bg-white text-red-600 rounded-full w-10 h-10 flex items-center justify-center font-black text-lg shadow-sm">
                    <span x-text="totalItem"></span>
                </div>
                <div class="text-left">
                    <p class="text-xs text-red-200 font-bold uppercase tracking-wider mb-0.5">Total Belanja</p>
                    <p class="font-black text-xl leading-none" x-text="formatRupiah(totalPrice)"></p>
                </div>
            </div>
            <div class="flex items-center font-black bg-red-800/40 px-4 py-2 rounded-xl">
                Buka
                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path></svg>
            </div>
        </button>
    </div>

    <footer class="bg-gray-950 text-white py-12 border-t-4 border-red-600 text-center pb-24 md:pb-12">
        <h2 class="font-black text-2xl text-white italic tracking-tighter mb-2">MIKSUSU.</h2>
        <p class="text-gray-400 font-medium text-sm">&copy; {{ date('Y') }} Miksusu Store. Tulungagung.</p>
    </footer>

    <div x-show="isCartOpen" class="relative z-50" x-cloak>
        <div x-show="isCartOpen" class="fixed inset-0 bg-gray-950/80 backdrop-blur-sm transition-opacity" @click="isCartOpen = false"></div>

        <div class="fixed inset-0 overflow-hidden">
            <div class="absolute inset-0 overflow-hidden">
                <div class="pointer-events-none fixed inset-y-0 right-0 flex max-w-full pl-10">
                    <div x-show="isCartOpen" 
                         x-transition:enter="transform transition ease-in-out duration-300" x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
                         x-transition:leave="transform transition ease-in-out duration-300" x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full"
                         class="pointer-events-auto w-screen max-w-md">
                        <div class="flex h-full flex-col overflow-y-scroll bg-white shadow-2xl rounded-l-3xl">
                            
                            <div class="flex-1 overflow-y-auto px-6 py-8">
                                <div class="flex items-center justify-between border-b border-gray-100 pb-5">
                                    <h2 class="text-2xl font-black text-gray-950 tracking-tight">Pesanan Kamu</h2>
                                    <button @click="isCartOpen = false" class="p-2 -m-2 text-gray-400 hover:text-red-600 rounded-full hover:bg-red-50">
                                        <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                                    </button>
                                </div>

                                <div class="mt-8">
                                    <ul role="list" class="-my-6 divide-y divide-gray-100">
                                        <template x-for="item in cart" :key="item.id">
                                            <li class="flex py-6 group hover:bg-gray-50 rounded-lg px-2 -mx-2">
                                                <div class="h-20 w-20 flex-shrink-0 overflow-hidden rounded-xl border bg-gray-50 shadow-inner p-1">
                                                    <img :src="item.foto || 'https://ui-avatars.com/api/?name=M&color=ef4444&background=fee2e2'" class="h-full w-full object-cover rounded-lg">
                                                </div>

                                                <div class="ml-5 flex flex-1 flex-col">
                                                    <div class="flex justify-between text-base font-bold text-gray-950">
                                                        <h3 x-text="item.nama" class="leading-tight"></h3>
                                                        <p class="ml-4 text-red-600" x-text="formatRupiah(item.harga * item.qty)"></p>
                                                    </div>
                                                    <div class="flex flex-1 items-end justify-between text-sm mt-3">
                                                        <div class="flex items-center border border-gray-200 rounded-full bg-white shadow-sm">
                                                            <button @click="minQty(item.id)" class="px-3.5 py-1.5 text-gray-500 hover:text-red-600 font-black text-lg">-</button>
                                                            <span class="px-2 font-black text-gray-900 min-w-[30px] text-center bg-gray-50 h-full flex items-center justify-center" x-text="item.qty"></span>
                                                            <button @click="addToCart(item.id, item.nama, item.harga, item.foto)" class="px-3.5 py-1.5 text-gray-500 hover:text-red-600 font-black text-lg">+</button>
                                                        </div>
                                                        <button @click="cart = cart.filter(i => i.id !== item.id)" class="font-bold text-red-600 hover:text-red-800 text-xs py-1.5 px-3 bg-red-50 hover:bg-red-100 rounded-full">Hapus</button>
                                                    </div>
                                                </div>
                                            </li>
                                        </template>
                                    </ul>
                                </div>
                            </div>

                            <div class="border-t border-gray-100 px-6 py-8 bg-gray-50 rounded-bl-3xl">
                                <div class="mb-6 p-5 bg-white rounded-2xl border border-gray-100 shadow-sm" x-show="cart.length > 0">
                                    <label for="customerName" class="block text-sm font-bold text-gray-800 mb-2">Nama Pemesan <span class="text-red-500">*</span></label>
                                    <input type="text" id="customerName" x-model="customerName" placeholder="Panggil kamu siapa nih?" 
                                           class="w-full border-gray-200 rounded-xl shadow-inner focus:ring-2 focus:ring-red-200 focus:border-red-400 bg-gray-50 px-4 py-3.5 text-lg font-medium"
                                           :class="{'border-red-300 ring-2 ring-red-100': cart.length > 0 && customerName.trim() === ''}">
                                </div>

                                <div class="flex justify-between items-end text-lg font-medium text-gray-900 mb-5">
                                    <p class="font-bold">Total Tagihan</p>
                                    <p class="text-3xl font-black text-red-600" x-text="formatRupiah(totalPrice)"></p>
                                </div>
                                <button @click="checkoutWA()" 
                                        :class="(cart.length === 0 || customerName.trim() === '') ? 'bg-gray-400 cursor-not-allowed opacity-80' : 'bg-green-600 hover:bg-green-700 active:scale-95 shadow-lg shadow-green-200'"
                                        class="flex w-full items-center justify-center rounded-2xl px-6 py-5 text-xl font-black text-white transition-all">
                                    <svg class="w-7 h-7 mr-3" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 00-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                                    Kirim Pesanan (WhatsApp)
                                </button>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>