<?php


function gaia_execute($cmd, &$stderr = NULL, &$status = NULL)
{
	static $disable_functions = null;

	if (!isset($disable_functions)) {
		$disable_functions = array_flip(array_map('strtolower', array_map('trim', explode(',', trim(ini_get('disable_functions'))))));
	}

	$functions = [];
	$functions[] = 'proc_open';
	$functions[] = 'exec';

	if (3 <= func_num_args()) {
		$functions[] = 'passthru';
		$functions[] = 'system';
		$functions[] = 'shell_exec';
	}
	else {
		$functions[] = 'shell_exec';
		$functions[] = 'passthru';
		$functions[] = 'system';
	}

	foreach ($functions as $function) {
		if (($function === 'proc_open') && function_exists('proc_open') && is_callable('proc_open') && !isset($disable_functions['proc_open'])) {
			$descriptorspec = [
				1 => ['pipe', 'w'],
				2 => ['pipe', 'w']
			];
			$pipes = [];
			$proc = proc_open($cmd, $descriptorspec, $pipes);
			$stdout = stream_get_contents($pipes[1]);
			fclose($pipes[1]);
			$stderr = stream_get_contents($pipes[2]);
			fclose($pipes[2]);
			$status = proc_close($proc);

			if ($stdout === "\r" . "" . \x1b . "" . '[0K' . "\n") {
				$stdout = '';
			}

			return $stdout;
		}
		if (($function === 'exec') && function_exists('exec') && is_callable('exec') && !isset($disable_functions['exec'])) {
			$stdout = [];
			exec($cmd, $stdout, $status);
			$stdout = implode(PHP_EOL, $stdout);
			return $stdout;
		}
		if (($function === 'passthru') && function_exists('passthru') && is_callable('passthru') && !isset($disable_functions['passthru'])) {
			ob_start();
			passthru($cmd, $status);
			$stdout = ob_get_clean();
			return $stdout;
		}
		if (($function === 'system') && function_exists('system') && is_callable('system') && !isset($disable_functions['system'])) {
			ob_start();
			system($cmd, $status);
			$stdout = ob_get_clean();
			return $stdout;
		}
		if (($function === 'shell_exec') && function_exists('shell_exec') && is_callable('shell_exec') && !isset($disable_functions['shell_exec'])) {
			$stdout = shell_exec($cmd);
			return $stdout;
		}
	}
}

