# Messages #
The _Message_ resource represents an OpenVBX voicemail or sms message received by the system.  Use the _Message_ resource to retrieve messages, modify properties on messages, annotate messages, or reply back to messages via sms or voice.

## Base Resource URI ##
### /2010-06-01/Messages ###

## Resource Properties ##
A Message Instance resource is represented by the following properties:

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
		<td>A unique identifier for that message instance</td>
	</tr>
	<tr>
		<td>From</td>
		<td>The Caller ID of the telephone that made this Call. For incoming calls, it's the person who called your Twilio phone number. For outgoing calls, it's the Caller you specified for the call. Always presented as a 10 digit number, with no "decoration" (like dashes, parentheses, etc.)</td>
	</tr>
    <tr>
        <td>To</td>
        <td>The phone number of the telephone that received this Call. For incoming calls, it's one of your Twilio phone numbers. For outgoing calls, it's the person that you called. Always presented as a 10 digit number, with no "decoration" (like dashes, parentheses, etc.)</td>
    </tr>
	<tr>
		<td>Body</td>
		<td>This can be either the transcription of a voicemail or the sms text message received.</td>
	</tr>
	<tr>
		<td>RecordingUrl</td>
		<td>This is a full url to the recording of a voicemail.</td>
	</tr>
	<tr>
		<td>RecordingLength</td>
		<td>Represents the length of RecordingUrl in (mm:ss) format.</td>
	</tr>
	<tr>
		<td>Type</td>
		<td>This is the type of message received, can be either 'sms' or 'voice'.</td>
	</tr>
	<tr>
		<td>Status</td>
		<td>Represents the status of the message, whether its 'new' or 'read'.</td>
	</tr>
	<tr>
		<td>TicketStatus</td>
		<td>Represents whether the voicemail has been handled by the assigned user.  Possible values 'pending', 'open', or 'closed'.</td>
	</tr>
	<tr>
		<td>Assigned</td>
		<td>Represents UserSid of who the message is Assigned to.</td>
	</tr>
	<tr>
		<td>Unread</td>
		<td>Represents if the message is unread or not by a boolean string of 'true' or 'false'</td>
	</tr>
	<tr>
		<td>Archived</td>
		<td>Represents if the message has been archived by a boolean string of 'true' or 'false'</td>
	</tr>
	<tr>
		<td>TimeReceived</td>
		<td>The time the message was received in RFC2822 UTC Format</td>
	</tr>
	<tr>
		<td>LastUpdated</td>
		<td>The time the message was last updated in RFC2822 UTC Format</td>
	</tr>
	<tr>
		<td>Owner</td>
		<td>Represents the user or group the message belongs to.  Contains two child properties UserSid and GroupSid.</td>
	</tr>
	<tr>
		<td>Assignees</td>
		<td>Respresents a list of Users that can be assigned to this message</td>
	</tr>
	<tr>
		<td>TotalAnnotations</td>
		<td>Total number of annotations on the message</td>
	</tr>
</tbody>
</table>


# Message List Resource #

    /2010-06-01/Messages

## HTTP Methods ##

### GET ###
GET /api/2008-06-01/Messages HTTP/1.1

    {
    	"Messages": [
    		{
    			"Sid": "4",
    			"From": "(480) 334-2609",
    			"To": "(480) 334-2609",
    			"Body": "hello",
    			"RecordingUrl": "",
    			"RecordingLength": null,
    			"Type": "voice",
    			"TicketStatus": "open",
    			"Status": "read",
    			"Assigned": "3",
    			"Archived": false,
    			"Unread": false,
    			"TimeReceived": "Mon, 12 Jul 2010 22:40:39 +0000",
    			"LastUpdated": "Wed, 14 Jul 2010 23:10:18 +0000"
    		},
    		{
    			"Sid": "2",
    			"From": "(480) 334-2609",
    			"To": "(352) 364-4032",
    			"Body": "Still waiting to hear from you, thanks",
    			"RecordingUrl": "",
    			"RecordingLength": null,
    			"Type": "voice",
    			"TicketStatus": "open",
    			"Status": "read",
    			"Assigned": null,
    			"Archived": false,
    			"Unread": false,
    			"TimeReceived": "Thu, 24 Jun 2010 19:23:09 +0000",
    			"LastUpdated": "Thu, 24 Jun 2010 19:23:09 +0000"
    		}
    	}],
    	"Total": "4",
    	"Offset": 0,
    	"Max": 10,
    	"Version": "2010-06-01"
    }
    
### POST ###
Not Implemented

### PUT ###
Not Implemented

### DELETE ###
Not Implemented

## URL Filtering ##

You may limit the list by providing certain query string parameters to the listing resource. Note, parameters are case-sensitive:

* body - searches body of messages for matching string, has similiar operators for matching starting(^), between(*), or ending($) strings.
         If you want to search for anything that contains "hello"
		 
		 http://openvbx.local/api/2010-06-01/Messages?body=hello
		 
		 Starts with "hello"

   		 http://openvbx.local/api/2010-06-01/Messages?body=^hello

		 Ends with "goodbye"
		 
		 http://openvbx.local/api/2010-06-01/Messages?body=goodbye$
					 
		 Between "hello" and "goodbye"
		 
		 http://openvbx.local/api/2010-06-01/Messages?body=hello*goodbye

* archived - set to 1 to get only archived messages, by default archived messages are not returned in standard requests.
* from - find messages by specific caller or sender phone number
* to - find messages by specific number in openvbx
* ticket_status - retrieve list of messages by a comma seperated list of ticket statuses, ie: _ticket_status=open,pending_

