# myaac-theme-atomio-v2.1 by Crixu

**Preview:**  
![image](https://github.com/user-attachments/assets/2e60d7b7-89b8-4d2a-87b7-6c19e92afbc0)




---
## How install:
   1. Install myaac from my repository <br>
   https://github.com/whitecrixu/myaac-15.xx <br>
   2.Go to plugins and install theme <br>
   3.Continue with tutorial

## ⚙️ Requirements

To make this theme work properly, you need the animated outfit system (for boosted creatures and bosses).

---

## Serwer uptime and events

To make this work correctly on your server, you need to create a Lua script responsible for saving the server's start time to a file.

In /data/scripts/globalevents, create a file called uptime.lua:
```bash
local uptimeFile = "data/uptime.txt"
-- Save the time when the server (and this script) started
local serverStartTime = os.time()

local saveUptimeEvent = GlobalEvent("SaveUptime")

function saveUptimeEvent.onThink(interval)
    -- Calculate uptime as the number of seconds since server/script start
    local uptime = os.time() - serverStartTime
    -- Try to open (or create) the file and write uptime
    local ok, err = pcall(function()
        local file = io.open(uptimeFile, "w")
        if file then
            file:write(uptime)
            file:close()
        else
            print("[SaveUptime] Cannot create or write to file: " .. uptimeFile)
        end
    end)
    if not ok then
        print("[SaveUptime] Error writing uptime: " .. tostring(err))
    end
    return true
end

-- Run this event every 60 seconds (60000 ms)
saveUptimeEvent:interval(60000)
saveUptimeEvent:register()
```

And change in the file 01-status.php:
```bash 
function getUptimeFromFile($path = '/home/USER/server/data/uptime.txt') { --change for you locatio
    if (file_exists($path)) {
        $seconds = (int)trim(file_get_contents($path));
        return $seconds > 0 ? $seconds : null;
    }
    return null;
}

$online = isServerOnline();

// Switch to reading from the file!
$uptimeSeconds = null;
if ($online) {
    $uptimeSeconds = getUptimeFromFile('/home/USER/server/data/uptime.txt'); --change for you location
}
```

and change in file 03-event.php
```bash 
function getUptimeFromFile($path = '/home/USER/server/data/uptime.txt') { --change for you location
    if (file_exists($path)) {
        $seconds = (int)trim(file_get_contents($path));
        return $seconds > 0 ? $seconds : null;
    }
    return null;
}

// Get the current server uptime in seconds
$uptimeSeconds = getUptimeFromFile('/home/USER/server/data/uptime.txt'); --change for you location
```
## 📥 Download and Install Animated Outfits

1. Download the animated outfit package from:  
   👉 https://ots.me/downloads/data/outfit-images/latest_walk.zip

2. Extract the archive.

3. Rename the extracted folder to: animated-outfits
4. Move the folder into your website's `/images/` directory

   
---

## 🧰 Enable GD Extension (Required for GIF rendering)

### Linux (Ubuntu/Debian):

```bash
sudo apt install php-gd
```
## Windows - Uniform Server:
``` bash
core/php/php_production.ini
Find this line:
;extension=gd
And change it to:
extension=gd
 ```

## Windows - XAMPP:
``` bash
Open:
php/php.ini
Find this line:
;extension=gd
And change it to:
extension=gd
```
## 🔐 Set Permissions (Linux)
``` bash
cd /var/www/html/images
sudo chmod 755 -R animated-outfits/
```
Depending on your setup:

# 🔄 Restart Nginx:
``` bash
sudo service nginx restart
```
# 🔄 Restart Apache2:
``` bash
sudo service apache2 restart
```

## ✅ Done!

Now your animated outfits (Boosted Creature and Boosted Boss) will display correctly using animoutfit.php inside the Atomio theme.

## Modifed by: Crixu
## Compatible with: MyAAC v0.8+




