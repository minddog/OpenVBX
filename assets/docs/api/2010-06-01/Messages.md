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
		<td>A unique identifier, long integer, for that Message Resource instance. </td>
	</tr>
	<tr>
		<td>Type</td>
		<td>This is the type of message received, can be either 'sms' or 'voice'.</td>
	</tr>
	<tr>
		<td>From</td>
        <td>The phone number of the telephone that made this Call. For incoming calls, it's the person that called you. Always presented as an E164 formatted number. For outgoing calls, it's one of your Twilio phone numbers.  For example, +15558675309.</td>
	</tr>
    <tr>
        <td>To</td>
        <td>The phone number of the telephone that received this Call. For incoming calls, it's one of your Twilio phone numbers. For outgoing calls, it's the person that you called. Always presented as an E164 formatted number.  For example, +15558675309.</td>
    </tr>
	<tr>
		<td>Body</td>
		<td>This can be either the transcription of a voicemail or the sms text message received.  Maximum length of Body is 64k characters.</td>
	</tr>
	<tr>
		<td>AudioRecordingUrl</td>
		<td>This is a full url to the recording of a voicemail.  If hosted on twilio.com, default format is wav, which can be changed to mp3 by appending .mp3. See the [Twilio Recordings](http://www.twilio.com/docs/api/2008-08-01/rest/recording) for more info.</td>
	</tr>
	<tr>
		<td>AudioRecordingLength</td>
		<td>Represents the length of AudioRecording in seconds referenced in the AudioRecordingUrl property.</td>
	</tr>
	<tr>
		<td>Status</td>
		<td>Represents whether the voicemail has been handled by the assigned user.  Possible values 'pending', 'open', or 'closed'.</td>
	</tr>
	<tr>
		<td>AssignedToUserSid</td>
		<td>Represents User of whom the message is Assigned to.</td>
	</tr>
	<tr>
		<td>AssignedToUserFriendlyName</td>
		<td>Represents User's FriendlyName of whom the message is Assigned to.</td>
	</tr>
	<tr>
		<td>IsUnread</td>
		<td>Represents if the message is unread or not by a boolean string of 'true' or 'false'</td>
	</tr>
	<tr>
		<td>IsArchived</td>
		<td>Represents if the message has been archived by a boolean string of 'true' or 'false'</td>
	</tr>
	<tr>
		<td>Labels</td>
		<td>Represents a list of Labels the message is mapped to, ie: "Labels" : ["Inbox", "Sales"]</td>
	</tr>
	<tr>
		<td>GroupSid</td>
		<td>Id of the group this message belongs to.</td>
	</tr>
	<tr>
		<td>Assignees</td>
		<td>Respresents a list of Users that can be assigned to this message</td>
	</tr>
	<tr>
		<td>NumAnnotations</td>
		<td>Total number of annotations to the message</td>
	</tr>
	<tr>
		<td>DateCreated</td>
		<td>The time the message was received in RFC2822 UTC Format. Ex: Mon, 19 Jul 2010 22:19:01 +0000</td>
	</tr>
	<tr>
		<td>DateUpdated</td>
		<td>The time the message was last updated in RFC2822 UTC Format. Ex: Mon, 19 Jul 2010 22:19:01 +0000</td>
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
    			"From": "+1555142109",
    			"To": "+15551342209",
    			"Body": "hello",
    			"AudioRecordingUrl": "http://myexamplerecording.com/hello.mp3",
    			"AudioRecordingLength": "00:51",
    			"Type": "voice",
    			"TicketStatus": "open",
    			"Status": "read",
    			"Assigned": "3",
    			"Archived": false,
    			"Unread": false,
    			"DateCreated": "Mon, 12 Jul 2010 22:40:39 +0000",
    			"LastUpdated": "Wed, 14 Jul 2010 23:10:18 +0000"
    		},
    		{
    			"Sid": "2",
    			"From": "+15558675309",
    			"To": "+13523644032",
    			"Body": "Still waiting to hear from you, thanks",
    			"AudioRecordingUrl": "",
    			"AudioRecordingLength": null,
    			"Type": "sms",
    			"TicketStatus": "open",
    			"Status": "read",
    			"Assigned": null,
    			"Archived": false,
    			"Unread": false,
    			"DateCreated": "Thu, 24 Jun 2010 19:23:09 +0000",
    			"LastUpdated": "Thu, 24 Jun 2010 19:23:09 +0000"
    		}
    	}],
    	"Total": "2",
    	"Offset": 0,
    	"Max": 10,
    	"Version": "2010-06-01"
    }

GET /api/2008-06-01/Messages.json HTTP/1.1

    <?xml version="1.0"?>
    <Response version="2010-06-01">
      <Messages total="2" offset="0" max="10">
        <Message>
          <Sid>4</Sid>
          <From>+15558675309</From>
          <To>+15558675309</To>
          <Body>hello</Body>
          <DateCreated>Mon, 12 Jul 2010 22:40:39 +0000</DateCreated>
          <LastUpdated>Wed, 14 Jul 2010 23:10:18 +0000</LastUpdated>
          <AudioRecordingUrl>http://myexamplerecording.com/hello.mp3</AudioRecordingUrl>
          <AudioRecordingLength>00:58</AudioRecordingLength>
          <Type>voice</Type>
          <TicketStatus>open</TicketStatus>
          <Status>read</Status>
          <Archived>false</Archived>
          <Unread>false</Unread>
        </Message>
        <Message>
          <Sid>2</Sid>
          <From>+15558675309</From>
          <To>+15558675309</To>
          <Body>Still waiting to hear from you, thanks</Body>
          <DateCreated>Thu, 24 Jun 2010 19:23:09 +0000</DateCreated>
          <LastUpdated>Thu, 24 Jun 2010 19:23:09 +0000</LastUpdated>
          <AudioRecordingUrl/>
          <AudioRecordingLength/>
          <Type>sms</Type>
          <TicketStatus>open</TicketStatus>
          <Status>read</Status>
          <Archived>false</Archived>
          <Unread>false</Unread>
        </Message>
      </Messages>
    </Response>
    																																																																																							
    
