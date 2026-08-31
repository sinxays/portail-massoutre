<?php
$menu_principal = [

    [
        'type_bouton_menu' => 'simple_bouton',
        'libelle_bouton' => 'Accueil',
        'icon' => 'bx bx-home',
        'roles' => [],
        'class' => 'nav__name',
        'url' => '/index.php'
    ],

    // AVIS
    [
        'type_bouton_menu' => 'dropdown_bouton',
        'libelle_bouton' => '',
        'logos' => [
            [
                'type_logo' => 'court',
                'class' => 'img_nav_court',
                'src' => '/assets/img/avis_logo_court.png'
            ],
            [
                'type_logo' => 'long',
                'class' => 'img_nav_long',
                'src' => '/assets/img/avis_logo.png'
            ]

        ],
        'roles' => [1],
        'items' => [
            [
                'name' => 'Stats',
                'url' => '/pages_stats/Locations.php'
            ],
        ]
    ],

    // LES GRANDES OCCASIONS
    [
        'type_bouton_menu' => 'dropdown_bouton',
        'libelle_bouton' => '',
        'logos' => [
            [
                'type_logo' => 'court',
                'class' => 'img_nav_court',
                'src' => '/assets/img/lgo_logo_court2.png'
            ],
            [
                'type_logo' => 'long',
                'class' => 'img_nav_long',
                'src' => '/assets/img/lgo_logo.png'
            ]

        ],
        // 'icon_logo' => '/assets/img/lgo_logo.png',
        // 'icon_logo_court' => '/assets/img/lgo_logo_court.png',
        'roles' => [1, 5],
        'items' => [
            // [
            //     'name' => 'Suivi BDC',
            //     'url' => '/pages_stats/suivi_bdc.php'
            // ],
            // [
            //     'name' => 'Suivi Factures',
            //     'url' => '/pages_stats/suivi_factures.php'
            // ]
            [
                'name' => 'Payplan',
                'url' => '/payplan/payplan.php'
            ]

        ]
    ],

    // LEASE AND GO
    [
        'type_bouton_menu' => 'dropdown_bouton',
        'libelle_bouton' => '',
        'logos' => [
            [
                'type_logo' => 'court',
                'class' => 'img_nav_court',
                'src' => '/assets/img/lag_logo_court.png'
            ],
            [
                'type_logo' => 'long',
                'class' => 'img_nav_long',
                'src' => '/assets/img/lag_logo.png'
            ]

        ],
        // 'icon_logo' => '/assets/img/lag_logo.png',
        'roles' => [1, 3],
        'items' => [
            [
                'name' => 'TDB (en cours)',
                'url' => '#'
            ],
            [
                'name' => 'Alertes LAG',
                'url' => '/operations/suivi_lag/suivi_lag.php',
            ]
        ]
    ],

    // MAINTENANCE VEHICULES
    [
        'type_bouton_menu' => 'dropdown_bouton',
        'libelle_bouton' => 'Maintenance',
        'icon' => 'bx bx-car',
        'roles' => [1, 4],
        'items' => [
            [
                'name' => 'Shop extérieurs',
                'url' => '/operations/shop_exterieurs/shop_exterieurs.php'
            ],

        ]
    ],

    //Informatique 
    [
        'type_bouton_menu' => 'dropdown_bouton',
        'libelle_bouton' => 'Informatique',
        'icon' => 'bx bx-laptop',
        'roles' => [1],
        'items' => [
            [
                'name' => 'Imprimantes',
                'url' => '/Informatique/imprimantes.php'
            ],
            [
                'name' => 'Réseau',
                'url' => '/Informatique/reseau.php'
            ]
        ]
    ],
];


$menu_bottom = [

    [
        'type_bouton_menu' => 'simple_bouton',
        'libelle_bouton' => 'Paramètres',
        'icon' => 'bx bxs-wrench',
        'roles' => [1],
        'class' => 'nav_param',
        'url' => '/parametres.php'
    ],

    [
        'type_bouton_menu' => 'simple_bouton',
        'libelle_bouton' => 'Déconnexion',
        'icon' => 'bx bx-log-out',
        'roles' => [1, 2, 3, 4, 5],
        'class' => 'nav__logout',
        'url' => '/logout.php'
    ],

];

?>