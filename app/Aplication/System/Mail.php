<?php
namespace ThisApp\Aplication\System;
//php data objet para deifinir cualquier base e datos c
use \ThisApp\Aplication\System\Config;
use \Mailgun\Mailgun;
use \Exception;

class Mail {

	public static function send($nameTo, $mailTo,$subject,$text,$html, array $replaceVars = [])
	{
		# Instantiate the client.
		$mgClient = new Mailgun(Config::get('mailgun/api_key'));
		$domain = Config::get('mailgun/domain');
		$from = "Superé <no-responder@".$domain.">";
		$to = $nameTo.' <'.$mailTo.'>';
		$html = file_get_contents($html);

		foreach ($replaceVars as $search => $replace) {
			$html = str_replace("[".$search."]", $replace, $html);
		}		

		# Make the call to the client.		
		$vars = ['from'    => $from,
			    'to'      => $to,
			    'subject' => $subject,
			    'text'    => $text,
			    'html'    => $html
		];

		$result = $mgClient->sendMessage($domain, $vars);
//investigar 'recipient-variables'		
		if ($result->http_response_code == 200)		
				return true;
			else				
       			return false;
		/*
			'from'    => 'Excited User <mailgun@YOUR_DOMAIN_NAME>',
		    'to'      => 'Baz <YOU@YOUR_DOMAIN_NAME>',
		    'subject' => 'Hello',
		    'text'    => 'Testing some Mailgun awesomness!'
		*/
	}

}
