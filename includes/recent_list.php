<?php
        require_once 'config.php';
?>
<div class="recent-bg">
    <div class="recent-text-flex">
        <div>
            <h1 class="recent-title">Featured Properties</h1>
            <p>Explore our selection of properties with great locations and unique features.</p>
        </div>
        <a href="<?= $base_url ?>/pages/results.php?location=&type=apartment&listing_type=rent" class="recent-link">Browse properties</a>
    </div>    
    
    <div class="recent-wrapper">
        <div class="recent-props container"></div>
    </div>
</div>