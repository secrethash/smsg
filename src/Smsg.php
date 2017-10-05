<?php

namespace Secrethash\Smsg;


use App\Http\Controllers\Controller;
use Log;

class Smsg extends Controller
{

    /**
    * Default Provider
    *
    * #-> MSG91.com
    *
    * @access protected
    */
    protected $provider = "";

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
    * 1. route=1 => Promotion Messages
    * 2. route=4 => Transaction Messages
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

    protected $outputBal = "";

    public function __construct()
    {
        $this->provider = config('smsg.provider');
        $this->authKey = config('smsg.api');
        $this->route = config('smsg.routes');
        $this->apiurl = config('smsg.apiUrl');
    }

    /**
     * Sending message using MSG91.com
     *
     * @return Response
     */
    public function send($_mobileNumber, $_senderId, $_message, $_provider='', $_route='')
    {
        if (empty($_provider))
        {
            $_provider = $this->provider;
        }

        if ($_provider==='msg91')  {
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
                return $output;
        }
        elseif ($_provider==='justsend'){
            // Defining the actual available values
            $this->message = $_message;
            $this->senderId = $_senderId;
            $this->mobileNumber = $_mobileNumber;
            //Preparing post parameters
            $postData = array(
                'to' => $this->mobileNumber,
                'message' => $this->message,
                'from' => $this->senderId,
                'bulkVariant' => $this->senderId == 'ECO' ? 'ECO' : (in_array($this->senderId , ['INFO', 'INFORMACJA', 'KONKURS', 'NOWOSC', 'OFERTA', 'OKAZJA', 'PROMOCJA', 'SMS']) ? 'FULL' : 'PRO')
            );
            // init the curl resource
            $ch = curl_init();
            curl_setopt_array($ch, array(
                CURLOPT_URL => $this->apiurl['justsend']['sms'].$this->authKey['justsend']['apiKey'],
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => json_encode($postData),
                CURLOPT_HTTPHEADER     => [
                    'content-type: application/json',
                ],
            ));


            //Ignore SSL certificate verification
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);


            //get response
            $output = curl_exec($ch);
            Log::debug('SMSG: Code of JustSend.pl has been executed');
            //Log error to DB if any
            if(curl_errno($ch))
            {
                Log::critical('SMSG: SMS Sending (justsend.pl): error:' . curl_error($ch));
            }

            curl_close($ch);

            Log::info('SMSG: Request for sending message returned: '.$output.' (Probably a request ID).');
            return $output;
        }

    }

    /**
    *
    *
    *
    *
    */
    public function _checkBal($_provider, $_type='', $_authkey='')
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
        elseif ($_provider==='justsend'){
            $authkey = (!empty($_authkey) ? $_authkey : $this->authKey['justsend']['apiKey']);

            $ch = curl_init();
            curl_setopt_array($ch, array(
                CURLOPT_URL=>$this->apiurl['justsend']['bal'].$authkey,
                CURLOPT_RETURNTRANSFER => true
            ));

            //Ignore SSL certificate verification
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            //get response
            $output = json_decode(curl_exec($ch), true);

            //Log error to DB if any
            if(curl_errno($ch))
            {
                Log::critical('Checking Balance (justsend.pl) error:' . curl_error($ch));
            }
            curl_close($ch);

            $this->outputBal = $output['data'];

            // ./(msg91)\.
            //--> End justsend.pl Balance Check Configuration
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
