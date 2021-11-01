Work in progress... :hammer_and_wrench:

# Frameworks are useless...
It's just a click-bait topic as I couldn't find better. They are not (in most cases :wink:). I believe there are three stages of programming:
 1. you don't know that frameworks exists
 2. you just discovered them and you think they are amazing, you want to use them everywhere no matter what
 3. you look under the hood of some of them and begin to doubt
 
 There are plenty of frameworks out there. Some of them have hundreds of lines, other hundreds of thousands lines of code. Some are better written some are not.
 I've been working with big and old projects without any framework which became one [big ball of mud](https://en.wikipedia.org/wiki/Big_ball_of_mud). I've also seen some greenfield, small projects using frameworks
 which were over-engineered, way much too complex and depending on that framework. At some point I asked myself if it's hard to write an application without them? It's not
 like I've never created any without framework but it was at the beginning of my career and I remembered them as hard to maintenance and develop. But now I've several years
 of professional experience and a better knowledge of programing so I think I can do better.
 
 ## My Goal
 
 My goal was to create a web application without any framework, but still very flexible and with posibility to quick changes of any components, a specialy core ones like e.g. routing,
 DI container or even switching to use one of existing frameworks. Also I didn't want to write too much and too complex code for something that basic like handling
 HTTP requests in PHP. I wanted to keep it small and simple.
 
 First I've made some ground decisons:
  1. The businnes logic must be separated from any network protocol, hardware and other infrastructure and application stuff. For that I've decided to go with
  DDD and [Clean Architecture](https://herbertograca.com/2017/11/16/explicit-architecture-01-ddd-hexagonal-onion-clean-cqrs-how-i-put-it-all-together/) approach.
  2. I don't want to invent wheel again so I don't want to write my own HTTP library for creating request/respons objects, I don't want to write own conatiner for my
  dependencies etc. Also I don't want to depend on any library and spread it across all the code making change of it to something else a hell. So for that reason I've decided to back my application on [PSR](https://www.php-fig.org/psr/)
  interfaces and for stuff like routing which doesn't exits in PSR I wanted to use my own interfaces and use [Adapter design pattern](https://refactoring.guru/pl/design-patterns/adapter).
