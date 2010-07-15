# OpenVBX Rest API Response Format #

## Response Formats ##
By default, OpenVBX's REST API returns a standard JSON object with a Version property.  For example, the default representation of the Label "Sales Team":

    GET http://apps.localhost.twilio.com/api/2010-06-01/Labels/Sales+Team HTTP/1.1

    {
    	"Name": "Sales Team",
    	"Sid": 1,
    	"Archived": 0,
    	"Type": "group",
    	"New": 0,
    	"Read": "1",
    	"Total": "1",
    	"Version": "2010-06-01"
    }
    
### XML ###
OpenVBX has a secondary format to retrieve responses in.  All response are wrapped in a &lt;Response/&gt; tag that include a version attribute of the API.
Below is the same example of the Label "Sales Team" request with an xml response:

    GET http://apps.localhost.twilio.com/api/2010-06-01/Labels/Sales+Team.xml HTTP/1.1
    
    <Response version="2010-06-01">
      <Label>
        <Name>Sales Team</Name>
        <Archived>0</Archived>
        <Total>1</Total>
        <Read>1</Read>
        <New>0</New>
        <Sid>1</Sid>
        <Type>group</Type>
      </Label>
    </Response>

## Errors ##
OpenVBX returns errors as a main property on the response object for easy to write error checking code within your favorite language.  The Message property is populated when an error is returned.  All errors should return the proper HTTP status code.  When a resource is not found like the example below, a status code of 404 is returned.

    {
	    "Error": true,
	    "Message": "No label found by the name: Sales",
	    "Version": "2010-06-01"
	}

