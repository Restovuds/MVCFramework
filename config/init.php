<?php

$params = array_merge(
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php'),
);

define('ROOT', dirname(__DIR__));

const WWW = ROOT . '/public';
const UPLOADS = WWW . '/uploads';
const APP = ROOT . '/app';
const CORE = ROOT . '/core';
const HELPERS = ROOT . '/helpers';
const CONFIG = ROOT . '/config';
const VIEWS = APP . '/Views';
const LAYOUTS = VIEWS . '/layouts';
const ERROR_LOG_PATH = ROOT . DIRECTORY_SEPARATOR . 'logs' . DIRECTORY_SEPARATOR . 'runtime-errors.log';
const CACHE_PATH = ROOT . DIRECTORY_SEPARATOR . 'cache';
const TMP_FOLDER = ROOT . DIRECTORY_SEPARATOR . 'tmp';

const DEBUG = true;

const DEFAULT_LAYOUT = 'defaultLayout';     

const SITE_PATH = 'http://fr.local';

const LOGIN_PAGE = SITE_PATH . '/login';

define("ENC_KEY", $params['session.enc.key']);

define('DB', [
    'db_host' => $params['db.host'],
    'db_port' => $params['db.port'],
    'username' => $params['db.username'],
    'user_password' => $params['db.password'],
    'db_name' => $params['db.name'],
    'charset' => $params['db.charset'],
    'options' => $params['db.options'],
]);

define('MAILER', [
    'host' => $params['mailer.host'],
    'debug' => $params['mailer.debug'],
    'port' => $params['mailer.port'],
    'SMTPAuth' => $params['mailer.SMTPAuth'],
    'username' => $params['mailer.username'],
    'password' => $params['mailer.password'],
    'SMTPSecure' => $params['mailer.SMTPSecure'],
    'from_email' => $params['mailer.from.email'],
    'from_name' => $params['mailer.from.name'],
]);