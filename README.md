# php-seeding-patterns

Seeding is in our view a primary component of modern development. Rather than a retrospective way to
populate tables with random data we view it as a means to drive development in a way that unlocks
teams of people working on different components of the system.

This library provides a few helper classes to projects that want to use our "Scenario" data seeding
approach.

## Scenario Data Seeding

Scenario data seeding creates data required to complete key journies through the software. They expose
the functionality by setting up states ready for the user to join and complete key actions. It 
saves time as testers don't need to create those states themselves.

Scenarios can be useful to a number of people on the team.

1) QA: Testers will be able to join complex journeys at key places without the tedium of setting up the 
relevant state. QA may also setup scenarios for automated testing tools in order to minimise test run
times

2) PMs: Project Managers will also be interested in testing key journeys. They may also request scenarios
configured in order to complete demos with a client.

3) Designers: Designers often need to assist on components or screens in the middle or at the end of complex
journeys. Scenarios can get them there immediately without wasting time exploring how to do it.

4) Developers: Developers often need to reset data in order to retry modifications to code. Scenario seeding
makes this fast and easy.

In practice the helper objects used to make seeding easy are also useful to unit test creators.

## Golden rules

In our experience there are some golden rules which if observed by everyone ensures we all get the maximum value
from data seeding. 

**1. Naming: Scenarios name a feature (or sub feature).**

The name of a scenario should describe not 'what' it creates, by 'why' it creates it. Why is this scenario
important and to whom?

**2. Descriptive: Scenarios should describe what they've created**

The scenario body should detail to the console the various objects and journeys it has configured. Logins should
be detailed, URLs presented etc. This should be done with regard for presentation - tabs, **bold** etc. to make
it as readable as possible.

The output of a scenario should give the user everything they need to complete the scenario.

**3. Idempotent: Scenarios should not 'spam' the database**

If you run a seeder twice in succession it should not create double the records. It should find and reset
existing records, and only add if missing. This is extremely important as seeding is expected to be ran
repeatedly.

**4. Complete: Scenarios should be independent of one another**

One scenario should not depend upon another scenario, or indeed upon the order of execution. Users should
be able to run all scenarios, or just one scenario and expect it to work.

**5. Isolated: Don't delete or update other records**

Scenarios should only modify data for the records it has created. It should not empty tables etc. In theory
you should be able to run another person's Scenario at any point without it damaging your own data.

**6. Composed: Built from shared units**

Keep things DRY by using Factories to make objects from Recipes.


## Key Classes

### ScenarioDataSeeder

This is a class provided by Rhubarb's Stem module and is the container for our scenarios.

The basic usage looks like:

```php
class CustomerSeeder extends ScenarioDataSeeder
{
    public function getScenarios(): array
    {
       return [
           new Scenario("Customers can't register if email address is in use", function(ScenarioDescription $description){
               // Code to create scenario data
               $description->writeLine("Something to describe what we've made");    
           }),
           new Scenario("Customers can reset their password", function(ScenarioDescription $description){
               // Code to create scenario data
               $description->writeLine("Something to describe what we've made");
           })
       ];
    }
}
```

We simply create a getScenarios function and return an array of Scenario objects. Those objects
take a string name and a callback function which is passed a ScenarioDescription object. The call
back should implement the core logic of the seeder and then use the description object to describe
what has been configured.

