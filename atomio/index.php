<?php
defined('MYAAC') or die('Direct access not allowed!');

$menus = get_template_menus();
if(count($menus) === 0) {
    $text = "Please install the $template_name template in Admin Panel, so the menus will be imported too.";
    throw new RuntimeException($text);
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <?php echo template_place_holder('head_start'); ?>
        <link rel="stylesheet" href="<?= $template_path ?>/css/style.css">
        <link rel="stylesheet" href="<?= $template_path ?>/fontawesome/css/font-awesome.min.css">
        <link rel="stylesheet" href="<?= $template_path ?>/css/resp.css">
        <?php echo template_place_holder('head_end'); ?>
    </head>
    <body>
        <?php echo template_place_holder('body_start'); ?>
        <div class="main">

            <div class="well banner"></div>

            <nav class="main-nav">
                <ul>
                    <!-- Główne menu z pliku menu.php -->
                    <?php include 'menu.php'; ?>

                    <!-- USUNIĘTO: Linki Login/Register z tego miejsca -->
                    <?php if($logged): ?>
                        <li><a href="<?= getLink('account/manage') ?>"><i class="fa fa-lock"></i> My Account</a></li>
                        <?php if(admin()): ?>
                            <li><a href="<?= ADMIN_URL ?>" target="_blank"><i class="fa fa-wrench"></i> Admin Panel</a></li>
                        <?php endif; ?>
                        <li><a href="<?= getLink('account/logout') ?>"><i class="fa fa-unlock"></i> Logout</a></li>
                    <?php endif; ?>
                </ul>
            </nav>

            <div class="well feedContainer preventCollapse">
                <!-- MAIN FEED -->
                <div class="pull-left leftPane">
                    <?php echo tickers() . template_place_holder('center_top') . $content; ?>
                </div>
                <!-- MAIN FEED END -->

                <!-- RIGHT PANE -->
                <div class="pull-right rightPane">
                    <?php
                    // Przywrócono prostą pętlę, która wczytuje WSZYSTKIE widżety z folderu.
                    // Upewnij się, że masz w folderze 'widgets' plik 'server_status.php'
                    // i usunąłeś stary 'login.php', aby uniknąć konfliktu.
                    foreach(scandir(__DIR__ . '/widgets', SCANDIR_SORT_ASCENDING) as $widget) {
                        $file = __DIR__ . '/widgets/' . $widget;
                        if(strpos($widget, '.php') !== false && file_exists($file)) {
                            include($file);
                        }
                    }
                    ?>
                </div>
                <!-- RIGHT PANE END -->
            </div>

            <footer class="well preventCollapse">
                <div style="text-align: center">
                    <?php echo template_footer(); ?>
                    Designed By <a href="https://otland.net/members/snavy.155163/" target="_blank">Snavy</a>
                    <?php if($config['template_allow_change']) { echo '<br/><br/>Change template: ' . template_form(); } ?>
                </div>
            </footer>
        </div>
    </body>
</html>
