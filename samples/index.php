<?php

declare(strict_types=1);

?>
<html>
    <head>
        <title>Samples</title>
        <style>
            h2 {
                float: left;
            }
            div {
                display: block;
                position: relative;
                float: left;
                margin: 5px 0;
                width: 100%;
            }
            div#main {

            }
        </style>
    </head>
    <body>
        <div id="main">
            <h1>Samples</h1>
            <?php

            $entries = glob(__DIR__ . DIRECTORY_SEPARATOR . '*');
            if (false !== $entries) {
                foreach ($entries as $entry) {
                    if (true === is_file($entry)) {
                        continue;
                    }

                    $samples = glob($entry . DIRECTORY_SEPARATOR . '*.php');
                    if (false === $samples || 0 === count($samples)) {
                        continue;
                    }

                    echo sprintf(
                        '<h2>%s</h2>' . PHP_EOL,
                        str_replace(' ', '', ucwords(str_replace('-', ' ', basename($entry))))
                    );

                    foreach ($samples as $sample) {
                        echo sprintf(
                            '<div>
                            <a href="%s" target="_blank">%s</a>
                        </div>' . PHP_EOL,
                            ltrim(str_replace(__DIR__, '', $sample), DIRECTORY_SEPARATOR),
                            str_replace(['-', '.php'], [' ', ''], ucfirst(basename($sample)))
                        );
                    }

                }
            }
            ?>
        </div>
    </body>
</html>
