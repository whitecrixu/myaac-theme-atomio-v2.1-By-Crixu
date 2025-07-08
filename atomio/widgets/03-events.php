<?php
// KONFIGURACJA EVENTÓW: czas w sekundach!
$events = [
    ['name' => 'Event 1', 'duration' => 10 * 60],  // 10 minut
    ['name' => 'Event 2', 'duration' => 20 * 60],  // 20 minut
    ['name' => 'Event 3', 'duration' => 30 * 60],  // 30 minut
    ['name' => 'Event 4', 'duration' => 40 * 60],  // 40 minut
    ['name' => 'Event 5', 'duration' => 50 * 60],  // 50 minut
    ['name' => 'Event 6', 'duration' => 60 * 60],  // 60 minut
];

// Tylko jeśli serwer online i jest uptime!
$eventOnline = ($online && $uptimeSeconds !== null);

foreach ($events as &$event) {
    if ($eventOnline) {
        $timePassed = $uptimeSeconds % $event['duration'];
        $event['remaining'] = $event['duration'] - $timePassed;
    } else {
        $event['remaining'] = null;
    }
}
unset($event);
?>

<div class="well widget" style="margin-top: 20px;">
    <div class="header">
        <h3 style="margin: 0; color: #fff;">Server Events</h3>
    </div>
    <div class="body">
        <table class="table-100">
            <?php foreach ($events as $index => $event): ?>
                <tr>
                    <td>
                        <strong style="color: #1ebc30;"><?= htmlspecialchars($event['name']) ?></strong>
                    </td>
                    <td>
                        <?php if ($event['remaining'] !== null): ?>
                            <span class="countdown"
                                  data-remaining="<?= $event['remaining'] ?>"
                                  data-duration="<?= $event['duration'] ?>"
                                  id="event-<?= $index ?>">
                                Loading...
                            </span>
                        <?php else: ?>
                            <span style="color:red; font-weight:bold;">OFFLINE</span>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</div>

<?php if ($eventOnline): ?>
<script>
document.addEventListener('DOMContentLoaded', function () {
    function updateCountdowns() {
        document.querySelectorAll('.countdown').forEach(el => {
            let remaining = parseInt(el.dataset.remaining, 10);
            const duration = parseInt(el.dataset.duration, 10);

            if (remaining <= 0) {
                remaining = duration;
            }

            const m = Math.floor(remaining / 60);
            const s = remaining % 60;
            let txt = '';
            if (m > 0) txt += `${m}m `;
            txt += `${s}s`;

            el.textContent = txt.trim();
            el.dataset.remaining = remaining - 1;
        });
    }
    updateCountdowns();
    setInterval(updateCountdowns, 1000);
});
</script>
<?php endif; ?>