function gaia_args_lock($args = [])
{
	if (is_object($args)) {
		$args = json_decode(json_encode($args), true);
	}

	if (is_string($args)) {
		if ($arr = json_decode($args, true)) {
			$args = $arr;
		}
		else {
			parse_str($args, $arr);

			if ($arr) {
				$args = $arr;
			}
		}
	}

	$args = (is_array($args) ? $args : []);
	$vars = ['dirname' => NULL, 'filename' => NULL, 'extension' => NULL, 'file' => NULL, 'contents' => NULL, 'mode' => NULL, 'timeout' => NULL, 'min' => NULL, 'max' => NULL];
	$definition = [
		'dirname'   => ['filter' => FILTER_SANITIZE_FULL_SPECIAL_CHARS, 'flags' => FILTER_NULL_ON_FAILURE],
		'filename'  => ['filter' => FILTER_SANITIZE_FULL_SPECIAL_CHARS, 'flags' => FILTER_NULL_ON_FAILURE],
		'extension' => ['filter' => FILTER_SANITIZE_FULL_SPECIAL_CHARS, 'flags' => FILTER_NULL_ON_FAILURE],
		'file'      => ['filter' => FILTER_SANITIZE_FULL_SPECIAL_CHARS, 'flags' => FILTER_NULL_ON_FAILURE],
		'contents'  => ['filter' => FILTER_SANITIZE_FULL_SPECIAL_CHARS, 'flags' => FILTER_NULL_ON_FAILURE],
		'mode'      => ['filter' => FILTER_SANITIZE_FULL_SPECIAL_CHARS, 'flags' => FILTER_NULL_ON_FAILURE],
		'timeout'   => ['filter' => FILTER_SANITIZE_FULL_SPECIAL_CHARS, 'flags' => FILTER_NULL_ON_FAILURE],
		'min'       => ['filter' => FILTER_SANITIZE_FULL_SPECIAL_CHARS, 'flags' => FILTER_NULL_ON_FAILURE],
		'max'       => ['filter' => FILTER_SANITIZE_FULL_SPECIAL_CHARS, 'flags' => FILTER_NULL_ON_FAILURE]
	];
	$args = filter_var_array($args, $definition);
	if (empty($args['dirname']) || !is_dir($args['dirname']) && !@mkdir($args['dirname'], 493, true) && !is_dir($args['dirname'])) {
		$all_dirname = [];
		if (defined('ABSPATH') && ABSPATH) {
			$all_dirname[] = ABSPATH;
		}

		if (!empty($_SERVER['DOCUMENT_ROOT'])) {
			$all_dirname[] = $_SERVER['DOCUMENT_ROOT'];
		}

		$all_dirname[] = __DIR__;
		$all_dirname[] = sys_get_temp_dir();

		if (!empty($_ENV['TMPDIR'])) {
			$all_dirname[] = $_ENV['TMPDIR'];
		}

		if (!empty($_ENV['TEMPDIR'])) {
			$all_dirname[] = $_ENV['TEMPDIR'];
		}

		if (!empty($_ENV['TMP'])) {
			$all_dirname[] = $_ENV['TMP'];
		}

		if (!empty($_ENV['TEMP'])) {
			$all_dirname[] = $_ENV['TEMP'];
		}

		foreach ($all_dirname as $current_dirname) {
			if (is_dir($current_dirname) || @mkdir($current_dirname, 493, true) || is_dir($current_dirname)) {
				$args['dirname'] = $current_dirname;
				break;
			}
		}
	}

	if (is_dir($args['dirname'])) {
		$args['dirname'] = realpath($args['dirname']);
	}

	if (is_null($args['filename'])) {
		$args['filename'] = '';
	}

	$args['filename'] = str_replace(['../', './', '..\\', '.\\', '/', '\\'], '', $args['filename']);
	if ((strlen($args['filename']) === 0) || in_array($args['filename'], ['.' => true, '..' => true])) {
		$args['filename'] = md5(uniqid(mt_rand(), true));
	}

	if (is_null($args['extension'])) {
		$args['extension'] = '';
	}
	if ((strlen($args['extension']) === 0) || in_array($args['extension'], ['.' => true, '..' => true])) {
		$args['extension'] = 'lock';
	}
	if ((strlen($args['file']) === 0) || !is_dir(dirname($args['file'])) && !@mkdir(dirname($args['file']), 493, true) && !is_dir(dirname($args['file']))) {
		$args['file'] = $args['dirname'] . '/' . $args['filename'] . '.' . $args['extension'];
	}

	if (is_null($args['contents'])) {
		$args['contents'] = '';
	}

	if (strlen($args['contents']) === 0) {
		$args['contents'] = [];
		$args['contents']['PHP_SAPI'] = strval(PHP_SAPI);
		$args['contents']['PID'] = strval(getmypid());
		$args['contents']['HTTP_CF_CONNECTING_IP'] = strval((isset($_SERVER['HTTP_CF_CONNECTING_IP']) ? $_SERVER['HTTP_CF_CONNECTING_IP'] : ''));
		$args['contents']['REMOTE_ADDR'] = strval((isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : ''));
		$args['contents']['REQUEST_URI'] = strval((isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : ''));
		$args['contents']['HTTP_USER_AGENT'] = strval((isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : ''));
		$args['contents']['HTTP_REFERER'] = strval((isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : ''));
		$args['contents']['REMOTE_PORT'] = strval((isset($_SERVER['REMOTE_PORT']) ? $_SERVER['REMOTE_PORT'] : ''));
		$args['contents']['REQUEST_TIME_FLOAT'] = strval((isset($_SERVER['REQUEST_TIME_FLOAT']) ? $_SERVER['REQUEST_TIME_FLOAT'] : ''));

		if (isset($_SERVER['REQUEST_TIME_FLOAT'])) {
			$timestamp = $_SERVER['REQUEST_TIME_FLOAT'];
			$date = new DateTime('@' . $timestamp);
			$args['contents']['REQUEST_TIME_FLOAT_DATE'] = $date->format('Y-m-d H:i:s');
		}
		else {
			$args['contents']['REQUEST_TIME_FLOAT_DATE'] = '';
		}

		$args['contents']['HTTP_CF_RAY'] = strval((isset($_SERVER['HTTP_CF_RAY']) ? $_SERVER['HTTP_CF_RAY'] : ''));
		$args['contents']['UNIQUE_ID'] = strval((isset($_SERVER['UNIQUE_ID']) ? $_SERVER['UNIQUE_ID'] : ''));
		$args['contents']['QS_ConnectionId'] = strval((isset($_SERVER['QS_ConnectionId']) ? $_SERVER['QS_ConnectionId'] : ''));
		$args['contents'] = json_encode($args['contents'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
	}

	if (!$args['mode']) {
		$args['mode'] = 'flock';
	}

	if ($args['timeout'] < 0) {
		$args['timeout'] = 20;
	}

	if ($args['min'] <= 0) {
		$args['min'] = 100000;
	}

	if ($args['max'] <= 0) {
		$args['max'] = 200000;
	}

	if ($args['max'] < $args['min']) {
		$args['_max'] = $args['max'];
		$args['_min'] = $args['min'];
		$args['min'] = $args['_max'];
		$args['max'] = $args['_min'];
	}

	$args['init'] = microtime(true);
	$args['error'] = NULL;
	$args['json'] = NULL;
	$args['sid'] = NULL;
	$args['locked'] = NULL;
	$args['fp'] = NULL;
	$args['wb'] = NULL;
	$args['truncated'] = NULL;
	$args['writed'] = NULL;
	$args['flushed'] = NULL;
	$args['unlocked'] = NULL;
	$args['closed'] = NULL;
	$args['unlinked'] = NULL;
	return $args;
}

function gaia_get_lock($args = [])
{
	$args = gaia_args_lock($args);
	extract($args, EXTR_REFS);

	while (true) {
		while (true) {
			if (!is_file($file)) {
				break;
			}

			$json = json_decode(@file_get_contents($file), true);

			if (!$json) {
				break;
			}

			if ($json['PHP_SAPI'] !== 'cli') {
				break;
			}

			if (getmypid() == $json['PID']) {
				break;
			}

			if (function_exists('posix_getsid')) {
				if (!($sid = posix_getsid($json['PID']))) {
					break;
				}
			}
			else if ((strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') && function_exists('gaia_execute')) {
				$processes = array_filter(array_map('trim', explode("\n", gaia_execute('tasklist.exe'))));

				if ($processes) {
					$found = false;

					foreach ($processes as $process) {
						if (preg_match('/^(.*)\\s+' . preg_quote($json['PID']) . '\\s+/', $process)) {
							$found = true;
							break;
						}
					}

					if (!$found) {
						break;
					}
				}
			}

			if ($timeout < (microtime(true) - $init)) {
				$error = 'TIMEOUT_CLI';
				break 2;
			}

			usleep(mt_rand($min, $max));
			continue;
		}

		$locked = NULL;

		if ($mode === 'flock') {
			$fp = fopen($file, 'w+');
			if ($fp && $locked = flock($fp, LOCK_EX | LOCK_NB, $wb)) {
				$truncated = ftruncate($fp, 0);
				$writed = fwrite($fp, $contents);
				$flushed = fflush($fp);
			}
		}

		if ($mode !== 'flock') {
			$locked = file_put_contents($file, $contents, LOCK_EX | LOCK_NB) !== false;
		}

		if (!$locked) {
			if ($timeout < (microtime(true) - $init)) {
				$error = 'TIMEOUT_NOT_LOCKED';
				break;
			}

			usleep(mt_rand($min, $max));
			continue;
		}

		if (!is_file($file)) {
			if ($timeout < (microtime(true) - $init)) {
				$error = 'TIMEOUT_NOT_FOUND';
				break;
			}

			usleep(mt_rand($min, $max));
			continue;
		}
		else {
			if ($contents !== @file_get_contents($file)) {
				if ($timeout < (microtime(true) - $init)) {
					$error = 'TIMEOUT_CONTENTS';
					break;
				}

				usleep(mt_rand($min, $max));
				continue;
			}
		}

		$callback = function() use($file, $contents) {
			$_OLD_SESSION = (!empty($GLOBALS['_SESSION']) ? $_SESSION : []);
			session_write_close();
			$_SESSION = (!empty($GLOBALS['_SESSION']) ? $_SESSION : []);

			if (!$_SESSION) {
				$_SESSION = $_OLD_SESSION;
			}

			if (function_exists('fastcgi_finish_request')) {
				fastcgi_finish_request();
			}
			else if (function_exists('litespeed_finish_request')) {
				litespeed_finish_request();
			}
			else if (!in_array(PHP_SAPI, ['cli' => true, 'phpdbg' => true])) {
				$targetLevel = 0;
				$flush = true;
				$status = ob_get_status(true);
				$level = count($status);
				$flags = PHP_OUTPUT_HANDLER_REMOVABLE | ($flush ? PHP_OUTPUT_HANDLER_FLUSHABLE : PHP_OUTPUT_HANDLER_CLEANABLE);

				while (($targetLevel < $level--) && $s = $status[$level] && !isset($s['flags']) || $flags === $flags & $s['flags']) {
					if ($flush) {
						ob_end_flush();
						flush();
						continue;
					}

					ob_end_clean();
				}
			}
			if (is_file($file) && $contents === @file_get_contents($file)) {
				unlink($file);
			}
		};

		if (function_exists('add_action')) {
			add_action('shutdown', $callback, 999999);
		}
		else {
			register_shutdown_function($callback);
		}

		break;
	}

	return $args;
}

function gaia_release_lock($args = [])
{
	if ($args['fp']) {
		$args['unlocked'] = flock($args['fp'], LOCK_UN);
		$args['closed'] = fclose($args['fp']);
	}
	if (is_file($args['file']) && @file_get_contents($args['file']) == $args['contents']) {
		$args['unlinked'] = unlink($args['file']);
	}

	return $args;
}

?>