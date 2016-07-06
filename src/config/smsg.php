<?php

return array(

    /*
     |--------------------------------------------------------------------------
     | API KEY(s) for SMS Providers
     |--------------------------------------------------------------------------
     | * API keys for the SMS to work.
     |   + MSG91:
     |     - SMS & Balance: Paste the API key obtained from MSG91 here. This API
     |                      Key will be used to "Send Messages" & "Check Available
     |						Balance".
     |
     */

    'api' => array(
        'msg91'=>array(
            'smsBal'=>'API_KEY' // To Send SMS and check Balance
            )
        ),

    /*
     |--------------------------------------------------------------------------
     | Default Route
     |--------------------------------------------------------------------------
     |
     | Set the Default Messaging Route. In several countries it is necessary to
     | send Transactional Messages through a Transactional Route and Promotional
     | messages through a Promotional Route only. They are also charged differently
     | by many SMS Providers. For Example:
     | 
     | In India TRAI or Telecom Regulatory Authority of India does not allow
     | Promotional messages through Transactional Route.
     |
     | msg91.com allows you to set routes for Transactional and Promotional
     | messages. According to msg91: "1" refers to Promotional and "4" refers
     | to Transactional
	 |
     |-> NOTE: Transactional Messages are given more Importance than Promotional
     |         ones. Read More about it in Project's Wiki on Github.
     |
     */

     'routes' => array(
     	'msg91' => '1' #-> 1 => Promotion, 4 => Transaction
     	),


    /*
     |--------------------------------------------------------------------------
     | API URLs
     |--------------------------------------------------------------------------
     | * API URL using which the SMSG API will connect to the Provider's API.
     |   + MSG91:
     |     - SMS & Balance: Generally, there is no need to change it.
     'https://control.msg91.com/api/sendhttp.php'
     |
     */


     'apiUrl' => array(
     	'msg91' => array(
     		'sms' => 'https://control.msg91.com/api/sendhttp.php',
     		'bal' => 'https://control.msg91.com/api/balance.php',
     		)
     	)


	);