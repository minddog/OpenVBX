# Calls #

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
		<td></td>
	</tr>
	<tr>
		<td>To</td>
		<td></td>
	</tr>
	<tr>
		<td>StartTime</td>
		<td></td>
	</tr>
	<tr>
		<td>EndTime</td>
		<td></td>
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
		<td>to</td>
		<td>Phone number to call.</td>
	</tr>
	<tr>
		<td>from</td>
		<td>Optional - A valid ten digit or international phone number.  If not provided, will dial first active number in user's device list.</td>
	</tr>
	<tr>
		<td>callerid</td>
		<td>Optional - A Twilio number to call with</td>
	</tr>
</tbody>
</table>


POST /api/2010-06-01/Calls HTTP/1.1

HTTP Body:
     to=5551212982

    {
    	"Version": "2010-06-01",
    	"Sid": "CA85ab5377b5ae84d4ce2d74a3a972b8bb",
    	"AnnotationSid": false,
    	"MessageSid": false,
    	"From": "(555) 867-5309",
    	"To": "(555) 121-2982",
    	"StartTime": "Thu, 15 Jul 2010 19:23:56 -0700",
    	"EndTime": ""
    }
    
POST /api/2010-06-01/Calls.xml HTTP/1.1

HTTP Body:
     to=5551212982

    <?xml version="1.0"?>
    <Response version="2010-06-01">
      <Call>
        <Sid>CA1a986efd24caa03cb20bec0677aeb865</Sid>
        <ReplySid/>
        <MessageSid/>
        <From>(555) 867-5309</From>
        <To>(555) 121-2982</To>
        <StartTime>Fri, 16 Jul 2010 02:23:37 +0000</StartTime>
        <EndTime/>
      </Call>
    </Response>
    
### PUT ###
Not Implemented

### DELETE ###
Not Implemented


## URL Filtering ##

You may limit the list by providing certain query string parameters to the listing resource. Note, parameters are case-sensitive:

