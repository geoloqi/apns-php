<?php
/**
 * @file
 * sample_server.php
 * 
 * Push server demo
 * 
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://code.google.com/p/apns-php/wiki/License
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to aldo.armiento@gmail.com so we can send you a copy immediately.
 * 
 * @version $Id$
 */

// Adjust to your timezone
date_default_timezone_set('Europe/Rome');

// Report all PHP errors
error_reporting(-1);

// Using Autoload all classes are loaded on-demand
require_once 'ApnsPHP/Autoload.php';

// Instanciate a new ApnsPHP_Push object
$Server = new ApnsPHP_Push_Server(
	ApnsPHP_Abstract::ENVIRONMENT_SANDBOX,
	'server_cerificates_bundle_sandbox.pem'
);

// Set the Root Certificate Autority to verify the Apple remote peer
$Server->setRootCertificationAuthority('entrust_root_certification_authority.pem');

// Set the number of concurrent processes
$Server->setProcesses(2);

// Starts the server forking the new processes
$Server->start();

// Main loop...
$i = 1;
while ($Server->run()) {
	
	// Check the error queue
	$aErrorQueue = $Server->getQueue();
	if (!empty($aErrorQueue)) {
		// Do somethings with this error messages...
		var_dump($aErrorQueue);
	}
	
	// Send 10 messages
	if ($i <= 10) {
		// Instantiate a new Message with a single recipient
		$Message = new ApnsPHP_Message('e3434b98811836079119bbb8617373073292d045dc195e87de5765ebae5e50d7');

		// Set badge icon to "i"
		$Message->setBadge($i);
		
		// Add the message to the message queue
		$Server->add($Message);
		
		$i++;
	}
	
	// Sleep a little...
	usleep(200000);
}
