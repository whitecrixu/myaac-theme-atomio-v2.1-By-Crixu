<?php
defined('MYAAC') or die('Direct access not allowed!');
session_start();

// === Sprawdzanie statusu serwera ===
function isServerOnline($ip = '127.0.0.1', $port = 7171, $timeout = 1): bool {
    $socket = @fsockopen($ip, $port, $errno, $errstr, $timeout);
    if ($socket) {
        fclose($socket);
        return true;
    }
    return false;
}

$online = isServerOnline();

if ($online) {
    if (!isset($_SESSION['server_start_time'])) {
        $_SESSION['server_start_time'] = time();
    }
    $uptimeStart = $_SESSION['server_start_time'];
} else {
    unset($_SESSION['server_start_time']);
    $uptimeStart = null;
}

// === Pobranie danych z bazy ===
$boostedCreature = [
    'name' => 'Unknown',
    'looktype' => 0,
    'lookaddons' => 0,
    'lookhead' => 0,
    'lookbody' => 0,
    'looklegs' => 0,
    'lookfeet' => 0
];

$boostedBoss = $boostedCreature;

try {
    $creature = $db->query("SELECT * FROM boosted_creature ORDER BY date DESC LIMIT 1")->fetch();
    if ($creature) {
        $boostedCreature = [
            'name' => $creature['boostname'],
            'looktype' => $creature['looktype'],
            'lookaddons' => $creature['lookaddons'],
            'lookhead' => $creature['lookhead'],
            'lookbody' => $creature['lookbody'],
            'looklegs' => $creature['looklegs'],
            'lookfeet' => $creature['lookfeet']
        ];
    }

    $boss = $db->query("SELECT * FROM boosted_boss ORDER BY date DESC LIMIT 1")->fetch();
    if ($boss) {
        $boostedBoss = [
            'name' => $boss['boostname'],
            'looktype' => $boss['looktype'],
            'lookaddons' => $boss['lookaddons'],
            'lookhead' => $boss['lookhead'],
            'lookbody' => $boss['lookbody'],
            'looklegs' => $boss['looklegs'],
            'lookfeet' => $boss['lookfeet']
        ];
    }
} catch (Exception $e) {
    // Możesz logować błąd
}

// === Lokalny URL do animowanego outfitu ===
function getOutfitUrl($data): string {
    return '/images/animated-outfits/animoutfit.php?' . http_build_query([
        'id'        => $data['looktype'],
        'addons'    => $data['lookaddons'],
        'head'      => $data['lookhead'],
        'body'      => $data['lookbody'],
        'legs'      => $data['looklegs'],
        'feet'      => $data['lookfeet'],
        'direction' => 3,
        'animation' => 1,
        'scale'     => 2
    ]);
}

// === Link do Tibia Wiki ===
function getWikiLink(string $name): string {
    return 'https://tibia.fandom.com/wiki/' . urlencode(str_replace(' ', '_', $name));
}
?>

<div class="well widget loginContainer" id="loginContainer">
    <div class="header">
        <a href="<?= getLink('online') ?>">Server Status</a>
    </div>
    <div class="body">
        <div style="text-align: center;">
            <?php if ($online): ?>
                <p style="color: #1ebc30;"><strong>Online</strong></p>
                <p>Uptime: <strong><span id="uptime"></span></strong></p>

                <!-- Boosted Creature -->
                <div style="display: flex; align-items: center; justify-content: center; margin: 10px 0; gap: 10px; background: #1e1e1e; padding: 10px; border-radius: 6px;">
                    <img src="<?= getOutfitUrl($boostedCreature) ?>"
                         alt="<?= htmlspecialchars($boostedCreature['name']) ?>"
                         width="64" height="64" style="image-rendering: pixelated;">
                    <div>
                        <p style="margin: 0; font-size: 14px; color: #ccc;">
                            <strong>🐾 Boosted Creature:</strong><br>
                            <a href="<?= getWikiLink($boostedCreature['name']) ?>" target="_blank" style="color: #6fb1fc; text-decoration: none;">
                                <?= htmlspecialchars($boostedCreature['name']) ?>
                            </a>
                        </p>
                    </div>
                </div>

                <!-- Boosted Boss -->
                <div style="display: flex; align-items: center; justify-content: center; margin: 10px 0; gap: 10px; background: #1e1e1e; padding: 10px; border-radius: 6px;">
                    <img src="<?= getOutfitUrl($boostedBoss) ?>"
                         alt="<?= htmlspecialchars($boostedBoss['name']) ?>"
                         width="64" height="64" style="image-rendering: pixelated;">
                    <div>
                        <p style="margin: 0; font-size: 14px; color: #ccc;">
                            <strong>💀 Boosted Boss:</strong><br>
                            <a href="<?= getWikiLink($boostedBoss['name']) ?>" target="_blank" style="color: #f472b6; text-decoration: none;">
                                <?= htmlspecialchars($boostedBoss['name']) ?>
                            </a>
                        </p>
                    </div>
                </div>

                <!-- JS: Uptime -->
                <script>
                    document.addEventListener('DOMContentLoaded', function () {
                        let startTime = <?= (int)$uptimeStart ?> * 1000;
                        function updateUptime() {
                            const now = new Date().getTime();
                            const diff = now - startTime;
                            const totalMinutes = Math.floor(diff / (1000 * 60));
                            const hours = Math.floor(totalMinutes / 60);
                            const minutes = totalMinutes % 60;
                            document.getElementById('uptime').innerText = `${hours}h ${minutes}m`;
                        }
                        updateUptime();
                        setInterval(updateUptime, 60 * 1000);
                    });
                </script>

            <?php else: ?>
                <p style="color: red;"><strong>Offline</strong></p>
                <p>Uptime: <strong>-</strong></p>
            <?php endif; ?>
        </div>
    </div>
</div>
