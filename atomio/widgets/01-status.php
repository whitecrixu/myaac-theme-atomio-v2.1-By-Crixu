<?php
defined('MYAAC') or die('Direct access not allowed!');
if(!isset($_SESSION)) { // Dodatkowe zabezpieczenie
    session_start();
}

$accountType = (USE_ACCOUNT_NAME ? 'name' : 'number');

if (!function_exists('isServerOnline')) {
    function isServerOnline($ip = '127.0.0.1', $port = 7171, $timeout = 1): bool {
        $socket = @fsockopen($ip, $port, $errno, $errstr, $timeout);
        if ($socket) {
            fclose($socket);
            return true;
        }
        return false;
    }
}

// NOWA FUNKCJA: uptime z pliku
function getUptimeFromFile($path = '/home/crixu/crystalserver/data/uptime.txt') {
    if (file_exists($path)) {
        $seconds = (int)trim(file_get_contents($path));
        return $seconds > 0 ? $seconds : null;
    }
    return null;
}

$online = isServerOnline();

// Zamiana na odczyt z pliku!
$uptimeSeconds = null;
if ($online) {
    $uptimeSeconds = getUptimeFromFile('/home/crixu/crystalserver/data/uptime.txt');
}

$boostedCreature = [
    'name' => 'Unknown',
    'looktype' => 0, 'lookaddons' => 0, 'lookhead' => 0, 'lookbody' => 0, 'looklegs' => 0, 'lookfeet' => 0
];
$boostedBoss = $boostedCreature;

try {
    $creature = $db->query("SELECT * FROM boosted_creature ORDER BY date DESC LIMIT 1")->fetch();
    if ($creature) {
        $boostedCreature = [
            'name' => $creature['boostname'], 'looktype' => $creature['looktype'], 'lookaddons' => $creature['lookaddons'],
            'lookhead' => $creature['lookhead'], 'lookbody' => $creature['lookbody'], 'looklegs' => $creature['looklegs'], 'lookfeet' => $creature['lookfeet']
        ];
    }

    $boss = $db->query("SELECT * FROM boosted_boss ORDER BY date DESC LIMIT 1")->fetch();
    if ($boss) {
        $boostedBoss = [
            'name' => $boss['boostname'], 'looktype' => $boss['looktype'], 'lookaddons' => $boss['lookaddons'],
            'lookhead' => $boss['lookhead'], 'lookbody' => $boss['lookbody'], 'looklegs' => $boss['looklegs'], 'lookfeet' => $boss['lookfeet']
        ];
    }
} catch (Exception $e) {}

function getOutfitUrl($data): string {
    return '/images/animated-outfits/animoutfit.php?' . http_build_query([
        'id'        => $data['looktype'], 'addons'    => $data['lookaddons'], 'head'      => $data['lookhead'],
        'body'      => $data['lookbody'], 'legs'      => $data['looklegs'], 'feet'      => $data['lookfeet'],
        'direction' => 3, 'animation' => 1, 'scale'     => 2
    ]);
}

function getWikiLink(string $name): string {
    return 'https://tibia.fandom.com/wiki/' . urlencode(str_replace(' ', '_', $name));
}
?>

