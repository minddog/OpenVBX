# OpenVBX Rest API Request Format #

## Authentication ##
To authenticate with the OpenVBX Rest API, you can use either HTTP Basic Auth or HTTP Digest. We recommend you run your OpenVBX installations under an SSL protected webserver to prevent sending your credentials in the clear.

Easily test Authentication with curl on the command line or by visiting the URL to your REST resource in your browser.

    curl -X GET -u adam@testing.com https://openvbx.local/api/2010-06-01/Messages

## Requests ##

### URL Resources ###
You can access REST Resources in the API as either json or xml.  Just append the extension for the format you want to request to the URI. 

#### XML Requests ####
    https://openvbx.local/api/2010-06-01/Messages.xml


#### JSON Requests - Optional extension ####
    https://openvbx.local/api/2010-06-01/Messages
    https://openvbx.local/api/2010-06-01/Messages.json

By default, all requests are natively JSON based.
