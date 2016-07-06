<?php

namespace Secrethash\Smsg;


use App\Http\Controllers\Controller;
use Log;

class Smsg extends Controller
{

    /**
    * Your authentication keys
    *
    * #-> MSG91.com
    *
    * @access protected
    */
    protected $authKey = "";


    /**
    * Multiple mobiles numbers separated by comma
    * 
    * @access protected
    */
    protected $mobileNumber;


    /**
    * Sender ID,While using route4 sender id should be 6 characters long.
    * 
    * @access protected
    */
    protected $senderId;


    /**
    * Your message to send, Add URL encoding here.
    * 
    * @access protected
    */
    protected $message;

    /**
    * Define messaging route
    * 
    * 
    * Available Options for India and similar countries
    * 1. route=1 => Promotional Messages
    * 2. route=4 => Transactional Messages
    * 
    * @access protected
    */
    protected $route = "";

    /**
    * All API URLs
    * 
    * #-> MSG91.com
    * 
    * @access protected
    */
    protected $apiurl = "";

    protected $outputBal;

    public function __construct()
    {
        $this->authKey = config('smsg.api');
        $this->route = config('smsg.routes');
        $this->apiurl = config('smsg.apiUrl');
    }

    /**
     * Sending message using MSG91.com
     *
     * @return Response
     */
    public function msg91($_mobileNumber, $_senderId, $_message, $_route='')
    {
        // Defining the actual available values
        $this->route = (!empty($_route) ? $_route : $this->route['msg91']);
        $this->message = urlencode($_message);
        $this->senderId = $_senderId;
        $this->mobileNumber = $_mobileNumber;
        // $_apiUrl_pre = (empty($_apiUrl_pre) ? 'api/sendhttp.php' : $_apiUrl_pre);
        // $msg_apiurl = $this->msg91_apiurl;
        //Preparing post parameters
        $postData = array(
            'authkey' => $this->authKey['msg91']['smsBal'],
            'mobiles' => $this->mobileNumber,
            'message' => $this->message,
            'sender' => $this->senderId,
            'route' => $this->route
        );

            // init the curl resource
            $ch = curl_init();
            curl_setopt_array($ch, array(
                CURLOPT_URL => $this->apiurl['msg91']['sms'],
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => $postData
                //,CURLOPT_FOLLOWLOCATION => true
            ));


            //Ignore SSL certificate verification
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);


            //get response
            $output = curl_exec($ch);
            Log::debug('SMSG: Code of MSG91.com has been executed');
            //Log error to DB if any
            if(curl_errno($ch))
            {
                Log::critical('SMSG: SMS Sending (msg91.com): error:' . curl_error($ch));
            }

            curl_close($ch);

            Log::info('SMSG: Request for sending message returned: '.$output.' (Probably a request ID).');



    }

    /**
    *
    *
    *
    *
    */
    public function _checkBal($_provider, $_type=1, $_authkey='')
    {
        if ($_provider==='msg91')
        {
            $type = (!empty($_type) ? $_type : $this->route['msg91']);
            $authkey = (!empty($_authkey) ? $_authkey : $this->authKey['msg91']['smsBal']);
            // $_apiUrl_pre = (empty($_apiUrl_pre) ? 'api/balance.php' : $_apiUrl_pre);

            $ch = curl_init();
            curl_setopt_array($ch, array(
                    CURLOPT_URL=>$this->apiurl['msg91']['bal'],
                    CURLOPT_RETURNTRANSFER => true
                ));

            //Ignore SSL certificate verification
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            //get response
            $output = curl_exec($ch);

            //Log error to DB if any
            if(curl_errno($ch))
            {
                Log::critical('Checking Balance (msg91.com) error:' . curl_error($ch));
            }
            curl_close($ch);
            $this->outputBal = $output;

            // ./(msg91)\.
            //--> End MSG91.com Balance Check Configuration
        }

    }
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function showbal($_provider, $_type='', $_authkey='')
    {
        //
        if (!empty($_provider)) { 

            $this->_checkbal($_provider, $_type, $_authkey);
            return $this->outputBal;
        }
    }

}
