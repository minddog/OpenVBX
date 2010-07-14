require 'config'
require 'twiliolib'
require 'rexml/document'
require 'matchers'
require 'uri'

describe "calls" do

  before(:each) do
    @api_version = API_VERSION 
    @api_user_email = API_USER_EMAIL
    @api_user_password = API_USER_PASSWORD
    @api_admin_email = API_ADMIN_EMAIL 
    @api_admin_password = API_ADMIN_PASSWORD
    @testing_phone_number = TESTING_PHONE_NUMBER
    @testing_twilio_number = TESTING_TWILIO_NUMBER

    # Create a Twilio REST account object using your Twilio account ID and token
    @account = Twilio::RestAccount.new(@api_user_email, @api_user_password)
    
    @resourceUrl = "api/#{@api_version}/Calls.xml"
  end

  it "should return a list of replies for a message instance" do
    resp = make_request({}, 'GET')
    resp.should have_nodes("/Response/Calls", 1)
  end

  it "should make a phone call back to the caller" do
    resp = make_request({ 
                          :from => @testing_phone_number,
                          :to => @testing_phone_number,
                          :callerid => @testing_twilio_number
                        }, 'POST')
    resp.should have_nodes("/Response/Call", 1)
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