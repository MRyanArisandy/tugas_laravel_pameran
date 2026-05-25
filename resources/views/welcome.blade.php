<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AutoVerse - Pameran & Event Mobil Premium</title>
    
    <!-- Google Fonts: Outfit for Heading & Inter for Body -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=Outfit:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS (compiled or CDN fallback for instant visualization) -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        outfit: ['Outfit', 'sans-serif'],
                    },
                    colors: {
                        darkBg: '#090a0f',
                        darkCard: 'rgba(17, 19, 31, 0.75)',
                        crimsonAccent: '#e50914',
                        crimsonGlow: 'rgba(229, 9, 20, 0.4)',
                    }
                }
            }
        }
    </script>
    
    <style>
        body {
            background-color: #090a0f;
            background-image: 
                radial-gradient(at 0% 0%, rgba(229, 9, 20, 0.12) 0px, transparent 50%),
                radial-gradient(at 100% 100%, rgba(20, 80, 220, 0.1) 0px, transparent 50%);
            background-attachment: fixed;
        }

        /* Glassmorphism custom styling */
        .glass-panel {
            background: rgba(17, 19, 31, 0.7);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.07);
        }
        
        .glass-card {
            background: rgba(25, 28, 45, 0.55);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.05);
            transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        }
        
        .glass-card:hover {
            transform: translateY(-6px);
            border-color: rgba(229, 9, 20, 0.4);
            box-shadow: 0 12px 25px -5px rgba(229, 9, 20, 0.15), 0 8px 10px -6px rgba(229, 9, 20, 0.15);
        }

        .crimson-gradient-text {
            background: linear-gradient(135deg, #ffffff 40%, #ff4b55 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        
        .accent-gradient {
            background: linear-gradient(135deg, #e50914 0%, #b8060f 100%);
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #090a0f;
        }
        ::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: rgba(229, 9, 20, 0.4);
        }

        /* Animations */
        @keyframes slideInRight {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }
        
        .animate-slide-in {
            animation: slideInRight 0.4s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }
        
        .tab-content {
            display: none;
            opacity: 0;
            transition: opacity 0.35s ease-in-out;
        }
        
        .tab-content.active {
            display: block;
            opacity: 1;
        }
    </style>
</head>
<body class="text-gray-100 font-sans antialiased min-h-screen">

    <!-- Toast Notifications Container -->
    <div id="toast-container" class="fixed top-5 right-5 z-50 flex flex-col gap-3 max-w-md w-full px-4"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header / Hero Section -->
        <header class="glass-panel rounded-3xl p-6 sm:p-10 mb-10 relative overflow-hidden shadow-2xl">
            <!-- Decorative light blob -->
            <div class="absolute -right-20 -top-20 w-80 h-80 bg-red-600 rounded-full blur-[100px] opacity-20 pointer-events-none"></div>
            
            <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-6">
                <div>
                    <div class="flex flex-wrap items-center gap-3 mb-3">
                        <span class="px-3 py-1 text-xs font-semibold tracking-wider text-red-400 bg-red-950/50 border border-red-800/40 rounded-full uppercase">
                            Showroom Eksklusif v13.9
                        </span>
                        <span id="auth-status-badge" class="px-3 py-1 text-xs font-semibold tracking-wider text-gray-400 bg-gray-900/60 border border-gray-700/40 rounded-full flex items-center gap-1.5 transition-all">
                            <span class="w-1.5 h-1.5 rounded-full bg-gray-500 animate-pulse"></span>
                            Guest (Read-Only)
                        </span>
                        <button id="auth-action-btn" onclick="handleAuthAction()" class="px-3 py-1 text-xs font-bold tracking-wider text-white bg-white/10 hover:bg-white/20 border border-white/10 rounded-full transition-all">
                            Masuk Admin
                        </button>
                    </div>
                    <h1 class="text-4xl sm:text-5xl font-extrabold font-outfit tracking-tight mb-3">
                        <span class="crimson-gradient-text">AutoVerse</span>
                        <span class="text-gray-400 font-light">Pameran</span>
                    </h1>
                    <p class="text-gray-400 text-lg max-w-xl font-light">
                        Destinasi eksklusif untuk mengeksplorasi mobil-mobil sport pameran mewah dan jadwal peluncuran event otomotif terbaru secara langsung.
                    </p>
                </div>
                
                <!-- Quick Stats -->
                <div class="flex gap-4 sm:gap-6">
                    <div class="glass-card px-5 py-4 rounded-2xl text-center">
                        <div class="text-3xl font-bold font-outfit text-red-500" id="total-mobil-count">-</div>
                        <div class="text-xs text-gray-400 uppercase tracking-widest mt-1">Mobil Pameran</div>
                    </div>
                    <div class="glass-card px-5 py-4 rounded-2xl text-center">
                        <div class="text-3xl font-bold font-outfit text-blue-500">{{ count($events) }}</div>
                        <div class="text-xs text-gray-400 uppercase tracking-widest mt-1">Event Jadwal</div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Navigation Tabs & Form Trigger -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
            <!-- Tabs Controls -->
            <div class="bg-gray-950/60 p-1.5 rounded-2xl flex items-center border border-white/5 self-start shadow-inner">
                <button onclick="switchTab('tab-mobil')" id="btn-tab-mobil" class="px-5 py-2.5 rounded-xl text-sm font-semibold tracking-wide transition-all duration-300 flex items-center gap-2 bg-red-600 text-white shadow-lg">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                    </svg>
                    Mobil Pameran
                </button>
                <button onclick="switchTab('tab-event')" id="btn-tab-event" class="px-5 py-2.5 rounded-xl text-sm font-semibold tracking-wide transition-all duration-300 flex items-center gap-2 text-gray-400 hover:text-white">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    Event Showroom
                </button>
            </div>

            <!-- Form Action Button (only visible or active in Mobil Tab) -->
            <button id="add-car-btn" onclick="openAddModal()" class="accent-gradient hover:shadow-[0_0_20px_rgba(229,9,20,0.5)] transition-all duration-300 text-white px-5 py-3 rounded-2xl text-sm font-semibold flex items-center gap-2 shadow-lg">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Tambah Mobil Baru
            </button>
        </div>

        <!-- MAIN CONTENT TABS -->
        
        <!-- 1. MOBIL PAMERAN TAB -->
        <div id="tab-mobil" class="tab-content active">
            <!-- Loading Indicator -->
            <div id="cars-loader" class="flex flex-col items-center justify-center py-20">
                <div class="w-12 h-12 border-4 border-red-600/30 border-t-red-600 rounded-full animate-spin mb-4"></div>
                <p class="text-gray-400 text-sm font-light">Memuat katalog mobil premium...</p>
            </div>

            <!-- Cars Grid -->
            <div id="cars-grid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 hidden">
                <!-- Dynamically populated via Javascript -->
            </div>
            
            <!-- Empty State for Cars -->
            <div id="cars-empty" class="glass-panel rounded-2xl p-10 text-center hidden">
                <svg class="w-16 h-16 text-gray-500 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <h3 class="text-xl font-semibold mb-2">Belum Ada Mobil</h3>
                <p class="text-gray-400 text-sm font-light">Klik tombol 'Tambah Mobil Baru' untuk memajang mobil pameran pertama Anda!</p>
            </div>
        </div>

        <!-- 2. EVENT SHOWROOM TAB -->
        <div id="tab-event" class="tab-content">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($events as $event)
                    <div class="glass-card rounded-2xl p-6 relative overflow-hidden flex flex-col justify-between h-64">
                        <!-- Neon side bar -->
                        <div class="absolute left-0 top-0 bottom-0 w-1.5 bg-gradient-to-b from-blue-500 to-indigo-600"></div>
                        
                        <div>
                            <div class="flex justify-between items-start mb-4">
                                <span class="px-2.5 py-1 text-[11px] font-semibold text-blue-400 bg-blue-950/40 border border-blue-800/30 rounded-lg uppercase tracking-wider">
                                    Upcoming Event
                                </span>
                                <span class="text-xs text-gray-500 flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                    </svg>
                                    Kapasitas: {{ $event->kapasitas }}
                                </span>
                            </div>
                            
                            <h3 class="text-xl font-bold font-outfit text-white mb-2 leading-snug">
                                {{ $event->nama_event }}
                            </h3>
                            
                            <p class="text-gray-400 text-sm font-light flex items-center gap-2 mt-3">
                                <svg class="w-4 h-4 text-blue-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                {{ $event->lokasi }}
                            </p>
                        </div>

                        <div class="border-t border-white/5 pt-4 mt-4 flex justify-between items-center">
                            <span class="text-xs text-gray-500 font-medium">
                                {{ \Carbon\Carbon::parse($event->tanggal_event)->translatedFormat('d M Y - H:i') }} WIB
                            </span>
                            <span class="text-[11px] font-semibold text-emerald-400 bg-emerald-950/40 px-2 py-0.5 border border-emerald-800/30 rounded-md">
                                Terbuka
                            </span>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full glass-panel rounded-2xl p-10 text-center">
                        <svg class="w-16 h-16 text-gray-500 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <h3 class="text-xl font-semibold mb-2">Belum Ada Event Terdekat</h3>
                        <p class="text-gray-400 text-sm font-light">Tidak ada event showroom terjadwal untuk saat ini.</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Footer -->
        <footer class="mt-20 border-t border-white/5 py-8 text-center text-xs text-gray-600">
            <p>&copy; {{ date('Y') }} AutoVerse Showroom. Built with Laravel 13 & Tailwind CSS v4.</p>
        </footer>
    </div>

    <!-- MODAL POPUP FORM (Tambah Mobil) -->
    <div id="add-modal" class="fixed inset-0 z-50 flex items-center justify-center px-4 hidden">
        <!-- Backdrop -->
        <div onclick="closeAddModal()" class="absolute inset-0 bg-black/80 backdrop-blur-sm transition-opacity"></div>
        
        <!-- Modal Content Box -->
        <div class="glass-panel max-w-md w-full rounded-3xl overflow-hidden shadow-2xl relative z-10 border border-white/10 scale-95 opacity-0 transition-all duration-300" id="modal-box">
            <!-- Top bar -->
            <div class="px-6 py-5 border-b border-white/5 flex items-center justify-between accent-gradient">
                <h3 class="text-lg font-bold font-outfit text-white">Tambah Mobil Pameran</h3>
                <button onclick="closeAddModal()" class="text-white/80 hover:text-white rounded-lg p-1 hover:bg-white/10 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            
            <!-- Form body -->
            <form id="add-car-form" onsubmit="submitCar(event)" class="p-6 space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-gray-400 mb-2">Nama Mobil</label>
                    <input type="text" name="nama_mobil" required placeholder="Contoh: Civic Type R, Aventador..." class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-red-500 focus:ring-1 focus:ring-red-500 transition-all">
                </div>
                
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-gray-400 mb-2">Merk / Pabrikan</label>
                    <input type="text" name="merk" required placeholder="Contoh: Honda, Lamborghini, Toyota..." class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-red-500 focus:ring-1 focus:ring-red-500 transition-all">
                </div>
                
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-gray-400 mb-2">Tahun Rilis</label>
                        <input type="number" name="tahun" required min="1900" max="2030" placeholder="2025" class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-red-500 focus:ring-1 focus:ring-red-500 transition-all">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-gray-400 mb-2">Harga (Rupiah)</label>
                        <input type="number" name="harga" required min="0" placeholder="Harga dalam Rupiah" class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-red-500 focus:ring-1 focus:ring-red-500 transition-all">
                    </div>
                </div>
                
                <!-- Action Buttons -->
                <div class="flex items-center justify-end gap-3 pt-4 border-t border-white/5">
                    <button type="button" onclick="closeAddModal()" class="px-5 py-2.5 rounded-xl text-sm font-medium text-gray-400 hover:text-white transition-colors">Batal</button>
                    <button type="submit" id="submit-btn" class="accent-gradient text-white px-5 py-2.5 rounded-xl text-sm font-semibold hover:shadow-[0_0_15px_rgba(229,9,20,0.4)] transition-all">
                        Simpan Mobil
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL POPUP FORM (Edit Mobil) -->
    <div id="edit-modal" class="fixed inset-0 z-50 flex items-center justify-center px-4 hidden">
        <!-- Backdrop -->
        <div onclick="closeEditModal()" class="absolute inset-0 bg-black/80 backdrop-blur-sm transition-opacity"></div>
        
        <!-- Modal Content Box -->
        <div class="glass-panel max-w-md w-full rounded-3xl overflow-hidden shadow-2xl relative z-10 border border-white/10 scale-95 opacity-0 transition-all duration-300" id="edit-modal-box">
            <!-- Top bar -->
            <div class="px-6 py-5 border-b border-white/5 flex items-center justify-between bg-gradient-to-r from-amber-600 to-amber-700">
                <h3 class="text-lg font-bold font-outfit text-white">Edit Mobil Pameran</h3>
                <button onclick="closeEditModal()" class="text-white/80 hover:text-white rounded-lg p-1 hover:bg-white/10 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            
            <!-- Form body -->
            <form id="edit-car-form" onsubmit="submitEditCar(event)" class="p-6 space-y-4">
                @csrf
                @method('PUT')
                <input type="hidden" name="id" id="edit-car-id">
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-gray-400 mb-2">Nama Mobil</label>
                    <input type="text" name="nama_mobil" id="edit-nama-mobil" required placeholder="Contoh: Civic Type R..." class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500 transition-all">
                </div>
                
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-gray-400 mb-2">Merk / Pabrikan</label>
                    <input type="text" name="merk" id="edit-merk" required placeholder="Contoh: Honda..." class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500 transition-all">
                </div>
                
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-gray-400 mb-2">Tahun Rilis</label>
                        <input type="number" name="tahun" id="edit-tahun" required min="1900" max="2030" placeholder="2025" class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500 transition-all">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-gray-400 mb-2">Harga (Rupiah)</label>
                        <input type="number" name="harga" id="edit-harga" required min="0" placeholder="Harga dalam Rupiah" class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500 transition-all">
                    </div>
                </div>
                
                <!-- Action Buttons -->
                <div class="flex items-center justify-end gap-3 pt-4 border-t border-white/5">
                    <button type="button" onclick="closeEditModal()" class="px-5 py-2.5 rounded-xl text-sm font-medium text-gray-400 hover:text-white transition-colors">Batal</button>
                    <button type="submit" id="edit-submit-btn" class="bg-gradient-to-r from-amber-500 to-amber-600 text-white px-5 py-2.5 rounded-xl text-sm font-semibold hover:shadow-[0_0_15px_rgba(245,158,11,0.4)] transition-all">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL POPUP FORM (Hapus Mobil) -->
    <div id="delete-modal" class="fixed inset-0 z-50 flex items-center justify-center px-4 hidden">
        <!-- Backdrop -->
        <div onclick="closeDeleteModal()" class="absolute inset-0 bg-black/80 backdrop-blur-sm transition-opacity"></div>
        
        <!-- Modal Content Box -->
        <div class="glass-panel max-w-sm w-full rounded-3xl overflow-hidden shadow-2xl relative z-10 border border-white/10 scale-95 opacity-0 transition-all duration-300" id="delete-modal-box">
            <div class="p-6 text-center">
                <span class="inline-flex p-3 rounded-full bg-red-950/50 border border-red-500/30 text-red-500 mb-4 animate-bounce">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                </span>
                
                <h3 class="text-xl font-bold font-outfit text-white mb-2">Hapus Mobil Pameran?</h3>
                <p class="text-gray-400 text-sm font-light mb-6">
                    Apakah Anda yakin ingin menghapus <span id="delete-car-name" class="text-red-400 font-semibold"></span> dari pameran? Tindakan ini tidak dapat dibatalkan.
                </p>
                
                <div class="flex items-center justify-center gap-3">
                    <button onclick="closeDeleteModal()" class="px-5 py-2.5 rounded-xl text-sm font-medium text-gray-400 hover:text-white transition-colors">Batal</button>
                    <button id="delete-confirm-btn" onclick="executeDeleteCar()" class="bg-red-600 hover:bg-red-700 text-white px-5 py-2.5 rounded-xl text-sm font-semibold hover:shadow-[0_0_15px_rgba(220,38,38,0.4)] transition-all">
                        Hapus
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL POPUP FORM (Login Admin) -->
    <div id="login-modal" class="fixed inset-0 z-50 flex items-center justify-center px-4 hidden">
        <!-- Backdrop -->
        <div onclick="closeLoginModal()" class="absolute inset-0 bg-black/80 backdrop-blur-sm transition-opacity"></div>
        
        <!-- Modal Content Box -->
        <div class="glass-panel max-w-md w-full rounded-3xl overflow-hidden shadow-2xl relative z-10 border border-white/10 scale-95 opacity-0 transition-all duration-300" id="login-modal-box">
            <!-- Top bar -->
            <div class="px-6 py-5 border-b border-white/5 flex items-center justify-between bg-gradient-to-r from-red-600 to-red-700">
                <h3 class="text-lg font-bold font-outfit text-white">Login Admin</h3>
                <button onclick="closeLoginModal()" class="text-white/80 hover:text-white rounded-lg p-1 hover:bg-white/10 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            
            <!-- Form body -->
            <form id="login-form" onsubmit="submitLogin(event)" class="p-6 space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-gray-400 mb-2">Email Admin</label>
                    <input type="email" name="email" id="login-email" required value="test@example.com" placeholder="admin@autoverse.com" class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-red-500 focus:ring-1 focus:ring-red-500 transition-all">
                </div>
                
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-gray-400 mb-2">Password</label>
                    <input type="password" name="password" id="login-password" required value="password" placeholder="••••••••" class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-red-500 focus:ring-1 focus:ring-red-500 transition-all">
                    <p class="text-[11px] text-gray-500 mt-1.5 font-light">Petunjuk: Gunakan akun default di atas untuk login satu klik.</p>
                </div>
                
                <!-- Action Buttons -->
                <div class="flex items-center justify-end gap-3 pt-4 border-t border-white/5">
                    <button type="button" onclick="closeLoginModal()" class="px-5 py-2.5 rounded-xl text-sm font-medium text-gray-400 hover:text-white transition-colors">Batal</button>
                    <button type="submit" id="login-submit-btn" class="accent-gradient text-white px-5 py-2.5 rounded-xl text-sm font-semibold hover:shadow-[0_0_15px_rgba(229,9,20,0.4)] transition-all">
                        Masuk
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- CORE JAVASCRIPT LOGIC -->
    <script>
        // Set of elegant gradient configurations for car card backdrops dynamically assigned based on indexes
        const cardGradients = [
            'from-red-600/10 to-transparent',
            'from-blue-600/10 to-transparent',
            'from-emerald-600/10 to-transparent',
            'from-amber-600/10 to-transparent',
            'from-indigo-600/10 to-transparent',
            'from-purple-600/10 to-transparent'
        ];

        // Format currency helper to local IDR
        function formatRupiah(number) {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0,
                maximumFractionDigits: 0
            }).format(number);
        }

        // Show toast helper with custom classes and styles
        function showToast(message, type = 'success') {
            const container = document.getElementById('toast-container');
            const toast = document.createElement('div');
            toast.className = `glass-panel animate-slide-in flex items-center justify-between p-4 rounded-2xl shadow-2xl border-l-4 ${
                type === 'success' 
                    ? 'border-emerald-500 bg-emerald-950/40 text-emerald-300' 
                    : 'border-red-500 bg-red-950/40 text-red-300'
            }`;
            
            const checkIcon = `<svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>`;
            
            const errorIcon = `<svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>`;

            toast.innerHTML = `
                <div class="flex items-center gap-3">
                    ${type === 'success' ? checkIcon : errorIcon}
                    <span class="text-sm font-medium">${message}</span>
                </div>
                <button onclick="this.parentElement.remove()" class="text-white/40 hover:text-white ml-4">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            `;
            
            container.appendChild(toast);
            
            // Auto remove after 4 seconds
            setTimeout(() => {
                toast.style.opacity = '0';
                toast.style.transform = 'translateX(50px)';
                toast.style.transition = 'all 0.35s ease';
                setTimeout(() => toast.remove(), 350);
            }, 4000);
        }

        // Active tab manager
        function switchTab(tabId) {
            // Hide all tab contents
            document.querySelectorAll('.tab-content').forEach(tab => {
                tab.classList.remove('active');
            });
            
            // Deactivate all button styles
            const btnMobil = document.getElementById('btn-tab-mobil');
            const btnEvent = document.getElementById('btn-tab-event');
            
            btnMobil.className = "px-5 py-2.5 rounded-xl text-sm font-semibold tracking-wide transition-all duration-300 flex items-center gap-2 text-gray-400 hover:text-white";
            btnEvent.className = "px-5 py-2.5 rounded-xl text-sm font-semibold tracking-wide transition-all duration-300 flex items-center gap-2 text-gray-400 hover:text-white";
            
            // Show requested tab content
            const activeTab = document.getElementById(tabId);
            activeTab.classList.add('active');
            
            // Set styles for active button
            if(tabId === 'tab-mobil') {
                btnMobil.className = "px-5 py-2.5 rounded-xl text-sm font-semibold tracking-wide transition-all duration-300 flex items-center gap-2 bg-red-600 text-white shadow-lg";
                document.getElementById('add-car-btn').style.display = 'flex';
            } else {
                btnEvent.className = "px-5 py-2.5 rounded-xl text-sm font-semibold tracking-wide transition-all duration-300 flex items-center gap-2 bg-blue-600 text-white shadow-lg";
                document.getElementById('add-car-btn').style.display = 'none';
            }
        }

        // Fetch all cars from API
        async function fetchCars() {
            const loader = document.getElementById('cars-loader');
            const grid = document.getElementById('cars-grid');
            const empty = document.getElementById('cars-empty');
            
            loader.classList.remove('hidden');
            grid.classList.add('hidden');
            empty.classList.add('hidden');

            try {
                const response = await fetch('/api/mobils');
                const result = await response.json();
                
                if (result.success && result.data.length > 0) {
                    grid.innerHTML = '';
                    
                    result.data.forEach((car, index) => {
                        const gradient = cardGradients[index % cardGradients.length];
                        
                        const carCard = document.createElement('div');
                        carCard.className = `glass-card rounded-3xl p-6 relative overflow-hidden bg-gradient-to-br ${gradient}`;
                        carCard.innerHTML = `
                            <!-- Decorative glow -->
                            <div class="absolute -right-10 -bottom-10 w-32 h-32 bg-red-500 rounded-full blur-[60px] opacity-10 pointer-events-none"></div>
                            
                            <div class="flex justify-between items-start mb-6">
                                <span class="px-3 py-1 text-xs font-semibold text-red-400 bg-red-950/40 border border-red-800/30 rounded-full uppercase tracking-wider">
                                    ${escapeHtml(car.merk)}
                                </span>
                                <div class="flex items-center gap-2">
                                    <!-- Edit Button -->
                                    <button onclick="openEditModal(${car.id}, '${escapeHtml(car.nama_mobil)}', '${escapeHtml(car.merk)}', ${car.tahun}, ${car.harga})" class="p-1.5 rounded-lg bg-white/5 border border-white/10 text-gray-400 hover:text-amber-400 hover:bg-amber-950/20 transition-all" title="Edit Mobil">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </button>
                                    <!-- Delete Button -->
                                    <button onclick="confirmDelete(${car.id}, '${escapeHtml(car.nama_mobil)}')" class="p-1.5 rounded-lg bg-white/5 border border-white/10 text-gray-400 hover:text-red-500 hover:bg-red-950/20 transition-all" title="Hapus Mobil">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            
                            <div class="mb-6">
                                <h3 class="text-2xl font-extrabold font-outfit text-white leading-tight mb-2">
                                    ${escapeHtml(car.nama_mobil)}
                                </h3>
                                <p class="text-gray-400 text-sm font-light">Spesifikasi Showroom Utama</p>
                            </div>
                            
                            <div class="border-t border-white/5 pt-4 flex justify-between items-center">
                                <div>
                                    <div class="text-xs text-gray-500 uppercase tracking-widest">Harga Pameran</div>
                                    <div class="text-xl font-bold font-outfit text-emerald-400 mt-0.5">
                                        ${formatRupiah(car.harga)}
                                    </div>
                                </div>
                                <span class="p-2 rounded-xl bg-white/5 border border-white/10 text-gray-300">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                    </svg>
                                </span>
                            </div>
                        `;
                        grid.appendChild(carCard);
                    });
                    
                    document.getElementById('total-mobil-count').innerText = result.data.length;
                    grid.classList.remove('hidden');
                } else {
                    document.getElementById('total-mobil-count').innerText = '0';
                    empty.classList.remove('hidden');
                }
            } catch (error) {
                console.error("Gagal memuat mobil:", error);
                showToast("Gagal memuat katalog mobil. Coba segarkan halaman.", "error");
                empty.classList.remove('hidden');
            } finally {
                loader.classList.add('hidden');
            }
        }

        // Helper to get auth headers
        function getAuthHeaders() {
            const token = localStorage.getItem('admin_token');
            const headers = {
                'Accept': 'application/json'
            };
            if (token) {
                headers['Authorization'] = `Bearer ${token}`;
            }
            return headers;
        }

        // Check and update Auth UI
        function checkAuthStatus() {
            const token = localStorage.getItem('admin_token');
            const badge = document.getElementById('auth-status-badge');
            const btn = document.getElementById('auth-action-btn');
            
            if (token) {
                // We're logged in
                badge.className = "px-3 py-1 text-xs font-semibold tracking-wider text-emerald-400 bg-emerald-950/60 border border-emerald-800/40 rounded-full flex items-center gap-1.5 transition-all";
                badge.innerHTML = `<span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span> Admin (Full Access)`;
                btn.innerText = "Keluar (Logout)";
                btn.className = "px-3 py-1 text-xs font-bold tracking-wider text-red-400 bg-red-950/20 hover:bg-red-950/40 border border-red-900/30 rounded-full transition-all";
            } else {
                // We're logged out
                badge.className = "px-3 py-1 text-xs font-semibold tracking-wider text-gray-400 bg-gray-900/60 border border-gray-700/40 rounded-full flex items-center gap-1.5 transition-all";
                badge.innerHTML = `<span class="w-1.5 h-1.5 rounded-full bg-gray-500 animate-pulse"></span> Guest (Read-Only)`;
                btn.innerText = "Masuk Admin";
                btn.className = "px-3 py-1 text-xs font-bold tracking-wider text-white bg-white/10 hover:bg-white/20 border border-white/10 rounded-full transition-all";
            }
        }

        // Action when login/logout button clicked
        function handleAuthAction() {
            const token = localStorage.getItem('admin_token');
            if (token) {
                // Logout action
                localStorage.removeItem('admin_token');
                showToast("Sesi admin berakhir, Anda kini bertindak sebagai Guest.", "success");
                checkAuthStatus();
            } else {
                openLoginModal();
            }
        }

        // Login Modal Controls
        function openLoginModal() {
            const modal = document.getElementById('login-modal');
            const box = document.getElementById('login-modal-box');
            
            modal.classList.remove('hidden');
            setTimeout(() => {
                box.classList.remove('scale-95', 'opacity-0');
                box.classList.add('scale-100', 'opacity-100');
            }, 50);
        }

        function closeLoginModal() {
            const modal = document.getElementById('login-modal');
            const box = document.getElementById('login-modal-box');
            
            box.classList.remove('scale-100', 'opacity-100');
            box.classList.add('scale-95', 'opacity-0');
            
            setTimeout(() => {
                modal.classList.add('hidden');
                document.getElementById('login-form').reset();
            }, 300);
        }

        // Submit API Login via AJAX
        async function submitLogin(event) {
            event.preventDefault();
            
            const form = event.target;
            const submitBtn = document.getElementById('login-submit-btn');
            const formData = new FormData(form);
            
            const originalText = submitBtn.innerText;
            submitBtn.disabled = true;
            submitBtn.innerHTML = `
                <svg class="w-4 h-4 animate-spin inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Autentikasi...
            `;

            try {
                const response = await fetch('/api/login', {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                    },
                    body: formData
                });
                
                const result = await response.json();
                
                if (response.ok && result.success) {
                    localStorage.setItem('admin_token', result.token);
                    showToast(result.message || "Autentikasi berhasil! Log antrean dijalankan.", "success");
                    closeLoginModal();
                    checkAuthStatus();
                } else {
                    showToast(result.message || "Email atau password salah.", "error");
                }
            } catch (error) {
                console.error("Gagal login:", error);
                showToast("Terjadi kesalahan pada server. Coba beberapa saat lagi.", "error");
            } finally {
                submitBtn.disabled = false;
                submitBtn.innerText = originalText;
            }
        }

        // Modal Action Handlers - ADD
        function openAddModal() {
            if (!localStorage.getItem('admin_token')) {
                showToast("Akses ditolak. Anda harus login sebagai admin terlebih dahulu!", "error");
                openLoginModal();
                return;
            }

            const modal = document.getElementById('add-modal');
            const box = document.getElementById('modal-box');
            
            modal.classList.remove('hidden');
            setTimeout(() => {
                box.classList.remove('scale-95', 'opacity-0');
                box.classList.add('scale-100', 'opacity-100');
            }, 50);
        }

        function closeAddModal() {
            const modal = document.getElementById('add-modal');
            const box = document.getElementById('modal-box');
            
            box.classList.remove('scale-100', 'opacity-100');
            box.classList.add('scale-95', 'opacity-0');
            
            setTimeout(() => {
                modal.classList.add('hidden');
                document.getElementById('add-car-form').reset();
            }, 300);
        }

        // Modal Action Handlers - EDIT
        function openEditModal(id, nama, merk, tahun, harga) {
            if (!localStorage.getItem('admin_token')) {
                showToast("Akses ditolak. Anda harus login sebagai admin terlebih dahulu!", "error");
                openLoginModal();
                return;
            }

            document.getElementById('edit-car-id').value = id;
            document.getElementById('edit-nama-mobil').value = nama;
            document.getElementById('edit-merk').value = merk;
            document.getElementById('edit-tahun').value = tahun;
            document.getElementById('edit-harga').value = harga;

            const modal = document.getElementById('edit-modal');
            const box = document.getElementById('edit-modal-box');
            
            modal.classList.remove('hidden');
            setTimeout(() => {
                box.classList.remove('scale-95', 'opacity-0');
                box.classList.add('scale-100', 'opacity-100');
            }, 50);
        }

        function closeEditModal() {
            const modal = document.getElementById('edit-modal');
            const box = document.getElementById('edit-modal-box');
            
            box.classList.remove('scale-100', 'opacity-100');
            box.classList.add('scale-95', 'opacity-0');
            
            setTimeout(() => {
                modal.classList.add('hidden');
                document.getElementById('edit-car-form').reset();
            }, 300);
        }

        // Global variables for delete confirmation
        let carIdToDelete = null;

        // Modal Action Handlers - DELETE
        function confirmDelete(id, nama) {
            if (!localStorage.getItem('admin_token')) {
                showToast("Akses ditolak. Anda harus login sebagai admin terlebih dahulu!", "error");
                openLoginModal();
                return;
            }

            carIdToDelete = id;
            document.getElementById('delete-car-name').innerText = nama;

            const modal = document.getElementById('delete-modal');
            const box = document.getElementById('delete-modal-box');
            
            modal.classList.remove('hidden');
            setTimeout(() => {
                box.classList.remove('scale-95', 'opacity-0');
                box.classList.add('scale-100', 'opacity-100');
            }, 50);
        }

        function closeDeleteModal() {
            const modal = document.getElementById('delete-modal');
            const box = document.getElementById('delete-modal-box');
            
            box.classList.remove('scale-100', 'opacity-100');
            box.classList.add('scale-95', 'opacity-0');
            
            setTimeout(() => {
                modal.classList.add('hidden');
                carIdToDelete = null;
            }, 300);
        }

        // Execute DELETE via AJAX
        async function executeDeleteCar() {
            if (!carIdToDelete) return;

            const confirmBtn = document.getElementById('delete-confirm-btn');
            const originalText = confirmBtn.innerText;
            
            confirmBtn.disabled = true;
            confirmBtn.innerHTML = `
                <svg class="w-4 h-4 animate-spin inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Menghapus...
            `;

            try {
                const response = await fetch(`/api/mobils/${carIdToDelete}`, {
                    method: 'DELETE',
                    headers: {
                        ...getAuthHeaders(),
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                    }
                });
                
                const result = await response.json();
                
                if (response.ok && result.success) {
                    showToast(result.message || "Mobil berhasil dihapus!", "success");
                    closeDeleteModal();
                    fetchCars();
                } else {
                    showToast(result.message || "Gagal menghapus mobil.", "error");
                }
            } catch (error) {
                console.error("Gagal menghapus mobil:", error);
                showToast("Terjadi kesalahan server saat menghapus mobil.", "error");
            } finally {
                confirmBtn.disabled = false;
                confirmBtn.innerText = originalText;
            }
        }

        // Submit form data via AJAX for Adding
        async function submitCar(event) {
            event.preventDefault();
            
            const form = event.target;
            const submitBtn = document.getElementById('submit-btn');
            const formData = new FormData(form);
            
            const originalBtnText = submitBtn.innerText;
            submitBtn.disabled = true;
            submitBtn.innerHTML = `
                <svg class="w-4 h-4 animate-spin inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Menyimpan...
            `;
            
            try {
                const response = await fetch('/api/mobils', {
                    method: 'POST',
                    headers: getAuthHeaders(),
                    body: formData
                });
                
                const result = await response.json();
                
                if (response.ok && result.success) {
                    showToast(result.message || "Mobil berhasil ditambahkan!", "success");
                    closeAddModal();
                    fetchCars();
                } else {
                    showToast(result.message || "Gagal menambahkan mobil. Periksa inputan Anda.", "error");
                }
            } catch (error) {
                console.error("Gagal menambahkan mobil:", error);
                showToast("Terjadi kesalahan pada server. Coba beberapa saat lagi.", "error");
            } finally {
                submitBtn.disabled = false;
                submitBtn.innerText = originalBtnText;
            }
        }

        // Submit form data via AJAX for Editing
        async function submitEditCar(event) {
            event.preventDefault();
            
            const form = event.target;
            const submitBtn = document.getElementById('edit-submit-btn');
            const carId = document.getElementById('edit-car-id').value;
            const formData = new FormData(form);
            
            const originalBtnText = submitBtn.innerText;
            submitBtn.disabled = true;
            submitBtn.innerHTML = `
                <svg class="w-4 h-4 animate-spin inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Menyimpan...
            `;
            
            try {
                const response = await fetch(`/api/mobils/${carId}`, {
                    method: 'POST',
                    headers: getAuthHeaders(),
                    body: formData
                });
                
                const result = await response.json();
                
                if (response.ok && result.success) {
                    showToast(result.message || "Data mobil berhasil diperbarui!", "success");
                    closeEditModal();
                    fetchCars();
                } else {
                    showToast(result.message || "Gagal memperbarui data mobil.", "error");
                }
            } catch (error) {
                console.error("Gagal memperbarui mobil:", error);
                showToast("Terjadi kesalahan pada server saat memperbarui data.", "error");
            } finally {
                submitBtn.disabled = false;
                submitBtn.innerText = originalBtnText;
            }
        }

        // Helper to prevent HTML injections
        function escapeHtml(text) {
            const map = {
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                '"': '&quot;',
                "'": '&#039;'
            };
            return text.replace(/[&<>"']/g, function(m) { return map[m]; });
        }

        // Initial Load
        document.addEventListener('DOMContentLoaded', () => {
            fetchCars();
            checkAuthStatus();
        });
    </script>
</body>
</html>
