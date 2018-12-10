@echo off
set /p file=nom fichier ?
echo ^<?php   ?^> >> views/view_%file%.php
echo ^<?php   ?^> >> models/model_%file%.php

echo ^<?php >> controllers/controller_%file%.php
echo // base repertory name >> controllers/controller_%file%.php
echo $repertory = dirname(__DIR__, 1) . DIRECTORY_SEPARATOR; >> controllers/controller_%file%.php

echo // inclusion du controleur de la page >> controllers/controller_%file%.php
echo require( $repertory . 'models' . DIRECTORY_SEPARATOR . 'model_%file%.php'); >> controllers/controller_%file%.php
echo require( $repertory . 'views' . DIRECTORY_SEPARATOR . 'view_%file%.php'); >> controllers/controller_%file%.php
echo ?^> >> controllers/controller_%file%.php