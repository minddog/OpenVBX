# OpenVBX Rest API Interface
The OpenVBX Rest API allows you to query resources stored in OpenVBX, like your voicemail, sms messages, or make phone calls.

Since the API is based on REST principles, it's very easy to write and test applications.  You can use your own browser to access URLs, and you can pretty much use any http-client in any programming language to interact with the API.

## Base URL ##
https://openvbx.local/api/2010-06-01


## HTTP and HTTPS ##
We recommend all OpenVBX administrators to host OpenVBX on an SSL based webserver to prevent eavesdropping of peoples passwords.

## About REST ##
You can check out more information on what REST means on [Wikipedia](http://en.wikipedia.org/wiki/Representational_State_Transfer)

We strived to build a very RESTy interface, so that developers can make accurate assumptions on what HTTP methods will perform corresponding operations.

### Protocol ###
* Stateless Resources
* Client-Server Model


## Overview ##
* [Request Formats](Request)
* [Response Formats](Response)

## Rest API Reference ##
### Resources supported in version _2010-06-01_ of the REST API ###
* [Labels](Labels)
* [Messages](Messages)
 * [Message Annotations](MessageAnnotations)
 * [Message Replies](MessageReplies)
* [Numbers](Numbers)
* [Calls](Calls)
* [SmsMessages](SmsMessages)

### Resources outside of OpenVBX API version scheme ###
* [API Versions](Api) 