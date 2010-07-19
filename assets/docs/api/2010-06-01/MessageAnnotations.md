# Message Annotations #
Message Annotations are resources for messages that describe changes, calls, sms replies, and private notes.  If you want to retrive a list of annotations for a particular type, for instance all private notes, you would use the Message Annotations resource.  You can also create new Message Annotations with this resource for any sort of custom client development.  

## Base Resource URI ##
### /2010-06-01/Messages/{MessageSid}/Annotations ###

## Resource Properties ##
An Annotation Instance resource is represented by the following properties:

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
		<td>Type of Method used to reply, eg: "changed", "noted", "sms", "called".</td>
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

## HTTP Methods ##

### GET ###

GET /api/2010-06-01/Messages/{MessageSid}/Annotations HTTP/1.1

    {
    	[{
    		"Sid": "73",
    		"SmsMessageSid": null,
    		"CallSid": "CAc902eb1d88390ba34d3013374574f05d",
    		"Type": "called",
    		"UserSid": "1",
    		"FirstName": "Tennan",
    		"LastName": "Baum",
    		"Description": "Called back from voicemail",
    		"Created": "Mon, 12 Jul 2010 19:58:47 +0000",
    		"MessageSid": "1"
    	}],
    	"Total": 1,
    	"Max": 10,
    	"Offset": 0,
    	"Version": "2010-06-01"
    }
    
GET /api/2010-06-01/Messages/{MessageSid}/Annotations.xml HTTP/1.1

    <?xml version="1.0"?>
    <Response version="2010-06-01">
      <Annotations total="1" max="10" offset="0">
        <Annotation>
          <Sid>71</Sid>
          <SmsMessageSid/>
          <CallSid/>
          <Type>called</Type>
          <UserSid>1</UserSid>
          <FirstName>Doug</FirstName>
          <LastName>Colt</LastName>
          <Description>Called back from voicemail</Description>
          <Created>Sat, 10 Jul 2010 05:54:20 +0000</Created>
          <MessageSid>1</MessageSid>
        </Annotation>
      </Annotations>
    </Response>
    

### POST ###
Creates a new Annotation

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
		<td>type</td>
		<td>Type of annotation.  Defaults to "notes".  Options are "called", "sms", and "note".</td>
	</tr>
	<tr>
		<td>body</td>
		<td>Summary of the annotation</td>
	</tr>
</tbody>
</table>

POST /api/2010-06-01/Messages/{MessageSid}/Annotations HTTP/1.1

type=notes&body=MyNote

    {
    	"Sid": "79",
    	"SmsMessageSid": null,
    	"CallSid": null,
    	"Type": "changed",
    	"UserSid": "1",
    	"FirstName": "Jerry",
    	"LastName": "Howl",
    	"Description": "Assigned to jhowl@example.com",
    	"Created": "Wed, 14 Jul 2010 23:10:18 +0000",
    	"MessageSid": "1",
    	"Version": "2010-06-01"
    }

POST /api/2010-06-01/Messages/{MessageSid}/Annotations HTTP/1.1

type=notes&body=MyNote

<?xml version="1.0"?>
<Response version="2010-06-01">
  <Annotation>
    <Sid>79</Sid>
    <SmsMessageSid/>
    <CallSid/>
    <Type>changed</Type>
    <UserSid>1</UserSid>
    <FirstName>Jerry</FirstName>
    <LastName>Howl</LastName>
    <Description>Assigned to jhowl@example.com</Description>
    <Created>Wed, 14 Jul 2010 23:10:18 +0000</Created>
    <MessageSid>1</MessageSid>
  </Annotation>
</Response>
    

### PUT ###

### DELETE ###

## URL Filtering ##

You may limit the list by providing certain query string parameters to the listing resource. Note, parameters are case-sensitive:

* Type - Filter by Annotation Type.  Filter types available: "called", "sms", "noted", "changed".

If you would like to filter all changes to see the change log history:

GET http://openvbx.local/api/2010-06-01/Messages/1/Annotations/?Type=changed HTTP/1.1

# Message Annotation Instace Resource

### /2010-06-01/Messages/{MessageSid}/Annotations/{AnnotationSid} ###

### GET ###

GET /2010-06-01/Messages/{MessageSid}/Annotations/80 HTTP/1.1

{
	"Sid": "80",
	"SmsMessageSid": null,
	"CallSid": "CAccfee8f13fd3ece7cb2be772334f2b07",
	"Type": "called",
	"UserSid": "1",
	"FirstName": "Jerry",
	"LastName": "Howl",
	"Description": "Called back from voicemail",
	"Created": "Fri, 16 Jul 2010 00:47:56 +0000",
	"MessageSid": "1",
	"Version": "2010-06-01"
}

GET /2010-06-01/Messages/{MessageSid}/Annotations/80.xml HTTP/1.1

<Response version="2010-06-01">
  <Annotation>
    <Sid>80</Sid>
    <SmsMessageSid/>
    <CallSid>CAccfee8f13fd3ece7cb2be772334f2b07</CallSid>
    <Type>called</Type>
    <UserSid>1</UserSid>
    <FirstName>Jerry</FirstName>
    <LastName>Howl</LastName>
    <Description>Called back from voicemail</Description>
    <Created>Fri, 16 Jul 2010 00:47:56 +0000</Created>
    <MessageSid>1</MessageSid>
  </Annotation>
</Response>


### POST ###
Not Implemented

### PUT ###
Not Implemented

### DELETE ###
Not Implemented
