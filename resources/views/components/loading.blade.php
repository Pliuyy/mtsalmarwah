<style>
    /* Base styles for the loading screen container */
    #loading-screen {
        position: fixed;
        inset: 0;
        /* Menutupi seluruh viewport */
        z-index: 9999;
        /* Pastikan di atas segalanya */
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        /* Penting untuk menyembunyikan panel saat bergeser keluar */
        /* background-color tidak di sini, ada di panel overlay */
    }

    /* Styles for the content (Logo sekolah dan dots) */
    #loading-content {
        position: relative;
        z-index: 10000;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        transition: opacity 0.4s ease-out, transform 0.4s ease-out;
    }

    #loading-logo {
        /* Tidak ada font-size karena akan diganti dengan <img> */
        /* Pastikan logo dimulai dengan opacity 0 dan transisi saat muncul */
        opacity: 0;
        transform: scale(0.8);
        /* Mulai sedikit lebih kecil */
        animation: logoAppear 0.8s ease-out forwards;
        /* Animasi kemunculan logo */
    }

    /* Style untuk logo image */
    #loading-logo img {
        max-width: 150px;
        /* Sesuaikan ukuran logo sesuai kebutuhan */
        height: auto;
        display: block;
        /* Menghilangkan spasi ekstra di bawah gambar */
    }

    /* Keyframe animations */
    @keyframes blink {

        0%,
        80%,
        100% {
            opacity: 0;
            transform: scale(0.9);
        }

        40% {
            opacity: 1;
            transform: scale(1.2);
        }
    }

    @keyframes logoAppear {
        to {
            opacity: 1;
            transform: scale(1);
        }
    }

    /* Styles for the new sliding overlay panels */
    .overlay-panel {
        position: absolute;
        width: 100%;
        height: 50%;
        background-color: #030566;
        transition: transform 0.8s cubic-bezier(0.86, 0, 0.07, 1);
        z-index: 9998;
    }

    .overlay-panel.top {
        top: 0;
        transform: translateY(0);
    }

    .overlay-panel.bottom {
        bottom: 0;
        transform: translateY(0);
    }

    /* State ketika loading screen menghilang (dipicu oleh kelas .hide) */
    #loading-screen.hide #loading-content {
        opacity: 0;
        /* Logo dan dot memudar */
        transform: scale(1.1);
        /* Logo membesar sedikit saat memudar */
        pointer-events: none;
        /* Nonaktifkan interaksi dengan konten yang tersembunyi */
    }

    #loading-screen.hide .overlay-panel.top {
        transform: translateY(-100%);
        /* Panel atas bergeser ke atas sepenuhnya */
    }

    #loading-screen.hide .overlay-panel.bottom {
        transform: translateY(100%);
        /* Panel bawah bergeser ke bawah sepenuhnya */
    }

    /* Pastikan seluruh elemen loading screen tidak bisa diklik setelah menghilang */
    #loading-screen.hide {
        pointer-events: none;
    }
</style>

<div id="loading-screen">
    <div class="overlay-panel top"></div>
    <div class="overlay-panel bottom"></div>

    <div id="loading-content">
        <div id="loading-logo">
            <img src="{{ asset('storage/logos/1kpgoYhlbH3wAMe38suq3xpU4QkKQwQMNXQNcQ6k.png') }}" alt="Logo Sekolah">
        </div>
    </div>
</div>

<script>
    const loadingScreen = document.getElementById('loading-screen');

    const hasVisited = sessionStorage.getItem('hasVisitedHome');

    if (!hasVisited) {
        window.addEventListener('load', function() {
            setTimeout(() => {
                loadingScreen.classList.add('hide'); 
                sessionStorage.setItem('hasVisitedHome', 'true'); 

                setTimeout(() => {
                    loadingScreen.remove();
                }, 1000); 
            }, 1500); 
        });
    } else {
        loadingScreen.style.display = 'none';
        loadingScreen.remove(); 
    }
</script>