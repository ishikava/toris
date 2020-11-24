<?php

exec('php ' . __DIR__ . '/api/parse_all_data.php ' . date('n') . ' ' . date('Y'));
