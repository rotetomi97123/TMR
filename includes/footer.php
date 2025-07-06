<div class="footer">
    <div class="footer-logo">
        <a href="<?= $base_url ?>index.php"><img src="<?= $base_url ?>assets/StanoviSrbijeWhite.png" alt="logo"></a>
    </div>
    <div class="footer-links">
        <div class="footer-links-item">
            <ul class="footer-links-item-list">
                <p>BUY, RENT, SELL</p>
                    <a href="<?= $base_url ?>pages/results.php?type=apartment&listing_type=rent"><li>Rent a property</li></a>
                    <a href="<?= $base_url ?>pages/results.php?type=apartment&listing_type=sale"><li>Buy a property</li></a>
                    <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="<?= $base_url ?>pages/create-listing.php"><li>Sell a property</li></a>
                    <?php else: ?>
                    <a href="<?= $base_url ?>auth/login.php"><li>Sell a propery</li></a>
    <?php endif; ?>
            </ul>
        </div>
        <div class="footer-links-item">
            <ul class="footer-links-item-list">
                <p>CONTACT INFORMATION</p>
                <a href="https://www.facebook.com/" target="_blank"><li><i class="bi bi-facebook"></i> Facebook</li></a>
                <a href="https://www.instagram.com/" target="_blank"><li><i class="bi bi-instagram"></i> Instagram</li></a>
                <a href="https://www.twitter.com/" target="_blank"><li><i class="bi bi-twitter"></i> Twitter</li></a>

            </ul>
        </div>
    </div>
    
</div>
<div class="footer-copyright">
    <hr>
    <p>©2025 StanoviSrbija. All rights reserved</p>
</div>
