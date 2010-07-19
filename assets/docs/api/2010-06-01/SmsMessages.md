# SmsMessages #
Use SmsMessage resource to make outbound text messages with OpenVBX.

## Base Resource URI ##
### /2010-06-01/SmsMessages ###

## Resource Properties ##
A SmsMessage resource is represented by the following properties:

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
		<td>A unique identifier for that sms message instance</td>
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
		<td>An E164 number representing the Sender.</td>
	</tr>
	<tr>
		<td>To</td>
		<td>An E164 number representing the Receiving party.</td>
	</tr>
	<tr>
		<td>DateSent</td>
		<td>The time the message was updated in RFC2822 UTC Format</td>
	</tr>
</tbody>
</table>

## HTTP Methods ##

### GET ###
Not Implemented

### POST ###
Send an SMS Message to someone.

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
		<td>Optional - A Twilio number to use as callerid.  If not provided, will automatically select a twilio number.</td>
	</tr>
	<tr>
		<td>Body</td>
		<td>Message to be sent to recipient.  Message is limited to 160 characters.</td>
	</tr>
</tbody>
</table>


POST /api/2010-06-01/SmsMessages HTTP/1.1
    
to=5558675309

    {
    	"Sid": "SM3ff62308179d8ecd8be42bf253911556",
    	"ReplySid": false,
    	"MessageSid": false,
    	"From": "(555) 121-3309",
    	"To": "(555) 867-5309",
    	"Status": "queued",
    	"DateSent": "Fri, 16 Jul 2010 18:39:43 +0000",
    	"Version": "2010-06-01"
    }
    
POST /api/2010-06-01/SmsMessages.xml HTTP/1.1

to=5558675309

    <?xml version="1.0"?>
    <Response version="2010-06-01">
      <SmsMessage>
        <Sid>SMd49e1d78580d002428fa22399fc1e77a</Sid>
        <ReplySid/>
        <MessageSid/>
        <From>(555) 331-1139</From>
        <To>(555) 867-5309</To>
        <Status>queued</Status>
        <DateSent>Fri, 16 Jul 2010 18:25:24 +0000</DateSent>
      </SmsMessage>
    </Response>
    
### PUT ###
Not Implemented

### DELETE ###
Not Implemented

## URL Filtering ##

You may limit the list by providing certain query string parameters to the listing resource. Note, parameters are case-sensitive:

