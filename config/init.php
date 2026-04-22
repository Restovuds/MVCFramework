<?php

define('ROOT', dirname(__DIR__));

const WWW = ROOT . '/public';
const APP = ROOT . '/app';
const CORE = ROOT . '/core';
const HELPERS = ROOT . '/helpers';
const CONFIG = ROOT . '/config';
const VIEWS = APP . '/Views';
const LAYOUTS = VIEWS . '/layouts';
const ERROR_LOG_PATH = ROOT . DIRECTORY_SEPARATOR . 'logs' . DIRECTORY_SEPARATOR . 'runtime-errors.log';

const DEBUG = true;

const DEFAULT_LAYOUT = 'defaultLayout';

const SITE_PATH = 'http://fr.local';

const DB = [
    'db_host' => 'db',
    'db_port' => 3306,
    'username' => 'user',
    'user_password' => 'user',
    'db_name' => 'fr',
    'charset' => 'utf8mb4',
    'options' => [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ],
];