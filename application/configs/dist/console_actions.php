<?php
/*
 *  Console actions
 *  types:
 *
 *  action - simple call of  \\Dvelum\\App\\Console\\Action
 *  requires adapter config
 *
 *  task - background task with execution statistics and control, using file locks
 *  requires adapter instance of Task_Cronjob_Abstract
 *
 *  job - cron job, using file locks
 *  requires adapter instance of Cronjob_Abstract
 *
 */
return [
    // Rebuild database
    'buildDb'=>[
        'type' => 'action',
        'adapter' => '\\Dvelum\\App\\Console\\Orm\\Build'
    ],
    // Rebuild database
    'buildShards'=>[
        'type' => 'action',
        'adapter' => '\\Dvelum\\App\\Console\\Orm\\BuildShards'
    ],
    // Create Model classes
    'generateModels'=>[
        'type' => 'action',
        'adapter' => '\\Dvelum\\App\\Console\\Generator\\Models'
    ],
    // Create Model classes
    'generateClassMap'=>[
        'type' => 'action',
        'adapter' => '\\Dvelum\\App\\Console\\Generator\\ClassMap'
    ],
    // Rebuild JS lang files
    'buildJs'=>[
        'type' => 'action',
        'adapter' => '\\Dvelum\\App\\Console\\Js\\Lang'
    ],
    // Clear memory tables used for Background tasks
    'clearMemory'=>[
        'type' => 'action',
        'adapter' => '\\Dvelum\\App\\Console\\Clear\\Memory'
    ],
    // test task
    'testTask'=>array(
        'type' => 'task',
        'property_1' => 10,
        'property_2' => 100,
        'adapter' => 'Task_Cronjob_Test'
    ),
    // test job
    'testJob'=>array(
        'type' => 'task',
        'adapter' => 'Cronjob_Test'
    )
];
