<?php

\Framework\Application\Route::get("Home", "TestController", "index")->defaultRoute();
\Framework\Application\Route::get("Home/Test", "TestController", "test");
