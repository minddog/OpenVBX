require 'config'
require 'twiliolib'
require 'rexml/document'
require 'matchers'
require 'uri'

describe "inbox/messages/{SID}/annotations" do

  before(:each) do
    @api_version = API_VERSION 
    @api_user_email = API_USER_EMAIL
    @api_user_password = API_USER_PASSWORD
    @api_admin_email = API_ADMIN_EMAIL 
    @api_admin_password = API_ADMIN_PASSWORD


    # Create a Twilio REST account object using your Twilio account ID and token
    @account = Twilio::RestAccount.new(@api_user_email, @api_user_password)
    
    @resourceUrl = "api/#{@api_version}/Inbox/Messages/1/Annotations.xml"
  end

  it "should return a list of annotations for a message instance" do
    resp = make_request({}, 'GET')
    resp.should have_nodes("/Response/Annotations", 1)
  end

  it "should create a new SMS reply annotation" do
    resp = make_request({:body => 'SMS body', :type => 'sms'}, 'POST')
    resp.should have_nodes("/Response/MessageSid", 1)
    resp.should have_nodes("/Response/Sid", 1)
  end

  it "should create a new Private Note annotation" do
    resp = make_request({:body => 'A private note, hide me', :type => 'noted'}, 'POST')
    resp.should have_nodes("/Response/MessageSid", 1)
    resp.should have_nodes("/Response/Sid", 1)
  end

  it "should create a new Called Back annotation" do
    resp = make_request({:body => 'Adam called 5557843234 back', :type => 'called'}, 'POST')
    resp.should have_nodes("/Response/MessageSid", 1)
    resp.should have_nodes("/Response/Sid", 1)
  end

  it "should create a new Changed Notification annotation" do
    resp = make_request({:body => 'Something changed', :type => 'changed'}, 'POST')
    resp.should have_nodes("/Response/MessageSid", 1)
    resp.should have_nodes("/Response/Sid", 1)
  end

  it "should generate an error creating an annotation" do
    resp = make_request({:body => 'testing', 'type' => 'asdf'}, 'POST')
    resp.should have_nodes("/Response/Error", 1)
    resp.should have_nodes("/Response/Message", 1)
  end

  it "should generate an error creating an annotation" do
    resp = make_request({:body => 'testing'}, 'POST')
    resp.should have_nodes("/Response/Error", 1)
    resp.should have_nodes("/Response/Message", 1)
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

