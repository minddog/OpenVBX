# Numbers #

## Base Resource URI ##
### /2010-06-01/Numbers ###

## Resource Properties ##
A Number resource is represented by the following properties:

<table class="parameters">
<thead>
    <tr>
        <th class="col-1">Property</th>
        <th class="col-2">Description</th>
    </tr>
</thead>
<tbody>
	<tr>
		<td>Sid</td>
		<td>A unique identifier for that call instance</td>
	</tr>
	<tr>
    	<td>Name</td>
		<td>Formatted phone number, eg: (555) 358-0978, or the assigned Twilio name.  You can change this in your twilio account portal.</td>
	</tr>
	<tr>
		<td>Phone</td>
		<td>An E164 formatted phone number that can be used to send or receive calls and/or text messages.</td>
	</tr>
    <tr>
		<td>Sandbox</td>
		<td>A boolean value that is true when the number is a valid sandbox number.  A corresponding "Pin" will be accompanied with this resource.</td>
	</tr>
	<tr>
		<td>Pin</td>
		<td>An optional value that contains an 8 digit pin code when the Number resource is a sandbox number.</td>
	</tr>
	<tr>
		<td>Installed</td>
    	<td>The Installed property describes a Number resource as being installed with an OpenVBX Flow.</td>
	</tr>
	<tr>
		<td>VoiceUrl</td>
    	<td>The URL assigned to the number for Incoming calls.</td>
	</tr>
	<tr>
		<td>VoiceMethod</td>
		<td>The HTTP Method to be performed on the VoiceUrl for Incoming Calls.</td>
	</tr>
	<tr>
		<td>SmsUrl</td>
    	<td>The URL assigned to the number for Incoming text messages.</td>
	</tr>
	<tr>
		<td>SmsMethod</td>
		<td>The HTTP Method to be performed on the SmsUrl for Incoming text messages.</td>
	</tr>
    <tr>
		<td>FlowSid</td>
		<td>The flow id assigned to the number</td>
	</tr>
</tbody>
</table>

## HTTP Methods ##

### GET ###

    GET http://openvbx.local/api/2010-06-01/Numbers HTTP/1.1

    {
    	"Numbers" : {
    		"Sid": "PN891b2cb175992a991b6bf4f4e1e1cbb6",
    		"Name": "(207) 358-0978",
    		"Phone": "+12073580978",
    		"Pin": null,
    		"Sandbox": false,
    		"Installed": false,
    		"VoiceUrl": "http:\/\/discover.dev.twilio.com\/final-walkthrough4\/twiml\/start\/voice\/4",
    		"VoiceMethod": "POST",
    		"SmsUrl": "http:\/\/discover.dev.twilio.com\/final-walkthrough4\/twiml\/start\/sms\/4",
    		"SmsMethod": "POST",
    		"FlowSid": 4
    	}
    ],
    "Total": 1,
    "Max": 50,
    "Page": 0,
    "Version": "2010-06-01"
    }

    GET http://openvbx.local/api/2010-06-01/Numbers.xml HTTP/1.1

    <?xml version="1.0"?>
    <Response>
    	<Numbers total="1" max="50" page="0">
    		<Number>
    			<Sid>PN891b2cb175992a991b6bf4f4e1e1cbb6</Sid>
    			<Name>(207) 358-0978</Name>
    			<Phone>+12073580978</Phone>
    			<Pin/>
    			<Sandbox>false</Sandbox>
    			<Installed>false</Installed>
    			<VoiceUrl>http://discover.dev.twilio.com/final-walkthrough4/twiml/start/voice/4</VoiceUrl>
    			<VoiceMethod>POST</VoiceMethod>
    			<SmsUrl>http://discover.dev.twilio.com/final-walkthrough4/twiml/start/sms/4</SmsUrl>
    			<SmsMethod>POST</SmsMethod>
    			<FlowSid>4</FlowSid>
    		</Number>
    	</Numbers>
    </Response>
    
    
### POST ###
Not Implemented

### PUT ###
Not Implemented

### DELETE ###
Not Implemented

