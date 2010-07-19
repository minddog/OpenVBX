# Message Replies #
With the Message Replies Resource, you can see communication activity between the sender of messages, respond to the sender with a phone call, or reply with an sms message.

## Base Resource URI ##
### /2010-06-01/Messages/{MessageSid}/Replies ###

## Resource Properties ##
A Reply Instance resource is represented by the following properties:

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
		<td>A unique identifier for that annotation instance</td>
	</tr>
	<tr>
		<td>MessageSid</td>
		<td>A unique identifier for that message instance</td>
	</tr>
	<tr>
		<td>SmsMessageSid</td>
		<td>A unique identifier for the corresponding SmsMessage</td>
	</tr>
	<tr>
		<td>CallSid</td>
		<td>A unique identifier for the corresponding Call Record</td>
	</tr>
	<tr>
		<td>Type</td>
		<td>Type of Method used to reply, can be either 'sms' or 'called'.</td>
	</tr>
	<tr>
		<td>UserSid</td>
		<td>User id of the user account who replied.</td>
	</tr>
	<tr>
		<td>First Name</td>
		<td>First name of user who made the reply</td>
	</tr>
	<tr>
		<td>Last Name</td>
		<td>Last name of user who made the reply</td>
	</tr>
	<tr>
		<td>Description</td>
		<td>A description of the reply or body of the message sent in the reply.</td>
	</tr>
	<tr>
		<td>Created</td>
		<td>Date and time reply was created.</td>
	</tr>
</tbody>
</table>

# Message Replies List Resource #

## HTTP Methods ##

### GET ###

