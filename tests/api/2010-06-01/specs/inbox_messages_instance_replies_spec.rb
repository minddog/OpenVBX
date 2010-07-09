require 'config'
require 'twiliolib'
require 'rexml/document'
require 'matchers'
require 'uri'

describe "inbox/messages/{SID}/replies" do

  before(:each) do
    @api_version = API_VERSION 
    @api_user_email = API_USER_EMAIL
    @api_user_password = API_USER_PASSWORD
    @api_admin_email = API_ADMIN_EMAIL 
    @api_admin_password = API_ADMIN_PASSWORD


    # Create a Twilio REST account object using your Twilio account ID and token
    @account = Twilio::RestAccount.new(@api_user_email, @api_user_password)
    
    @resourceUrl = "api/#{@api_version}/Inbox/Messages/1/Replies.xml"
  end

  it "should return a list of replies for a message instance" do
    resp = make_request({}, 'GET')
    resp.should have_nodes("/Response/Annotations", 1)
    resp.should have_at_least_num_nodes("/Response/Annotations/Annotation", 1)
    resp.should have_nodes("//Annotation[Type!='sms'][Type!='called']", 0)
  end

  def make_request(params, method= 'GET', url = nil)
    if url == nil
      url = @resourceUrl
    end

    resp = @account.request(url, method, params)
    print resp.body

    return REXML::Document.new(resp.body)
  end
end

