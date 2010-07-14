# Label Resource #
The _Label_ resource represents an overview of an OpenVBX user's inbox.

## Base Resource URI ##
### /2010-06-01/Labels ###

# Label Resource #
The Label resource represents an overview of a specific set of messages. 

## Resource Properties ##
A Label resource is represented by the following properties:

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

# Labels List Resource #
This resource manages a list of labels that exist for a user's account.  This is the same list that appears in the navigation menu of OpenVBX Web Interface under Messages.

    /2010-06-01/Labels

## HTTP Methods ##

### GET ###
Returns an overview of the OpenVBX user's inbox and labels.  

GET /api/2010-06-01/Labels HTTP/1.1

    {
    	"Labels": [
    		{
    			"Name": "Label",
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
    
GET /api/2010-06-01/Labels.xml HTTP/1.1

    <Response version="2010-06-01">
    	<Labels>
    		<Label>
    			<Name>Label</Name>
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
    	</Labels>
    </Response> 
    
### POST ###
Not Implemented

### PUT ###
Not Implemented

### DELETE ###
Not Implemented

# Label Instance Resource #
This resource represents a specific instance of a label.  

    /2010-06-01/Labels/{LabelName}

## HTTP Methods ##

### GET ###
Returns an instance of a Label

GET /api/2010-06-01/Labels/{LabelName} HTTP/1.1

    {
    	"Name": "Sales",
    	"Sid": "1",
    	"Archived": 0,
    	"Type": "group",
    	"New": "1",
    	"Read": 0,
    	"Total": "1",
    	"Version": "2010-06-01"
    } 
	
GET http://apps.localhost.twilio.com/api/2010-06-01/Labels/Sales.xml

    <?xml version="1.0"?>
    <Response version="2010-06-01">
    	<Label>
    		<Name>Sales</Name>
    		<Archived>0</Archived>
    		<Total>1</Total>
    		<Read>0</Read>
    		<New>1</New>
    		<Sid>1</Sid>
    		<Type>group</Type>
    	</Label>
    </Response>
    

### POST ###
Not Implemented

### PUT ###
Not Implemented

### DELETE ###
Not Implemented

# Label Instance Sub Resources #

# Messages #

http://apps.localhost.twilio.com/api/2010-06-01/Labels/Sales/Messages

Returns a list of messages that are under that label name. See the [Messages](Messages) section for the response format.
