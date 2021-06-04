<?php

/**
 * Configuration
 *
 * For more info about constants please @see http://php.net/manual/en/function.define.php
 * If you want to know why we use "define" instead of "const" @see http://stackoverflow.com/q/2447791/1114320
 */

/**
 * Configuration for: Error reporting
 * Useful to show every little problem during development, but only show hard errors in production
 */
error_reporting(E_ERROR);

/**
 * Configuration for: Project URL
 * Put your URL here, for local development "127.0.0.1" or "localhost" (plus sub-folder) is fine
 */
const URL = 'http://127.0.0.1:80/InterviewProj/';

/**
 * Configuration for: Database
 * This is the place where you define your database credentials, database type etc.
 */
const DB_TYPE = 'mysql';
const DB_CHARSET = 'utf8';
const DB_HOST = 'localhost';
const DB_NAME = 'dbproject';
const DB_USER = 'root';
const DB_PASS = 'root';