<?php
namespace AngularFilemanager\LocalBridge;

date_default_timezone_set('Asia/Shanghai');
define('SYSTEM_coding', 'GBK');

/**
 *  PHP Local filesystem bridge for angular-filemanager
 *
 *  @author Jakub Ďuraš <jakub@duras.me>
 *  @version 0.1.0
 */
include 'LocalBridge/Response.php';
include 'LocalBridge/Rest.php';
include 'LocalBridge/Translate.php';
include 'LocalBridge/FileManagerApi.php';

/**
 * Takes two arguments
 * - base path without last slash (default: '$currentDirectory/../files')
 * - language (default: 'en'); mute_errors (default: true, will call ini_set('display_errors', 0))
 */
$fileManagerApi = new FileManagerApi(preg_replace(['/\\\\+/', '/\/+/'], ['\\\\', '/'], realpath('../../fackpath')), 'zh');

$rest = new Rest();
$rest->post([$fileManagerApi, 'postHandler'])
     ->get([$fileManagerApi, 'getHandler'])
     ->handle();

function sbasename($filename) {
  return preg_replace('/^.*[\\\\\\/]/', '', $filename);
}
function getFilesize($file) {
  return sprintf('%u', filesize($file));
}
function debugLog($msg) {
  $handle = fopen('debug_log.txt', 'a');
  fwrite($handle, sprintf("%s : ", date('Y-m-d H:i:s')));
  fwrite($handle, "\r\n");
  fwrite($handle, $msg . "\r\n\r\n");
  fclose($handle);
}
