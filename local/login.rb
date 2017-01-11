require 'open-uri'
require 'openssl'
require 'csv'
# require 'rubygems'
require 'redis'
# require 'nokogiri'
require 'mechanize'
require 'logger'




agent = Mechanize.new
# agent.user_agent_alias = 'Android'
# # # a.user_agent
# login_page = agent.get('https://m.facebook.com/')
# login_form = agent.page.form_with(:method => 'POST')
# login_form.email = 'matveev.alexander.vladimirovi4@gmail.com'
# login_form.pass = 'Name0123Space'
# agent.submit(login_form)

puts "---login success ---"


redis = Redis.new

 


profileCounter = ARGV[0].to_i


if (redis.lrange "fblat", 0, 0).any? == true
 b = redis.lrange "fblat", 0, 0
 a = b[0].to_i
 # puts a
else
 a = 9313000
 # puts a
end
 
puts a
 
start_count = redis.scard("facebookids") 

while redis.scard("facebookids") < start_count + profileCounter
	begin
		users = agent.get('http://facebook.com/' + a.to_s) #//9312314
		# users = agent.page.links
		# users = agent.page.link_with(:text => 'Friends')

		# if agent.page.uri.to_s.include? "?_rdr"

			fburl = agent.page.uri.to_s.split("?")[0].sub( '//m.', '//www.')
			if redis.sismember("black_facebookids" , fburl ) == false
				redis.sadd("facebookids" , fburl )
				puts fburl+ "--> inserted"
			end
			
		# end
	rescue Exception => e
	  page = e.page
	end
	# puts agent.page.title
	# sleep(2)
	a = a+1
end
redis.lpush("fblat" , a)

