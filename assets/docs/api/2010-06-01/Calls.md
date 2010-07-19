# Calls #
Use the Calls resource to make outbound calls.

## Base Resource URI ##
### /2010-06-01/Calls ###

## Resource Properties ##
A Call resource is represented by the following properties:

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
		<td>A unique identifier for that Call instance</td>
	</tr>
	<tr>
		<td>MessageSid</td>
		<td>A unique identifier for that <a href="Messages.md">Message</a> instance</td>
	</tr>
	<tr>
		<td>ReplySid</td>
		<td>A unique identifier for that <a href="MessageReplies.md">Reply</a> instance</td>
	</tr>
	<tr>
		<td>From</td>
		<td>An E164 number representing the Caller.</td>
	</tr>
	<tr>
		<td>To</td>
		<td>An E164 number representing the Called party.</td>
	</tr>
	<tr>
		<td>StartTime</td>
		<td>The time the call was received in RFC2822 UTC Format</td>
	</tr>
	<tr>
		<td>EndTime</td>
		<td>The time the call ended in RFC2822 UTC Format</td>
	</tr>
</tbody>
</table>

## HTTP Methods ##

### GET ###
Not Implemented

### POST ###
Using the _POST_ method will initiate an outbound phone call.

_Post Parameters_
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
		<td>A valid phone number in any format.</td>
	</tr>
	<tr>
		<td>From</td>
		<td>Optional - A valid phone number in any format.  If not provided, will dial first active number in user's device list.</td>
	</tr>
	<tr>
		<td>Callerid</td>
		<td>Optional - A Twilio number to use as callerid.  If not provided, will automatically select a twilio number.</td>
	</tr>
</tbody>
</table>


    POST /api/2010-06-01/Calls HTTP/1.1
    To=5551212982

	{
		"Version": "2010-06-01",
		"Sid": "CA46c7a71c81fd556bd20bab9a80f91c2c",
		"ReplySid": false,
		"MessageSid": false,
		"From": "+15551142309",
		"To": "+15551212982",
		"StartTime": "Mon, 19 Jul 2010 22:18:12 +0000",
		"EndTime": false
	}
    
    POST /api/2010-06-01/Calls.xml HTTP/1.1
    To=5551212982

    <?xml version="1.0"?>
    <Response version="2010-06-01">
      <Call>
        <Sid>CA48f91902f8b359067884b53000b73cc5</Sid>
        <ReplySid/>
        <MessageSid/>
        <From>+15551142309</From>
        <To>+15551212982</To>
        <StartTime>Mon, 19 Jul 2010 22:19:01 +0000</StartTime>
        <EndTime/>
      </Call>
    </Response>
        
### PUT ###
Not Implemented

### DELETE ###
Not Implemented
