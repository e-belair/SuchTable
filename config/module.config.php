<?php

return array(
    'view_helpers' => array(
        'invokables' => array(
            'table' => 'SuchTable\View\Helper\Table',
            'thead' => 'SuchTable\View\Helper\TableHead',
            'tbody' => 'SuchTable\View\Helper\TableBody',
            'tfoot' => 'SuchTable\View\Helper\TableFoot',
            'tr'    => 'SuchTable\View\Helper\TableRow',
            'th'    => 'SuchTable\View\Helper\TableHeaderCell',
            'td'    => 'SuchTable\View\Helper\TableCell',

            // Content helpers
            'tableText'    => 'SuchTable\View\Helper\TableText',
            'tableLink'    => 'SuchTable\View\Helper\TableLink',
        )
    )
);
