require 'config'
require 'twiliolib'
require 'rexml/document'
require 'matchers'
require 'uri'

describe "messages/{SID}" do

  before(:each) do
    @api_version = API_VERSION 
    @api_user_email = API_USER_EMAIL
    @api_user_password = API_USER_PASSWORD
    @api_admin_email = API_ADMIN_EMAIL 
    @api_admin_password = API_ADMIN_PASSWORD


    # Create a Twilio REST account object using your Twilio account ID and token
    @account = Twilio::RestAccount.new(@api_user_email, @api_user_password)
    
    @resourceUrl = "api/#{@api_version}/Messages/1.xml"
  end

  it "should return an instance of a message" do
    resp = make_request({}, 'GET')
    resp.should have_nodes("/Response/Message", 1)
  end

  def make_request(params, method= 'GET', url = nil)
    if url == nil
      url = @resourceUrl
    end

    resp = @account.request(url, method, params)

    return REXML::Document.new(resp.body)
  end
end
