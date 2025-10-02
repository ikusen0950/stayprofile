<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Email extends BaseConfig
{
	public $fromEmail = 'no-reply@finolhu.com';
	public $fromName  = 'Islanders App Support';

	public $recipients;

	public $userAgent = 'CodeIgniter';
	public $protocol  = 'smtp';

	public $mailPath  = '/usr/sbin/sendmail';

	// ✅ Microsoft 365 SMTP Settings
	public $SMTPHost     = 'smtp.office365.com';
	public $SMTPUser     = 'no-reply@finolhu.com';
	public $SMTPPass     = 'pvhtjsjsxfgyqxps';
	public $SMTPPort     = 587;              // Microsoft 365 uses port 587
	public $SMTPTimeout  = 60;
	public $SMTPKeepAlive = false;
	public $SMTPCrypto   = 'tls';            // Use TLS for Office365

	public $wordWrap     = true;
	public $wrapChars    = 76;
	public $mailType     = 'html';
	public $charset      = 'UTF-8';
	public $validate     = false;
	public $priority     = 3;

	public $CRLF         = "\r\n";
	public $newline      = "\r\n";

	public $BCCBatchMode = false;
	public $BCCBatchSize = 200;

	public $DSN          = false;
}
