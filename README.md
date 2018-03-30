# [Legacy][Abandoned] TrinityCore 2 character transfer

PHP application and World of Warcraft (Wrath of the Lich King) addon for gamemasters.

Gamemaster can transfer character money and items from another server (without admin rights) to its own server.

Application was originaly developed for wowresource.eu comunity in late of 2011 by [hisgrak](https://github.com/higi90).
## Usage
1. Install addon
2. Login to a character on foreign server
3. type /transfer
4. Copy code
5. Login to app web interface via own server admin credentials
6. Paste code
7. Choose recipient name
8. Recipient will receive items and money by in-game post.

## Installation
### Addon
* Copy Addon/Transfer to your Interface/Addons folder
* Enable addon  in-game

### Applicaiton
*  Edit TC2 World server config to enable remote access
```
Ra.Enable = 1			
Ra.Port = 3443	
Ra.MinLevel = 3	
```
* Upload contets of Web_PHP folder to your webserver's document root
* Edit config.php


