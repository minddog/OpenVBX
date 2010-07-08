require 'rexml/document'
require 'rexml/element'

module Spec
  module Matchers

    # check if the xpath exists one or more times
    class HaveXpath
      def initialize(xpath)
        @xpath = xpath
      end

      def matches?(response)
        @response = response
        doc = response.is_a?(REXML::Document) ? response : REXML::Document.new(@response)
        match = REXML::XPath.match(doc, @xpath)
        not match.empty?
      end

      def failure_message
        "Did not find expected xpath #{@xpath}"
      end

      def negative_failure_message
        "Did find unexpected xpath #{@xpath}"
      end

      def description
        "match the xpath expression #{@xpath}"
      end
    end

    def have_xpath(xpath)
      HaveXpath.new(xpath)
    end

    # check if the xpath has the specified value
    # value is a string and there must be a single result to match its
    # equality against
    class MatchXpath
      def initialize(xpath, val)
        @xpath = xpath
        @val= val
      end

      def matches?(response)
        @response = response
        doc = response.is_a?(REXML::Document) ? response : REXML::Document.new(@response)
        ok= true

        matches = REXML::XPath.match(doc, @xpath)

	 	if (matches.size == 0) 
			return false
		end

        REXML::XPath.each(doc, @xpath) do |e|
          @actual_val= case e
          when REXML::Attribute
            e.to_s
          when REXML::Element
            e.text
          else
            e.to_s
          end
          return false unless @val == @actual_val
        end

        return ok
      end

      def failure_message
        "The xpath #{@xpath} did not have the value '#{@val}' It was '#{@actual_val}'"
      end

      def description
        "match the xpath expression #{@xpath} with #{@val}"
      end
    end

    def match_xpath(xpath, val)
      MatchXpath.new(xpath, val)
    end

    # checks if the given xpath occurs num times
    class HaveNodes  #:nodoc:
      def initialize(xpath, num, atLeast)
        @xpath= xpath
        @num = num
		@atLeast = atLeast
      end

      def matches?(response)
        @response = response
        doc = response.is_a?(REXML::Document) ? response : REXML::Document.new(@response)
        match = REXML::XPath.match(doc, @xpath)
        @num_found= match.size
		if (@atLeast) 
        	@num_found >= @num
		else
        	@num_found == @num
		end
      end

      def failure_message
        "Did not find expected number of nodes #{@num} in xpath #{@xpath} Found #{@num_found}"
      end

      def description
        "match the number of nodes #{@num}"
      end
    end

    def have_nodes(xpath, num )
      HaveNodes.new(xpath, num, false)
    end

	def have_at_least_num_nodes(xpath, num) 
      HaveNodes.new(xpath, num, true)
	end

    # checks if the given xpath occurs num times
    class HaveStructure #:nodoc:
      def initialize(xmlString, typeMap={})
        @xml = REXML::Document.new xmlString
		@types = typeMap
		@xpath = ""
      end

	  def get_type(xpath) 
		#look up full xpath
		type = @types[xpath] 
		if type == nil
			#try to get just the node name
			nodeName = xpath[xpath.rindex("/")+1..xpath.length]
			type = @types[nodeName]
		end

		return type
	  end

	  def structure_matches(given, expected) 
	  
	  	given.each_recursive { |elem| 
	  		matches = REXML::XPath.match(expected, elem.xpath)
	  		if matches.size == 0
	  			return false
			else
				type = get_type(elem.xpath)
				if type != nil && !type.verify(elem.text)
					@xpath = "#{elem.xpath} text '#{elem.text}' did not verify type checker."
					return false	
				end
	  		end
	  	}
	  
	  	expected.each_recursive { |elem| 
	  		matches = REXML::XPath.match(given, elem.xpath)
	  		if matches.size == 0
				@xpath = elem.xpath
	  			return false
	  		end
	  	}
	  
	  	return true
	  end

      def matches?(response)
        @response = response
        doc = response.is_a?(REXML::Document) ? response : REXML::Document.new(@response)
		return structure_matches(doc, @xml);
      end

      def failure_message
        "Did not match structure failed on #{@xpath}"
      end

      def description
        "match the structure"
      end
    end

    def have_structure(xmlString, typeMap = {})
      	HaveStructure.new(xmlString, typeMap)
    end

  end
end

