<footer class="custom-footer" id="kontak">
    <!-- Back to Top Button -->
<button class="back-to-top" id="backToTop">
    <i class="fas fa-chevron-up"></i>
</button>
        <div class="container footer-content">
            <div class="contact-section">
                <h4 class="contact-title">Hubungi Kami:</h4>
                <div class="contact-info">
                    <div class="contact-item">
                        <i class="fas fa-envelope"></i>
                        <span>triatmakaofficial@gmail.com</span>
                    </div>
                    <div class="contact-item">
                        <i class="fab fa-whatsapp"></i>
                        <span>+62 838 9675 6124</span>
                    </div>
                    <div class="contact-item">
                        <i class="fas fa-map-marker-alt"></i>
                        <span>Jl.Ardi Manis F4/30, Manisrejo, Taman, Kota Madiun, Jawa Timur, Indonesia</span>
                    </div>
                </div>
            </div>

            <div class="social-media">
                <div class="social-icons">
                    <a href="https://instagram.com/yan_leyan" class="social-icon instagram" target="_blank">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="https://wa.me/62895395756124" class="social-icon whatsapp" target="_blank">
                        <i class="fab fa-whatsapp"></i>
                    </a>
                    <a href="https://tiktok.com/@barleyan_tigo" class="social-icon tiktok" target="_blank">
                        <i class="fab fa-tiktok"></i>
                    </a>
                </div>
            </div>

            <div class="footer-bottom">
                <p>&copy; 2025 CV Abon Manisrejo. All rights reserved.</p>
            </div>
        </div>
    </footer>
<script>
    // Back to Top Button
const backToTopButton = document.getElementById('backToTop');

// Show/hide button berdasarkan scroll position
window.addEventListener('scroll', () => {
    if (window.pageYOffset > 300) {
        backToTopButton.classList.add('show');
    } else {
        backToTopButton.classList.remove('show');
    }
});

// Smooth scroll ke atas saat tombol diklik
backToTopButton.addEventListener('click', () => {
    window.scrollTo({
        top: 0,
        behavior: 'smooth'
    });
});
</script>