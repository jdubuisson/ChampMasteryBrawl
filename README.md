ChampMasteryBrawl
=================

This is a game where you build a team of 5 champions. Then, you can challenge a friend (or stranger/foe/...). The idea being that what matters is your mastery with the champion.

Each of your champions will "fight" against one of the enemy's champions. (The fight is actually a comparison of your mastery points with this champion VS the enemy's mastery with his/her champion.). This fight is called a (ChampMastery) brawl.

Whichever team wins the most duels, wins the brawl.

You can edit your team (change champions & their order) to better match your opponent if you don't win at first. But you cannot harass the same user : once you've won a brawl, you have to wait 24h or until the opponent updates his team. 

Accounts are created automatically once a user logs-in with his/her Google/Facebook account. A mandatory "profile" step is presented to new user so that they provide a summoner name/region and a username (screen name) for "ChampMastery : Brawl".
> The screen name fills two roles : it helps identify accounts using the same summoner and it protects the user's privacy (we do not use their name from Google/Facebook)

Feel free to play-test it now :http://champmastery.nanto.fr !

##Install

### Prerequisites
You downloaded the source and extracted it.
Your server is configured so that the `./web` of the project is accessible by a browser.

You need a database engine (mysql), with the rights to create a new database, or an empty database at your disposal.

### Composer
[Composer](https://getcomposer.org/) is required to build the project.


If you have curl :
```
curl -sS https://getcomposer.org/installer | php
```

Then, run composer install :
```
php composer.phar install
```
> This will initialise the parameters.yml file for you : you should have your Riot API Key ready, as well as the Google and Facebook app_id/secret required so the Oauth Login works. More parameters will be asked during this process.

### Final steps

#### Assets
```
php bin/console assets:install web --symlink && bin/console assetic:dump
```

#### Cache and logs permissions
You will likely need to fix the `./var/cache` and `./var/logs` folders permissions.

#### Database
To initiate the database and its structure :
```
bin/console doctrine:database:create
bin/console doctrine:schema:create
```

#### Data
You will need to initiate the local static data :
```
bin/console cmb:static-data-init
```

### Use it

That's it, the site should be fully functionnal !