<div class="sub-nav-widget-container">
    <!-- SERVER STATUS -->
    <div class="well widget">
        <div class="header">
            <h3 style="margin: 0; color: #fff;">Server Status</h3>
        </div>
        <div class="body" style="text-align: center;">
            <?php if ($online): ?>
                <p style="color: #1ebc30; margin: 5px 0;"><strong>Online</strong></p>
                <p style="margin: 5px 0;">Uptime: <strong><span id="uptime">-</span></strong></p>

                <div class="boost-container">
                    <!-- Boosted Creature -->
                    <div class="boost-box">
                        <img src="<?= getOutfitUrl($boostedCreature) ?>" alt="<?= htmlspecialchars($boostedCreature['name']) ?>" width="64" height="64" style="image-rendering: pixelated;">
                        <div>
                            <p class="boost-title"><strong>🐾 Boosted Creature:</strong><br>
                                <a href="<?= getWikiLink($boostedCreature['name']) ?>" target="_blank" class="boost-link creature">
                                    <?= htmlspecialchars($boostedCreature['name']) ?>
                                </a>
                            </p>
                        </div>
                    </div>

                    <!-- Boosted Boss -->
                    <div class="boost-box">
                        <img src="<?= getOutfitUrl($boostedBoss) ?>" alt="<?= htmlspecialchars($boostedBoss['name']) ?>" width="64" height="64" style="image-rendering: pixelated;">
                        <div>
                            <p class="boost-title"><strong>💀 Boosted Boss:</strong><br>
                                <a href="<?= getWikiLink($boostedBoss['name']) ?>" target="_blank" class="boost-link boss">
                                    <?= htmlspecialchars($boostedBoss['name']) ?>
                                </a>
                            </p>
                        </div>
                    </div>
                </div>

                <script>
                document.addEventListener('DOMContentLoaded', function () {
                    let uptimeSeconds = <?= (int)$uptimeSeconds ?>;
                    const uptimeElement = document.getElementById('uptime');
                    function updateUptime() {
                        if (!uptimeSeconds || !uptimeElement) return;
                        let seconds = uptimeSeconds;
                        let days = Math.floor(seconds / (60*60*24));
                        let hours = Math.floor((seconds % (60*60*24)) / 3600);
                        let minutes = Math.floor((seconds % 3600) / 60);
                        let text = '';
                        if (days > 0) text += days + 'd ';
                        text += hours + 'h ' + minutes + 'm';
                        uptimeElement.innerText = text;
                    }
                    updateUptime();
                    setInterval(function () {
                        uptimeSeconds += 60;
                        updateUptime();
                    }, 60 * 1000);
                });
                </script>

            <?php else: ?>
                <p style="color: red;"><strong>Offline</strong></p>
                <p>Uptime: <strong>-</strong></p>
            <?php endif; ?>
        </div>
    </div>

    <!-- LOGIN FORM -->
    <?php if (!$logged): ?>
        <div class="well widget">
            <div class="header">
                <h3 style="margin: 0; color: #fff;">Login</h3>
            </div>
            <div class="body">
                <form class="loginForm" action="<?= getLink('account/manage') ?>" method="post">
                    <div>
                        <label for="account_login">Account <?= $accountType ?>:</label>
                        <input type="text" name="account_login" id="account_login" autocomplete="username">
                    </div>
                    <div>
                        <label for="password_login">Password:</label>
                        <input type="password" name="password_login" id="password_login" autocomplete="current-password">
                    </div>
                    <div>
                        <input type="submit" value="Login">
                    </div>
                    <div class="links">
                        <a href="<?= getLink('account/create') ?>"><strong>Create account</strong></a>
                        <a href="<?= getLink('account/lost') ?>">Lost account?</a>
                    </div>
                </form>
            </div>
        </div>
    <?php endif; ?>
</div>

<!-- Style specyficzne dla tego widgetu -->
<style>
.sub-nav-widget-container {
    display: flex;
    justify-content: center;
    gap: 20px;
    flex-wrap: wrap;
    margin-bottom: 2rem;
}
.sub-nav-widget-container .widget {
    flex: 1;
    min-width: 300px;
    max-width: 400px; /* Ograniczenie szerokości */
}
.boost-container {
    display: flex;
    justify-content: center;
    gap: 15px;
    margin-top: 15px;
}
.boost-box {
    display: flex;
    align-items: center;
    gap: 10px;
    background: #1e1e1e;
    padding: 10px;
    border-radius: 6px;
    flex: 1;
}
.boost-title {
    margin: 0;
    font-size: 14px;
    color: #ccc;
}
.boost-link {
    text-decoration: none;
}
.boost-link.creature { color: #6fb1fc; }
.boost-link.boss { color: #f472b6; }

.loginForm {
    display: flex;
    flex-direction: column;
    gap: 12px;
    padding: 10px 0;
}
.loginForm label {
    display: block; margin-bottom: 4px; font-weight: bold; color: #ccc;
}
.loginForm input[type="text"],
.loginForm input[type="password"] {
    width: 100%; padding: 8px 10px; border: 1px solid #444; border-radius: 4px;
    background-color: #2c2c2c; color: #eee; font-size: 14px; box-sizing: border-box;
}
.loginForm input[type="text"]:focus,
.loginForm input[type="password"]:focus {
    border-color: #1e90ff; outline: none;
}
.loginForm input[type="submit"] {
    background-color: #007bff; color: white; border: none; padding: 10px;
    border-radius: 4px; cursor: pointer; transition: background-color 0.3s ease;
    font-weight: bold; width: 100%;
}
.loginForm input[type="submit"]:hover { background-color: #0056b3; }
.loginForm .links { text-align: center; margin-top: 10px; }
.loginForm .links a {
    color: #6fb1fc; text-decoration: none; font-size: 14px;
    display: block; margin-top: 4px;
}
.loginForm .links a:hover { text-decoration: underline; }
</style>
