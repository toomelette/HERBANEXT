<?php

namespace App\Core\Interfaces;
 


interface PurchaseOrderInterface {

	public function fetch($request);

	public function fetchBuffer($request);

	public function store($request);

	public function update($request, $slug);

	public function updatePrices($purchase_order, $subtotal_price, $total_price);

	public function destroy($slug);

	public function findBySlug($slug);

}