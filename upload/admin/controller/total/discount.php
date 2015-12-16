<?php
/**
 * Discount on Order Total module for Opencart by Anand S
 *
 * Copyright © 2015 anandrmedia@gmail.com. All Rights Reserved.
 * This file may not be redistributed in whole or significant part.
 * This copyright notice MUST APPEAR in all copies of the script!
 *
 * @author 		Anand S <anandrmedia@gmail.com>
 * @copyright	Copyright (c) 2015, Anand S <anandrmedia@gmail.com>
 * @package 	Discount on Order Total
 */
 
class ControllerTotalDiscount extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('total/discount');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('discount', $this->request->post);

			//print_r($this->request->post);
			//die();
			
			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('extension/total', 'token=' . $this->session->data['token'], 'SSL'));
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_edit'] = $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_percentage'] = $this->language->get('text_percentage');
		$data['text_fixed'] = $this->language->get('text_fixed');
		
		
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_sort_order'] = $this->language->get('entry_sort_order');
		$data['entry_discount_type'] = $this->language->get('entry_discount_type');
		$data['entry_discount_value'] = $this->language->get('entry_discount_value');
		$data['entry_above_total'] = $this->language->get('entry_above_total');
		
		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_total'),
			'href' => $this->url->link('extension/total', 'token=' . $this->session->data['token'], 'SSL')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('total/discount', 'token=' . $this->session->data['token'], 'SSL')
		);

		$data['action'] = $this->url->link('total/discount', 'token=' . $this->session->data['token'], 'SSL');

		$data['cancel'] = $this->url->link('extension/total', 'token=' . $this->session->data['token'], 'SSL');

		if (isset($this->request->post['discount_status'])) {
			$data['discount_status'] = $this->request->post['discount_status'];
		} else {
			$data['discount_status'] = $this->config->get('discount_status');
		}

		if (isset($this->request->post['discount_sort_order'])) {
			$data['discount_sort_order'] = $this->request->post['discount_sort_order'];
		} else {
			$data['discount_sort_order'] = $this->config->get('discount_sort_order');
		}
		
		if (isset($this->request->post['discount_type'])) {
			$data['discount_type'] = $this->request->post['discount_type'];
		} else {
			$data['discount_type'] = $this->config->get('discount_type');
		}
		
		if (isset($this->request->post['discount_value'])) {
			$data['discount_value'] = $this->request->post['discount_value'];
		} else {
			$data['discount_value'] = $this->config->get('discount_value');
		}
		
		if (isset($this->request->post['discount_above_total'])) {
			$data['discount_above_total'] = $this->request->post['discount_above_total'];
		} else {
			$data['discount_above_total'] = $this->config->get('discount_above_total');
		}

		
		
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('total/discount.tpl', $data));
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'total/discount')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}
}