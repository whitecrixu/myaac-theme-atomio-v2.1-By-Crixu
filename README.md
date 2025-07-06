# myaac-theme-atomio-v2.1 by Crixu

**Preview:**  
🌐 https://wolfots.online/

---

## ⚙️ Requirements

To make this theme work properly, you need the animated outfit system (for boosted creatures and bosses).

---

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




