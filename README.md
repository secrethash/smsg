---
# SMSG - SMS Package

---
[TOC]

---

##Introduction
>***Don't go on the name. :P***. The name is just a mixture of SMS and MSG (seriously! :D ).

SMSG is a Messaging Package or SMS Package that was created for the ease of sending messages using the APIs of Popular Service Providers. SMSG was made keeping in mind the possibilities of SMS Technology.

In today's world the SMS have been depreciated from normal people's life, but we Programmers and Coders have many possibilities with SMS Technology, still. SMS is very Important in our lives. See how below:

* **SMS Verification:** SMS can be used as a method of verification of users over bots and also for valid phone numbers.
* **Transaction Summary:** Transaction Summary can be sent to the users to tell them about their most recent purchase.
*  **Purchase Confirmation:** Purchase Confirmation Request codes can be sent to user's mobile devices and requested on website. This can be used as 2-step Purchase Verification for users buying via their wallet credits.
*  **Many More: ** Possibilities are only limited by your thinking, therefore, expand and more possibilities will take birth.

##Install

Just a one line `composer` command:

`composer require secrethash/smsg`

>That's It!

##Setup
Setting up **SMSG** is also not difficult. Just follow the below steps for successfully setting up the package.

---
###Step 1: Service Provider
You will have to add the `SmsgServiceProvider` in the Provider's array:

+ Open `config\app.php` file.
+ Find `'providers'` array.
+ At the end of the array add `Secrethash\Smsg\SmsgServiceProvider::class,`

###Step 2: Facade
The working should always be easy, right? Facade makes it happen. After you register the SMSG's Facade, you will be able to access it via `SMSG` facade directly. For example: 

```php
SMSG::showbal('msg91'); // outputs balance for MSG91.com
```

***Let's set it up:***

+ Open `config\app.php`
+ Find `'aliases'`array
+ At the end add `'SMSG'      => Secrethash\Smsg\Facade\Smsg::class,`

>Hurrah!

###Step 3: Configuration
You will have to publish the SMSG's Config File to get started with it. Run the Command:

`php artisan vendor:publish --provider=Secrethash\Smsg\SmsgServiceProvider`

Now open the SMSG configuration file which must be at  `config\smsg.php` and edit according to your Provider and needs.

>Done! You are now ready to Rock 'n Roll!

---

##Working with SMSG
Working is very easy with SMSG. There are certain functions that are needed to be triggered to get the desired work done. All the available functions are listed below:

---
### Sending Message
To send a message using SMSG you just need to trigger the`SMSG::send()` function with the required parameters.

####Parameters:
1.  **Mobile Number(s):**  It is the first parameter to be passed. There can be single mobile number or multiple mobile numbers. ***Multiple Mobile Numbers*** should be separated by commas for eg: `0123456789, 9876543210`.
	* ***FIELD REQUIRED***
	* ***MUST BE NUMBERS ONLY***
> **NOTE:** Do Not provide multiple mobile numbers in an array. Separate it by commas only.

1.  **Sender ID:** The sender ID is the ID that is shown on the receiver's mobile in place of a sender's mobile number. For Eg: `DM-SMSG`. Sender ID should be in supplied in ***Plain Text Only***.
	* ***FIELD REQUIRED***
	* ***PLAIN TEXT ONLY***
1. **Message:** Message is basically the body of SMS that you want to send.
	* ***FIELD REQUIRED***

1. **Provider:** Provider is not important to be filled. If you want to use a different provider for a particular SMS then you should provide it's valid ID as the Input for **4th Parameter**, otherwise the default provider will be used as defined in your `config\smsg.php` file.
	* ***NOT COMPULSORY***
	* ***SHOULD BE A VALID PROVIDER ID***
>**NOTE:** Find the Available Provider's ID below.

1. **Route:** Route is the passage of sending a message. Mostly, there are only 2 Routes:
	2. _Transaction:_ It is a Passage for SMS that has higher delivery rate than others. This passage is for Transaction Related Messages, to send the user transaction summary or some other important message like Mobile Number Verification code. Many Provider prohibit Promotion Messages through Transaction Route. Sometimes account can also get suspended.
	3. _Promotion:_ Route to send promotional messages like coupon codes. Sale Updates, News Updates, etc. This passage is mainly for less important messages. They are usually a little cheaper than Transactional SMS.

---
####Winding Up the Parameters: 

Here is an example on feeding the parameters with Inputs:
```php
<?php

namespace App\Http\Controllers;


use App\Http\Controllers\Controller;

use Request;

use SMSG;


class SmsgDemoController extends Controller
{
	// Some Code
		# More Code
			$mobile = '1234567890';
			$sender = 'SMSG';
			$msg = 'Hey, John Doe! Your Verification Code is: 7cx50S';
			$provider = 'msg91';
			$route = '4';
			// Will also catch the output
			$trigger = SMSG::send($mobile, $sender, $msg, $provider, $route);
 echo $trigger;
 }
```
Try it yourself.

---
###Checking Available Balance
Currently all the Providers provide the possibility to check your balance virtually. With this function you can be updated to your balance with available balance on your dashboard. You can also work with this function to automate a reminder to your email or mobile, via sms, and never upset the client.

To perform the check, use `SMSG::showbal()`. This will return the available balance in your account using the default provider and API key of default route.

>Feed the parameters with input to get more flexible data.

####Parameters:
> **Note:** None of the below parameters are Compulsory.

1. **Provider:** If you want to check the balance of a different provider. Simply pass the provider's name as input.
2.  **Route:** Some Providers provide different balance for different routes. If you also want to know the balance of different route at the same time, trigger the function 2 time, once without feeding the input to this parameter and the second time by feeding the input.
3. **API Key:** Know the balance of different account using the same installation and without editing the configuration.

---
####Winding Up with Parameters
```php
<?php

namespace App\Http\Controllers;


use App\Http\Controllers\Controller;

use Request;

use SMSG;


class SmsgDemoController extends Controller
{
	$trigger = SMSG::showbal('msg91', '4', 'XYZ_API_KEY');
	 echo $trigger; 
	 // Outputs the balance of Transaction route of user with API XYZ_API_KEY on MSG91.com
 }
```

##Available Providers

###1. MSG91 ([msg91.com](http://msg91.com/))
MSG91 is a SMS Service Provider. They have a great set of REST APIs that gives the flexibility in each and every thing. The Robust API is perfect for an app to that sends a large number of request. APIs are Fast and the Delivery System is also quick.

|Function Supported|Description|Provider ID|
|------------------|-----------|-----------:|
|`send()`		   | Sends the message|***msg91***|
|`showbal()`|Checks the available balance|***msg91***|


----------


---

>###More Providers Coming Soon!


----------


----------
