# SmsMessages #

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
		<td></td>
	</tr>
	<tr>
		<td>To</td>
		<td></td>
	</tr>
	<tr>
		<td>DateSent</td>
		<td></td>
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
		<td>to</td>
		<td>Phone number to call.</td>
	</tr>
	<tr>
		<td>from</td>
		<td>Optional - A valid ten digit or international phone number.  If not provided, will dial first active number in user's device list.</td>
	</tr>
	<tr>
		<td>body</td>
		<td>SMS Message to be received.</td>
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

