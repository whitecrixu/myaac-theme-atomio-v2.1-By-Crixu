<?php
// Konfiguracja eventów – możesz edytować czasy
$events = [
    ['name' => 'Event 1', 'duration' => 2 * 3600 + 5 * 60 + 10],
    ['name' => 'Event 2', 'duration' => 3 * 3600],
    ['name' => 'Event 3', 'duration' => 1 * 3600 + 30 * 60],
    ['name' => 'Event 4', 'duration' => 60 * 60],
    ['name' => 'Event 5', 'duration' => 2 * 3600]
];

// Tylko jeśli uptimeStart jest ustawiony przez status.php (czyli serwer online)
foreach ($events as &$event) {
    $event['endTime'] = isset($uptimeStart) ? $uptimeStart + $event['duration'] : null;
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
                        <?php if (isset($uptimeStart) && $event['endTime']): ?>
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

<?php if (isset($uptimeStart)): ?>
<script>
document.addEventListener('DOMContentLoaded', function () {
    function updateCountdowns() {
        const now = Math.floor(Date.now() / 1000);
        document.querySelectorAll('.countdown').forEach(el => {
            const end = parseInt(el.dataset.endtime);
            const remaining = end - now;

            if (remaining <= 0) {
                el.textContent = 'Event ended';
                return;
            }

            const h = Math.floor(remaining / 3600);
            const m = Math.floor((remaining % 3600) / 60);
            const s = remaining % 60;
            el.textContent = `${h}h ${m}m ${s}s`;
        });
    }

    updateCountdowns();
    setInterval(updateCountdowns, 1000);
});
</script>
<?php endif; ?>
