<?php

return array(
    'view_helpers' => array(
        'invokables' => array(
            'table' => 'ZendTable\View\Helper\Table',
            'thead' => 'ZendTable\View\Helper\TableHead',
            'tbody' => 'ZendTable\View\Helper\TableBody',
            'tfoot' => 'ZendTable\View\Helper\TableFoot',
            'tr'    => 'ZendTable\View\Helper\TableRow',
            'th'    => 'ZendTable\View\Helper\TableHeaderCell',
            'td'    => 'ZendTable\View\Helper\TableCell',

            // Content helpers
            'tableText'    => 'ZendTable\View\Helper\TableText',
            'tableLink'    => 'ZendTable\View\Helper\TableLink',
        )
    )
);
