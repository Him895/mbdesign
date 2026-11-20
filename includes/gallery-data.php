<?php
/**
 * GALLERY ka data - yahin bharo.
 *
 * Har gallery ke liye ek block. Naya jodna ho to ek block copy karke paste karo.
 *   id     : chhota unique naam (sirf small letters, numbers aur -). URL me use hota hai.
 *   title  : gallery ka naam (list aur detail dono me dikhta hai)
 *   images : photos ke naam. Photos yahan rakho: assets/img/gallery/
 *            Pehli photo list me cover banti hai. Zyada photos ho to naam aur add karo.
 *   text   : (optional) detail page par chhota description. Nahi chahiye to '' rehne do.
 *
 * Folder me photo rakhne par hi dikhegi; na ho to gold placeholder dikhta hai.
 */
return [
    [
        'id'     => 'avi-bante-wathoda',
        'title'  => 'Avi Bante at Wathoda, Nagpur',
        'images' => ['g1.jpg'],
        'text'   => '',
    ],
    [
        'id'     => 'arora-lawn-jaripatka',
        'title'  => 'Arora Lawn Jaripatka, Nagpur',
        'images' => ['g2.jpg','g3.jpg'],
        'text'   => '',
    ],
    [
        'id'     => 'madan-wathoda',
        'title'  => 'Madan at Wathoda, Nagpur',
        'images' => ['g4.jpg'],
        'text'   => '',
    ],
    [
        'id'     => 'makkad-wadsa',
        'title'  => 'Makkad at Wadsa, Gadchiroli',
        'images' => ['g5.jpg'],
        'text'   => '',
    ],
    [
        'id'     => 'prashant-fia-hudkeshwar',
        'title'  => 'Prashant FIA at Hudkeshwar Road, Nagpur',
        'images' => ['g6.jpg','g7.jpg','g8.jpg','g9.jpg','g10.php','g11.jpg'],
        'text'   => '',
    ],
    // Purani site par 6th card ka title "All" tha. Uska asli naam pata ho to uncomment karke bharo:
    // [
    //     'id'     => 'sixth-gallery',
    //     'title'  => 'TODO naam',
    //     'images' => ['sixth-1.jpg'],
    //     'text'   => '',
    // ],
];