### POST ###
Not Implemented

### PUT ###
Not Implemented

### DELETE ###
Not Implemented

## URL Filtering ##

You may limit the list by providing certain query string parameters to the listing resource. Note, parameters are case-sensitive:

* GroupSid - filter messages that match a specific group

* Labels - filters messages that match the comma seperated list of Labels

     http://openvbx.local/api/2010-06-01/Messages?Labels=Inbox,Sales

     http://openvbx.local/api/2010-06-01/Messages?Labels=Sales


* Body - searches body of messages for matching string, has similiar operators for matching starting(^), between(*), or ending($) strings.
         If you want to search for anything that contains "hello"
		 
		 http://openvbx.local/api/2010-06-01/Messages?body=hello
		 
		 Starts with "hello"

   		 http://openvbx.local/api/2010-06-01/Messages?body=^hello

		 Ends with "goodbye"
		 
		 http://openvbx.local/api/2010-06-01/Messages?body=goodbye$
					 
		 Between "hello" and "goodbye"
		 
		 http://openvbx.local/api/2010-06-01/Messages?body=hello*goodbye
* Archived - set to 1 to get only archived messages, by default archived messages are not returned in standard requests.
* From - find messages by specific caller or sender phone number
* To - find messages by specific number in openvbx
* Status - retrieve list of messages by a comma seperated list of ticket statuses, ie: _ticket_status=open,pending_

# Message Instance Resource #

    /2010-06-01/Messages/{MessageSid}

## HTTP Methods ##

### GET ###
Retrieves full details on a message resource.

GET /api/2008-06-01/Messages/1 HTTP/1.1

    {
    	"Sid": "1",
    	"Type": "voice",
    	"From": "+15557685309",
    	"To": "+15553644032",
    	"Body": "Hey ... can you give me a ring back, very important",
    	"AudioRecordingUrl": "http://myexamplerecording.com/hello.mp3",
    	"AudioRecordingLength": 58,
    	"Status": "open",
    	"Assigned": null,
    	"Archived": false,
    	"Unread": false,
    	"DateCreated": "Thu, 24 Jun 2010 19:23:08 +0000",
    	"LastUpdated": "Thu, 24 Jun 2010 19:23:08 +0000",
		"Labels" : ["Inbox", "Sales"],
    	"Assignees": [
    		{
    			"FirstName": "Terry",
    			"LastName": "Tornado",
    			"Email": "terry@tornado.com",
    			"Sid": "1"
    		},
    		{
    			"FirstName": "Barry",
    			"LastName": "Goldwater",
    			"Email": "barry@goldwater.com",
    			"Sid": "3"
    		}
    	],
    	"TotalAnnotations": 0,
    	"Version": "2010-06-01"
    }
    
GET /api/2008-06-01/Messages/1.xml HTTP/1.1

    <?xml version="1.0"?>
    <Response version="2010-06-01">
      <Message>
        <Sid>1</Sid>
        <From>(480) 334-2609</From>
        <To>(352) 364-4032</To>
        <Body>Hey ... can you give me a ring back, very important</Body>
        <DateCreated>Thu, 24 Jun 2010 19:23:08 +0000</DateCreated>
        <LastUpdated>Thu, 24 Jun 2010 19:23:08 +0000</LastUpdated>
        <AudioRecordingUrl>http://myexamplerecording.com/hello.mp3</AudioRecordingUrl>
        <AudioRecordingLength>00:58</AudioRecordingLength>
        <Type>voice</Type>
        <TicketStatus>open</TicketStatus>
        <Status>read</Status>
        <Archived>false</Archived>
        <Unread>false</Unread>
        <Owner>
          <UserSid>1</UserSid>
          <GroupSid/>
        </Owner>
        <Assignees>
          <Assignee>
            <FirstName>Terry</FirstName>
            <LastName>Tornado</LastName>
            <Email>terry@tornado.com</Email>
            <Sid>1</Sid>
          </Assignee>
          <Assignee>
            <FirstName>Barry</FirstName>
            <LastName>Goldwater</LastName>
            <Email>barry@goldwater.com</Email>
            <Sid>3</Sid>
          </Assignee>
        </Assignees>
      </Message>
    </Response>
    
### POST ###
Update a limited number of properties on a message.

Parameters to POST
... TBD ...

### PUT ###
Not Implemented

### DELETE ###
Not Implemented

# Message Instance Sub Resources #

# Annotations #

http://apps.localhost.twilio.com/api/2010-06-01/Messages/{MessageSid}/Annotations

Returns a list of annotations that belong to the Message Resource.  See the [Message Annotations](MessageAnnotations) section for the response format.

# Replies #

http://apps.localhost.twilio.com/api/2010-06-01/Messages/{MessageSid}/Replies

Returns a list of replies that belong to the Message Resource.  See the [Message Replies](MessageReplies) section for the response format.
