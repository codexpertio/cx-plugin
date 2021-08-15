<?php
use codexpert\plugin\Table;

$config = [
	'per_page'		=> 5,
	'columns'		=> [
		'id'			=> __( 'Order #', 'cx-plugin' ),
		'products'			=> __( 'Products', 'cx-plugin' ),
		'order_total'		=> __( 'Order Total', 'cx-plugin' ),
		'commission'		=> __( 'Commission', 'cx-plugin' ),
		'payment_status'	=> __( 'Payment Status', 'cx-plugin' ),
		'time'				=> __( 'Time', 'cx-plugin' ),
	],
	'sortable'		=> [ 'visit', 'id', 'products', 'commission', 'payment_status', 'time' ],
	'orderby'		=> 'time',
	'order'			=> 'desc',
	'data'			=> [
		[ 'id' => 345, 'products' => 'Abc', 'order_total' => '$678', 'commission' => '$98', 'payment_status' => 'Unpaid', 'time' => '2020-06-29' ],
		[ 'id' => 567, 'products' => 'Xyz', 'order_total' => '$178', 'commission' => '$18', 'payment_status' => 'Paid', 'time' => '2020-05-26' ],
		[ 'id' => 451, 'products' => 'Mno', 'order_total' => '$124', 'commission' => '$12', 'payment_status' => 'Paid', 'time' => '2020-07-01' ],
		[ 'id' => 588, 'products' => 'Uji', 'order_total' => '$523', 'commission' => '$22', 'payment_status' => 'Pending', 'time' => '2020-07-02' ],
		[ 'id' => 426, 'products' => 'Rim', 'order_total' => '$889', 'commission' => '$33', 'payment_status' => 'Paid', 'time' => '2020-08-01' ],
		[ 'id' => 109, 'products' => 'Rio', 'order_total' => '$211', 'commission' => '$11', 'payment_status' => 'Unpaid', 'time' => '2020-08-12' ],
	],
	'bulk_actions'	=> [
		'delete'	=> __( 'Delete', 'cx-plugin' ),
		'draft'		=> __( 'Draft', 'cx-plugin' ),
	],
];

$table = new Table( $config );
echo '<form method="post">';
$table->prepare_items();
$table->search_box( 'Search', 'search' );
$table->display();
echo '</form>';