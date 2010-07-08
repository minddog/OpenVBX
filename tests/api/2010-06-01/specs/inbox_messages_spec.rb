require 'config'
require 'twiliolib'
require 'rexml/document'
require 'matchers'
require 'uri'

describe "inbox/messages" do

  before(:each) do
    @api_version = API_VERSION 
    @api_user_email = API_USER_EMAIL
    @api_user_password = API_USER_PASSWORD
    @api_admin_email = API_ADMIN_EMAIL 
    @api_admin_password = API_ADMIN_PASSWORD


    # Create a Twilio REST account object using your Twilio account ID and token
    @account = Twilio::RestAccount.new(@api_user_email, @api_user_password)
    
    @resourceUrl = "api/#{@api_version}/Inbox/Messages.xml"
  end

  it "should return a list of messages" do
    resp = make_request({}, 'GET')
    resp.should have_nodes("/Response/Messages", 1)
    resp.should have_at_least_num_nodes("/Response/Messages/Message", 1)
  end

  def make_request(params, method= 'GET', url = nil)
    if url == nil
      url = @resourceUrl
    end

    resp = @account.request(url, method, params)

    return REXML::Document.new(resp.body)
  end
end
