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
		<td>A unique identifier for that call instance</td>
	</tr>
	<tr>
		<td>MessageSid</td>
		<td>A unique identifier for that call instance</td>
	</tr>
	<tr>
		<td>ReplySid</td>
		<td>A unique identifier for that call instance</td>
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
     from=5551212982&to=5558675309&callerid=5554511234



### PUT ###

### DELETE ###


## URL Filtering ##

You may limit the list by providing certain query string parameters to the listing resource. Note, parameters are case-sensitive:

