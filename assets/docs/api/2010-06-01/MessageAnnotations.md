# Message Annotations #

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

## HTTP Methods ##

### GET ###

GET /api/2010-06-01/Messages/{MessageSid}/Annotations HTTP/1.1



GET /api/2010-06-01/Messages/{MessageSid}/Annotations.xml HTTP/1.1

### POST ###

### PUT ###

### DELETE ###

## URL Filtering ##

You may limit the list by providing certain query string parameters to the listing resource. Note, parameters are case-sensitive:

