# Message Replies #

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

    /2010-06-01/Messages/{MessageSid}/Replies

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

## URL Filtering ##

You may limit the list by providing certain query string parameters to the listing resource. Note, parameters are case-sensitive:

# Reply Calls List Resource #

    /2010-06-01/Messages/{MessageSid}/Replies/Calls

## HTTP Methods ##

### GET ###

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

### PUT ###

### DELETE ###

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

### PUT ###

### DELETE ###
