<?php

$root = realpath(__DIR__ . '/../');

$types = [
    'crosshair' => [
        'cl_crosshairalpha',
        'cl_crosshaircolor',
        'cl_crosshaircolor_b',
        'cl_crosshaircolor_r',
        'cl_crosshaircolor_g',
        'cl_crosshairdot',
        'cl_crosshairgap',
        'cl_crosshairsize',
        'cl_crosshairstyle',
        'cl_crosshairusealpha',
        'cl_crosshairthickness',
        'cl_fixedcrosshairgap',
        'cl_crosshair_outlinethickness',
        'cl_crosshair_drawoutline',
    ],
    'viewmodel' => [
        'viewmodel_fov',
        'viewmodel_offset_x',
        'viewmodel_offset_y',
        'viewmodel_offset_z',
        'cl_bob_lower_amt',
    ],
];

$players = scandir($root . '/players/');
foreach ($players as $player) {
    $dir = $root . '/players/' . $player;
    if (!is_dir($dir)) continue;
    if (!file_exists($dir . '/config.cfg')) continue;

    foreach ($types as $type => $settings) {
        $values = [];
        foreach (explode(PHP_EOL, file_get_contents($dir . '/config.cfg')) as $line) {
            if (in_array(substr($line, 0, strpos($line, ' ')), $settings)) {
                $values[] = trim($line);
            }
        }

        if (count($values)) {
            $fn = sprintf($root . '/%s/%s.cfg', $type, $player);
            file_put_contents($fn, implode(PHP_EOL, $values));
            echo 'Wrote ' . $fn . PHP_EOL;
        }
    }
}

exit('DONE' . PHP_EOL);
