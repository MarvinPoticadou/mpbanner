<?php

return [
    'mpbanner' => [
        'columns' => [
            'id_mpbanner' => 'int(10) UNSIGNED NOT NULL AUTO_INCREMENT',
            'filename' => 'varchar(255) DEFAULT NULL',
            'cover_filename' => 'varchar(255) DEFAULT NULL',
            'mobile_filename' => 'varchar(255) DEFAULT NULL',
            'mobile_background_color' => 'varchar(32) DEFAULT NULL',
            'url' => 'varchar(255) DEFAULT NULL',
            'cover_position' => 'int(1) DEFAULT 0',
            'position' => 'int DEFAULT 0',
            'status' => 'int DEFAULT 1',
        ],
        'primary' => ['id_mpbanner'],
    ],
    'mpbanner_lang' => [
        'columns' => [
            'id_mpbanner' => 'int(10) UNSIGNED NOT NULL',
            'id_lang' => 'int(10) UNSIGNED NOT NULL',
            'title' => 'varchar(255) DEFAULT NULL',
            'sub_title' => 'varchar(255) DEFAULT NULL',
            'cta' => 'varchar(255) DEFAULT NULL',
            'flag' => 'varchar(255) DEFAULT NULL',
            'description' => 'text DEFAULT NULL',
        ],
        'primary' => ['id_mpbanner', 'id_lang'],
    ],
];
