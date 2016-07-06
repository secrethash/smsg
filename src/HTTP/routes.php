<?php

// Binding Facade Trickster
App::bind('smsg', function()
{
	return new Secrethash\Smsg\Facade\Smsg;
});


// Route::get('test/smsg/checkbalance', 'secrethash\smsg\smsg@showbal');