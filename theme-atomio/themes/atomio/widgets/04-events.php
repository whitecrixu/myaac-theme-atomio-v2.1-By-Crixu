<?php
defined('MYAAC') or die('Direct access not allowed!');

// Plik do zapisu czasu startu
$startFile = __DIR__ . '/server_start_time.txt';

// Sprawdzenie czy serwer OTServ działa
function isServerOnline(): bool {
    $sock = @fsockopen('127.0.0.1', 7171, $errno, $errstr, 1);
    if ($sock) {
        fclose($sock);
        return true;
    }
    return false;
}

$online = isServerOnline();

// Zapisz/usuń czas startu do/z pliku
if ($online && !file_exists($startFile)) {
    file_put_contents($startFile, time());
}
if (!$online && file_exists($startFile)) {
    unlink($startFile);
}

// Pobierz czas startu
$serverStart = file_exists($startFile) ? (int)file_get_contents($startFile) : null;

// Eventy: nazwa + czas trwania w sekundach
$events = [
    ['name' => 'Event 1', 'duration' => 2 * 3600 + 5 * 60 + 10],
    ['name' => 'Event 2', 'duration' => 3 * 3600],
    ['name' => 'Event 3', 'duration' => 1 * 3600 + 30 * 60],
    ['name' => 'Event 4', 'duration' => 60 * 60],
    ['name' => 'Event 5', 'duration' => 2 * 3600]
];

// Oblicz czas zakończenia eventów
foreach ($events as &$event) {
    $event['endTime'] = $serverStart ? $serverStart + $event['duration'] : null;
}
unset($event);
?>

<div class="well">
    <div class="header">Events</div>
    <div class="body">
        <table class="table-100">
            <?php foreach ($events as $event): ?>
                <tr>
                    <td><?= htmlspecialchars($event['name']) ?></td>
                    <td>
                        <?php if ($online && $event['endTime']): ?>
                            <span class="countdown" data-endtime="<?= $event['endTime'] ?>"></span>
                        <?php else: ?>
                            <span style="color:red; font-weight:bold;">OFFLINE</span>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</div>

<?php if ($online): ?>
<script>
document.addEventListener('DOMContentLoaded', function () {
    function updateCountdowns() {
        const now = Math.floor(Date.now() / 1000);
        document.querySelectorAll('.countdown').forEach(el => {
            const end = parseInt(el.dataset.endtime);
            const left = end - now;

            if (left <= 0) {
                el.textContent = 'Event ended';
                return;
            }

            const h = Math.floor(left / 3600);
            const m = Math.floor((left % 3600) / 60);
            const s = left % 60;
            el.textContent = `${h}h ${m}m ${s}s`;
        });
    }

    updateCountdowns();
    setInterval(updateCountdowns, 1000);
});
</script>
<?php endif; ?>
