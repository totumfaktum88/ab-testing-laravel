<img src="https://brokerchooser.com/images/brokerchooser-logo.png" alt="BrokerChooser logo">

## BrokerChooser Backend Developer Homework

Congratulations on getting to this part of our interview process!

Here you can find a basic Laravel project configured with some extra features.

Your task is to design and implement a basic [A/B testing](https://en.wikipedia.org/wiki/A/B_testing) system.

This application already starts a basic session in the database for visitors and is capable of adding events to these
sessions.

Requirements:

- An A/B test has a name and 2 or more variants
- Variants have a name and a targeting ratio. The system decides which variant to select for a given A/B test based on
  the targeting ratios (compared to each other)
- Example: variant A (targeting ratio: 1), variant B (targeting ratio: 2) - in this case, variant B is 2 times more
  likely to be selected than variant A
- An A/B test can be started and stopped, after stopping, it cannot be restarted
- At the same time, more A/B tests can run simultaneously
- When an A/B test is running:
    - new sessions should be assigned to one of the variants of the A/B test
    - the site should behave according to the variant selected
    - the site should behave consistently in a given session, i.e. it should not behave according to variant A at first
      and then according to variant B later

After implementing the above system, create an A/B test (you can use a migration to start it) and demonstrate the usage
of the system by changing some behaviour of the site (that is visible to the visitors) based on the A/B test variant.

Disclaimer: BrokerChooser already has a more robust version of this A/B testing system implemented, we do not expect you
to work for us before we hire you. :)

## Developer notes

- The application was supplemented with 2 new tables, that stores the AB Test records and the AB Test variants
- The running AB tests (tests with "running" status) and their variants storing into the session and logging into the events table (initialize, remove), when the StartSession middleware called.
- If there are any store, but stopped Tests, these tests will be removed from session.
- If there are any AB Test with in "running" status and it's not stored in session, the test service will try select a variant for the session and then it will try to store it into to session. The selection mechanism use the weighted random selection method.
- An AB tests is runnable in "created" status only and it is stoppable status only
- There are five AB Test in the ABTestSeeder, all of them in "running" state, so after a migration / seed command all will be running
- These test integrated the base route path "/". This route contains a static html page with blade template, where i integrated all of the five AB Test variant changes with some easter eggs ( May the force be with you Marty :) )
- You can change the AB test states from command line with artisan commands:

```
# Start an AB Test
$ php artisan ab-test:start [ab-test-name]
```

```
# Stop an AB Test
$ php artisan ab-test:stop [ab-test-name]
```

Also we can query the statistics of an AB Test's variants:

```

$ php artisan ab-test:statistics landing-animation

The statistics based on 206 samples.

+-------------------+-------+---------+
| Variant name      | Count | Percent |
+-------------------+-------+---------+
| basic             | 118   | 57.28%  |
| delorean          | 57    | 27.67%  |
| millennium-falcon | 31    | 15.05%  |
+-------------------+-------+---------+

```
