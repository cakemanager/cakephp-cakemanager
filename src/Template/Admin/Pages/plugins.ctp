<?php

use Cake\Core\Plugin;
use Cake\Filesystem\File;

?>

<h3>Plugins</h3>

<h4>List of all loaded plugin</h4>

<table>
    <thead>
        <tr>
            <td>Name</td>
            <td>Description</td>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach (Plugin::loaded() as $plugin) {
            ?>
            <tr>
                <td><?= $plugin ?></td>
                <td>
                    <?php
                    $file = new File(Plugin::path($plugin) . "composer.json", false);
                    $composer = json_decode($file->read());
                    echo $composer->description;
                    ?>
                </td>
            </tr>
            <?php
        }
        ?>
    </tbody>

</table>

<h4>How to load and unload</h4>

<p>Via the shell you are able to load and unload plugins.</p>