<?php
    renderView(
        'accueil', 
        [
            'pagetTitle' => "Bienvenue sur mon site",
            'now' => date('l jS \of F Y h:i:s A')
        ]
    );
?>