GET /api/2010-06-01/Messages/{MessageSid/Replies HTTP/1.1

    {
    	"Replies": [
    		{
    			"Sid": "78",
    			"SmsMessageSid": "SM9cfc986df3fada9d13d26bf17f442ef9",
    			"CallSid": null,
    			"ActionSid": "SM9cfc986df3fada9d13d26bf17f442ef9",
    			"Type": "sms",
    			"UserSid": "1",
    			"FirstName": "Tommy",
    			"LastName": "Tillman",
    			"Description": "5554720188 to (555) 867-5309: Testing message from functional tester.",
    			"Created": "Mon, 12 Jul 2010 20:37:48 +0000",
				"MessageSid": "1"
    		},
    	],
    	"Total": 73,
    	"Max": 10,
    	"Offset": 0,
    	"Version": "2010-06-01"
    }
    
GET /api/2010-06-01/Messages/{MessageSid}/Replies.xml HTTP/1.1

    <?xml version="1.0"?>
    <Response version="2010-06-01">
      <Replies total="73" max="10" offset="0">
        <Reply>
          <Sid>78</Sid>
          <SmsMessageSid>SM9cfc986df3fada9d13d26bf17f442ef9</SmsMessageSid>
          <CallSid/>
          <Type>sms</Type>
          <UserSid>1</UserSid>
          <FirstName>Tommy</FirstName>
          <LastName>Tillman</LastName>
          <Description>5554720188 to (555) 867-5309: Testing message from functional tester.</Description>
          <Created>Mon, 12 Jul 2010 20:37:48 +0000</Created>
		  <MessageSid>1</MessageSid>
        </Reply>
      </Replies>
    </Response>
    
### POST ###
Not Implemented

### PUT ###
Not Implemented

### DELETE ###
Not Implemented

# Reply Calls List Resource #

    /2010-06-01/Messages/{MessageSid}/Replies/Calls

## HTTP Methods ##

### GET ###
Gets a list of Call Replies.

GET /api/2010-06-01/Messages/{MessageSid}/Replies/Calls HTTP/1.1

    {
    	"Replies" : [{
    		"Sid": "68",
    		"SmsMessageSid": null,
    		"CallSid": null,
    		"ActionSid": null,
    		"Type": "called",
    		"UserSid": "1",
    		"FirstName": "Tommy",
    		"LastName": "Tillman",
    		"Description": "Called back from voicemail",
    		"Created": "Sat, 10 Jul 2010 05:45:16 +0000",
			"MessageSid": "1",
    	}],
    	"Total": 65,
    	"Max": 10,
    	"Offset": 0,
    	"Version": "2010-06-01"
    }
    
GET /api/2010-06-01/Messages/{MessageSid}/Replies/Calls.xml HTTP/1.1

    <?xml version="1.0"?>
    <Response version="2010-06-01">
      <Replies total="65" max="10" offset="0">
        <Reply>
          <Sid>77</Sid>
          <SmsMessageSid/>
          <CallSid>CA68271032d9d2413a7f276c3952b5ac97</CallSid>
          <Type>called</Type>
          <UserSid>1</UserSid>
          <FirstName>Tommy</FirstName>
          <LastName>Tillman</LastName>
          <Description>Called back from voicemail</Description>
          <Created>Mon, 12 Jul 2010 20:23:24 +0000</Created>
    	  <MessageSid>1</MessageSid>
        </Reply>
      </Replies>
    </Response>
    
### POST ###
Use this method for calling back a specific message.  

Post Fields
<table class="parameters">
<thead>
    <tr>
        <th class="col-1">Property</th>
        <th class="col-2">Description</th>
    </tr>
</thead>
<tbody>
	<tr>
		<td>To</td>
		<td>Optional, the phone number to call the voicemail or sms message back.  When not supplied, To field will default to the caller who left the voicemail or text message.</td>
	</tr>
	<tr>
		<td>From</td>
		<td>Optional phone number for the caller's number.  This is the number that will receive the initial calls to connect to the "To" number.</td>
	</tr>
</tbody>
</table>


    POST https://openvbx.local/api/2010-06-01/Messages/1/Replies/Calls HTTP/1.1
    To=5558675309
    
    {
    	"Version": "2010-06-01",
    	"Sid": "CAbfe331c23f1032857db4776098b3b018",
    	"ReplySid": 89,
    	"MessageSid": "1",
    	"From": "+15553112909",
    	"To": "+15558675309",
    	"StartTime": "Mon, 19 Jul 2010 12:50:29 -0700",
    	"EndTime": ""
    }

    POST https://openvbx.local/api/2010-06-01/Messages/1/Replies/Calls.xml HTTP/1.1
    To=5558675309

    <?xml version="1.0"?>
    <Response version="2010-06-01">
      <Call>
        <Sid>CA0dcb19f75e72bb39a0c61bf7e9752e50</Sid>
        <ReplySid>90</ReplySid>
        <MessageSid>1</MessageSid>
        <From>+14803342609</From>
        <To>+14803342609</To>
        <StartTime>Mon, 19 Jul 2010 19:54:23 +0000</StartTime>
        <EndTime/>
      </Call>
    </Response>
        
### PUT ###
Not Implemented

### DELETE ###
Not Implemented

# Reply SmsMessages List Resource #

    /2010-06-01/Messages/{MessageSid}/Replies/SmsMessages

## HTTP Methods ##

### GET ###

    GET /api/2010-06-01/Messages/{MessageSid}/Replies/SmsMessages HTTP/1.1

    {
    	"Replies": [
    		{
    			"Sid": "78",
    			"SmsMessageSid": "SM9cfc986df3fada9d13d26bf17f442ef9",
    			"CallSid": null,
    			"ActionSid": "SM9cfc986df3fada9d13d26bf17f442ef9",
    			"Type": "sms",
    			"UserSid": "1",
    			"FirstName": "Tommy",
    			"LastName": "Tillman",
    			"Description": "5554720188 to (555) 867-5309: Testing message from functional tester.",
    			"Created": "Mon, 12 Jul 2010 20:37:48 +0000",
				"MessageSid": "1"
    		},
    	],
    	"Total": 8,
    	"Max": 10,
    	"Offset": 0,
    	"Version": "2010-06-01"
    }
    
    GET /api/2010-06-01/Messages/{MessageSid}/Replies/SmsMessages.xml HTTP/1.1

    <?xml version="1.0"?>
    <Response version="2010-06-01">
      <Replies total="8" max="10" offset="0">
    	  <Reply>
    		  <Sid>22</Sid>
    		  <SmsMessageSid>SM9cfc986df3fada9d13d26bf17f442ef9</SmsMessageSid>
    		  <CallSid/>
    		  <Type>sms</Type>
    		  <UserSid>1</UserSid>
    		  <FirstName>Tommy</FirstName>
    		  <LastName>Tillman</LastName>
    		  <Description>Tommy called 5557843234 back</Description>
    		  <Created>Thu, 08 Jul 2010 21:18:48 +0000</Created>
			  <MessageSid>1</MessageSid>
    	  </Reply>
      </Replies>
    </Response>
    

### POST ###
Reply to messages via SMS using this resource method.

POST Fields
<table class="parameters">
<thead>
    <tr>
        <th class="col-1">Property</th>
        <th class="col-2">Description</th>
    </tr>
</thead>
<tbody>
	<tr>
		<td>To</td>
		<td>Optional, the phone number to call the voicemail or sms message back.  When not supplied, To field will default to the caller who left the voicemail or text message.</td>
	</tr>
	<tr>
		<td>From</td>
		<td>Optional phone number for the caller's number.  This is the number that will receive the initial calls to connect to the "To" number.</td>
	</tr>
    /2010-06-01/Messages/{MessageSid}/Replies
</tbody>
</table>

    POST https://openvbx.local/api/2010-06-01/Messages/1/Replies/SmsMessages HTTP/1.1
    To=5552123421&Body=A+Text+Message

    {
    	"Sid": "SM40dab1a88055bb5c188cdb1893eea39c",
    	"ReplySid": 94,
    	"MessageSid": "1",
    	"From": "+15558675309",
    	"To": "+15552123421",
    	"Status": false,
    	"DateSent": false,
    	"Version": "2010-06-01"
    }
    
    POST https://openvbx.local/api/2010-06-01/Messages/1/Replies/SmsMessages.xml HTTP/1.1
    To=555212342&Body=A+Text+Message

    <?xml version="1.0"?>
    <Response version="2010-06-01">
      <SmsMessage>
        <Sid>SM68b3405b603954b6a9ebbdb220071105</Sid>
        <ReplySid>92</ReplySid>
        <MessageSid>1</MessageSid>
        <From>+15558675309</From>
    	<To>+15552123421</To>
        <Status/>
        <DateSent/>
      </SmsMessage>
    </Response>
    


### PUT ###
Not Implemented

### DELETE ###
Not Implemented
