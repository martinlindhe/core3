<?php
namespace Core;

require_once realpath(__DIR__.'/../class/Core').'/Bootstrapper.php';
Bootstrapper::bootstrap();

Bootstrapper::initTestingSettings();
