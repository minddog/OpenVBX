require 'yaml'
require 'twiliolib'

env = 'local'
if ENV['VBX_TEST_ENV']
    env = ENV['VBX_TEST_ENV']
end

APP_CONFIG = YAML.load_file('config.yml')[env]

Twilio::TWILIO_API_URL = APP_CONFIG['vbxURL']

API_VERSION = APP_CONFIG['version']
API_USER_EMAIL = APP_CONFIG['userEmail']
API_USER_PASSWORD = APP_CONFIG['userPassword']

API_ADMIN_EMAIL = APP_CONFIG['adminEmail']
API_ADMIN_PASSWORD = APP_CONFIG['adminPassword']
