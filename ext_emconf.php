<?php

$EM_CONF[$_EXTKEY] = [
    'title'            => 'tt_content to tx_news converter',
    'description'      => 'tt_content to tx_news converter',
    'category'         => 'plugin',
    'author'           => 'Cedric Ziel',
    'author_email'     => 'cedric@cedric-ziel.com',
    'state'            => 'alpha',
    'internal'         => '',
    'uploadfolder'     => '0',
    'createDirs'       => '',
    'clearCacheOnLoad' => 1,
    'version'          => '',
    'constraints'      => [
        'depends'   => [
            'typo3' => '7.6.0-8.9.99',
        ],
        'conflicts' => [
        ],
        'suggests'  => [
        ],
    ],
    'autoload'         => [
        'psr-4' => ['CedricZiel\\TtcontentToTxnews\\' => 'Classes'],
    ],
];
