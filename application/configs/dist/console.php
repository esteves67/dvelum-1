<?php
return [
    // Rebuild database
    'buildDb'=>'Console_Orm_Build',
    'ormMigrate'=>'Console_Orm_Build',
    // Create Model classes
    'genModels' =>'Console_Orm_GenerateModels',
    // Rebuild JS lang files
    'buildJs' =>'Console_Js_Lang'  ,
    // Clear memory tables used for Background tasks
    'clearMemory' =>'Console_Clear_Memory',
];