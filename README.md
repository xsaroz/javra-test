# Javra Test
## Assignment
You need to write the code that listens for user events and unlocks the relevant achievement.
For example:
- When a user writes a comment for the first time they unlock the “First Comment Written” achievement.
- When a user has already unlocked the “First Lesson Watched” achievement by watching a single video and then watches another four videos they unlock the “5 Lessons Watched” achievement.

# Events
When an achievement is unlocked an AchievementUnlocked event must be fired with a payload of; 
- achievement_name (string)
- user (User Model)

When a user unlocks enough achievement to earn a new badge a BadgeUnlocked event must be fired with a payload of; 
- badge_name (string)
- user (User Model)

# Achievement Endpoints
- There is an endpoint `users/{user}/achievements` that can be found in the ‘web’ routes file, this must return the following;

- unlocked_achievements (string[ ]) 
An array of the user’s unlocked achievements by name

- next_available_achievements (string[ ])
An array of the next achievements the user can unlock by name. 

Note: Only the next available achievement should be returned for each group of achievements. 

Example: If the user has unlocked the “5 Lessons Watched” and “First Comment Written” achievements only the “10 Lessons Watched” and “3 Comments Written“ achievements should be returned.

- current_badge (string) 
The name of the user’s current badge.

- next_badge (string)
The name of the next badge the user can earn.

- remaining_to_unlock_next_badge (int)
The number of additional achievements the user must unlock to earn the next badge. 

Example: If a user has unlocked 5 achievements they must unlock an additional 3 achievements to earn the “Advanced” badge.

## Installation
```sh
git clone git@github.com:xsaroz/javra-test.git
composer install
php artisan migrate --seed
```

## Test
Since the requirement had mysql the tests also run on mysql. Please setup .env.testing environment with necessary fields
Run this command for tests
```php
php artisan test
```
or 
```php
./vendor/bin/phpunit
```
Note: In case of tests not working please clear cache and config of env environment
```php
php artisan config:cache --env=testing
```



