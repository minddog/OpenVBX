# Inbox Resource #
The _Inbox_ resource represents an overview of an OpenVBX user's inbox, describing the number of messages by status and label.

## Base Resource URI ##
### /2010-06-01/Inbox ###

## Resource Properties ##
An <Inbox> resource is represented by the following properties:

<table class="parameters">
<thead>
    <tr>
        <th class="col-1">Property</th>
        <th class="col-2">Description</th>
    </tr>
</thead>
<tbody>
    <tr>
        <td>Total</td>
        <td>Total number of messages in the user's inbox</td>
    </tr>
	<tr>
		<td>Read</td>
		<td>Number of read messages in the user's inbox</td>
	</tr>
	<tr>
		<td>New</td>
		<td>Number of new messages in the user's inbox</td>
	</tr>
	<tr>
		<td>Archived</td>
		<td>Number of archived messages in the user's inbox</td>
	</tr>
	<tr>
		<td>Labels</td>
		<td>A list of Label resources representing a grouping of messages</td>
	</tr>
</tbody>
</table>

# Label Resource #
The <Label> resource represents an overview of a specific set of messages.  It is similar to its parent <Inbox> resource in regards to counts of different message statuses.

## Resource Properties ##
A <Label> resource is represented by the following properties:

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
		<td>A unique identifier for that inbox label</td>
	</tr>
    <tr>
        <td>Total</td>
        <td>Total number of messages in the label</td>
    </tr>
	<tr>
		<td>Read</td>
		<td>Number of read messages in the label</td>
	</tr>
	<tr>
		<td>New</td>
		<td>Number of new messages in the label</td>
	</tr>
	<tr>
		<td>Archived</td>
		<td>Number of archived messages in the label</td>
	</tr>
</tbody>
</table>

# Inbox Factory Resource #
HTTP Methods

## GET ##
Returns an overview of the OpenVBX user's inbox and labels.  Represented by <Inbox> and <Label> resources.

GET /api/2010-06-01/Inbox.json HTTP/1.1

    {
    	"Total": 3,
    	"Archived": 0,
    	"New": 2,
    	"Read": 1,
    	"Labels": [
    		{
    			"Name": "Inbox",
    			"Sid": 0,
    			"Archived": 0,
    			"Type": "inbox",
    			"New": "2",
    			"Read": "1",
    			"Total": "3"
     		},
    		{
    			"Name": "Sales",
    			"Sid": "1",
    			"Archived": 0,
    			"Type": "group",
    			"New": 0,
    			"Read": 0,
    			"Total": 0
    		},
    		{
    			"Name": "Support",
    			"Sid": "2",
    			"Archived": 0,
    			"Type": "group",
    			"New": 0,
    			"Read": 0,
    			"Total": 0
    		}
    	],
    	"Version": "2010-06-01"
    }
    
GET /api/2010-06-01/Inbox.xml HTTP/1.1

    <Response version="2010-06-01">
    	<Inbox>
    		<Label>
    			<Name>Inbox</Name>
    			<Archived>0</Archived>
    			<Total>3</Total>
    			<Read>1</Read>
    			<New>2</New>
    			<Sid>0</Sid>
				<Type>inbox</Type>
    		</Label>
    		<Label>
    			<Name>Sales</Name>
    			<Archived>0</Archived>
    			<Total>0</Total>
    			<Read>0</Read>
    			<New>0</New>
    			<Sid>1</Sid>
				<Type>group</Type>
    		</Label>
    		<Label>
    			<Name>Support</Name>
    			<Archived>0</Archived>
    			<Total>0</Total>
    			<Read>0</Read>
    			<New>0</New>
    			<Sid>2</Sid>
				<Type>group</Type>
    		</Label>
    		<Total>3</Total>
    		<Read>1</Read>
    		<New>2</New>
    		<Archived>0</Archived>
    	</Inbox>
    </Response> 
    
## POST ##
Not Implemented

## PUT ##
Not Implemented

## DELETE ##
Not Implemented


Inbox Label Instance
